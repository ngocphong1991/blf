<?php
/*
Plugin Name: TextLink.vn Advertiser Plugin 
Plugin URI: http://textlink.vn
Description: Allows many xml keys per plugin install. Text Link sell ads on specific pages. Join the Text Link marketplace.  
Author: Text Link
Version: 3.9.8
Author URI: http://textlink.vn
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
    textlink_disable_plugin();
    exit;
}
 
$wp_cache_shutdown_gc = 1;

$textlinkads_object = null;

add_action('init', 'textlink_initialize');
// general/syncing hooks

if (!textlink_widget_installed() && textlink_between_posts()) {
    add_filter('the_content', 'textlink_between_content_show');
} else {
    if ($wp_version < 2.8) {
        add_action('plugins_loaded', 'textlinkads_widget_init');
    } else {
        add_action('widgets_init', create_function('', 'return register_widget("textlinkads_widget");'));
    }
}

add_action('admin_init', 'textlink_admin_init');
add_action('admin_menu', 'textlink_admin_menu');
add_action('admin_notices', 'textlink_admin_notices');
add_action('update_option_textlink_site_keys', 'textlink_refresh');

$tlaPluginName = plugin_basename(__FILE__);  

add_filter("plugin_action_links_$tlaPluginName", 'textlink_settings_link');  

function textlink_settings_link($links) 
{  
    $plugin = plugin_basename(__FILE__);  
    $settings_link = '<a href="options-general.php?page='.$plugin.'">Settings</a>';  
    array_unshift($links, $settings_link);  
    return $links;  
}  

function textlink_admin_notices() 
{
    global $textlinkads_object;
    if ($textlinkads_object->websiteKeys) {
        return;
    }
    $pluginName = plugin_basename(__FILE__);
    echo "<div class='updated' style='background-color:#f66;'><p>" . sprintf(__('<a href="%s">Text Link Plugin</a> needs attention: please enter a site key or disable the plugin.'), "options-general.php?page=$pluginName") . "</p></div>";
}

function textlink_disable_plugin()
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

function textlink_admin_init()
{
    global $textlinkads_object;
    if (!function_exists('register_setting')) return;
    register_setting('textlinkads', 'textlink_between_posts'); 
    register_setting('textlinkads', 'textlink_site_keys', 'textlink_site_key_check'); 
    register_setting('textlinkads', 'textlink_style_a'); 
    register_setting('textlinkads', 'textlink_style_ul'); 
    register_setting('textlinkads', 'textlink_style_li'); 
    register_setting('textlinkads', 'textlink_style_span'); 
    register_setting('textlinkads', 'textlink_fetch_method');     
    register_setting('textlinkads', 'textlink_decoding');
    register_setting('textlinkads', 'textlink_allow_caching');
    
}

function textlink_site_key_check($setting)
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

function textlink_admin_menu()
{
    add_options_page('Text Link Options', 'Text Link', 'manage_options', __FILE__, 'textlink_options_page');
}

function textlink_options_page()
{
    global $textlinkads_object, $wp_version;
    $home = @parse_url(get_option('siteurl'));
    $home = $home['scheme'] . '://' . $home['host'];
    if ($_POST['action'] == 'update' && $wp_version < 2.7) {
    	update_option('textlink_between_posts', isset($_POST['textlink_between_posts']) ? $_POST['textlink_between_posts'] : 0); 
    	update_option('textlink_site_keys', textlink_site_key_check($_POST['textlink_site_keys'])); 
    	update_option('textlink_style_a', $_POST['textlink_style_a']); 
    	update_option('textlink_style_ul', $_POST['textlink_style_ul']); 
    	update_option('textlink_style_li', $_POST['textlink_style_li']); 
    	update_option('textlink_style_span', $_POST['textlink_style_span']); 
    	update_option('textlink_fetch_method', isset($_POST['textlink_fetch_method']) ? $_POST['textlink_fetch_method'] : 0);   
    	update_option('textlink_last_update', '');  
    	update_option('textlink_style_span', $_POST['textlink_style_span']); 
    	update_option('textlink_allow_caching', isset($_POST['textlink_allow_caching']) ? $_POST['textlink_allow_caching'] : 0);
    	update_option('textlink_decoding', isset($_POST['textlink_decoding']) ? $_POST['textlink_decoding'] : 0);
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
                settings_fields('textlinkads'); 
            } else { 
                echo "<input type='hidden' name='option_page' value='textlinkads' />";
                echo '<input type="hidden" name="action" value="update" />';
                wp_nonce_field("textlinkads-options");
            }
            ?>
            <style>
            .textlink_setting tr {
                border-bottom:5px solid #FFF;
            }
            .warning {
                color:red;
                border:1px solid #000;
                padding:5px;
            }
            </style>
            <table class="form-table textlink_setting">
                <tr valign="top">
                    <td colspan=2>
                    <table><tr><th width=5%></th><th>Site Key</th><th>Ad Target Url</th></tr>
                
                <?php 
                $counter = 0;
                foreach ($textlinkads_object->websiteKeys as $url => $key) { 
                ?>
                <tr valign="top">
                    <td width=10%><?php echo ($url == get_option('siteurl') || $counter == 0) ? 'Primary' : $counter;?></td>
                    <td><input type="text" name="textlink_site_keys[<?php echo $counter;?>][key]" value="<?php echo $key;?>" /></td>
                    <td style="text-align:left;">
                        <input type="text" size="50" name="textlink_site_keys[<?php echo $counter;?>][url]" value="<?php echo $url;?>" />
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
                    <td width=10%>Add New</td><td style="text-align:left;"><input type="text" name="textlink_site_keys[<?php echo $counter;?>][key]" value="" /></td><td><input type="text" name="textlink_site_keys[<?php echo $counter;?>][url]" size="50"  value="" /></td>
                </tr>
                <tr>
                    <td valign=top> Or Bulk Add<br /></td><td colspan=3><textarea wrap=off rows=3 cols=77 name="textlink_site_keys[0][mass]"></textarea><br />
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
                            <input type="radio" id="textlink_between_posts_y" name="textlink_between_posts" value="1" <?php echo get_option('textlink_between_posts') ? 'checked="checked"' : '' ?>" />
                            <label for="textlink_between_posts_y">Between Posts on Homepage</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="textlink_between_posts_n" name="textlink_between_posts" value="0" <?php echo !get_option('textlink_between_posts') ? 'checked="checked"' : '' ?>" />
                            <label for="textlink_between_posts_n">Widget or Template Based</label>
                        <?php else: ?>
                            Ads will be displayed on the urls entered above. Make sure to activate the widget or add the <br /><?php echo '&lt;'.'?'.'php'.' textlink_ads(); ?'.'&gt;';?> code to your template
                            <input type="hidden" name="textlink_between_posts" value="0" />
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
                        <?php if (function_exists('curl_init')): ?><input type=radio name="textlink_fetch_method" value="curl" <?php echo get_option('textlink_fetch_method') == 'curl' ? 'checked="checked"' : '' ?>" /> Curl <br /><?php endif; ?>
                        <?php if (function_exists('file_get_contents')): ?><input type=radio name="textlink_fetch_method" value="native" <?php echo get_option('textlink_fetch_method') == 'native' ? 'checked="checked"' : '' ?>" /> Php (file_get_contents)<br /><?php endif; ?>
                        <input type=radio name="textlink_fetch_method" value="0" <?php echo !get_option('textlink_fetch_method') ? 'checked="checked"' : '' ?>" /> Default (sockets)
                    </td>
                </tr>
                <?php endif; ?>
                 <tr>
                	<th>Allow Cached Pages</th>
                    <td><input type="checkbox" name="textlink_allow_caching" value='1' <?php echo get_option('textlink_allow_caching') ? 'checked="checked"' :'' ?>' /></td>
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
                    	<select name="textlink_decoding">
                    	<?php foreach (mb_list_encodings() as $enValue): ?>
                    		<option value="<?php echo $enValue;?>" <?php echo $textlinkads_object->decoding == $enValue || ($textlinkads_object->decoding == '' && $enValue == 'UTF-8') ? 'selected="selected"' : '';?>><?php echo $enValue;?></option>
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
                    <td><input type="text" name="textlink_style_a" value='<?php echo get_option('textlink_style_a') ? get_option('textlink_style_a') : '' ?>' /><em>&lt;a ...&gt;</em></td>
                </tr>
                <tr valign="top">
                    <td scope="row">Style span</td>
                    <td><input type="text" name="textlink_style_span" value='<?php echo get_option('textlink_style_span') ? get_option('textlink_style_span') : '' ?>' /><em>&lt;span ...&gt; </em></td>
                </tr>
                <tr valign="top">
                    <td scope="row">Style ul</td>
                    <td><input type="text" name="textlink_style_ul" value='<?php echo get_option('textlink_style_ul') ? get_option('textlink_style_ul') : '' ?>' /><em>&lt;ul ...&gt; For Widget Mode only</em></td>
                </tr>
                <tr valign="top">
                    <td scope="row">Style li</td>
                    <td><input type="text" name="textlink_style_li" value='<?php echo get_option('textlink_style_li') ? get_option('textlink_style_li') : '' ?>' /><em>&lt;li ...&gt; For Widget Mode only</em></td>
                </tr>
                <tr>
                    <td colspan=2>            
                        <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
                    </td>
                </tr>
                <?php if (!is_file($textlinkads_object->htaccess_file)): ?>
                <tr>
                    <td valign="top"><p ><div class="warning">Optional Security Additions. We want to protect your privacy. Please make sure that your <strong>plugins directory is writable</strong> or add a file named <strong>.htaccess</strong> in your <strong>textlink.vn</strong> plugin directory with the code in the textbox to your right:</div> <strong><?php echo $textlinkads_object->htaccess_file; ?></strong></p></td>
                    <td><br /><textarea cols="30" rows="10"><?php echo $textlinkads_object->htaccess(); ?></textarea>
                </td>
                </tr>
                <?php endif; ?>
            </table>
        </form>
    </div>
    <?php 
}

function textlink_widget_installed() 
{
    if (!function_exists('wp_get_sidebars_widgets')) return;
    $widgets = wp_get_sidebars_widgets(); 
    foreach ($widgets as $widget) {
        if (is_array($widget)) {
             foreach ($widget as $wid) {
                 if (stripos($wid, 'textlinkads-widget') !== false) {
                    return true;
                 }
             }
        } else {
            if (stripos($widget, 'textlinkads-widget') !== false) {
                return true;
            }
        }
    }
}

function textlink_between_posts() 
{
    return get_option('textlink_between_posts');
}

function textlink_initialize()
{
    global $wpdb, $textlinkads_object;
    $textlinkads_object = new textlinkadsObject;
    $textlinkads_object->initialize();
    if (isset($_REQUEST['textlinkads_key']) && isset($_REQUEST['textlinkads_action'])) {
        if (in_array($_REQUEST['textlinkads_key'], array_values($textlinkads_object->websiteKeys))) {
            switch($_REQUEST['textlinkads_action']) {
                case 'debug_tla':
                case 'debug':
                    $textlinkads_object->debug(isset($_REQUEST['textlinkads_reset_index']) ? $_REQUEST['textlinkads_reset_index'] : '');
                    exit;
        
                case "refresh":
                case "refresh_tla":
                    echo "refreshing";
                    textlink_refresh();
                    echo "refreshing complete";
                    break;
                    
            }
        }
    }
}

function textlink_refresh()
{
    global $textlinkads_object;
    if (get_option('textlink_last_update') < date('Y-m-d H:i:s', time() - 60)) {
        $textlinkads_object->cleanCache();
        $textlinkads_object->updateLocalAds();
    }            
}
                
function textlink_check_installation()
{
    global $textlinkads_object;

    $textlinkads_object = new textlinkadsObject;
    $textlinkads_object->checkInstallation();
}

/** WP version less than 2.8 widget functions */
if (!textlink_between_posts()) {
    if ($wp_version < 2.8) {
        function textlinkads_widget_init()
        {
            if (!function_exists('register_sidebar_widget') || !function_exists('register_widget_control')) return;
            register_sidebar_widget('textlinkads', 'textlinkads_widget');
            register_widget_control('textlinkads', 'textlinkads_widget_control');
        }
         
        function textlinkads_widget($args)
        {
            extract($args);
            global $textlinkads_object;
            if (!$textlinkads_object->ads) {
                return;
            } 
            $options = get_option('widget_textlinkads');
            $title = $options['title'];
            $before_widget = str_replace('textlinkads', '', $before_widget);
            echo $before_widget;
            echo $before_title . $title . $after_title;
            textlink_ads();
            echo $after_widget;
        }
        
        function textlinkads_widget_control()
        {
            $options = $newoptions = get_option('widget_textlinkads');
            global $textlinkads_object;

            if (isset($_POST['textlinkads-title'])) {
                $newoptions['title'] = strip_tags(stripslashes($_POST['textlinkads-title']));
            }
        
            if ($options != $newoptions) {
                $options = $newoptions;
                update_option('widget_textlinkads', $options);
            }
        
            ?>
            <p><label for="textlinkads-title">Title: <input type="text" style="width: 250px;" id="textlinkads-title" name="textlinkads-title" value="<?php echo htmlspecialchars($options['title']); ?>" /></label></p>
            <input type="hidden" name="textlinkads-submit" id="textlinkads-submit" value="1" />
        <?php
        }
    // 2.8 + Api Additions    
    } else {
        class textlinkads_Widget extends WP_Widget
        {
            function textlinkads_Widget()
            {
                parent::WP_Widget(false, $name = 'Text Link');
            }
        
            function widget($args, $instance)
            {
                global $textlinkads_object;
                if (!$textlinkads_object->ads) {
                    return;
                } 
                extract($args);
                $title = apply_filters('widget_title', empty($instance['title']) ? __('Links of Interest') : $instance['title']);
                $before_widget = str_replace('textlinkads', '', $before_widget);
                echo $before_widget;
                echo $before_title . $title . $after_title;
                textlink_ads();
                echo $after_widget;
            }
            
            function form($instance) 
            {
                global $textlinkads_object;
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
} else if (textlink_widget_installed()) {
    if (!function_exists('unregister_sidebar_widget') || !function_exists('unregister_widget_control')) return;
    unregister_sidebar_widget('textlinkads', 'textlinkads_widget');
    unregister_widget_control('textlinkads', 'textlinkads_widget_control');
}


function textlink_ads()
{
    global $textlinkads_object;
    $textlinkads_object->outputHtmlAds();
}

function textlink_between_content_show($content) 
{
    global $wpdb, $textlinkads_object;
    $adlink = '';

    if (!$textlinkads_object) {
        $textlinkads_object = new textlinkadsObject;
        $textlinkads_object->initialize();
    }

    if (is_home() || is_front_page()) {
        for ($z = 0; $z < $textlinkads_object->num_ads_per_post; $z++) {
            if ($ads = $textlinkads_object->ads[$textlinkads_object->nextAd++]) {
                if ($textlinkads_object->style_span) {
                    $adlink .= '<span ' . $textlinkads_object->style_span . '>';
                }
                $adlink .= $ads->before_text . ' <a';
                if ($textlinkads_object->style_a) {
                    $adlink .= ' ' . $textlinkads_object->style_a;
                }
                $adlink .= ' href="' . $ads->url . '">' . $ads->text.'</a> ' . $ads->after_text;
                if ($textlinkads_object->style_span) {
                    $adlink .= '</span>';
                }
            }
        }
    }
    return $content . $adlink;
}

class textlinkadsObject
{
    var $websiteKey = 'FGKPAN9ACSDX0T8WBFOA';
    var $websiteKeys = array();
    var $xmlRefreshTime = 3600;
    var $connectionTimeout = 10;
    var $DataTable = 'textlink_data';
    var $version = '3.9.8';
    var $ads;

    function textlinkadsObject()
    {
        global $table_prefix;
        $this->DataTable = $table_prefix . $this->DataTable;
        
        //overwrite default key if set in options
        $this->siteKeys = maybe_unserialize(get_option('textlink_site_keys'));
        if ($this->websiteKey && (!is_array($this->siteKeys) || count($this->siteKeys) == 0)) {
            add_option('textlink_site_keys', serialize(array('0' => array('url' => get_option('siteurl'), 'key' => $this->websiteKey))));
            $this->siteKeys = maybe_unserialize(get_option('textlink_site_keys'));
        } 
        
        if (is_array($this->siteKeys)) foreach ($this->siteKeys as $data) {
            $this->websiteKeys[trim($data['url'])] = trim($data['key']);
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
        <lastRefresh><?php echo get_option('textlink_last_update') ?></lastRefresh>
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
        add_option('textlink_last_update', '0000-00-00 00:00:00');

        if (!get_option('textlink_between_posts')) {
            add_option('textlink_between_posts', '');
        }

        if (!get_option('textlink_site_keys') && $this->websiteKey) {
            add_option('textlink_site_keys', serialize(array('0' => array('url' => get_option('siteurl'), 'key' => $this->websiteKey))));
        }
        if (!get_option('textlink_fetch_method')) {
            add_option('textlink_fetch_method', 0);
        }
        if (!get_option('textlink_decoding')) {
            add_option('textlink_decoding', 'UTF-8');
        }
        if (!get_option('textlink_allow_caching')) {
            add_option('textlink_allow_caching', 0);
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
        $this->between_posts = get_option('textlink_between_posts') ? get_option('textlink_between_posts') : '';
        $this->style_a = get_option('textlink_style_a') ? get_option('textlink_style_a') : '';;
        $this->style_ul = get_option('textlink_style_ul') ? get_option('textlink_style_ul') : '';
        $this->style_li = get_option('textlink_style_li') ? get_option('textlink_style_li') : '';
        $this->style_span = get_option('textlink_style_span') ? get_option('textlink_style_span') : '';
        $this->fetch_method = get_option('textlink_fetch_method') ? get_option('textlink_fetch_method') : '';
        $this->decoding = get_option('textlink_decoding') ? get_option('textlink_decoding') : '';
        $this->allow_caching = get_option('textlink_allow_caching') ? get_option('textlink_decoding') : '';
        
        if (get_option('textlink_last_update') < date('Y-m-d H:i:s', time() - $this->xmlRefreshTime) || get_option('textlink_last_update') > date('Y-m-d H:i:s')) {
            $this->updateLocalAds();
        }

        if ($this->websiteKeys) {
            $home = @parse_url(get_option('siteurl'));
            if ($home) {
                $home = $home['scheme'] . '://' . $home['host'];
            } else {
                $home = get_option('siteurl');
            }
            $urlBase = $home . $_SERVER['REQUEST_URI'];
            $altBase = (substr($urlBase, -1) == '/') ? substr($urlBase, 0, -1) : $urlBase . '/';
            $pageKey = isset($this->websiteKeys[$urlBase]) ? $this->websiteKeys[$urlBase] : '';
            if (!$pageKey) {
                $pageKey = isset($this->websiteKeys[$altBase]) ? $this->websiteKeys[$altBase] : '';
            }
            if (!$pageKey) {
                $altBase1 = stripos($urlBase, '://www.') !== false ? str_replace('://www.', '://', $urlBase) : str_replace('://','://www.', $urlBase);
                $pageKey = isset($this->websiteKeys[$altBase1]) ? $this->websiteKeys[$altBase1] : '';
            }
            if (!$pageKey) {
	            $altBase2 = stripos($altBase, '://www.') !== false ? str_replace('://www.', '://', $altBase) : str_replace('://','://www.', $altBase);
                $pageKey = isset($this->websiteKeys[$altBase2]) ? $this->websiteKeys[$altBase2] : '';
            }
            if ($pageKey) {
                $this->ads = $wpdb->get_results("SELECT * FROM " . $this->DataTable . " WHERE xml_key='" . mysql_real_escape_string($pageKey) . "'");
            } elseif ($this->websiteKeys['']) {
                $this->ads = $wpdb->get_results("SELECT * FROM " . $this->DataTable . " WHERE xml_key='" . mysql_real_escape_string($this->websiteKeys['']) . "'");
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
        foreach ($this->websiteKeys as $url => $key) {
            $ads = 0;
            $query = '';
            $url = 'http://textlink.vn/ad_files/xml.php?k=c467dbf145ec55f230ff277152b5060d&l=wordpress-tla-3.9.8';

            if (function_exists('json_decode') && is_array(json_decode('{"a":1}', true))) {
                $url .= '&f=json';
            }

            update_option('textlink_last_update', date('Y-m-d H:i:s'));

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
                        $ads++;
                    }
                    if ($ads){
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
            foreach ($this->ads as $ads) {
            	if ($this->decoding && $this->decoding != 'UTF-8') {
	            	$after = $ads->after_text ? ' ' . iconv('UTF-8', $this->decoding, $ads->after_text) : '';
            		$before = $ads->before_text ? iconv('UTF-8', $this->decoding,$ads->before_text) . ' ' : '';
            		$text = iconv('UTF-8', $this->decoding, $ads->text);
            	} else {
            		$after = $ads->after_text ? ' ' . $ads->after_text : '';
            		$before = $ads->before_text ? $ads->before_text . ' ' : '';
            		$text = $ads->text;
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
                echo ' href="' . $ads->url . '">' . $text . '</a>' . $after;
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