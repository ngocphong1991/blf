<?php
/*
Plugin Name: TextLink.vn Advertiser Plugin 
Plugin URI: http://textlink.vn
Description: Let's Join the TextLink.vn VN marketplace.  
Author: kisyrua@gmail.com
Version: 1.0.0
URI: http://textlink.vn
*/
if (!function_exists('add_action')) {
    header('HTTP/1.0 404 Not Found');
    header('Location: ../../../404');
    exit;
}
global $wp_version;

//ensure that mysql_real_escape_string exists

if (!function_exists('mysql_real_escape_string')) {
    echo('You must be running PHP 4.3.0 or higher to use the Text Link plugin. Please contact your web host about upgrading.');
    textlink_vn_disable_plugin();
    exit;
}
 
$wp_cache_shutdown_gc = 1;

$textlink_vn_ads_object = null;

add_action('init', 'textlink_vn_initialize');
// general/syncing hooks

if (!textlink_vn_widget_installed() && textlink_vn_between_posts()) {
    add_filter('the_content', 'textlink_vn_between_content_show');
} else {
    if ($wp_version < 2.8) {
        add_action('plugins_loaded', 'textlink_vn_ads_widget_init');
    } else {
        add_action('widgets_init', create_function('', 'return register_widget("textlink_vn_ads_widget");'));
    }
}

add_action('admin_init', 'textlink_vn_admin_init');
add_action('admin_menu', 'textlink_vn_admin_menu');
add_action('admin_notices', 'textlink_vn_admin_notices');
add_action('update_option_textlink_vn_site_keys', 'textlink_vn_refresh');

$tlaPluginName = plugin_basename(__FILE__);  

add_filter("plugin_action_links_$tlaPluginName", 'textlink_vn_settings_link');  

function textlink_vn_settings_link($links) 
{  
    $plugin = plugin_basename(__FILE__);  
    $settings_link = '<a href="options-general.php?page='.$plugin.'">Settings</a>';  
    array_unshift($links, $settings_link);  
    return $links;  
}  

function textlink_vn_admin_notices() 
{
    global $textlink_vn_ads_object;
    if ($textlink_vn_ads_object->web_key_vns) {
        return;
    }
    $pluginName = plugin_basename(__FILE__);
    echo "<div class='updated' style='background-color:#f66;'><p>" . sprintf(__('<a href="%s">Text Link Plugin</a> needs attention: please enter a site key or disable the plugin.'), "options-general.php?page=$pluginName") . "</p></div>";
}

function textlink_vn_disable_plugin()
{
    $pluginName = basename(__FILE__);
    $plugins = get_option('active_plugins');
    $index = array_search($pluginName, $plugins);
    if ($index !== false) {
        array_splice($plugins, $index, 1);
        update_option('active_plugins', $plugins);
        do_action('deactivate_'.$pluginName);
    }
}

function textlink_vn_admin_init()
{
    global $textlink_vn_ads_object;
    if (!function_exists('register_setting')) return;
    register_setting('textlink_vn_ads', 'textlink_vn_between_posts'); 
    register_setting('textlink_vn_ads', 'textlink_vn_site_keys', 'textlink_vn_site_key_check'); 
    register_setting('textlink_vn_ads', 'textlink_vn_style_a'); 
    register_setting('textlink_vn_ads', 'textlink_vn_style_ul'); 
    register_setting('textlink_vn_ads', 'textlink_vn_style_li'); 
    register_setting('textlink_vn_ads', 'textlink_vn_style_span'); 
    register_setting('textlink_vn_ads', 'textlink_vn_fetch_method');     
    register_setting('textlink_vn_ads', 'textlink_vn_decoding');
    register_setting('textlink_vn_ads', 'textlink_vn_allow_caching');
    
}

function textlink_vn_site_key_check($setting)
{
    $tmpsetting = array();
    if (isset($setting[0]) && isset($setting[0]['mass']) && $setting[0]['mass']) {
        $setting[0]['mass'] = str_replace("\r", "\n", $setting[0]['mass']);
        $list = explode("\n", $setting[0]['mass']);
        foreach ($list as $item) {
            $item = str_replace("\t", " ", $item);
            list($xml_key, $url) = explode(" ", $item);
            $setting[] = array('key' => trim($xml_key), 'url' => trim($url));
        }
    }
    
    if ($setting) foreach ($setting as $data) {
        $badkey = false;
        $key = trim($data['key']);
        $url = trim($data['url']);
        $isurl = @parse_url($url);
        if (strlen($key) != 20) {
            $badkey = true;
        }
        if (!$isurl) {
            $badkey = true;
        }
        if (!$badkey) {
            $tmpsetting[] = $data;
        }
    }
    return $tmpsetting;
}

function textlink_vn_admin_menu()
{
    add_options_page('Text Link Options', 'Text Link', 'manage_options', __FILE__, 'textlink_vn_options_page');
}

function textlink_vn_options_page()
{
    global $textlink_vn_ads_object, $wp_version;
    $home = @parse_url(get_option('siteurl'));
    $home = $home['scheme'] . '://' . $home['host'];
    if ($_POST['action'] == 'update' && $wp_version < 2.7) {
    	update_option('textlink_vn_between_posts', isset($_POST['textlink_vn_between_posts']) ? $_POST['textlink_vn_between_posts'] : 0); 
    	update_option('textlink_vn_site_keys', textlink_vn_site_key_check($_POST['textlink_vn_site_keys'])); 
    	update_option('textlink_vn_style_a', $_POST['textlink_vn_style_a']); 
    	update_option('textlink_vn_style_ul', $_POST['textlink_vn_style_ul']); 
    	update_option('textlink_vn_style_li', $_POST['textlink_vn_style_li']); 
    	update_option('textlink_vn_style_span', $_POST['textlink_vn_style_span']); 
    	update_option('textlink_vn_fetch_method', isset($_POST['textlink_vn_fetch_method']) ? $_POST['textlink_vn_fetch_method'] : 0);   
    	update_option('textlink_vn_last_update', '');  
    	update_option('textlink_vn_style_span', $_POST['textlink_vn_style_span']); 
    	update_option('textlink_vn_allow_caching', isset($_POST['textlink_vn_allow_caching']) ? $_POST['textlink_vn_allow_caching'] : 0);
    	update_option('textlink_vn_decoding', isset($_POST['textlink_vn_decoding']) ? $_POST['textlink_vn_decoding'] : 0);
    	wp_cache_flush();
    	echo "Settings have been updated";
    	return;
    }
    ?>
    <div class="wrap">
        <h2>Text Link</h2>
        <form method="post" <?php echo $wp_version >= 2.7 ? 'action="options.php"' : ''?>>
            <?php 
            if (function_exists('settings_fields')) {
                settings_fields('textlink_vn_ads'); 
            } else { 
                echo "<input type='hidden' name='option_page' value='textlink_vn_ads' />";
                echo '<input type="hidden" name="action" value="update" />';
                wp_nonce_field("textlink_vn_ads-options");
            }
            ?>
            <style>
            .textlink_vn_setting tr {
                border-bottom:5px solid #FFF;
            }
            .warning {
                color:red;
                border:1px solid #000;
                padding:5px;
            }
            </style>
            <table class="form-table textlink_vn_setting">
                <tr valign="top">
                    <td colspan=2>
                    <table><tr><th width=5%></th><th>Site Key</th><th>Ad Target Url</th></tr>
                
                <?php 
                $counter = 0;
                foreach ($textlink_vn_ads_object->web_key_vns as $url => $key) { 
                ?>
                <tr valign="top">
                    <td width=10%><?php echo ($url == get_option('siteurl') || $counter == 0) ? 'Primary' : $counter;?></td>
                    <td><input type="text" name="textlink_vn_site_keys[<?php echo $counter;?>][key]" value="<?php echo $key;?>" /></td>
                    <td style="text-align:left;">
                        <input type="text" size="50" name="textlink_vn_site_keys[<?php echo $counter;?>][url]" value="<?php echo $url;?>" />
                        <?php if (!$counter):?>
                        	<br />
                        	<?php echo !$url ? '<font color="red">' :''; ?>
                        	<em>Leaving this blank will make your ads site wide. <br />Specify a URL to ensure the ads only display on one page which is preferred.</em>
                        	<?php echo !$url ? '</font>' :''; ?>
                    	<?php endif; ?>
                    </td>
                    
                </tr>
                <?php
                    $counter++;
                }
                ?>
                 <tr>
                    <td colspan=2 valign="top">
                        This key can be obtained logging into <a href="http://textlink.vn">Text Link</a> and submitting your blog site. Delete a key by emptying the url and key fields.
                    </td>
                    <td valign="top">
                        The full url that your page was setup as. This is your default URI <br><em> <?php echo $home;?> </em>
                    </td>
                </tr>
                <tr valign="top">
                    <td width=10%>Add New</td><td style="text-align:left;"><input type="text" name="textlink_vn_site_keys[<?php echo $counter;?>][key]" value="" /></td><td><input type="text" name="textlink_vn_site_keys[<?php echo $counter;?>][url]" size="50"  value="" /></td>
                </tr>
                <tr>
                    <td valign=top> Or Bulk Add<br /></td><td colspan=3><textarea wrap=off rows=3 cols=77 name="textlink_vn_site_keys[0][mass]"></textarea><br />
                    <em>[site key] space or tab separated [url]</em>:<br/><br/>example:<br/>
                    <em>XXXXXXXXXXXXXXXXXXXX http://www.domain.com</em>
                    </td>
                </tr>
               
                </table></td></tr>
                <tr><td colspan=2>Adding multiple keys will remove the ability to do site wide via the widget or links between posts on the homepage</td></tr>
 
                <tr valign="top">
                    <th>Ad Display Method</th>
                    <td>
                        <?php if ($counter <= 1): ?>
                            <input type="radio" id="textlink_vn_between_posts_y" name="textlink_vn_between_posts" value="1" <?php echo get_option('textlink_vn_between_posts') ? 'checked="checked"' : '' ?>" />
                            <label for="textlink_vn_between_posts_y">Between Posts on Homepage</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="textlink_vn_between_posts_n" name="textlink_vn_between_posts" value="0" <?php echo !get_option('textlink_vn_between_posts') ? 'checked="checked"' : '' ?>" />
                            <label for="textlink_vn_between_posts_n">Widget or Template Based</label>
                        <?php else: ?>
                            Ads will be displayed on the urls entered above. Make sure to activate the widget or add the <br /><?php echo '&lt;'.'?'.'php'.' textlink_vn_ads(); ?'.'&gt;';?> code to your template
                            <input type="hidden" name="textlink_vn_between_posts" value="0" />
                        <?php endif ?>
                    </td>
                </tr>
                <?php if ($counter <= 1): ?>
                <tr>
                    <td colspan="2">If you previously select Between Posts on Homepage option, the widget mode is disabled and your links will only appear on the homepage between posts. </td>
                </tr>
                <?php endif ?>
                <?php if (!function_exists('wp_remote_get')): ?>
                <tr valign="top">
                    <th>Ad Retrieval Method</th>
                    <td>
                        <?php if (function_exists('curl_init')): ?><input type=radio name="textlink_vn_fetch_method" value="curl" <?php echo get_option('textlink_vn_fetch_method') == 'curl' ? 'checked="checked"' : '' ?>" /> Curl <br /><?php endif; ?>
                        <?php if (function_exists('file_get_contents')): ?><input type=radio name="textlink_vn_fetch_method" value="native" <?php echo get_option('textlink_vn_fetch_method') == 'native' ? 'checked="checked"' : '' ?>" /> Php (file_get_contents)<br /><?php endif; ?>
                        <input type=radio name="textlink_vn_fetch_method" value="0" <?php echo !get_option('textlink_vn_fetch_method') ? 'checked="checked"' : '' ?>" /> Default (sockets)
                    </td>
                </tr>
                <?php endif; ?>
                 <tr>
                	<th>Allow Cached Pages</th>
                    <td><input type="checkbox" name="textlink_vn_allow_caching" value='1' <?php echo get_option('textlink_vn_allow_caching') ? 'checked="checked"' :'' ?>' /></td>
                </tr>
                <tr>
               		<td colspan="2">
                    	<em>If you are comfortable with Super Cache or WP Cache you can try to allow caching, however it is not suggested.</em>
                    </td>
              	</tr>
              	<?php if (function_exists('iconv') && function_exists('mb_list_encodings')):?>
                <tr>
                	<th>Output Encoding</th>
                    <td>
                    	<select name="textlink_vn_decoding">
                    	<?php foreach (mb_list_encodings() as $enValue): ?>
                    		<option value="<?php echo $enValue;?>" <?php echo $textlink_vn_ads_object->decoding == $enValue || ($textlink_vn_ads_object->decoding == '' && $enValue == 'UTF-8') ? 'selected="selected"' : '';?>><?php echo $enValue;?></option>
						<?php endforeach; ?>
                    	</select>
                 	</td>
              	</tr>
              	<?php endif;?>
              	<tr>
               		<td colspan="2">
                    	<em>A output encoding that matches your theme. Use this option if you are having troubles displaying the text properly</em>
                    </td>
              	</tr>
              	<tr>
                    <th>Styling Options</th><td><small><em>e.g. style="color:#CCC;" (use double quotes not single quotes)</em></small></em></td>
                </tr>
                 <tr valign="top">
                    <td scope="row">Style a</td>
                    <td><input type="text" name="textlink_vn_style_a" value='<?php echo get_option('textlink_vn_style_a') ? get_option('textlink_vn_style_a') : '' ?>' /><em>&lt;a ...&gt;</em></td>
                </tr>
                <tr valign="top">
                    <td scope="row">Style span</td>
                    <td><input type="text" name="textlink_vn_style_span" value='<?php echo get_option('textlink_vn_style_span') ? get_option('textlink_vn_style_span') : '' ?>' /><em>&lt;span ...&gt; </em></td>
                </tr>
                <tr valign="top">
                    <td scope="row">Style ul</td>
                    <td><input type="text" name="textlink_vn_style_ul" value='<?php echo get_option('textlink_vn_style_ul') ? get_option('textlink_vn_style_ul') : '' ?>' /><em>&lt;ul ...&gt; For Widget Mode only</em></td>
                </tr>
                <tr valign="top">
                    <td scope="row">Style li</td>
                    <td><input type="text" name="textlink_vn_style_li" value='<?php echo get_option('textlink_vn_style_li') ? get_option('textlink_vn_style_li') : '' ?>' /><em>&lt;li ...&gt; For Widget Mode only</em></td>
                </tr>
                <tr>
                    <td colspan=2>            
                        <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
                    </td>
                </tr>
                <?php if (!is_file($textlink_vn_ads_object->htaccess_file)): ?>
                <tr>
                    <td valign="top"><p ><div class="warning">Optional Security Additions. We want to protect your privacy. Please make sure that your <strong>plugins directory is writable</strong> or add a file named <strong>.htaccess</strong> in your <strong>textlink.vn</strong> plugin directory with the code in the textbox to your right:</div> <strong><?php echo $textlink_vn_ads_object->htaccess_file; ?></strong></p></td>
                    <td><br /><textarea cols="30" rows="10"><?php echo $textlink_vn_ads_object->htaccess(); ?></textarea>
                </td>
                </tr>
                <?php endif; ?>
            </table>
        </form>
    </div>
    <?php 
}

function textlink_vn_widget_installed() 
{
    if (!function_exists('wp_get_sidebars_widgets')) return;
    $widgets = wp_get_sidebars_widgets(); 
    foreach ($widgets as $widget) {
        if (is_array($widget)) {
             foreach ($widget as $wid) {
                 if (stripos($wid, 'textlink_vn_ads-widget') !== false) {
                    return true;
                 }
             }
        } else {
            if (stripos($widget, 'textlink_vn_ads-widget') !== false) {
                return true;
            }
        }
    }
}

function textlink_vn_between_posts() 
{
    return get_option('textlink_vn_between_posts');
}

function textlink_vn_initialize()
{
    global $wpdb, $textlink_vn_ads_object;
    $textlink_vn_ads_object = new textlink_vn_adsObject;
    $textlink_vn_ads_object->initialize();
    if (isset($_REQUEST['textlink_vn_ads_key']) && isset($_REQUEST['textlink_vn_ads_action'])) {
        if (in_array($_REQUEST['textlink_vn_ads_key'], array_values($textlink_vn_ads_object->web_key_vns))) {
            switch($_REQUEST['textlink_vn_ads_action']) {
                case 'debug_tla':
                case 'debug':
                    $textlink_vn_ads_object->debug(isset($_REQUEST['textlink_vn_ads_reset_index']) ? $_REQUEST['textlink_vn_ads_reset_index'] : '');
                    exit;
        
                case "refresh":
                case "refresh_tla":
                    echo "refreshing";
                    textlink_vn_refresh();
                    echo "refreshing complete";
                    break;
                    
            }
        }
    }
}

function textlink_vn_refresh()
{
    global $textlink_vn_ads_object;
    if (get_option('textlink_vn_last_update') < date('Y-m-d H:i:s', time() - 60)) {
        $textlink_vn_ads_object->cleanCache();
        $textlink_vn_ads_object->updateLocalAds();
    }            
}
                
function textlink_vn_check_installation()
{
    global $textlink_vn_ads_object;

    $textlink_vn_ads_object = new textlink_vn_adsObject;
    $textlink_vn_ads_object->checkInstallation();
}

/** WP version less than 2.8 widget functions */
if (!textlink_vn_between_posts()) {
    if ($wp_version < 2.8) {
        function textlink_vn_ads_widget_init()
        {
            if (!function_exists('register_sidebar_widget') || !function_exists('register_widget_control')) return;
            register_sidebar_widget('textlink_vn_ads', 'textlink_vn_ads_widget');
            register_widget_control('textlink_vn_ads', 'textlink_vn_ads_widget_control');
        }
         
        function textlink_vn_ads_widget($args)
        {
            extract($args);
            global $textlink_vn_ads_object;
            if (!$textlink_vn_ads_object->ads) {
                return;
            } 
            $options = get_option('widget_textlink_vn_ads');
            $title = $options['title'];
            $before_widget = str_replace('textlink_vn_ads', '', $before_widget);
            echo $before_widget;
            echo $before_title . $title . $after_title;
            textlink_vn_ads();
            echo $after_widget;
        }
        
        function textlink_vn_ads_widget_control()
        {
            $options = $newoptions = get_option('widget_textlink_vn_ads');
            global $textlink_vn_ads_object;

            if (isset($_POST['textlink_vn_ads-title'])) {
                $newoptions['title'] = strip_tags(stripslashes($_POST['textlink_vn_ads-title']));
            }
        
            if ($options != $newoptions) {
                $options = $newoptions;
                update_option('widget_textlink_vn_ads', $options);
            }
        
            ?>
            <p><label for="textlink_vn_ads-title">Title: <input type="text" style="width: 250px;" id="textlink_vn_ads-title" name="textlink_vn_ads-title" value="<?php echo htmlspecialchars($options['title']); ?>" /></label></p>
            <input type="hidden" name="textlink_vn_ads-submit" id="textlink_vn_ads-submit" value="1" />
        <?php
        }
    // 2.8 + Api Additions    
    } else {
        class textlink_vn_ads_Widget extends WP_Widget
        {
            function textlink_vn_ads_Widget()
            {
                parent::WP_Widget(false, $name = 'Text Link');
            }
        
            function widget($args, $instance)
            {
                global $textlink_vn_ads_object;
                if (!$textlink_vn_ads_object->ads) {
                    return;
                } 
                extract($args);
                $title = apply_filters('widget_title', empty($instance['title']) ? __('Links of Interest') : $instance['title']);
                $before_widget = str_replace('textlink_vn_ads', '', $before_widget);
                echo $before_widget;
                echo $before_title . $title . $after_title;
                textlink_vn_ads();
                echo $after_widget;
            }
            
            function form($instance) 
            {
                global $textlink_vn_ads_object;
                $instance = wp_parse_args((array)$instance, array('title' => ''));
                $title = esc_attr($instance['title']);
                ?>
                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
                <?php 
            }
            
            function update($new_instance, $old_instance) 
            {
                $instance = $old_instance;
                if ($new_instance['title']) $instance['title'] = strip_tags(stripslashes($new_instance['title']));
                return $instance;
            }
        }
    }
} else if (textlink_vn_widget_installed()) {
    if (!function_exists('unregister_sidebar_widget') || !function_exists('unregister_widget_control')) return;
    unregister_sidebar_widget('textlink_vn_ads', 'textlink_vn_ads_widget');
    unregister_widget_control('textlink_vn_ads', 'textlink_vn_ads_widget_control');
}


function textlink_vn_ads()
{
    global $textlink_vn_ads_object;
    $textlink_vn_ads_object->outputHtmlAds();
}

function textlink_vn_between_content_show($content) 
{
    global $wpdb, $textlink_vn_ads_object;
    $adlink = '';

    if (!$textlink_vn_ads_object) {
        $textlink_vn_ads_object = new textlink_vn_adsObject;
        $textlink_vn_ads_object->initialize();
    }

    if (is_home() || is_front_page()) {
        for ($z = 0; $z < $textlink_vn_ads_object->num_ads_per_post; $z++) {
            if ($textlink_ads = $textlink_vn_ads_object->ads[$textlink_vn_ads_object->nextAd++]) {
                if ($textlink_vn_ads_object->style_span) {
                    $adlink .= '<span ' . $textlink_vn_ads_object->style_span . '>';
                }
                $adlink .= $textlink_ads->before_text . ' <a';
                if ($textlink_vn_ads_object->style_a) {
                    $adlink .= ' ' . $textlink_vn_ads_object->style_a;
                }
                $adlink .= ' href="' . $textlink_ads->url . '">' . $textlink_ads->text.'</a> ' . $textlink_ads->after_text;
                if ($textlink_vn_ads_object->style_span) {
                    $adlink .= '</span>';
                }
            }
        }
    }
    return $content . $adlink;
}

class textlink_vn_adsObject
{
    var $web_key_vn = 'FGKPAN9ACSDX0T8WBFOA';
    var $web_key_vns = array();
    var $xmlRefreshTime = 3600;
    var $connectionTimeout = 10;
    var $DataTable = 'textlink_vn_data';
    var $version = '1.0.0';
    var $textlink_ads;

    function textlink_vn_adsObject()
    {
        global $table_prefix;
        $this->DataTable = $table_prefix . $this->DataTable;
        
        //overwrite default key if set in options
        $this->siteKeys = maybe_unserialize(get_option('textlink_vn_site_keys'));
        if ($this->web_key_vn && (!is_array($this->siteKeys) || count($this->siteKeys) == 0)) {
            add_option('textlink_vn_site_keys', serialize(array('0' => array('url' => get_option('siteurl'), 'key' => $this->web_key_vn))));
            $this->siteKeys = maybe_unserialize(get_option('textlink_vn_site_keys'));
        } 
        
        if (is_array($this->siteKeys)) foreach ($this->siteKeys as $data) {
            $this->web_key_vns[trim($data['url'])] = trim($data['key']);
        }
        
    }

    function debug()
    {
        global $wpdb, $wp_version;
        $home = @parse_url(get_option('siteurl'));
        $home = $home['scheme'] . '://' . $home['host'];
        
        if ($wpdb->get_var("SHOW TABLES LIKE '" . $this->DataTable . "'") != $this->DataTable) {
            $installed = 'N';
        } else {
            $installed = 'Y';
            $data = print_r($wpdb->get_results("SELECT * FROM `" . $this->DataTable . "`"), true);
        }
        header('Content-type: application/xml');
        echo "<?xml version=\"1.0\" ?>\n";
        ?>
        <info>
        <lastRefresh><?php echo get_option('textlink_vn_last_update') ?></lastRefresh>
        <version><?php echo $this->version ?></version>
        <caching><?php echo defined('WP_CACHE') ? 'Y' : 'N' ?></caching>
        <phpVersion><?php echo phpversion() ?></phpVersion>
        <engineVersion><?php echo $wp_version ?></engineVersion>
        <installed><?php echo $installed ?></installed>
        <data><![CDATA[<?php echo $data ?>]]></data>
        <requestUrl><?php echo $home; ?></requestUrl>
        </info> 
        <?php            
    }

    function installDatabase()
    {
        global $wpdb;

        require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

        $sql = "DROP TABLE IF EXISTS `" . $this->DataTable . "`";
        $wpdb->query($sql);
        
        $sql = "CREATE TABLE `" . $this->DataTable . "` (
                  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `post_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
                  `url` VARCHAR(255) NOT NULL,
                  `text` VARCHAR(255) NOT NULL,
                  `before_text` VARCHAR(255) NULL,
                  `after_text` VARCHAR(255) NULL,
                  `xml_key` VARCHAR(255) NULL,
                  PRIMARY KEY (`id`),
                  INDEX `post_id` (`post_id`),
                  INDEX `xml_key` (`xml_key`)
               ) AUTO_INCREMENT=1;";

        dbDelta($sql);
        $sql = "ALTER TABLE `" . $this->DataTable . "` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
        @$wpdb->query($sql);
        add_option('textlink_vn_last_update', '0000-00-00 00:00:00');

        if (!get_option('textlink_vn_between_posts')) {
            add_option('textlink_vn_between_posts', '');
        }

        if (!get_option('textlink_vn_site_keys') && $this->web_key_vn) {
            add_option('textlink_vn_site_keys', serialize(array('0' => array('url' => get_option('siteurl'), 'key' => $this->web_key_vn))));
        }
        if (!get_option('textlink_vn_fetch_method')) {
            add_option('textlink_vn_fetch_method', 0);
        }
        if (!get_option('textlink_vn_decoding')) {
            add_option('textlink_vn_decoding', 'UTF-8');
        }
        if (!get_option('textlink_vn_allow_caching')) {
            add_option('textlink_vn_allow_caching', 0);
        }
    }

    function checkInstallation()
    {
        global $wpdb;

        if ($wpdb->get_var("SHOW TABLES LIKE '" . $this->DataTable . "'") != $this->DataTable) {
            $this->installDatabase();
        }

        if (is_writable(dirname(__FILE__)) && !is_file($this->htaccess_file)) {
            $fh = fopen($this->htaccess_file, 'w+');
            fwrite($fh, $this->htaccess());
            fclose($fh); 
        }          

        if ($wpdb->get_var("SHOW COLUMNS FROM " . $this->DataTable . " LIKE 'xml_key'") != 'xml_key') {
            $wpdb->query("ALTER TABLE `" . $this->DataTable . "` ADD `xml_key` VARCHAR(20) NULL DEFAULT '' AFTER `after_text`;");
        }    
    }
    
    function htaccess()
    {
        return "<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule $ /index.php/404
</IfModule>";
    }
    
    function initialize()
    {
        global $wpdb;
        $where = '';
        $this->htaccess_file = dirname(__FILE__) . "/.htaccess";
        $this->checkInstallation();
        $this->ads = array();
        $this->between_posts = get_option('textlink_vn_between_posts') ? get_option('textlink_vn_between_posts') : '';
        $this->style_a = get_option('textlink_vn_style_a') ? get_option('textlink_vn_style_a') : '';;
        $this->style_ul = get_option('textlink_vn_style_ul') ? get_option('textlink_vn_style_ul') : '';
        $this->style_li = get_option('textlink_vn_style_li') ? get_option('textlink_vn_style_li') : '';
        $this->style_span = get_option('textlink_vn_style_span') ? get_option('textlink_vn_style_span') : '';
        $this->fetch_method = get_option('textlink_vn_fetch_method') ? get_option('textlink_vn_fetch_method') : '';
        $this->decoding = get_option('textlink_vn_decoding') ? get_option('textlink_vn_decoding') : '';
        $this->allow_caching = get_option('textlink_vn_allow_caching') ? get_option('textlink_vn_decoding') : '';
        
        if (get_option('textlink_vn_last_update') < date('Y-m-d H:i:s', time() - $this->xmlRefreshTime) || get_option('textlink_vn_last_update') > date('Y-m-d H:i:s')) {
            $this->updateLocalAds();
        }

        if ($this->web_key_vns) {
            $home = @parse_url(get_option('siteurl'));
            if ($home) {
                $home = $home['scheme'] . '://' . $home['host'];
            } else {
                $home = get_option('siteurl');
            }
            $urlBase = $home . $_SERVER['REQUEST_URI'];
            $altBase = (substr($urlBase, -1) == '/') ? substr($urlBase, 0, -1) : $urlBase . '/';
            $pageKey = isset($this->web_key_vns[$urlBase]) ? $this->web_key_vns[$urlBase] : '';
            if (!$pageKey) {
                $pageKey = isset($this->web_key_vns[$altBase]) ? $this->web_key_vns[$altBase] : '';
            }
            if (!$pageKey) {
                $altBase1 = stripos($urlBase, '://www.') !== false ? str_replace('://www.', '://', $urlBase) : str_replace('://','://www.', $urlBase);
                $pageKey = isset($this->web_key_vns[$altBase1]) ? $this->web_key_vns[$altBase1] : '';
            }
            if (!$pageKey) {
	            $altBase2 = stripos($altBase, '://www.') !== false ? str_replace('://www.', '://', $altBase) : str_replace('://','://www.', $altBase);
                $pageKey = isset($this->web_key_vns[$altBase2]) ? $this->web_key_vns[$altBase2] : '';
            }
            if ($pageKey) {
                $this->ads = $wpdb->get_results("SELECT * FROM " . $this->DataTable . " WHERE xml_key='" . mysql_real_escape_string($pageKey) . "'");
            } elseif ($this->web_key_vns['']) {
                $this->ads = $wpdb->get_results("SELECT * FROM " . $this->DataTable . " WHERE xml_key='" . mysql_real_escape_string($this->web_key_vns['']) . "'");
            }
        }
        if (!$this->ads) {
        	return;
        }
        if (!$this->allow_caching){
            define('DONOTCACHEPAGE', true);
        }
        $this->adsCount = count($this->ads);
        $this->nextAd = 0;
        $this->posts_per_page = get_option('posts_per_page');
        if ($this->posts_per_page < $this->adsCount) {
            $this->num_ads_per_post = ceil($this->adsCount / $this->posts_per_page);
        } else {
            $this->num_ads_per_post = $this->adsCount;
        }
    }

    function updateLocalAds()
    {
        global $wpdb;
        foreach ($this->web_key_vns as $url => $key) {
            $textlink_ads = 0;
            $query = '';
            $url = 'http://textlink.vn/ad_files/xml.php?k=3213afefc239592ed4c69444e4815daa&l=wordpress-tla-3.9.8';

            if (function_exists('json_decode') && is_array(json_decode('{"a":1}', true))) {
                $url .= '&f=json';
            }

            update_option('textlink_vn_last_update', date('Y-m-d H:i:s'));

            if ($xml = $this->fetchLive($url)) {
                $links = $this->decode($xml);
                $wpdb->show_errors();
                $wpdb->query("DELETE FROM `" . $this->DataTable . "` WHERE xml_key='" . mysql_real_escape_string($key) . "' OR xml_key = ''");
                if ($links && is_array($links)) {
                    foreach ($links as $link) {
                        $postId = isset($link['PostID']) ? $link['PostID'] : 0;
                        if ($postId) {
                            continue;
                        }
                        $query .= " (
                            '" . mysql_real_escape_string($link['URL']) . "',
                            '" . mysql_real_escape_string($postId) . "',
                            '" . mysql_real_escape_string($key) . "',
                            '" . mysql_real_escape_string(trim($link['Text'])) . "',
                            '" . mysql_real_escape_string(trim($link['BeforeText'])) . "',
                            '" . mysql_real_escape_string(trim($link['AfterText'])) . "'
                        ),";
                        $textlink_ads++;
                    }
                    if ($textlink_ads){
                        $wpdb->query("INSERT INTO `" . $this->DataTable . "` (`url`, `post_id`, `xml_key`, `text`, `before_text`, `after_text`) VALUES " . substr($query, 0, strlen($query) - 1));
                    }
                }
                
            }
        }
    }

    function fetchLive($url)
    {
        $results = '';
        if (!function_exists('wp_remote_get')) {
            switch ($this->fetch_method) {
                case 'curl':
                    if (function_exists('curl_init')) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);
                        curl_setopt($ch, CURLOPT_TIMEOUT, $this->connectionTimeout);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        $results = curl_exec($ch);
                        curl_close($ch);
                        break;
                    }
                case 'native':
                    if (function_exists('file_get_contents')) {
                        if (PHP_VERSION >= '5.2.1') {
                            $fgt_options = stream_context_create(
                                array(
                                    'http' => array(
                                        'timeout' => $this->connectionTimeout
                                        )
                                    )
                            ); 
                            $results = @file_get_contents($url, 0, $fgt_options);
                        } else {
                            ini_set('default_socket_timeout', $this->connectionTimeout);
                            $results = @file_get_contents($url);
                        }                    
                        break;
                    }
                default:
                    $url = parse_url($url);
                    if ($handle = @fsockopen($url["host"], 80)) {
                        if (function_exists("socket_set_timeout")) {
                            socket_set_timeout($handle, $this->connectionTimeout, 0);
                        } else if (function_exists("stream_set_timeout")) {
                            stream_set_timeout($handle, $this->connectionTimeout, 0);
                        }
            
                        fwrite($handle, "GET $url[path]?$url[query] HTTP/1.0\r\nHost: $url[host]\r\nConnection: Close\r\n\r\n");
                        while (!feof($handle)) {
                            $results .= @fread($handle, 40960);
                        }
                        fclose($handle);
                    }
                    break;
            }
        } else {
            $results = wp_remote_get($url);
            if (!is_wp_error($results)) {
                $results = substr($results['body'], strpos($results['body'], '<?'));
            } else {
                $results = '';
            }
        }

        $return = '';
        $capture = false;
        foreach (explode("\n", $results) as $line) {
            $char = substr(trim($line), 0, 1);
            if ($char == '[' || $char == '<') {
                $capture = true;
            }

            if ($capture) {
                $return .= $line . "\n";
            }
        }

        return $return;
    }

    function decode($str)
    {
        if (!function_exists('html_entity_decode')) {
            function html_entity_decode($string)
            {
               // replace numeric entities
               $str = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\1"))', $str);
               $str = preg_replace('~&#([0-9]+);~e', 'chr(\1)', $str);
               // replace literal entities
               $transTable = get_html_translation_table(HTML_ENTITIES);
               $transTable = array_flip($transTable);
               return strtr($str, $transTable);
            }
        }

        if (substr($str, 0, 1) == '[') {
            $arr = json_decode($str, true);
            foreach ($arr as $i => $a) {
                foreach ($a as $k => $v) {
                    $arr[$i][$k] = $this->decodeStr($v);
                }
            }

            return $arr;
        }

        $out = array();
        $returnData = array();

        preg_match_all("/<(.*?)>(.*?)</", $str, $out, PREG_SET_ORDER);
        $n = 0;
        while (isset($out[$n])) {
            $returnData[$out[$n][1]][] = $this->decodeStr($out[$n][0]);
            $n++;
        }

        if (!$returnData) {
            return false;
        }

        $arr = array();
        $count = count($returnData['URL']);
        for ($i = 0; $i < $count; $i++) {
            $arr[] = array(
                'BeforeText' => $returnData['BeforeText'][$i],
                'URL' => $returnData['URL'][$i],
                'Text' => $returnData['Text'][$i],
                'AfterText' => $returnData['AfterText'][$i],
            );
        }

        return $arr;
    }

    function decodeStr($str)
    {
        $search_ar = array('&#60;', '&#62;', '&#34;');
        $replace_ar = array('<', '>', '"');
        return str_replace($search_ar, $replace_ar, html_entity_decode(strip_tags($str)));
    }

    function outputHtmlAds()
    {
        foreach ($this->ads as $key => $ad) {
            if (trim($ad->text) == '' && trim($ad->before_text) == '' && trim($ad->after_text) == '') unset($this->ads[$key]);
        }
        if (count($this->ads) > 0) {
            echo "\n<ul";
            if ($this->style_ul) {
                echo ' '.$this->style_ul.'>'."\n";
            } else {
                echo '>';
            }
            foreach ($this->ads as $textlink_ads) {
            	if ($this->decoding && $this->decoding != 'UTF-8') {
	            	$after = $textlink_ads->after_text ? ' ' . iconv('UTF-8', $this->decoding, $textlink_ads->after_text) : '';
            		$before = $textlink_ads->before_text ? iconv('UTF-8', $this->decoding,$textlink_ads->before_text) . ' ' : '';
            		$text = iconv('UTF-8', $this->decoding, $textlink_ads->text);
            	} else {
            		$after = $textlink_ads->after_text ? ' ' . $textlink_ads->after_text : '';
            		$before = $textlink_ads->before_text ? $textlink_ads->before_text . ' ' : '';
            		$text = $textlink_ads->text;
            	}
                echo "<li";
                if ($this->style_li) {
                    echo ' ' . $this->style_li . '>';
                } else {
                    echo ">";
                }
                if ($this->style_span) {
                    echo '<span ' . $this->style_span . '>';
                }
                echo $before . '<a';
                if ($this->style_a) {
                    echo ' ' . $this->style_a;
                }
                echo ' href="' . $textlink_ads->url . '">' . $text . '</a>' . $after;
                if ($this->style_span) {
                    echo '</span>';
                }
                echo "</li>\n";
            }
            echo "</ul>";
        }
    }

    function cleanCache($posts=array())
    {
        if (!defined('WP_CACHE')) {
            return;   
        }

        if (count($posts) > 0) {
            //check wp-cache
            @include_once(ABSPATH . 'wp-content/plugins/wp-cache/wp-cache.php');
           
            if (function_exists('wp_cache_post_change')) {
                foreach ($posts as $post_id) {
                    wp_cache_post_change($post_id);
                }
            } else {
                //check wp-super-cache
                @include_once(ABSPATH . 'wp-content/plugins/wp-super-cache/wp-cache.php');  
                if (function_exists('wp_cache_post_change')) {
                    foreach ($posts as $post_id) {
                        wp_cache_post_change($post_id);
                    } 
                }
            }
        }
    } 
}
?>