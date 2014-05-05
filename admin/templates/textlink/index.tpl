{literal}
<style>
.style41 {color: #FF0000; font-weight: normal;}
</style>
{/literal}

{if $smarty.session.admin_uid eq ''}
<div id="main">
  <h1><a href="../admin/" class="style27">{if isset($smarty.get.install_success)} Installation Complete{else}Admin Log In {/if}</a></h1>
  <table width="100%" border="0">


{if isset($smarty.get.install_success)}

      <tr>
          <td class="style39"><h1><span class="green">Please Read The Following Important Steps, To Finalise The Installation Of This Software</span></h1>
            <table width="100%" border="0">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="td"><h2 class="style41"><strong>1</strong></h2></td>
                <td class="td style41"><strong>IMPORTANT:</strong> Delete the install folder and set the permissions of the 'include' folder to 755.</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="td"><h2 class="style41"><strong>2</strong></h2></td>
                <td class="td style41">Login  Below With The Default Username and Password. (<strong> Username</strong>: admin <strong>Password</strong>: admin )</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="td"><h2 class="style41"><strong>3</strong></h2></td>
                <td class="td style41">Once You Have Logged Into Your Admin Area. Click the <strong>'System Preferences'</strong> Link and Setup Your Website Just How You Like It. By Default, the Video Ads feature is turned off. Make sure your server supports video ads before turing it on.</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="td"><h2 class="style41"><strong>4</strong></h2></td>
                <td class="td style41">Change The Default Admin Password, by clicking the  <strong>'Admin Password'</strong> link from your admin homepage.</td>
              </tr>
            </table>
         </td>
        </tr>

      {/if}

    <tr>
      <td class="error">{$msg}</td>
    </tr>
  </table>
  <div class="splitleft">
    <div class="box">
      <form id="form1" name="form1" method="post" action="">
        <table border="0" cellspacing="8" cellpadding="4">
          <tr>
            <td class="style47 green"><strong>User Name </strong></td>
            <td><input name="username" type="text" id="username" class="button" /></td>
          </tr>
          <tr>
            <td class="style47 green"><strong>Password</strong></td>
            <td><input name="pass" type="password" id="pass" class="button" /></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><input name="login" type="submit" id="login" value="LogIn" class="button" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <BR />
  <br />
</div>
{elseif isset($smarty.get.new_acc)}
<div id="main" style="margin-bottom: 20px;">
      <h1><a href="../admin/" class="style27">Admin Control Panel </a></h1>
<table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">New Account Approvals</span></h1></td>
        </tr>

        <tr>
          <td class="style39"><div align="right"></div></td>
        </tr>
      </table>

  <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                  <td><div align="justify">
                        <ul id="maintab" class="shadetabs">
                          <li class="selected"><a href="#" rel="tcontent1">New Accounts</a></li>
                          <li><a href="#" rel="tcontent2">New Websites</a></li>
                          <li><a href="#" rel="tcontent3">Approval Settings</a></li>
                        </ul>
                      <div class="tabcontentstyle">
                          <div id="tcontent1" class="tabcontent">
                            <div class="buy-area-call-to-action">

                            <div id="mini_list">
                            <table width="100%" border="0" cellpadding="5" cellspacing="5">
                                <tr>
                                  <th width="20%"><div align="left"><strong>Signup Date:</strong></div></th>
                                  <th width="20%"><div align="left"><strong>Account Type:</strong></div></th>
                                  <th width="20%"><div align="left"><strong>Username:</strong></div></th>
                                  <th width="20%"><div align="left"><strong>More Info:</strong></div></th>
                                  <th width="20%"><div align="left"><strong>Approve/Reject:</strong></div></th>
                                </tr>
                                {section name=num loop=$new_users}
                                <tr>
                                  <td><div align="left">{$new_users[num].signup_date|date_format:"%d/%m/%Y"}</div></td>
                                  <td><div align="left">{if $new_users[num].utype == 'adv'}Advertiser{else}Publisher{/if}</div></td>
                                  <td><div align="left">{$new_users[num].username}</div></td>
                                  <td><div align="left"><a href="javascript:void(0);" onclick="javascript: document.getElementById('acc_details_{$new_users[num].uid}').style.display='block'; document.getElementById('mini_list').style.display='none';">More Info</a></div></td>
                                  <td><div align="left"><a href="../admin/?new_acc&approve={$new_users[num].uid}">Approve</a> - <a href="../admin/?new_acc&reject={$new_users[num].uid}">Reject</a></div></td>
                                </tr>
                                {/section}
                              </table>
                            </div>





                            {section name=num loop=$new_users}
                            <div id="acc_details_{$new_users[num].uid}" style="display: none;">
                             <table width="100%" border="0" cellpadding="5" cellspacing="5">
                                <tr>
                                  <th width="25%">Username:</th>
                                  <th width="18%"><div align="left">{$new_users[num].username}</div></th>
                                  <th width="17%">&nbsp;</th>
                                  <th width="11%">&nbsp;</th>
                                </tr>
                                <tr>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <th>Full Name:</th>
                                  <th><div align="left">{$new_users[num].fullname}</div></th>
                                  <td colspan="2" rowspan="3"><div align="center"><a href="../admin/?new_acc&approve={$new_users[num].uid}">Approve</a> | <a href="../admin/?new_acc&reject={$new_users[num].uid}">Reject</a>
                                  </div>
                                  <div align="center"></div>                                    </td>
                                </tr>
                                <tr>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                </tr>
                                <tr>
                                  <th>Address:</th>
                                  <th><div align="left">{$new_users[num].address} <br />
                                    {$new_users[num].city}<br />
                                    {$new_users[num].state}<br />
                                    {$new_users[num].country}<br />
                                  {$new_users[num].zip}</div></th>
                                </tr>
                                <tr>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                </tr>
                                <tr>
                                  <th>Email:</th>
                                  <th><div align="left">{$new_users[num].email}</div></th>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                </tr>
                                <tr>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                </tr>
                                <tr>
                                  <th>Company Name:</th>
                                  <th><div align="left">{$new_users[num].company}</div></th>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                </tr>
                                <tr>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                </tr>
                              </table>
                              </div>
                              {/section}


                            </div>
                          </div>
                        <div id="tcontent2" class="tabcontent">
                            <div class="buy-area-call-to-action">
                              <table width="100%" border="0" cellpadding="5" cellspacing="5">
                                <tr>
                                  <th width="20%"><div align="left"><strong>Date Added:</strong></div></th>
                                  <th width="20%" nowrap="nowrap"><div align="left"><strong>Publishers Username:</strong></div></th>
                                  <th width="20%"><div align="left"><strong>Website Name:</strong></div></th>
                                  <th width="20%"><div align="left"><strong>Website URL:</strong></div></th>
                                  <th width="20%"><div align="left"><strong>Approve/Reject:</strong></div></th>
                                </tr>
                               {section name=num loop=$new_sites}
                                <tr>
                                  <td><div align="left">{$new_sites[num].member_since|date_format:"%d/%m/%Y"}</div></td>
                                  <td><div align="left">{$new_sites[num].username}</div></td>
                                  <td><div align="left">{$new_sites[num].websitename}</div></td>
                                  <td><div align="left"><a href="{$new_sites[num].url}" target="_blank">{$new_sites[num].url}</a></div></td>
                                  <td><div align="left"><a href="../admin/?new_acc&approve_site={$new_sites[num].pid}">Approve</a> - <a href="../admin/?new_acc&reject_site={$new_sites[num].pid}">Reject</a></div></td>
                                </tr>
                                {/section}
                              </table>
                            </div>
                        </div>
                        <div id="tcontent3" class="tabcontent">
                            <div class="buy-area-call-to-action">
                            <form action="" method="post">
                             <table width="100%" border="0" cellpadding="5" cellspacing="5">
                                <tr>
                                  <th width="54%"><div align="left"></div></th>
                                  <th width="18%">&nbsp;</th>
                                  <th width="17%">&nbsp;</th>
                                  <th width="11%">&nbsp;</th>
                                </tr>
                                <tr>
                                  <th><div align="left"><strong>Would You Like To Approve New User Accounts?</strong></div></th>
                                  <th><div align="right">

                                    <input name="approve_new_user" type="radio" id="radio" value="no" {if $_config.approve_new_user == 'no'} checked="checked" {/if} />
                                    No</div></th>
                                  <th>
                                    <div align="center">
                                      <input type="radio" name="approve_new_user" id="radio2" value="yes" {if $_config.approve_new_user == 'yes'} checked="checked" {/if} />
                                    Yes</div></th>
                                  <th><div align="right"></div></th>
                                </tr>
                                <tr>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                  <th><div align="center"></div></th>
                                  <th>&nbsp;</th>
                                </tr>

                                <tr>
                                  <th><div align="left"><strong>Would You Like To Approve</strong> New Websites Added By Publishers?</div></th>
                                  <th><div align="right">
                                    <input name="approve_new_site" type="radio" id="radio4" value="no" {if $_config.approve_new_site == 'no'} checked="checked" {/if} />
                                    No</div></th>
                                  <th>
                                    <div align="center">
                                      <input type="radio" name="approve_new_site" id="radio7" value="yes" {if $_config.approve_new_site == 'yes'} checked="checked" {/if} />
                                    Yes</div></th>
                                  <th><div align="right"></div></th>
                                </tr>
                                <tr>
                                  <th>&nbsp;</th>
                                  <th><div align="right"></div></th>
                                  <th><div align="center"></div></th>
                                  <th><div align="right"></div></th>
                                </tr>
                                <tr>
                                  <th><div align="left"><strong>Would You Like To</strong> Receive an Email When A New Account or Website Is Added?</div></th>
                                  <th><div align="right">
                                    <input name="get_email_notification" type="radio" id="radio5" value="no" {if $_config.get_email_notification == 'no'} checked="checked" {/if} />
                                    No</div></th>
                                  <th>
                                    <div align="center">
                                      <input type="radio" name="get_email_notification" id="radio6" value="yes" {if $_config.get_email_notification == 'yes'} checked="checked" {/if} />
                                    Yes</div></th>
                                  <th><div align="right"></div></th>
                                </tr>
                                <tr>
                                  <th>&nbsp;</th>
                                  <th>&nbsp;</th>
                                  <th><div align="center"><BR />
                                  </div></th>
                                  <th> <input type="submit" name="app_config" id="app_config" value="Update" /></th>
                                </tr>
                              </table>
                              </form>
                          </div>
                        </div>
                      </div>
                      <script type="text/javascript">
//Start Tab Content script for UL with id="maintab" Separate multiple ids each with a comma.
initializetabcontent("maintab")
                </script>
                    </div></td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
  </table>

</div>

{elseif isset($smarty.get.tips)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">{$_config.website_name} {$_lang.tips}</span></h1></td>
        </tr>
        <tr>
          <td class="style39"><div align="right"></div></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td width="5%" class="style47">&nbsp;</td>
                    <td width="55%" class="style47">&nbsp;</td>
                    <td width="13%" class="style47">&nbsp;</td>
                    <td width="3%" class="style47">&nbsp;</td>
                    <td width="3%" class="style47">&nbsp;</td>
                    <td width="21%" class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="tips"><strong>Current Tips:</strong></span></td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
				  {section name=num loop=$tips}
				  <form action="" method="post">
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td colspan="4" class="style47"><textarea name="tip_txt" style="width: 500px; height: 35px;">{$tips[num].tip}</textarea></td>
                    <td class="style47"> <input name="tip_id" type="hidden" id="tip_id" value="{$tips[num].id}" />
                      <input name="update_tip" type="submit" id="update_tip" value="Update" />
                    | <a href="../admin/?tips&delete_tip&amp;tip_id={$tips[num].id}">Delete</a> </td>
                  </tr>
				  </form>
				  {/section}
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
				  <form action="" method="post">
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td colspan="4" class="style47"><textarea name="tip_txt" style="height: 35px; width: 500px;"></textarea></td>
                    <td class="style47"><input name="add_tip" type="submit" id="add_tip" value="Add" /></td>
                  </tr>
				  </form>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>
</div>
{elseif isset($smarty.get.cat)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">{$_lang.prod_cats}</span></h1></td>
        </tr>

        <tr>
          <td class="style39"><div align="right"></div></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td width="6%" class="style47">&nbsp;</td>
                    <td width="57%" class="style47">&nbsp;</td>
                    <td width="37%" class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>Add/Edit/Delete Categories:</strong></span></td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
				  {section name=num loop=$cats.cid}
				  <form action="" method="post">
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><input name="cat" type="text" size="20" value="{$cats.category[num]}" />
					<input type="hidden" name="cid" value="{$cats.cid[num]}"  />
					<a href="../admin/?subcat&amp;cid={$cats.cid[num]}&amp;cat_name={$cats.category[num]}">Add Subcategory</a> </td>
                    <td class="style47"><input name="update_cat" type="submit" id="update_cat" value="Update" />
                    | <a href="../admin/?cat&del_cid={$cats.cid[num]}">Delete</a> </td>
                  </tr>
				  </form>
                  {/section}
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
				   <form action="" method="post">
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><input name="cat" type="text" size="20" /></td>
                    <td class="style47"><input name="add_cat" type="submit" id="add_cat" value="Add Category" /></td>
                  </tr>
				  </form>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.subcat)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Product Sub Categories</span></h1></td>
        </tr>

        <tr>
          <td class="style39"><div align="right"></div></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td width="5%" class="style47">&nbsp;</td>
                    <td width="58%" class="style47">&nbsp;</td>
                    <td width="37%" class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><a href="../admin/?cat"><strong>{$smarty.get.cat_name}</strong></a> Sub Categories </td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="tips_text"><span class="style42"><strong>Add/Edit/Delete Subcategories:</strong></span></td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  {section name=num loop=$subcats.sid}
				  <form action="" method="post">
				  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><input name="subcat" type="text" value="{$subcats.subcategory[num]}" size="20" />
					<input type="hidden" name="sid" value="{$subcats.sid[num]}"  />
					</td>
                    <td class="style47"> <input name="update_subcat" type="submit" value="Update" />
                    | <a href="../admin/?subcat&del_sid={$subcats.sid[num]}&cid={$smarty.get.cid}&cat_name={$smarty.get.cat_name}">Delete</a> </td>
                  </tr>
				  </form>
                  {/section}

                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
				  <form action="" method="post">
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><input name="subcat" type="text" size="20" /></td>
                    <td class="style47"><input name="add_subcat" type="submit" id="add_subcat" value="Add Sub Category" /></td>
                  </tr>
				  </form>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.stat)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Website Stats</span></h1></td>
        </tr>

        <tr>
          <td class="style39"><div align="right"></div></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>Ads Sold Today:</strong></span></td>
                    <td class="style47"><span class="style42"><strong>{$ad_sold_today}</strong></span></td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>Registered Members:</strong></span></td>
                    <td class="style47"><strong>{$total_users}</strong></td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>Ads Sold Today Value:</strong></span></td>
                    <td class="style47"><span class="style42"><strong>{$CURRENCY}{$ad_sold_today_value}</strong></span></td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>Newsletter Users: </strong></span></td>
                    <td class="style47"><strong>{$total_newsletter_users}</strong></td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>Ads Sold This Week: </strong></span></td>
                    <td class="style47"><span class="style42"><strong>{$ad_sold_week}</strong></span></td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>Website Unique Users Today: </strong></span></td>
                    <td class="style47"><strong>{$unique_users}</strong></td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>Ads Sold This Week Value:</strong></span></td>
                    <td class="style47"><strong>{$CURRENCY}{$ad_sold_week_value}</strong></td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>TextLink Earnings Today </strong></span></td>
                    <td class="style47"><strong>{$CURRENCY}{$earning_today}</strong></td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>Total Ads Running: </strong></span></td>
                    <td class="style47"><strong>{$total_ads}</strong></td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>TextLink Earnings This Week </strong></span></td>
                    <td class="style47"><strong>{$CURRENCY}{$earning_week}</strong></td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>Click Throughs Today: </strong></span></td>
                    <td class="style47"><strong>{$total_clicks}</strong></td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style42"><strong>TextLink Earnings This Month </strong></span></td>
                    <td class="style47"><strong>{$CURRENCY}{$earning_month}</strong></td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.money) && isset($smarty.get.uid)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Money Area</span> - Detailed View</h1></td>
        </tr>

        <tr>
          <td class="style39">&nbsp;</td>
        </tr>
        <tr>
          <td class="style39"><strong>{section name=num loop=$money}{if $money[num].uid == $smarty.get.uid}{$money[num].company}{/if}{/section} Payment Details <br />
Amount To Send: {$CURRENCY}{section name=num loop=$money}{if $money[num].uid == $smarty.get.uid}{$money[num].amount}{/if}{/section} </strong></td>
        </tr>
        <tr>
          <td class="style39"><div align="right"></div></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td><span class="style39">Company</span></td>
                    <td><span class="style47">{section name=num loop=$money}{if $money[num].uid == $smarty.get.uid}{$money[num].company}{/if}{/section}</span></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><span class="style39">Address</span></td>
                    <td><span class="style47">{section name=num loop=$money}{if $money[num].uid == $smarty.get.uid}
					{$money[num].address}<br />
					{$money[num].city}<br />
					{$money[num].state}	<br />
					{$money[num].country}
					{/if}{/section} </span></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><span class="style39">  {section name=num loop=$money}{if $money[num].uid == $smarty.get.uid}{if $money[num].paymethod_id == '1'} Paypal address {else} Cheque {/if}{/if}{/section}
                       Payable to. </span></td>
                    <td><span class="style47">{section name=num loop=$money}{if $money[num].uid == $smarty.get.uid}{$money[num].pay_info}{/if}{/section}</span></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.money)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Money Area</span></h1></td>
        </tr>

        <tr>
          <td class="style39"><div align="right"></div></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="16%"><span class="style39">Company</span></td>
                    <td width="29%"><span class="style39">Account Balance </span></td>
                    <td width="26%"><span class="style39">Payment Details </span></td>
                    <td width="23%"><span class="style39">Payment Sent </span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                  </tr>
				  {section name=num loop=$money}
                  <tr>
                    <td>&nbsp;</td>
                    <td><span class="style47">{$money[num].company}</span></td>
                    <td><strong>{$CURRENCY}{$money[num].balance}</strong></td>
                    <td><span class="style47"><a href="../admin/?money&amp;uid={$money[num].uid}">View Details</a> </span></td>
                    <td><span class="style47">{if $money[num].status == 'sent'}Sent(or low amount){else}<a href="../admin/?money&amp;send_id={$money[num].uid}&amp;amount={$money[num].amount}">Send</a>{/if}</span></td>
                  </tr>
				  {/section}
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.newsl)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Newsletter</span></h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td width="16%" class="style47">&nbsp;</td>
                    <td width="23%" class="style47">&nbsp;</td>
                    <td width="29%" class="style47">&nbsp;</td>
                    <td width="29%" class="style47">&nbsp;</td>
                    <td width="3%" class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style42"><div align="left"><strong><a href="../admin/?news_mem">View Members </a></strong></div></td>
                    <td class="style42"><div align="left"><strong><a href="../admin/?view_sent">View Sent Newsletters </a> </strong></div></td>
                    <td class="style42"><div align="left"><strong><a href="../admin/?send_newsletter">Send Newsletter</a> </strong></div></td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>
</div>
{elseif isset($smarty.get.news_mem)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Newsletter</span> - View Members</h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td width="16%" class="style47">&nbsp;</td>
                    <td width="9%" class="style47">&nbsp;</td>
                    <td width="27%" class="style47">&nbsp;</td>
                    <td width="16%" class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  {section name=num loop=$email}
				  <tr>
                    <td width="12%" class="style47">&nbsp;</td>
                    <td colspan="4" class="style47"><span class="tips"><strong>{$email[num].email}</strong></span></td>
                    <td width="20%" class="style47"><a href="../admin/?news_mem&amp;del_email={$email[num].uid}">Delete</a></td>
                  </tr>
                  {/section}

                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td colspan="2" class="style47">
					<form action="" method="post">
					<div align="right">
                        <input name="email" type="text" id="email" size="20" />
                        <input name="add_news" type="submit" class="button" value="Add" />
                    </div>
					</form>
					</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td colspan="2" class="style47">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.view_sent)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Newsletter</span> - View Sent Newsletters</h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td width="12%" class="style47">&nbsp;</td>
                    <td width="17%" class="style47">&nbsp;</td>
                    <td width="32%" class="style47">&nbsp;</td>
                    <td width="4%" class="style47">&nbsp;</td>
                    <td width="13%" class="style47">&nbsp;</td>
                    <td width="22%" class="style47">&nbsp;</td>
                  </tr>
				  {section name=num loop=$newsl}
                  <tr>
                    <td class="style39">&nbsp;</td>
                    <td class="style39"><strong>{$newsl[num].date|date_format:"%d/%m/%y"}</strong></td>
                    <td colspan="4" class="style47"><a href="../admin/?newsl_id={$newsl[num].id}"><strong>View Newsletter</strong></a> </td>
                  </tr>
                  {/section}
                  <tr>
                    <td class="style39">&nbsp;</td>
                    <td class="style39">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style39">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.newsl_id)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Newsletter</span> - View Sent Newsletter - {$news.date|date_format:"%e %B %Y"}</h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td width="45%" class="style47">&nbsp;</td>
                    <td width="43%" class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="12%" class="style47">&nbsp;</td>
                    <td colspan="2" class="style47">This newsletter was sent to {$news.total} users. </td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>

                  <tr>
                    <td class="style39">&nbsp;</td>
                    <td colspan="2" class="style39">Subject<a href="admin_newsletter_viewsent_21062006.html"></a>: {$news.sub}</td>
                  </tr>
                  <tr>
                    <td class="style39">&nbsp;</td>
                    <td class="style39">&nbsp;</td>
                    <td class="style47"><a href="admin_newsletter_viewsent_21062006.html"></a> </td>
                  </tr>
                  <tr>
                    <td class="style39">&nbsp;</td>
                    <td class="style39">Message</td>
                    <td class="style47">&nbsp;</td>
                  </tr>

                  <tr>
                    <td class="style39">&nbsp;</td>
                    <td colspan="2" class="style47">{$news.body|nl2br}</td>
                  </tr>
                  <tr>
                    <td class="style39">&nbsp;</td>
                    <td colspan="2" class="style47">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>

{elseif isset($smarty.get.send_newsletter)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Newsletter</span> - Send Newsletter</h1></td>
        </tr>
      </table>
	  <form action="../admin/?view_sent" method="post"><table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td width="7%" class="style47">&nbsp;</td>
                    <td width="36%" class="style47">&nbsp;</td>
                    <td width="50%" class="style47">&nbsp;</td>
                    <td width="7%" class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style39">Newsletter Subject</td>
                    <td class="style47"><input type="text" name="sub" id="sub" /></td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><span class="style39">Newsletter Message</span></td>
                    <td class="style47"><textarea name="body" id="body" cols="65" rows="5"></textarea></td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47"><div align="right">
                      <input type="submit" name="send_emails" id="send_emails" value="Send" class="button" />
                    </div></td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table></form>


</div>
{elseif isset($smarty.get.featured)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Featured Retailers</span></h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td><span class="style39">Company</span></td>
                    <td><span class="style39">Start Date </span></td>
                    <td><span class="style39">End Date </span></td>
                    <td><span class="style39">Length</span></td>
                    <td><span class="style39">Edit</span></td>
                    <td><span class="style39">Delete</span></td>
                  </tr>
                  <tr>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                  </tr>
                  {section name=num loop=$cf}
				  <tr>
                    <td><span class="style47">{$cf[num].company}</span></td>
                    <td><span class="style47">{$cf[num].sdate|date_format:"%d/%m/%y"}</span></td>
                    <td><span class="style47">{$cf[num].edate|date_format:"%d/%m/%y"}</span></td>
                    <td><span class="style47">{$cf[num].length} Month </span></td>
                    <td><span class="style47"><a href="../admin/?edit_fid={$cf[num].fid}">Edit</a> </span></td>
                    <td><span class="style47"><a href="../admin/?del_fid={$cf[num].fid}&amp;featured" onclick="javascript: return confirm('Do you really want to delete this request?');">Delete</a></span></td>
                  </tr>
				  {/section}
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2"><span class="style39">Waiting Companies </span></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                  </tr>
                  {section name=num loop=$wf}
				  <tr>
                    <td><span class="style47">{$wf[num].company}</span></td>
                    <td><span class="style47">{$wf[num].sdate|date_format:"%d/%m/%y"}</span></td>
                    <td><span class="style47">{$wf[num].edate|date_format:"%d/%m/%y"}</span></td>
                    <td><span class="style47">{$wf[num].length} Month </span></td>
                    <td><span class="style47"><a href="../admin/?edit_fid={$wf[num].fid}">Edit</a> </span></td>
                    <td><span class="style47"><a href="../admin/?del_fid={$wf[num].fid}&amp;featured" onclick="javascript: return confirm('Do you really want to delete this request?');">Delete</a></span></td>
                  </tr>
				  {/section}
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2"><span class="style39">Awaiting Approval </span></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                    <td>&nbsp;</td>
                  </tr>
                   {section name=num loop=$af}
				  <tr>
                    <td><span class="style47">{$af[num].company}</span></td>
                    <td><span class="style47">{$af[num].sdate|date_format:"%d/%m/%y"}</span></td>
                    <td><span class="style47">{$af[num].edate|date_format:"%d/%m/%y"}</span></td>
                    <td><span class="style47">{$af[num].length} Month </span></td>
                    <td><span class="style47"><a href="../admin/?edit_fid={$af[num].fid}">View</a> </span></td>
                    <td><span class="style47"><a href="../admin/?del_fid={$af[num].fid}&amp;featured" onclick="javascript: return confirm('Do you really want to delete this request?');">Delete</a></span></td>
                  </tr>
				  {/section}
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2"><a href="../admin/?edit_fid=0&amp;add_ff=1">Add Free Featured Retailers</a></td>
                    <td colspan="2">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <div align="right"></div>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.edit_fid)}
<div id="main">
      <h1><a href="account.html" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Featured Retailers</span> - Add/Edit</h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
			  <form action="" method="post" enctype="multipart/form-data">
			    <table width="100%" border="0">
                  <tr>
                    <td><span class="style39">Company</span></td>
                    <td>
                    <input name="wname" type="hidden" id="wname3250" value="{$ef.wname}"  />
                    {if isset($smarty.get.add_ff)}<input name="free" type="hidden" value="true" />{/if}
                    <select name="pid" id="pid" onchange="javascript: document.getElementById('wname3250').value=this.options[this.selectedIndex].text;">
                        {html_options  values=$web_list.pid output=$web_list.websitename selected=$ef.pid}
                      </select>

                      {literal}
                      	<script type="text/javascript">
                        	document.getElementById('wname3250').value = document.getElementById('pid').options[document.getElementById('pid').selectedIndex].text ;
                        </script>
                      {/literal}

                      </td>
                  </tr>
                  <tr>
                    <td><span class="style39">Start Date </span></td>
                    <td>{html_select_date time=$ef.start end_year="+1" field_order="DMY" }</td>
                  </tr>
                  <tr>
                    <td><span class="style39">Featured Length </span></td>
                    <td><select name="length" id="length">
                    <option value="1" {if $ef.length == '1'} selected="selected" {/if}>1 Month</option>
                    <option value="2" {if $ef.length == '2'} selected="selected" {/if}>2 Months</option>
                    <option value="3" {if $ef.length == '3'} selected="selected" {/if}>3 Months</option>
                  </select></td>
                  </tr>
                  <tr>
                    <td><span class="style39">Logo</span></td>
                    <td><input name="logo" type="file" id="logo" size="25" /></td>
                  </tr>
                  <tr>
                    <td><span class="style39">Description</span></td>
                    <td><textarea name="des" cols="30" rows="8" id="des">{$ef.des|sslash}</textarea></td>
                  </tr>

				  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><span class="style39">Logo URL </span></td>
                    <td><a href="{$ef.logo_url}" target="_blank"><span class="style39">{$ef.logo_url}</span></a></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="update_f" type="submit" class="button" id="update_f" value="Add to Featured Retailer" /></td>
                    <td>&nbsp;</td>
                  </tr>
                </table></form>

                <div align="right"></div>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.rates)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Pay Rates</span></h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" cellspacing="1" cellpadding="5" border="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td width="8%">&nbsp;</td>
                    <td width="34%"><b>Website</b></td>
                    <td width="28%"><b>Rate</b></td>
                    <td width="30%"></td>
                  </tr>
                    <form action="" method="post" >
				  <tr>
                    <td class="td">&nbsp;</td>

                      <td class="td"><select name="pid" id="pid" onchange="javascript: if(this.value != -1) window.location='../admin/?rates&pid='+this.value;">
					  <option value="-1"> - select - </option>
                        {html_options  values=$web_list.pid output=$web_list.websitename selected=$smarty.get.pid}
                      </select>
</td>
                    <td class="td"><input name="rate" type="text" class="effect" value="{if $pay_rate == '0'}{$_config.default_pay_rate}{else}{$pay_rate}{/if}" size="5" alt="blank" />
                      %                        </td>
                      <td class="td"><input name="update_pay_rate" type="submit" class="button" id="update_pay_rate" value="Update" /></td>

                  </tr>
				  </form>
				     <form action="" method="post" >
                  <tr>
                    <td class="td">&nbsp;</td>
                      <td class="td"><b>Default Rate</b></td>
                      <td class="td"><input type="text" name="rate" size="5" value="{$_config.default_pay_rate}" class="effect" alt="blank" />
                        %</td>
                      <td class="td"><input name="update_default_pay_rate" type="submit" class="button" id="update_pay_rate" value="Update" /></td>

                  </tr>
				  </form>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.acc)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Website Users</span></h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" cellspacing="1" cellpadding="5" border="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td width="2%">&nbsp;</td>
                    <td width="28%"><strong>Username</strong></td>
                    <td width="14%"><strong>Email</strong></td>
                    <td width="10%"><strong>Signup Date</strong></td>
                    <td width="10%"><strong>Last Login</strong></td>
                    <td width="10%"><strong>Actions</strong></td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>

                      <td class="td">&nbsp;</td>
                      <td class="td">&nbsp;</td>
                      <td class="td">&nbsp;</td>
                      <td class="td">&nbsp;</td>
                      <td class="td">&nbsp;</td>

                  </tr>
				  {section name=num loop=$acc}
                  <tr>
                    <td class="td">&nbsp;</td>
                      <td class="td">{$acc[num].uname}</td>
                      <td class="td">{$acc[num].email}</td>
                      <td class="td">{$acc[num].signup|date_format:"%d/%m/%y"}</td>
                      <td class="td">{$acc[num].last|date_format:"%d/%m/%y"}</td>
                      <td class="td"><a href="../admin/?acc&suspend_acc_id={$acc[num].uid}&ts={$acc[num].status}">
                      <img src="{$template_dir}/images/icon_arrow{$acc[num].status}.gif" alt="Suspend/Active Account" width="16" height="16" border="0" /></a> <a href="update_acc.php?acc_id={$acc[num].uid}"><img src="{$template_dir}/images/icon_edit.gif" alt="User Profile" width="16" height="16" border="0" /></a> <a href="../admin/?acc&amp;del_acc_id={$acc[num].uid}" onclick="javascript: if(confirm('Do You Really Want To Delete This Account?')) return true; else return false;"><img src="{$template_dir}/images/icon_delete.gif" alt="Delete Account" width="16" height="16" border="0" /></a></td>

                  </tr>
				  {/section}
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.credit)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Credit User Accounts</span></h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
			  <form action="" method="post"><table width="100%" cellspacing="1" cellpadding="5" border="0">
                  <tr>
                    <td colspan="4" class="error">{$msg}</td>
                  </tr>

                  <tr>
                    <td width="28%" class="td">&nbsp;</td>

                      <td width="13%" class="td"><b>User Name </b></td>
                      <td width="29%" class="td"><select name="uid" >
                        {html_options options=$u_acc selected=$smarty.post.uid}
                      </select></td>
                      <td width="30%" class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>

                      <td class="td"><b>Amount</b></td>
                      <td class="td">{$CURRENCY}
                        <input name="amount" type="text" class="effect" id="amount" size="5" alt="blank" /></td>
                      <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td"><div align="right">
                      <input name="credit_acc" type="submit" class="button" id="credit_acc" value="Add" />
                    </div></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  </table>
			  </form>

              <div align="right"></div>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.pref)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">{$_lang.sys_pref}</span></h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
			  <form action="" method="post"><table width="100%" cellspacing="1" cellpadding="5" border="0">
                  <tr>
                    <td width="7%">&nbsp;</td>
                    <td width="47%">&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                    <td width="20%"></td>
                  </tr>

                  <tr>
                    <td class="td">&nbsp;</td>

                      <td class="td"><b>Website Name</b></td>
                      <td colspan="2" class="td"><input name="website_name" type="text" class="effect" id="website_name" value="{$_config.website_name}" size="20" alt="blank" /></td>
                      <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><strong>Root URL</strong></td>
                    <td colspan="2" class="td"><input name="www" type="text" class="effect" value="{$_config.www}" size="20" alt="blank" /></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>

                      <td class="td"><b>Admins Email Address</b></td>
                      <td colspan="2" class="td"><input name="admin_email" type="text" class="effect" id="admin_email" value="{$_config.admin_email}" size="20" alt="blank" /></td>
                      <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td colspan="2" class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><strong>Payment Gateway</strong></td>
                    <td colspan="2" class="td">

                        <select name="pay_method" id="pay_method">
                          <option value="PayPal"  {if $_config.pay_method == 'PayPal'} selected="selected" {/if}>Paypal</option>
                          <option value="2CO"  {if $_config.pay_method == '2CO'} selected="selected" {/if}>2checkout.com</option>
                          <option value="Setcom"  {if $_config.pay_method == 'Setcom'} selected="selected" {/if}>Setcom.com</option>
                        </select>
                      </td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><strong>Paypal Email Address</strong></td>
                    <td colspan="2" class="td"><input name="PayPal" type="text" class="effect" id="PayPal" value="{$_config.PayPal}" size="20"  /></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><strong>2checkout.com User ID</strong></td>
                    <td colspan="2" class="td"><input name="2CO" type="text" class="effect" id="2CO" value="{$_config.2CO}" size="20"  /></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><strong>setcom.com User ID</strong></td>
                    <td colspan="2" class="td"><input name="Setcom" type="text" class="effect" id="Setcom" value="{$_config.Setcom}" size="20"  /></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td colspan="2" class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><strong>Default Currency</strong></td>
                    <td colspan="2" class="td"><h2>
                      <select name="currency" style="width: 100px;" >
                        <option value="&pound;"  {if $_config.currency == '&pound;'} selected="selected" {/if}>&pound;</option>
                        <option value="$"  {if $_config.currency == '$'} selected="selected" {/if}>$</option>
                        <option value="&#8364;"  {if $_config.currency == '&#8364;' || $_config.currency == '�'} selected="selected" {/if}>&#8364;</option>
                      </select>
                    </h2></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td colspan="2" class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>

                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><strong>Featured Retailers Cost</strong></td>
                    <td colspan="2" class="td"><strong>
                      {$CURRENCY}<input name="featured_rate" type="text" class="effect" id="featured_rate" value="{$_config.featured_rate}" size="10"  /> per month
                    </strong></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><strong>Number of Featured Retailers</strong></td>
                    <td colspan="2" class="td"><select name="max_featured" id="max_featured">
                      <option {if $_config.max_featured == 1} selected="selected" {/if} value="1">1</option>
                      <option {if $_config.max_featured == 2} selected="selected" {/if} value="2">2</option>
                      <option {if $_config.max_featured == 3} selected="selected" {/if} value="3">3</option>
                      <option {if $_config.max_featured == 4} selected="selected" {/if} value="4">4</option>
                      <option {if $_config.max_featured == 5} selected="selected" {/if} value="5">5</option>
                      <option {if $_config.max_featured == 6} selected="selected" {/if} value="6">6</option>
                      <option {if $_config.max_featured == 7} selected="selected" {/if} value="7">7</option>
                      <option {if $_config.max_featured == 8} selected="selected" {/if} value="8">8</option>
                      <option {if $_config.max_featured == 9} selected="selected" {/if} value="9">9</option>
                      <option {if $_config.max_featured == 10} selected="selected" {/if} value="10">10</option>
                     </select></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td colspan="2" class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td nowrap="nowrap" class="td"><strong>Minimum Payout Amount For Publishers</strong></td>
                    <td colspan="2" class="td"><strong>
                      {$CURRENCY}
                      <input name="min_pub_payout" type="text" class="effect" id="min_pub_payout" value="{$_config.min_pub_payout}" size="10"  />
                    </strong></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td colspan="2" class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><strong>Default Language</strong></td>
                    <td colspan="2" class="td"><select name="lang" >
                     		{html_options values=$lang_files selected=$_config.lang output=$lang_files}
                    </select></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td colspan="2" class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><strong>Website Template</strong></td>
                    <td colspan="2" class="td"><select name="template">
                      {html_options values=$tpls selected=$sel_tmp output=$tpls}
                    </select></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td colspan="2" class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><strong>Turn Video Ads On/Off?</strong></td>
                    <td width="10%" class="td">On
                    <input type="radio" name="video_ad" id="video_ad" value="on" {if $_config.video_ad == 'on'} checked="checked" {/if} /></td>
                    <td width="16%" class="td">Off
                      <input name="video_ad" type="radio" id="video_ad" value="off" {if $_config.video_ad == 'off'} checked="checked" {/if} />                    </td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><strong>License Number</strong></td>
                    <td colspan="2" align="left" class="td"><input name="key_string" type="text" id="key_string" value="{$_config.key_string}" /></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td colspan="2" align="right" class="td"><input type="submit" name="update_config" id="update_config" value="Update" class="button" /></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td colspan="2" class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                </table>
			  </form>

              <div align="right"></div>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{elseif isset($smarty.get.pass)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Admin Password</span></h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
			  {literal}
			   <form action="" method="post" onsubmit="javascript: if (this.new_pass.value != this.new_pass2.value) {alert('Password does not match!'); return false} else return true;">
			   {/literal}
                <table width="100%" cellspacing="1" cellpadding="5" border="0">
                  <tr>
                    <td colspan="4" class="error">{$msg}</td>
                  </tr>
                  <tr>
                    <td width="19%">&nbsp;</td>
                    <td width="24%"><strong>Admin User Name</strong></td>
                    <td width="27%"><span class="td">
                      <input name="name" type="text" class="effect" value="{$smarty.session.admin_username}" size="20" alt="blank" />
                    </span></td>
                    <td width="30%"></td>
                  </tr>

                  <tr>
                    <td class="td">&nbsp;</td>

                      <td class="td"><b>Old Password</b></td>
                      <td class="td"><input name="old_pass" type="password" class="effect" id="old_pass" size="20" alt="blank" /></td>
                      <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>

                      <td class="td"><b>New Password</b></td>
                      <td class="td"><input name="new_pass" type="password" class="effect" id="new_pass" size="20" alt="blank" /></td>
                      <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td"><b>Confirm New Password</b></td>
                    <td class="td"><input name="new_pass2" type="password" class="effect" id="new_pass2" size="20" alt="blank" /></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td"><div align="right">
                      <input type="submit" name="change_pass" id="change_pass" value="Update" />
                    </div></td>
                    <td class="td">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                    <td class="td">&nbsp;</td>
                  </tr>
                </table>
				</form>
              <div align="right"></div>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>

{elseif isset($smarty.get.size)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Ad Layout Size/Length</span> </h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td valign="top"><table width="100%" border="0">
                      <tr>
                        <td><strong>Text Ad Layouts</strong></td>
                      </tr>
                      {section name=num loop=$txt_layouts.id}
                      <tr>
                        <td>
                        <form action="" method="post">
                          Name
                          <input name="layout_name" type="text" id="layout_name" value="{$txt_layouts.layout_name[num]}" size="15" />
                          <br />
                          <input name="width" type="text" id="width" value="{$txt_layouts.width[num]}" size="3" maxlength="4" />
                         x
                         <input name="height" type="text" id="height" value="{$txt_layouts.height[num]}" size="3" maxlength="4" />
                         <input name="id" type="hidden" value="{$txt_layouts.id[num]}" />
                         <input type="submit" name="update_txt_size" id="update_txt_size" value="Update" />
                         <a href="../admin/?size&amp;del_txt_layout={$txt_layouts.id[num]}">delete</a>
                        </form>                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      {/section}
                      <tr>
                        <td>
                        <form action="" method="post">
                        Name
                          <input name="layout_name" type="text" value="{$txt_layouts.layout_name[num]}" size="15" />
                          <br />
                          <input name="width" type="text" value="{$txt_layouts.width[num]}" size="3" maxlength="4" />
x
<input name="height" type="text" value="{$txt_layouts.height[num]}" size="3" maxlength="4" />

<input type="submit" name="add_txt_size" value="Add" />
</form>
</td>
                      </tr>
                    </table>


                      <br />
                    </td>
                    <td valign="top"><table width="100%" border="0">
                      <tr>
                        <td><strong>Image Ad Layouts</strong></td>
                      </tr>
                      {section name=num loop=$img_layouts.id}
                      <tr>
                        <td>
                        <form action="" method="post">
                          Name
                          <input name="layout_name" type="text" id="layout_name" value="{$img_layouts.layout_name[num]}" size="15" />
                          <br />
                          <input name="width" type="text" id="width" value="{$img_layouts.width[num]}" size="3" maxlength="4" />
                         x
                         <input name="height" type="text" id="height" value="{$img_layouts.height[num]}" size="3" maxlength="4" />
                         <input name="id" type="hidden" value="{$img_layouts.id[num]}" />
                         <input type="submit" name="update_img_size" value="Update" />
                         <a href="../admin/?size&amp;del_img_layout={$img_layouts.id[num]}">delete</a>
                        </form>                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      {/section}
                      <tr>
                        <td>
                        <form action="" method="post">
                        Name
                          <input name="layout_name" type="text" value="{$img_layouts.layout_name[num]}" size="15" />
                          <br />
                          <input name="width" type="text" value="{$img_layouts.width[num]}" size="3" maxlength="4" />
x
<input name="height" type="text" value="{$img_layouts.height[num]}" size="3" maxlength="4" />

<input type="submit" name="add_img_size" value="Add" />
</form>
</td>
                      </tr>
                    </table></td>
                  <td valign="top"><table width="100%" border="0">
                      <tr>
                        <td><strong>Video Ad Layouts</strong></td>
                      </tr>
                      {section name=num loop=$vdo_layouts.id}
                      <tr>
                        <td>
                        <form action="" method="post">
                          Name
                          <input name="layout_name" type="text" id="layout_name" value="{$vdo_layouts.layout_name[num]}" size="15" />
                          <br />
                          <input name="width" type="text" id="width" value="{$vdo_layouts.width[num]}" size="3" maxlength="4" />
                         x
                         <input name="height" type="text" id="height" value="{$vdo_layouts.height[num]}" size="3" maxlength="4" />
                         <input name="id" type="hidden" value="{$vdo_layouts.id[num]}" />
                         <input type="submit" name="update_vdo_size" id="update_vdo_size" value="Update" />
                         <a href="../admin/?size&amp;del_vdo_layout={$vdo_layouts.id[num]}">delete</a>
                        </form>                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      {/section}
                      <tr>
                        <td>
                        <form action="" method="post">
                        Name
                          <input name="layout_name" type="text" value="{$vdo_layouts.layout_name[num]}" size="15" />
                          <br />
                          <input name="width" type="text" value="{$vdo_layouts.width[num]}" size="3" maxlength="4" />
x
<input name="height" type="text" value="{$vdo_layouts.height[num]}" size="3" maxlength="4" />

<input type="submit" name="add_vdo_size" value="Add" />
</form>
</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td valign="top"><table width="100%" border="0">
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2"><strong>Text Ad Lengths</strong></td>
                      </tr>
                      {section name=num loop=$txt_len.length}
                      <tr>
                        <td>{$txt_len.length[num]} Day Text Ad </td>
                        <td><a href="../admin/?size&del_txt_len={$txt_len.id[num]}">delete</a></td>
                      </tr>
                      {/section}
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2"><form id="form2" name="form2" method="post" action="">
                          <input name="len" type="text" id="len" size="4" maxlength="4" />
                                                Day Text Ad
                                                <input type="submit" name="add_txt_len" id="add_txt_len" value="Add" />
                        </form>                        </td>
                      </tr>
                    </table></td>
                    <td valign="top"><table width="100%" border="0">
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2"><strong>Image Ad Lengths</strong></td>
                      </tr>
                      {section name=num loop=$img_len.length}
                      <tr>
                        <td>{$img_len.length[num]} Day Image Ad </td>
                        <td><a href="../admin/?size&del_img_len={$img_len.id[num]}">delete</a></td>
                      </tr>
                      {/section}
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2"><form id="form2" name="form2" method="post" action="">
                          <input name="len" type="text" id="len" size="4" maxlength="4" />
                                                Day Image Ad
                                                <input type="submit" name="add_img_len" id="add_img_len" value="Add" />
                        </form>                        </td>
                      </tr>
                    </table></td>
                    <td valign="top"><table width="100%" border="0">
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2"><strong>Video Ad Lengths</strong></td>
                      </tr>
                      {section name=num loop=$vdo_len.length}
                      <tr>
                        <td>{$vdo_len.length[num]} Day Video Ad </td>
                        <td><a href="../admin/?size&del_vdo_len={$vdo_len.id[num]}">delete</a></td>
                      </tr>
                      {/section}
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2"><form id="form2" name="form2" method="post" action="">
                          <input name="len" type="text" id="len" size="4" maxlength="4" />
                                                Day Video Ad
                                                <input type="submit" name="add_vdo_len" id="add_vdo_len" value="Add" />
                        </form>                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>

{elseif isset($smarty.get.lang)}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">{$_lang.langs}</span> </h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="100%" border="0">
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td width="16%" class="style47">English</td>
                    <td width="9%" class="style47">&nbsp;</td>
                    <td width="27%" class="style47">&nbsp;</td>
                    <td width="16%" class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  {section name=num loop=$lang.lid}
				  <tr>
                    <td width="12%" class="style47">&nbsp;</td>
                    <td colspan="4" class="style47"><span class="tips"><strong>{$lang.language[num]}</strong></span></td>
                    <td width="20%" class="style47"><a href="../admin/?lang&amp;del_lang={$lang.lid[num]}">Delete</a></td>
                  </tr>
                  {/section}

                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td colspan="2" class="style47">
					<form action="" method="post">
					<div align="right">
                        <input name="lang_name" type="text" size="20" />
                        <input name="add_lang" type="submit" class="button" value="Add" />
                    </div>
					</form>
					</td>
                  </tr>
                  <tr>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td class="style47">&nbsp;</td>
                    <td colspan="2" class="style47">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{else}
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">{$_lang.home}</span> </h1></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="100%"><div class="splitleft">
            <div class="box">
              <div align="left">
                <table width="95%" border="0" align="center">
                  <tr>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="2%" class="style35">&nbsp;</td>
                    <td width="20%" nowrap="nowrap" class="style35"><strong><img src="{$template_dir}/images/note.png" alt="" width="16" height="16" border="0" align="absmiddle" /> <a href="../admin/?tips">{$_config.website_name} {$_lang.tips}</a> </strong></td>
                    <td width="28%" class="style35"><strong><img src="{$template_dir}/images/images.png" alt="" width="16" height="16" border="0" align="absmiddle" /> <a href="../admin/?cat">{$_lang.prod_cats}</a> </strong></td>
                    <td width="28%" class="style35"><strong><img src="{$template_dir}/images/language.png" alt="" width="16" height="16" border="0" align="absmiddle" /> <a href="../admin/?lang">{$_lang.langs}</a> </strong></td>
                    <td width="22%" nowrap="nowrap" class="style35"><strong><img src="{$template_dir}/images/sizes.png" alt="" width="16" height="16" border="0" align="absmiddle" /> <a href="../admin/?size">Ad Layout Size/Length</a> </strong></td>
                  </tr>
                  <tr>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style35">&nbsp;</td>
                    <td class="style35"><strong><img src="{$template_dir}/images/chart_bar.png" alt="" width="16" height="16" border="0" align="absmiddle" /> <a href="../admin/?stat">Website Stats</a> </strong></td>
                    <td class="style35"><strong><img src="{$template_dir}/images/money_dollar.png" alt="" width="16" height="16" border="0" align="absmiddle" /> <a href="../admin/?money">Money Page</a> </strong></td>
                    <td class="style35"><strong><img src="{$template_dir}/images/newspaper.png" alt="" width="16" height="16" border="0" align="absmiddle" /> <a href="../admin/?newsl">Newsletter</a> </strong></td>
                    <td class="style35"><strong><img src="{$template_dir}/images/award_star_gold_2.png" alt="" width="16" height="16" border="0" align="absmiddle" /> <a href="../admin/?featured">Featured Reatilers </a></strong></td>
                  </tr>
                  <tr>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="style35">&nbsp;</td>
                    <td class="style35"><strong><span class="style3"><img src="{$template_dir}/images/money_dollar.png" alt="" width="16" height="16" border="0" align="absmiddle" /></span> <a href="../admin/?rates">Pay Rates</a> </strong></td>
                    <td class="style35"><strong><img src="{$template_dir}/images/group.png" alt="" width="16" height="16" border="0" align="absbottom" /> <a href="../admin/?acc">User Accounts</a> </strong></td>
                    <td nowrap="nowrap" class="style35"><strong><span class="style3"><img src="{$template_dir}/images/money_dollar.png" alt="" width="16" height="16" border="0" align="absmiddle" /></span> <a href="../admin/?credit">Credit User Accounts</a> </strong></td>
                    <td class="style35"><strong><img src="{$template_dir}/images/monitor.png" alt="" width="16" height="16" border="0" align="absmiddle" /> <a href="../admin/?pref">{$_lang.sys_pref}</a></strong></td>
                  </tr>
                  <tr>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                    <td class="style35">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div></td>
        </tr>
      </table>

</div>
{/if}