<script src="js/SpryValidationTextField.js" type="text/javascript"></script>
<link href="js/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="js/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="js/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
{if isset($smarty.get.fpass)}
<div id="main">
  
  <div class="form-wrp">
  {if $msg ne ''}
  {$msg}
  {/if}
  
    <div class="inner">
    <div class="reg">            
      <form  name="form1" class="reg-form" method="post" action="">
      <input type="hidden" value="2" name="register_step">
     
        <div class="pkg">
            <label><span class="red">*</span>Email của bạn</label>
            <input type="text" value="" style="width:250px" name="email" class="txt2">
        </div>
       
        <div class="pkg"><input name="get_pass" type="submit" style="float:right;" value="Gửi lại mật khẩu »" class="blue-btn"></div>
      </form>
      </div>

    <!--reg--> 
    </div>
    </div>  
  <BR />
  
  {$TIP}
  
  <br />
</div>
{elseif isset($smarty.get.reset_password)}
<div id="main">  
  <div class="form-wrp">  
          <div class="inner">
            <div class="reg">   
			<div style="padding:10">
			 {if $msg ne ''}
			<p class="error"><span> {$msg}</span></p>  
			  {/if}        
              <form  name="form1" class="reg-form" method="post" action="">
			  <input type="hidden" value="2" name="update_password">			 
                <div class="pkg">
                	<label><span class="red">*</span>Nhập password mới</label>
                   <input name="password" size="30" type="password" id="password" class="txt2" />
                </div>
				  <div class="pkg">
                	<label><span class="red">*</span>Nhập lại password</label>
				<input name="confirm_password" size="30" type="password" id="pass" class="txt2" />
				</div>               
                <div class="pkg"><input name="submit_pass" type="submit" style="float:right;" value="Submit »" class="blue-btn"></div>
              </form>
			  </div>
              </div>            
            <!--reg--> 
          </div>
        </div>  
  <BR />
  
  {$TIP}
  
  <br />
</div>
{elseif $smarty.session.uid eq ''}
<div class="wrapper">
    <div class="container">
        <div class="row inner-content">
            {include file='left-menu-user.tpl'}
            <div class="col-sm-9 right-content">
                <img src="{$template_dir}/images/login.png" />
                <h4>LOGIN OR <a href="{$_config.www}/register.php">REGISTER NEW ACCOUNT</a></h4>
                <form action="{$_config.www}/account.php" class="form-horizontal" id="loginForm" method="post">
                    <fieldset>
                        <div class="control-group">
                            <h5>Your account information</h5>
                            <input name="login" type="hidden" />
                            {if $msg ne ''}
                                <div class="message-error"><span>{$msg}</span></div>
                            {/if}
                            <div class="form-group" >
                                <label for="username" class="col-sm-3 col-xs-3 control-label">Username <span>*</span></label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="col-sm-4 col-xs-4 required" value="" id="username"  name="username" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 col-xs-3 control-label">Password <span>*</span></label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="password" class="col-sm-4 col-xs-4 required" value="" id="password"  name="pass" >
                                </div>
                            </div>
                            {literal}
                                <!-- remove cache form of browser-->
                                <script type="application/javascript">
                                    jQuery(document).ready(function(){
                                        jQuery("#username").focus().attr("value","");
                                        jQuery("#password").attr("value","");
                                        jQuery.validator.messages.required = "";
                                        jQuery("#loginForm").validate();
                                    });
                                </script>
                            {/literal}
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-xs-offset-3 col-sm-9 col-xs-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="save-pw" name="save-pw" /> Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-xs-offset-3 col-sm-9 col-xs-9">
                                    <button class="submit button blue jquery-corner">Login</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

{elseif $current_acc_page=='home'}
<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} & {$_lang.Advertiser} {/if} & {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
    <tr>
      <td><h1 class="green">{$_lang.Home}</h1></td>
    </tr>
    <tr>
      <td class="style39">{$_lang.your_control_panel}</td>
    </tr>
    

    <tr>
      <td class="error">{$msg}</td>
    </tr>
  </table>   
	
	      
  <div class="splitleft">
    <div class="box">
      <div align="left">
        <table width="100%" border="0">
          <tr>
            <td width="33%"><span class="style39"><strong>{$_lang.Account_Status} </strong></span></td>
            <td width="33%"><span class="style39"><strong>{$_lang.Account_Type} </strong></span></td>
            <td width="33%"><span class="style39"><strong>{$_lang.Upgrade}</strong></span></td>
          </tr>
          <tr>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
          </tr>
          <tr>
            <td><span class="style38">{if $status=='1'}{$_lang.Live}{else}{$_lang.Inactive}{/if}</span></td>
            <td><span class="style38">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} & {$_lang.Advertiser} {/if}</span></td>
            <td>{if $smarty.session.utype=='adv'}<a href="account.php?upgrade">{$_lang.upgrade_advertiser_publisher}</a>{else}{$_lang.Already_Upgraded}{/if}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <BR />
  <div class="splitleft">
    <div class="box">
      <div align="left"> {if $getnewsletter == 'N'}
        {$_lang.not_subscribed}  {$_lang.Newsletter2}. <a href="?getNewsletter=Y">{$_lang.Subscribe}</a> {elseif $getnewsletter == 'Y'}
        {$_lang.subscribed} {$_lang.Newsletter2}. <a href="?getNewsletter=N" >{$_lang.Unsubscribe}</a> {else}
        <form action="" method="post">
          <table width="100%" border="0">
            <tr>
              <td colspan="4" class="style38"><strong><a href="seller_paymenthistory.html" class="style32">{$_lang.would_you} {$_config.website_name} {$_lang.Newsletter2}? </a></strong></td>
            </tr>
            <tr>
              <td colspan="4" class="style47">{$_lang.not_currently_subscribed} </td>
            </tr>
            <tr>
              <td width="25%" class="style38">&nbsp;</td>
              <td width="25%" class="style38"><input name="getNewsletter" type="radio" value="Y" />
                <strong><a href="seller_paymenthistory.html" class="style32">{$_lang.Yes}</a></strong></td>
              <td width="25%" class="style38"><input name="getNewsletter" type="radio" value="N" checked="checked" />
                <strong><a href="seller_paymenthistory.html" class="style32">{$_lang.No}</a></strong></td>
              <td width="25%" class="style38"><input name="Newsletter" type="submit" id="Newsletter" value="{$_lang.Update}" /></td>
            </tr>
          </table>
        </form>
        {/if} <strong><br />
        </strong></div>
    </div>
  </div>
  {$TIP}
  <br />
</div>
{elseif $current_acc_page=='current_ads'}
<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
    <tr>
      <td><h1 class="green">{$_lang.Current_Adverts_Running}</h1></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div class="splitleft">
    <div class="box">
      <div align="left">
        <table width="100%" border="0">
          <tr>
            <td><span class="style39"><strong>{$_lang.Ad}</strong></span></td>
            <td><span class="style39"><strong>{$_lang.Ad_Start_Date} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Length} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Ad_Approved}? </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Cost}</strong></span></td>
            <td><span class="style39"><strong>{$_lang.Edit}</strong></span></td>
          </tr>
          <tr>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
          </tr>
          {section name=num loop=$adinfo}
          <tr>
            <td><span class="style38">{$adinfo[num].ad}</span></td>
            <td><span class="style38">{$adinfo[num].sdate|date_format:"%d/%m/%y"}</span></td>
            <td><span class="style38">
			{if $adinfo[num].length == 'N/A'}
			N/A
			{else}
			{$adinfo[num].length} Day(s)
			{/if}
			</span></td>
            <td><span class="style38">{$adinfo[num].status}</span></td>
            <td><span class="style38">{$CURRENCY}{$adinfo[num].cost}</span></td>
            <td><span class="style38">{if $adinfo[num].status != 'Awaiting Approval'}<a href="buy_ads.php?edit=1&adv_id={$adinfo[num].adv_id}&order_product_id={$adinfo[num].ad_space_id}&ref=true&advertisersinfo_edit=1">{$_lang.Edit_Ad}</a> {/if}</span></td>
          </tr>
          {/section}
        </table>
      </div>
    </div>
  </div>
  <h1 class="green">{$_lang.Rejected_Ads} </h1>
  <div class="splitleft">
    <div class="box">
      <div align="left">
        <table width="100%" border="0">
          <tr>
            <td><span class="style39"><strong>{$_lang.Ad}</strong></span></td>
            <td><span class="style39"><strong>{$_lang.Ad_Start_Date} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Length} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Ad_Approved}? </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Cost}</strong></span></td>
          </tr>
          <tr>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
          </tr>
          {section name=num loop=$radinfo}
          <tr>
            <td><span class="style38">{$radinfo[num].ad}</span></td>
            <td><span class="style38">{$radinfo[num].sdate|date_format:"%d/%m/%y"}</span></td>
            <td><span class="style38">{$radinfo[num].length} {$_lang.Day} </span></td>
            <td><span class="style38">{$radinfo[num].status} - <a href="account.php?denied_adv_id={$radinfo[num].adv_id}">{$_lang.View_Reason}</a></span></td>
            <td><span class="style38">{$CURRENCY}{$radinfo[num].cost}</span></td>
          </tr>
          {/section}
        </table>
        <strong><br />
        </strong></div>
    </div>
  </div>
  {$TIP}
  <br />
</div>
{elseif $current_acc_page=='live_ads'}
<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
    <tr>
      <td><h1 class="green">{$_lang.Live_Ad_Stats} </h1></td>
    </tr>
    <tr>
      <td class="style39"><div align="right"><strong><img src="{$template_dir}/images/txt_ad.png" alt="" width="16" height="16" border="0" align="absmiddle" /> - {$_lang.Text_Ads} <img src="{$template_dir}/images/vdo_ad.png" alt="" width="16" height="16" border="0" align="absmiddle" /> - {$_lang.Video Ads} <img src="{$template_dir}/images/img_ad.png" alt="" width="16" height="16" border="0" align="absmiddle" /> - {$_lang.Image_Ads} </strong></div></td>
    </tr>
  </table>
  <table width="100%" border="0" align="center">
    <tr>
      <td width="100%"><div class="splitleft">
          <div class="box">
            <div align="left">
              <table width="100%" border="0">
                <tr>
                  <td width="16%"><span class="style39"><strong>{$_lang.Ad}</strong></span></td>
                  <td width="11%"><span class="style39"><strong>{$_lang.Length} </strong></span></td>
                  <td width="13%"><span class="style39"><strong>{$_lang.Clicks_Today}</strong></span></td>
                  <td width="12%"><span class="style39"><strong>{$_lang.Clicks_Total} </strong></span></td>
                  <td width="18%"><span class="style39"><strong>{$_lang.Impressions_Today} </strong></span></td>
                  <td width="17%"><span class="style39"><strong>{$_lang.Impressions_Total}</strong></span></td>
                  <td width="13%"><span class="style39"><strong>{$_lang.Conversions}</strong></span></td>
                </tr>
                <tr>
                  <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
                  <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
                  <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
                  <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
                  <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
                  <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
                  <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
                </tr>
                {section name=num loop=$ladinfo}
                <tr>
                  <td><span class="style47">{$ladinfo[num].ad} <img src="{$template_dir}/images/{$ladinfo[num].AdType}.png" alt="" width="16" height="16" border="0" align="absmiddle" /></span></td>
                  <td><span class="style47">{if $ladinfo[num].length != 'N/A'}{$ladinfo[num].length} Day(s){else}N/A{/if}</span></td>
                  <td><span class="style47">{$ladinfo[num].clicksToday}</span></td>
                  <td><span class="style47">{$ladinfo[num].clicksTotal}</span></td>
                  <td><span class="style47">{$ladinfo[num].impressionsToday}</span></td>
                  <td><span class="style47">{$ladinfo[num].impressionsTotal}</span></td>
                  <td><span class="style47">{$ladinfo[num].conversionsTotal}</span></td>
                </tr>
                {/section}
              </table>
            </div>
          </div>
        </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><h1><span class="green">{$_lang.Targeted_Ad_Campaign_Stats} </span></h1></td>
    </tr>
  </table>
  <div class="splitleft">
    <div class="box">
      <div align="left">
        <table width="100%" border="0">
          {if $acdmsg == 1}
          <tr>
            <td colspan="7" class="error">Ad Campaign Deleted.</td>
          </tr>
          {/if}
          <tr>
            <td width="17%"><span class="style39"><strong>{$_lang.Campaign_Name} </strong></span></td>
            <td width="24%"><span class="style39"><strong>{$_lang.Websites_Appeared_On} </strong></span></td>
            <td width="18%"><strong>{$_lang.Remaining_Budget} </strong></td>
            <td width="16%"><span class="style39"><strong>{$_lang.Click_Through_Rate} </strong></span></td>
            <td width="13%"><span class="style39"><strong>{$_lang.Clicks_Today} </strong></span></td>
            <td width="12%"><span class="style39"><strong>{$_lang.Clicks_Total} </strong></span></td>
            <td width="12%"><span class="style39"><strong>{$_lang.Action} </strong></span></td>
          </tr>
          <tr>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
          </tr>
          {section name=num loop=$tadinfo}
          <tr>
            <td><span class="style47"><a href="ad_campaign.php?campaign={$tadinfo[num].cmp_id}&edit">{$tadinfo[num].cname}</a> <img src="{$template_dir}/images/txt_ad.png" alt="" width="16" height="16" border="0" align="absmiddle" /></span></td>
            <td><span class="style47">
              <select name="wsao" onchange="void(0);" style="width: 100px;">
                
				{html_options values=$tadinfo[num].wid output=$tadinfo[num].wname}
            
              </select>
              </span></td>
            <td><span class="style38">{$CURRENCY}{$tadinfo[num].rbudget}</span></td>
            <td><span class="style38">{$CURRENCY}{$tadinfo[num].cpc}</span></td>
            <td><span class="style47">{$tadinfo[num].clicksToday}</span></td>
            <td><span class="style47">{$tadinfo[num].clicksTotal}</span></td>
            <td nowrap="nowrap">{if $tadinfo[num].pause_resume == "Y"}<a href="account.php?live_ads&amp;pause_cmp_id={$tadinfo[num].cmp_id}" title="Pause"><img src="{$template_dir}/images/icon_arrow.gif" alt="Pause" width="19" height="16" border="0" align="absmiddle" /></a>{else}<a href="account.php?live_ads&amp;resume_cmp_id={$tadinfo[num].cmp_id}" title="Resume"><img src="{$template_dir}/images/icon_arrow2.gif" alt="Resume" width="19" height="16" border="0" align="absmiddle" /></a>{/if}  <a href="account.php?live_ads&amp;delete_cmp_id={$tadinfo[num].cmp_id}" onclick="javascript: return confirm('Do you really want to Delete this Ad Campaign?');" title="Delete"><img src="{$template_dir}/images/icon_delete.gif" alt="Delete" width="19" height="16" border="0" align="absmiddle" /></a></td>
          </tr>
          {/section}
        </table>
      </div>
    </div>
  </div>
  {$TIP}
  <br />
</div>
{elseif $current_acc_page=='detailed_ads'}
<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
    <tr>
      <td><h1 class="green">{$_lang.Detailed_Ad_Stats}</h1></td>
    </tr>
    <tr>
      <td class="style6"><strong>{$_lang.stats_relate} </strong></td>
    </tr>
    <tr>
      <td><span class="error">{$msg}</span></td>
    </tr>
    <tr>
      <td><strong>{if $smarty.get.show_from!='7'}<a href="account.php?show_from=7&detailed_ads">{/if}{$_lang.ads_last_7}{if $smarty.get.show_from!='7'}</a>{/if}  | {if $smarty.get.show_from!='30'}<a href="account.php?show_from=30&detailed_ads">{/if}{$_lang.ads_last_month}{if $smarty.get.show_from!='30'}</a>{/if}  | {if $smarty.get.show_from!='0'}<a href="account.php?show_from=0&detailed_ads">{/if}{$_lang.show_finished_ads}{if $smarty.get.show_from!='0'}</a>{/if} |  {if $smarty.get.show_from!=''}<a href="account.php?detailed_ads">{/if}{$_lang.Show_All}{if $smarty.get.show_from==''}</a>{/if}</strong></td>
    </tr>
  </table>
  <div class="splitleft">
    <div class="box">
      <div align="left">
        <table width="100%" border="0">
          <tr>
            <td><span class="style39"><strong>{$_lang.Ad}</strong></span></td>
            <td><span class="style39"><strong>{$_lang.Length} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Start_Date} </strong></span></td>
            <td><strong>End Date </strong></td>
            <td><span class="style39"><strong>{$_lang.Ad_Status} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Clicks_Total} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Impressions_Total}</strong></span></td>
            <td><span class="style39"><strong>{$_lang.Conversions}</strong></span></td>
          </tr>
          <tr>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
            <td>&nbsp;</td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
          </tr>
          {section name=num loop=$dadinfo}
          <tr>
            <td><span class="style38">{$dadinfo[num].ad}</span></td>
            <td><span class="style38">{$dadinfo[num].length} Day(s)</span></td>
            <td><span class="style38">{$dadinfo[num].sdate|date_format:"%d/%m/%y"}</span></td>
            <td><span class="style38">{$dadinfo[num].edate|date_format:"%d/%m/%y"}</span></td>
            <td><span class="style38">{$dadinfo[num].status}</span>{if $dadinfo[num].status=='Awaiting Approval'}<a href="account.php?detailed_ads&cancel_ad_id={$dadinfo[num].adv_id}" onclick="javascript: return confirm('Do you really want to Cancel this Ad?\nYour account will be credited with the amount you paid for the ad.');">{$_lang.Cancel_Ad}</a>{/if}</td>
            <td><span class="style38">{$dadinfo[num].clicksTotal}</span></td>
            <td><span class="style38">{$dadinfo[num].impressionsTotal}</span></td>
            <td><span class="style38">{$dadinfo[num].conversionsTotal}</span></td>
          </tr>
          {/section}
        </table>
      </div>
    </div>
  </div>
  {$TIP}
  <br />
</div>
{elseif $current_acc_page=='new_ads'}
<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
    <tr>
      <td><h1 class="green">{$_lang.New_Ads_Approval} </h1></td>
    </tr>
    <tr>
      <td class="style39">{$_lang.approval_page1}</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div class="splitleft">
    <div class="box">
      <div align="left">
        <table width="100%" border="0">
          <tr>
            <td colspan="5">{$_lang.approval_page2} </td>
          </tr>
          <tr>
            <td width="27%"><span class="style39"><strong>{$_lang.Ad}</strong></span></td>
            <td width="16%"><span class="style39"><strong>{$_lang.Ad_Type} </strong></span></td>
            <td width="17%"><span class="style39"><strong>{$_lang.Offer_Made} </strong></span></td>
            <td width="21%"><span class="style39"><strong>{$_lang.New_Edit} </strong></span></td>
            <td width="19%"><span class="style39"><strong>{$_lang.Approve_Reject2}</strong></span></td>
          </tr>
          <tr>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
          </tr>
          {section name=num loop=$nadinfo}
          <tr>
            <td><span class="style38"><a href="ads_approval.php?adv_id={$nadinfo[num].adv_id}{if $nadinfo[num].status == 'Edit'}&edit=true{/if}">{$nadinfo[num].ad}</a></span></td>
            <td><span class="style38">{$nadinfo[num].type}</span></td>
            <td> {if $nadinfo[num].offer=='Y'}
              {$_lang.Yes} - <a href="ads_approval.php?adv_id={$nadinfo[num].adv_id}{if $nadinfo[num].status == 'Edit'}&edit=true{/if}">{$CURRENCY}{$nadinfo[num].cost}</a> {else}
              {$_lang.No}
              {/if} </td>
            <td><span class="style38">{$nadinfo[num].status}</span></td>
            <td><a href="ads_approval.php?adv_id={$nadinfo[num].adv_id}{if $nadinfo[num].status == 'Edit'}&edit=true{/if}">{$_lang.Approve}</a>/<a href="ads_approval.php?adv_id={$nadinfo[num].adv_id}{if $nadinfo[num].status == 'Edit'}&edit=true{/if}">{$_lang.Reject}</a></td>
          </tr>
          {/section}
        </table>
      </div>
    </div>
  </div>
  <h1>&nbsp;</h1>
  {$TIP}
  <br />
</div>
{elseif $current_acc_page=='set_adprices'}
<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
    <tr>
      <td><h1 class="green">{$_lang.Set_Rates} </h1></td>
    </tr>
    <tr>
      <td class="style39"></td>
    </tr>
    <tr>
      <td class="error">{$msg}</td>
    </tr>
  </table>
  <table width="100%" border="0" align="center">
    <tr>
      <td><div id="ddtabs" class="basictab">
          
        </div>
        <div id="tabcontentcontainer">
          <div id="sc1" class="tabcontent"> {$_lang.click_tab_text} </div>
          <div id="sc2" class="tabcontent"> {$_lang.click_tab_image} </div>
          <div id="sc3" class="tabcontent"> {$_lang.click_tab_video} </div>
        </div>
      </td>
    </tr>
    <tr>
      <td width="100%"><h2 align="right"> {section name=num loop=$www}
          {if $www[num].pid != $smarty.get.pid}<a href="account.php?set_adprices&pid={$www[num].pid}&tab=1" class="style37">{/if}{$www[num].web}{if $www[num].pid != $smarty.get.pid}</a>{/if} - 
          {/section} </h2></td>
    </tr>
  </table>
  <div class="splitleft" id='tab_sc1'>
    <form action="" method="post">
      <div class="box">
        <div align="left">
          <table width="100%" border="0">
            <tr>
              <td colspan="4">{$_lang.Currently_Showing} <strong>{$_lang.Text_Ads}</strong> {$_lang.Prices_For_Your_Website} <strong> {section name=num loop=$www}
                {if $www[num].pid == $smarty.get.pid}{$www[num].web}{/if}
                {/section} </strong></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="30%"><span class="style39"><strong>{$_lang.Ad_Product} </strong></span></td>
              <td width="26%"><span class="style39"><strong>{$_lang.Cost}</strong></span></td>
              <td width="20%"><span class="style39"><strong>{$_lang.Length} </strong></span></td>
              <td width="24%"><span class="style39"><strong>{$_lang.Edit}</strong></span></td>
            </tr>
            <tr>
              <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
              <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
              <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
              <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></td>
            </tr>
            {section name=num loop=$tad_rates}
            <tr>
              <td><span class="style38"> {$tad_rates[num].length} {$_lang.Day_Text_Ad} </span></td>
              <td><span class="style38">{$CURRENCY}{$tad_rates[num].cost}</span></td>
              <td><span class="style38">{$tad_rates[num].length} {$_lang.Day} </span></td>
              <td><span class="style38"><a href="account.php?edit_text_ad={$tad_rates[num].ad_id}">{$_lang.Edit}</a> | <a href="account.php?delete_text_ad={$tad_rates[num].ad_id}" onclick="javascript: return del_confirm();">{$_lang.Delete}</a> </span></td>
            </tr>
            {/section}
            
            {section name=num loop=$ppc_tad_rates}
            <tr>
              <td><span class="style38"> {if $ppc_tad_rates[num].title neq ''} {$ppc_tad_rates[num].title} {else}{$_lang.Pay_Per_Click}{/if} </span></td>
              <td><span class="style38">{$CURRENCY}{$ppc_tad_rates[num].cost}</span></td>
              <td><span class="style38">N/A</span></td>
              <td><span class="style38"><a href="account.php?edit_text_ad={$ppc_tad_rates[num].ad_id}">{$_lang.Edit}</a> | <a href="account.php?delete_text_ad={$ppc_tad_rates[num].ad_id}" onclick="javascript: return del_confirm();">{$_lang.Delete}</a> </span></td>
            </tr>
            {/section}
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="30%"><span class="style39"><strong>Add New Text Ad Product </strong></span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><select name="length" onchange="document.getElementById('tlen').innerHTML=this.value">
                  
            {section name=num loop=$txt_ad_lengths.length}
				
                  <option value="{$txt_ad_lengths.length[num]}">{$txt_ad_lengths.length[num]} {$_lang.Day_Text_Ad}</option>
                  
			{/section}
          
                </select>
              </td>
              <td><span class="style38">{$CURRENCY}
                <input name="cost" type="text" id="Cost" size="7" />
                <input name="pid" type="hidden" id="pid" value="{$smarty.get.pid}" />
                </span></td>
              <td><span class="style38" id='tlen'>1</span> day(s)</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="50" colspan="3" align="right">{$_lang.willing_offers}&nbsp;&nbsp;&nbsp; </td>
              <td><input name="accept_offers" type="radio" value="Y" checked="checked" />
                {$_lang.Yes}
                &nbsp;&nbsp;&nbsp;
                <input name="accept_offers" type="radio" value="N" />
                {$_lang.No} </td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
              <td><input class="button" name="add_txt_ad" type="submit" id="add_txt_ad" value="Add" onclick="MM_validateForm('cost','','RisNum');return document.MM_returnValue" /></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
			<!--
            <tr>
              <td colspan="2"><span class="style39"><strong>{$_lang.add_payperclick} </strong></span></td>
              <td><strong>{$_lang.Minimum_Spend} </strong></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><input name="title" type="hidden" id="title" value="{$_lang.Pay_Per_Click}" maxlength="100" /></td>
              <td><span class="style38">{$CURRENCY}
                <input name="ppc_cost" type="text" id="Pay per click Cost" size="7" />
                </span></td>
              <td><span class="style38">{$CURRENCY}
                <input name="min_spend" type="text" size="7" id="Minimum Spend " />
              </span></td>
              <td><input class="button"  name="add_ppc_txt_ad" type="submit" id="add_ppc_txt_ad" value="{$_lang.Add}"  onclick="MM_validateForm('ppc_cost','','RisNum','min_spend','','RisNum');return document.MM_returnValue" /></td>
            </tr>
			-->
          </table>
        </div>
      </div>
    </form>
  </div>
  
  
  {$TIP}
  <br />
</div>
{if $smarty.get.tab=='1'}
{literal}
<script language="javascript" type="text/javascript">
expandcontent('sc1', document.getElementById('init1'));
</script>
{/literal}
{/if}
{if $smarty.get.tab=='2'}
{literal}
<script language="javascript" type="text/javascript">
expandcontent('sc2', document.getElementById('init2'));
</script>
{/literal}
{/if}
{if $smarty.get.tab=='3'}
{literal}
<script language="javascript" type="text/javascript">
expandcontent('sc3', document.getElementById('init3'));
</script>
{/literal}
{/if}





{elseif $current_acc_page=='my_earnings'}
<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
    <tr>
      <td colspan="2"><h1 class="green">{$_lang.My_Earnings}</h1></td>
    </tr>
	 <tr>
      <td colspan="2"><h1 class="green">Affiliate Earnings</h1></td>
    </tr>
	 
    <tr>
      <td><div align="left">
          <h1><span class="style6 style22"> {if isset($smarty.get.all)}
            {$_lang.All_Ads}
            {elseif isset($smarty.get.uns)}
            {$_lang.Unsettled_Ads_Only}
            {else}
            {$heading_date|date_format:"%B %Y"}
            {/if} </span></h1>
        </div></td>
      <td><div align="right">
          <form action="account.php?my_earnings" method="post" name="f" id="f">
            <select name="month" onchange="javascript: if(this.value!=0)document.forms['f'].submit();">
              <option value="0">{$_lang.View_Month}</option>
              <option value="0">---------</option>
              
			  
			  {html_options values=$months.m_values selected=$smarty.post.month output=$months.m_names}
            
            </select>
          </form>
        </div></td>
    </tr>
    <tr>
      <td colspan="2"><span class="style39">{if !isset($smarty.get.all) || isset($smarty.post.month)}<a href="?my_earnings&all"><strong>{/if}{$_lang.View_All_Ads}{if !isset($smarty.get.all) || isset($smarty.post.month)}</strong></a>{/if} | {if !isset($smarty.get.uns) || isset($smarty.post.month)}<a href="?my_earnings&amp;uns"><strong>{/if}{$_lang.View_Unsettled_Ads_Only}{if !isset($smarty.get.uns) || isset($smarty.post.month)}</strong> </a>{/if}</span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
  <div class="splitleft">
    <div class="box">
      <div align="left">
        <table width="100%" border="0">
          <tr>
            <td><span class="style39"><strong>{$_lang.Ad_Sold_Through} </strong><strong></strong></span></td>
            <td><span class="style39"><strong>{$_lang.Ad_Sold} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Length} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Your_Earnings}*</strong></span></td>
            <td><span class="style39"><strong>{$_lang.Money_Sent} </strong></span></td>
          </tr>
          <tr>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
          </tr>
          {section name=num loop=$earning}
          <tr>
            <td><span class="style38">{$earning[num].ad}</span></td>
            <td><span class="style38">{$earning[num].sold_date|date_format:"%d/%m/%y"}</span></td>
            <td><span class="style38">{if $earning[num].length != 'N/A'}{$earning[num].length} Day(s){else}N/A{/if}</span></td>
            <td><span class="style38">{$CURRENCY}{$earning[num].price}</span></td>
            <td><span class="style38">{if $earning[num].money_sent=='Not Yet'}{$earning[num].money_sent}{else}{$earning[num].money_sent|date_format:"%d/%m/%y"}{/if}</span></td>
          </tr>
          {/section}
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="style39"><strong>{$_lang.Network_Ads_Earnings} </strong></span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
       
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
			<h2 class="right black">Earnings Total: <span class="green">{$CURRENCY}{math equation="x + y + z" x=$earning[0].total_sold y=$earning[0].ppc_total z=$earning[0].net_total}</span></h2>
			<span class="style39"><strong>{$_lang.Money_Earnt}</strong></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><span class="style38"></span></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <span class="style39"><strong>* {$_lang.includes_deduction} {$_config.website_name}'s {$_lang.fee}.</strong></span>
  {$TIP}
  <br />
</div>
{elseif $current_acc_page=='pub_live_ads'}
<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
    <tr>
      <td colspan="2"><h1 class="green">{$_lang.Live} {$_lang.Ad_Stats}</h1></td>
    </tr>
    <tr>
      <td colspan="2"><span class="style39"><strong>{$_lang.relate_ads_running} </strong></span></td>
    </tr>
    <tr>
      <td colspan="2"><div align="right">
          <h2>{section name=num loop=$www}
            {if $www[num].pid != $smarty.get.pid}<a href="account.php?pub_live_ads&pid={$www[num].pid}" class="style37">{/if}{$www[num].web}{if $www[num].pid != $smarty.get.pid}</a>{/if} - 
            {/section}</h2>
        </div></td>
    </tr>
  </table>
  <div class="splitleft">
    <div class="box">
      <div align="left">
        <table width="100%" border="0">
          <tr>
            <td><span class="style39"><strong>{$_lang.Ad_Sold_Through} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Length} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Clicks_Today}</strong></span></td>
            <td><span class="style39"><strong>{$_lang.Clicks_Total} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Impressions_Today} </strong></span></td>
            <td><span class="style39"><strong>{$_lang.Impressions_Total}</strong></span></td>
          </tr>
          <tr>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
            <td><img src="{$template_dir}/images/Bullet_green.gif" alt="" width="19" height="16" /></span></td>
          </tr>
          {section name=num loop=$pladinfo}
          <tr>
            <td><span class="style38">{$pladinfo[num].ad}</span></td>
            <td><span class="style38">{$pladinfo[num].length}</span></td>
            <td><span class="style38">{$pladinfo[num].clicksToday}</span></td>
            <td><span class="style38">{$pladinfo[num].clicksTotal}</span></td>
            <td><span class="style38">{$pladinfo[num].impressionsToday}</span></td>
            <td><span class="style38">{$pladinfo[num].impressionsTotal}</span></td>
          </tr>
          {/section}
        </table>
      </div>
    </div>
  </div>
  <h1>&nbsp;</h1>
  {$TIP}
  <br />
</div>
{elseif $current_acc_page=='ad_codes'}
<div id="maininner">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
    <tr>
      <td><h1 class="green">{$_lang.Get_Ad_Code} </h1></td>
    </tr>
    <tr>
      <td class="style39">{$_lang.customize_ads}
	  <noscript> <div class="error"> <p><strong>Javascript must be enabled</strong>
in order to use this part.</p> <p>It seems JavaScript is
either disabled or not supported by your browser, which means
<strong>the page below might not work properly.</strong></p> <p>We
apologize for this inconvenience.</p> </div> </noscript>	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right">
          <h2>{section name=num loop=$www}
            {if $www[num].pid != $smarty.get.pid}<a href="account.php?ad_codes&pid={$www[num].pid}" class="style37">{/if}{$www[num].web}{if $www[num].pid != $smarty.get.pid}</a>{/if} - 
            {/section}</h2>
          <div align="left">
            <form action="" method="post" name="menu1">
              <select name="code_type" onchange="javascript: if(this.value != 0) document.forms['menu1'].submit();">
                <option value="0">{$_lang.Select_Ad_code_type_for} {section name=num loop=$www} {if $www[num].pid == $smarty.get.pid}{$www[num].web}{/if} {/section} </option>
                <option value="text" {if $smarty.post.code_type == 'text'} selected="selected" {/if}>{$_lang.Text_Ad}</option>
                <option value="image" {if $smarty.post.code_type == 'image'} selected="selected" {/if}>{$_lang.Image_Ad}</option>                
                {if $_config.video_ad == 'on'}				
                <option value="video" {if $smarty.post.code_type == 'video'} selected="selected" {/if}>{$_lang.Video_Ad}</option>                
                {/if}
              
              </select>
            </form>
          </div>
        </div></td>
    </tr>
  </table>
<div class="splitleft"> {if isset($smarty.post.code_type)}
   
<div class="box">
        <div align="left">
		 <form action="" method="post" name="ad_code_form">
        <table width="100%" border="0" align="center">
          <tr>
            <td width="100%"><table width="100%" border="0">
                <tr>
                  <td>
                    <table class="table_outer" border="0" cellpadding="1" cellspacing="0" width="100%">
                      <tr>
                        <td><span class="style38">{$_lang.Currently_Showing} <strong>{$_lang.html_ad_code} </strong> {$_lang.For_Your_Website}: <strong>{section name=num loop=$www} {if $www[num].pid == $smarty.get.pid}{$www[num].web}{/if} {/section} </strong></span></td>
                      </tr>
                      <tr>
                        <td></td>
                      </tr>
                      <tr>
                        <td><table class="table_inner" border="0" cellpadding="12" cellspacing="0" width="100%">
                            <tr>
                              <td valign="top" width="37%" class="table_content"><b>{$_lang.Layout}:</b><br />
							  
                                <div id="customopts"> {section name=num loop=$layout.id}
                                  <input type="radio" name="img_vdo_size_id" value="{$layout.id[num]}" {if $ac.img_vdo_size_id==$layout.id[num]} checked="checked"{/if} onclick="javascript: AdQuick('layout', {$layout.width[num]}, {$layout.height[num]});" />
                                  {$layout.layout_name[num]} <br />
                                  {/section} 
                                  <br />

                                  <strong>Text Direction:</strong> <input name="text_dir" type="radio" value="Y" {if $ac.txt_hl_B == "Y"} checked="checked" {/if} onclick="javascript: AdQuick('text_dir', 'Y');" /> Horizontal <input name="text_dir" type="radio" value="N" {if $ac.txt_hl_B == "N"} checked="checked" {/if} onclick="javascript: AdQuick('text_dir', 'N');" /> Vertical<br /><br />


                                  </div>
							  </td>
                              <td valign="top" width="63%" class="table_content">
							  <div id="lines">
							  <table width="100%" border="0">
                                  <tr>
                                    <td width="62%"><span class="style39">{$_lang.Number_ads_show} </span></td>
                                    <td width="38%"><span class="style47">
                                      <input name="txt_total_ads" type="text" id="txt_total_ads" value="{$ac.txt_total_ads}" size="4" maxlength="2" onkeyup="javascript: AdQuick('totalads', this.value);" />
                                      </span></td>
                                  </tr>
                                  <tr>
                                    <td><span class="style47"> <span class="style39">{$_lang.Text_Characters_In_Headline} </span></span></td>
                                    <td><span class="style47">
                                      <input name="txt_hl_len" type="text" id="txt_hl_len" value="{$ac.txt_hl_len}" size="4" maxlength="3" />
                                      </span></td>
                                  </tr>
                                  <tr>
                                    <td><span class="style39">{$_lang.Text_Characters_In_Description} </span></td>
                                    <td><span class="style47">
                                      <input name="txt_des_len" type="text" id="txt_des_len" value="{$ac.txt_des_len}" size="4" maxlength="3" />
                                      </span></td>
                                  </tr>
                                </table>
								</div>
							  </td>
                            </tr>
                          </table></td>
                      </tr>
                    </table>
                    <table class="table_outer" border="0" cellpadding="1" cellspacing="0" width="100%">
                      <tr> </tr>
                      <tr>
                        <td >
						<div id="colors">
						<b>{$_lang.Text_Colors}</b><br />
                          <br />
                          <b>{$_lang.Border_Color}:</b> <br />
                          <input name="txt_border_c" type="text" class="med_field" id="field1" value="{$ac.txt_border_c}" size="10" maxlength="6" onkeyup="javasript: if(this.value.length==6) AdQuick('change_color', 'field1');" />
                          <a href="javascript:colorPop('field1', 'img1')" title="Choose Color"><img src="js/colorpop_icon.gif" id="img1" width="20" height="20" border="0" align="top"
						style="border:1px #666 outset;" /></a> <br />
                          <b>{$_lang.Background_Color}:</b> <br />
                          <input name="txt_bg_c" type="text" class="med_field" id="field2" value="{$ac.txt_bg_c}" size="10" maxlength="6" onkeyup="javasript: if(this.value.length==6) AdQuick('change_color', 'field2');" />
                          <a href="javascript:colorPop('field2', 'img2')" title="Choose Color"><img src="js/colorpop_icon.gif" id="img2" width="20" height="20" border="0" align="top"
						style="border:1px #666 outset;" /></a><br />
                          <b>{$_lang.Headline_Text_Color}:</b> <br />
                          <input name="txt_hl_c" type="text" class="med_field" id="field3" value="{$ac.txt_hl_c}" size="10" maxlength="6" onkeyup="javasript: if(this.value.length==6) AdQuick('change_color', 'field3');"  />
                          <a href="javascript:colorPop('field3', 'img3')" title="Choose Color"><img src="js/colorpop_icon.gif" id="img3" width="20" height="20" border="0" align="top"
						style="border:1px #666 outset;" /></a><br />
                          <b>{$_lang.Description_Text_Color}:</b> <br />
                          <input name="txt_des_c" type="text" class="med_field" id="field4" value="{$ac.txt_des_c}" size="10" maxlength="6" onkeyup="javasript: if(this.value.length==6) AdQuick('change_color', 'field4');" />
                          <a href="javascript:colorPop('field4', 'img4')" title="Choose Color"><img src="js/colorpop_icon.gif" id="img4" width="20" height="20" border="0" align="top"
						style="border:1px #666 outset;" /></a>
						</div>
						</td>
                        <td >
						<div id='fonts'>
						<b>{$_lang.Fonts}<BR />
                          <BR />
                          {$_lang.Font}: <BR />
                          <select name="txt_font"  onchange="javascript: AdQuick('font', this.value);">
                            <option value="Arial" {if $ac.txt_font == 'Arial'} selected="selected"{/if}>Arial</option>
                            <option value="Times New Roman" {if $ac.txt_font == 'Times New Roman'} selected="selected"{/if}>Times New Roman</option>
                            <option value="Verdana" {if $ac.txt_font == 'Verdana'} selected="selected"{/if}>Verdana</option>
                            <option value="Tahoma" {if $ac.txt_font == 'Tahoma'} selected="selected"{/if}>Tahoma </option>
                          </select>
                          <BR />
                          {$_lang.Headline_Font_Size}: <BR />
                          <select name="txt_hl_size" id="txt_hl_size"  onchange="javascript: AdQuick('hl_font_s', this.value);">
                            <option value="8px" {if $ac.txt_hl_size == '8px'} selected="selected"{/if}>8px</option>
                            <option value="9px" {if $ac.txt_hl_size == '9px'} selected="selected"{/if}>9px</option>
                            <option value="10px" {if $ac.txt_hl_size == '10px'} selected="selected"{/if}>10px</option>
                            <option value="11px" {if $ac.txt_hl_size == '11px'} selected="selected"{/if}>11px</option>
                            <option value="12px" {if $ac.txt_hl_size == '12px'} selected="selected"{/if}>12px </option>
                            <option value="13px" {if $ac.txt_hl_size == '13px'} selected="selected"{/if}>13px</option>
                            <option value="14px" {if $ac.txt_hl_size == '14px'} selected="selected"{/if}>14px </option>
							<option value="15px" {if $ac.txt_hl_size == '15px'} selected="selected"{/if}>15px </option>
							<option value="16px" {if $ac.txt_hl_size == '16px'} selected="selected"{/if}>16px </option>
							<option value="17px" {if $ac.txt_hl_size == '17px'} selected="selected"{/if}>17px </option>
							<option value="18px" {if $ac.txt_hl_size == '18px'} selected="selected"{/if}>18px </option>
                          </select>
                          <BR />
                          {$_lang.Description_Font_Size}: <br />
                          <select name="txt_des_size" id="txt_des_size" onchange="javascript: AdQuick('des_font_s', this.value);">
                            <option value="8px" {if $ac.txt_des_size == '8px'} selected="selected"{/if}>8px</option>
                            <option value="9px" {if $ac.txt_des_size == '9px'} selected="selected"{/if}>9px</option>
                            <option value="10px" {if $ac.txt_des_size == '10px'} selected="selected"{/if}>10px</option>
                            <option value="11px" {if $ac.txt_des_size == '11px'} selected="selected"{/if}>11px</option>
                            <option value="12px" {if $ac.txt_des_size == '12px'} selected="selected"{/if}>12px </option>
                            <option value="13px" {if $ac.txt_des_size == '13px'} selected="selected"{/if}>13px</option>
                            <option value="14px" {if $ac.txt_des_size == '14px'} selected="selected"{/if}>14px </option>
							<option value="15px" {if $ac.txt_des_size == '15px'} selected="selected"{/if}>15px </option>
							<option value="16px" {if $ac.txt_des_size == '16px'} selected="selected"{/if}>16px </option>
                          </select>
                          <br />
                          {$_lang.Headline_Text_Underlined}: <br />
                          </b>{$_lang.Yes}
                          <input name="txt_hl_U" type="radio" value="Y"  {if $ac.txt_hl_U == 'Y'} checked="checked"{/if}  onclick="AdQuick('underline', 'Y')"  />
                          {$_lang.No}
                          <input name="txt_hl_U" type="radio" value="N" {if $ac.txt_hl_U == 'N'} checked="checked"{/if}  onclick="AdQuick('underline', 'N')"   />
                       </div>
					    </td>
                        <td><b>{$_lang.Other_Options} <br />
                          <br />
                          {$_lang.show_powered_by_text}: <br />
                          </b>{$_lang.Yes}
                          <input name="txt_pow_by" type="radio" value="Y" {if $ac.txt_pow_by == 'Y'} checked="checked"{/if} onclick="javascript: document.getElementById('pow').style.display='block';" />
                          {$_lang.No}
                          <input name="txt_pow_by" type="radio" value="N"  {if $ac.txt_pow_by == 'N'} checked="checked"{/if}  onclick="javascript: document.getElementById('pow').style.display='none';" />
                          <b><br />
                          </b><b>{$_lang.show_your_ad_here_text} <br />
                          </b>{$_lang.Yes}
                          <input name="your_ad" type="radio" value="Y"  {if $ac.your_ad == 'Y'} checked="checked"{/if} onclick="javascript: document.getElementById('yad').style.display='block'; document.getElementById('yad').innerHTML='{$_lang.show_your_ad_here_text}'" />
                          {$_lang.No}
                          <input name="your_ad" type="radio" value="N"  {if $ac.your_ad == 'N'} checked="checked"{/if} onclick="javascript: document.getElementById('yad').style.display='none';" />
                          Custom <b>
                          <input name="your_ad" type="radio" value="C" id="cus"  {if $ac.your_ad == 'C'} checked="checked"{/if} onclick="javascript: document.getElementById('yad').style.display='block'; document.getElementById('yad').innerHTML=document.getElementById('yourad_title').value"  />
                          <BR />
                          <input name="yourad_title" type="text" id="yourad_title" value="{$ac.yourad_title}" size="10" onfocus="javascript: document.getElementById('cus').checked='checked'; document.getElementById('yad').innerHTML = this.value; document.getElementById('yad').style.display='block';" onkeyup="javascript: document.getElementById('yad').innerHTML = this.value;" />
                          <br />
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3"><div align="right">                        
						 {if $smarty.post.code_type != 'text'} 
						 	<script language="javascript" type="text/javascript">
							//	document.getElementById('customopts').style.display = 'none';
								document.getElementById('fonts').style.display = 'none';
								document.getElementById('colors').style.display = 'none';
								document.getElementById('lines').style.display = 'none';
							</script>
						 {/if}
                         	<input name="code_type" type="hidden" value="{$smarty.post.code_type}" />
                            <input name="type" type="hidden" value="{$smarty.post.code_type}" />
                            <input name="pid" type="hidden" value="{$smarty.get.pid}" />
                        </div></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3"><b>&nbsp;{$_lang.Your_Ads_Look} </b> </td>
                      </tr>
                      <tr>
                        <td colspan="3"><table class="table_inner" border="0" cellpadding="3" cellspacing="0" width="100%">
                            <tr>
                              <td valign="top" class="table_content" align="center">
							  <div id="pow" align="center" style="text-align:center; overflow:hidden; padding-left:0px; margin:0px;">{$_lang.Powered_By} {$_config.website_name}</div>
							  <div id="ad_code" style="overflow:hidden; padding-left:2px; margin:0px;"></div>
							  <div id="yad" align="center" style="overflow:hidden; padding-left:0px; margin:0px; text-align:center; text-decoration:underline;">{$_lang.Your_Ad_Here}</div>
							  </td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td colspan="3"></td>
                      </tr>
                    </table>
                    <br />
                    <table class="table_outer" border="0" cellpadding="1" cellspacing="0" width="100%">
                      <tr>
                        <td valign="bottom"><b><span class="error">
                          <input name="save" type="submit" id="save" value="Save Settings" class="button" />
                        ({$_lang.save_settings_code}) </span> <br />
                        &nbsp;</b></td>
                      </tr>
                      <tr>
                        <td><table class="table_inner" border="0" cellpadding="12" cellspacing="0" width="100%">
                            <tr>
                              <td valign="top" class="table_content">
                                <b><span class="style39">{$_lang.Your} {$_config.website_name} {$_lang.html_copy_paste}</span></b> <br />
<textarea name="codeField" rows="1" readonly="readonly" style="width:650px; height:50px;" onfocus="this.select();"><script type="text/javascript" src="{$_config.www}/ac/?ci={$ac.code_id}"></script></textarea></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
              <h1 class="green">&nbsp;</h1></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
		</form>
      </div>
    
    <script language="javascript" type="text/javascript">
	
		{section name=num loop=$layout.id}
			{if $ac.img_vdo_size_id==$layout.id[num]} AdQuick('layout', {$layout.width[num]}, {$layout.height[num]}); {/if}
		{/section}

			AdQuick('initialize',{section name=num loop=$js}'{$js[num]}',{/section}'x');
			
			{if $ac.your_ad == 'Y'}
				document.getElementById('yad').style.display = 'block';
				document.getElementById('yad').innerHTML = 'Your Ad Here';
			{elseif $ac.your_ad == 'N'}
				document.getElementById('yad').style.display = 'none';				
			{elseif $ac.your_ad == 'C'}
				document.getElementById('yad').style.display = 'block';
				document.getElementById('yad').innerHTML = '{$ac.yourad_title}';
			{/if}
			
			{if $ac.txt_pow_by == 'N'}
				document.getElementById('pow').style.display = 'none';
			{/if}
		</script>
    {/if} </div>
	
	{$TIP}
  <br />
</div>


{elseif $current_acc_page=='network_ads'}

<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
        <tr>
          <td colspan="2"><h1 class="green">Network Ads</h1></td>
        </tr>
        
        <tr>
          <td colspan="2"><p class="style39"><strong>If you have sold no ads, you can choose to show 'Network ads' on your website. 'Network Ads' are random adverts from {$_lang.Advertiser}s who have bought ads on other websites. </strong></p>
          <p class="style39"><strong>You will be paid 50%  of {$_config.website_name}'s fee for every click through made from your website. </strong></p></td>
        </tr>
  </table>
      <div class="splitleft">
        <div class="box">
          <div align="left">
		  
	    <form action="" method="post"><table width="100%" border="0">
              <tr>
                <td width="9%">&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="23%" nowrap="nowrap" class="style32"><strong>Show Network Ads? </strong></td>
                <td colspan="2" class="style44"><strong>
                  <input name="sna" type="radio" value="Y" {if $net_show == 'Y'} checked="checked" {/if} />
                {$_lang.Yes}                <br />
                <input name="sna" type="radio" value="N" {if $net_show == 'N'} checked="checked" {/if}  />
                {$_lang.No} </strong><br /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="3" class="style44"><strong>Filter Ads </strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="3">You can choose what kind of ads will show on your website. </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="3" style="font-weight:normal;">{html_checkboxes name="cats" output=$cats.category values=$cats.cid selected=$cat_sel}</td>
              </tr>
              
              <tr>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td width="25%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="2">
                    <input name="save_net_ads" type="submit" id="save_net_ads" value="Submit" class="button" />
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></form>
            
          </div>
        </div>
      </div>
      <a href="browse.html" class="style27"></a>
  
      
      {$TIP}
      <br />
</div>
{elseif $current_acc_page == 'promotion'}
<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
        <tr>
          <td colspan="2"><h1 class="green">{$_lang.Further_Promotion}</h1></td>
        </tr>
        
        <tr>
          <td colspan="2"><p class="style39">{$_lang.The} <span class="style50">{$_config.website_name}</span> {$_lang.homepage_featured_time}<br />
{$_lang.account_page7} {$CURRENCY}{$_config.featured_rate} {$_lang.per_month}.<br />
{$_lang.account_page8} <BR /><br />
<span class="style49">{$_lang.Please_Note}:</span> {$_lang.account_page9} <span class="style50">{$_config.website_name}</span> {$_lang.homepage}. </p>
          </td>
        </tr>
  </table>
      <div class="splitleft">
        <div class="box">
          <div align="left">
		  <form action="" method="post"><table width="100%" border="0">
              <tr>
                <td width="6%">&nbsp;</td>
                <td width="44%"><span class="style56">{$_lang.Website_Name}: </span></td>
                <td width="50%"><input name="wname" type="hidden" id="wname" value="{$f_data.wname}" size="30" maxlength="100" />
                  <select name="pid" onchange="javascript: document.getElementById('wname').value=this.options[this.selectedIndex].text;">
                  	{html_options values=$www.pid output=$www.websitename selected=$f_data.pid}
                  </select>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style56">{$_lang.Your_Logo_url2}:</span></td>
                <td><span id="sprytextfield1">
                  <input name="logo_url" type="text" id="logo_url" value="{$f_data.logo_url}" size="30" maxlength="255" />
                <span class="textfieldRequiredMsg">{$_lang.Your_Logo_url2} is required.</span></span></td>
            </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style56">{$_lang.how_long_featured_homepage} </span></td>
                <td><select name="length" id="length">
                    <option value="1" {if $f_data.length == '1'} selected="selected" {/if}>1 Month</option>
                    <option value="2" {if $f_data.length == '2'} selected="selected" {/if}>2 Months</option>
                    <option value="3" {if $f_data.length == '3'} selected="selected" {/if}>3 Months</option>
                  </select>                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style56">{$_lang.Website_Description}: </span></td>
                <td><span id="sprytextarea1">
                  <textarea name="des" cols="35" rows="8" id="des">{$f_data.des}</textarea>
                <span class="textareaRequiredMsg">Description is required.</span></span></td>
            </tr>
              <tr>
                <td>&nbsp;</td>
                <td>
                    <input name="ad_to_f_bask" type="submit" id="ad_to_f_bask" class="button" value="{$_lang.Add_To_Basket}" />
                </td>
                <td>&nbsp;</td>
              </tr>
            </table></form>
            
          </div>
        </div>
      </div>
     
  
     
      {$TIP}
      <br />
</div>
{literal}
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
//-->
</script>
{/literal}

{elseif $current_acc_page == 'edit_ad'}

<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
        <tr>
          <td><h1 class="green">{$_lang.Edit}  
		  {if $edit.ad_type == 'txt_ad'}
		   {$_lang.Text}
		  {elseif $edit.ad_type == 'ppc_txt_ad'}
		  {$_lang.Pay_Per_Click_Text}
		  {elseif $edit.ad_type == 'img_ad'}
		   {$_lang.Image}
		  {elseif $edit.ad_type == 'ppc_img_ad'}
		  {$_lang.Pay_Per_Click_Image}
		  {elseif $edit.ad_type == 'vdo_ad'}
		   {$_lang.Video}
		  {elseif $edit.ad_type == 'ppc_vdo_ad'}
		  {$_lang.Pay_Per_Click_Video}
		  {/if}
	      {$_lang.Ad_Product}</h1></td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
        </tr>
  </table>
      <div class="splitleft">
        <div class="box">
          <div align="left">
		<form action="account.php?set_adprices&pid={$edit.pid}&tab={$tab}" method="post"><table width="100%" border="0">
              
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="6%">&nbsp;</td>
                <td width="44%"><span class="style39">{$_lang.Product_Name}</span></td>
                <td width="27%"><span class="style39">{$_lang.Price}</span></td>
                <td width="23%"><span class="style39">{$_lang.Edit}</span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><img src="images/Bullet_green.gif" width="19" height="16" /></span></td>
                <td><img src="images/Bullet_green.gif" width="19" height="16" /></span></td>
                <td><img src="images/Bullet_green.gif" width="19" height="16" /></span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>

		  {if $edit.ad_type == 'ppc_txt_ad'}
		  {$_lang.Pay_Per_Click_Text}
		  {elseif $edit.ad_type == 'ppc_img_ad'}
		  {$_lang.Pay_Per_Click_Image}
		  {elseif $edit.ad_type == 'ppc_vdo_ad'}
		  {$_lang.Pay_Per_Click_Video}
		  {/if}
		    
			
	{if $edit.length != '0'} 
			
			{if $edit.ad_type == 'txt_ad'}
			<select name="length" >
                  
            {section name=num loop=$txt_ad_lengths.length}
				
                  <option value="{$txt_ad_lengths.length[num]}" {if $txt_ad_lengths.length[num] == $edit.length} selected="selected" {/if}>{$txt_ad_lengths.length[num]} {$_lang.Day_Text_Ad}</option>
                  
			{/section}
          
                </select>
			{/if}	

			{if $edit.ad_type == 'img_ad'}
			<select name="length" >

            {section name=num loop=$img_ad_lengths.length}
				
                  <option value="{$img_ad_lengths.length[num]}" {if $img_ad_lengths.length[num] == $edit.length} selected="selected" {/if}>{$img_ad_lengths.length[num]} {$_lang.Day_Image_Ad}</option>
                  
			{/section}
          
                </select>
			{/if}	

			{if $edit.ad_type == 'vdo_ad'}
			<select name="length" >

            {section name=num loop=$vdo_ad_lengths.length}
				
                  <option value="{$vdo_ad_lengths.length[num]}" {if $vdo_ad_lengths.length[num] == $edit.length} selected="selected" {/if}>{$vdo_ad_lengths.length[num]} {$_lang.Day_Video_Ad}</option>
                  
			{/section}
          
                </select>
			{/if}	
				
	{/if}						
                </td>
                <td><span class="style38">{$CURRENCY}
                      <input name="cost" type="text" id="cost" value="{$edit.cost}" size="7" />
                      <input name="ad_id" type="hidden" id="ad_id" value="{$ad_space_id}" />
                </span></td>
                <td><input type="submit" name="update_ad" value="{$_lang.Edit}" onclick="MM_validateForm('cost','','RisNum');return document.MM_returnValue" class="button" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></form>
            
          </div>
        </div>
      </div>
      
      {$TIP} 
      <br />
</div>

{elseif $current_acc_page == 'ad_rejection'}

<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ...</a></h1>
  <table width="100%" border="0">
        <tr>
          <td><h1 class="green">{$_lang.Ad_Rejection}</h1></td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
        </tr>
  </table>
      <div class="splitleft">
        <div class="box">
          <div align="left">
            <table width="100%" border="0">
              <tr>
                <td><span class="style39">{$_lang.Ad}</span></td>
                <td><span class="style39">{$_lang.Reference}</span></td>
                <td><span class="style39">{$_lang.Date}</span></td>
                <td><span class="style39">{$_lang.Cost}</span></td>
              </tr>
              <tr>
                <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
              </tr>
              <tr>
                <td><span class="style38">{$ref.site_name}</span></td>
                <td><span class="style38">{$ref.adv_id}</span></td>
                <td><span class="style38">{$ref.req_date|date_format:"%d/%m/%y"}</span></td>
                <td><span class="style38">{$CURRENCY}{if $ref.ppc_balance == 0}{$ref.price}{else}{$ref.ppc_balance}{/if}</span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2"><span class="small style3"><strong>{$_lang.Reason_For_Rejection_From} {$_lang.Advertiser}. </strong></span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4"><p class="style38">{$ref.refuse_reason|nl2br}</p></td>
              </tr>
              <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4"><span class="style3 small"><strong>{$_lang.Message_From} {$_config.website_name} </strong></span></td>
              </tr>
              <tr>
                <td colspan="4"><span class="style38">{$_lang.money_credited} </span></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      
{$TIP} 
      <br />
</div>
{/if}
