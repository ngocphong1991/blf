
<div id="maininner">
      <h1><a href="account.php" class="style27">{$_lang.Publisher_Control_Panel} ...</a></h1>
      <table width="100%" border="0">
        <tr>
          <td colspan="2"><h1 class="green">{$_lang.Account_Details}</h1></td>
        </tr>
      </table>
      <div class="splitleft">
        <div class="box">
          <div align="left">
        {if $smarty.session.utype == 'pub+adv'}
          {literal}
		  <form  action="" method="post" onsubmit="javascript: if (this.company.value == '') { document.getElementById('cmp_err').style.display = 'block'; return false; } else return true;" >
          {/literal}
        {else}  
          <form  action="" method="post" >
        {/if}  
          
          <table width="100%" border="0">
              <tr>
                <td colspan="3" class="error">{if $smarty.session.just_once == 'yes'}<span class="error">You Must Enter Your Company Name Below Before Proceeding </span>{/if}</td>
              </tr>
              <tr>
                <td colspan="3" class="error">{$msg}</td>
              </tr>
              <tr>
                <td width="11%">&nbsp;</td>
                <td width="45%"><span class="style39">{$_lang.Username}:</span></td>
                <td width="44%"><span class="style39">{$smarty.post.username}</span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" /></span></td>
                <td></span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style38">{$_lang.Full_Name}</span></td>
                <td><input name="fname" type="text" id="fname" value="{$smarty.post.fullname}" size="20" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style38">{$_lang.Email_Address} </span></td>
                <td><input name="email" type="text" value="{$smarty.post.email}" size="20"  /></td>
              </tr>
              
              <tr>
                <td>&nbsp;</td>
                <td><span class="style38">{$_lang.Address} </span></td>
                <td><input name="address" type="text" id="address" value="{$smarty.post.address}" size="20" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style38">{$_lang.City}</span></td>
                <td><input name="city" type="text" value="{$smarty.post.city}" size="20" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style38">{$_lang.County_State_Province} </span></td>
                <td><input name="state" type="text" id="state" value="{$smarty.post.state}" size="20" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style38">{$_lang.Country}</span></td>
                <td><select name="country">
                  <option value="unknown">{$_lang.Select_Your_Country}</option>
                  <option value="unknown">-------</option>
                  
									{html_options values=$country output=$country selected=$smarty.post.country}
                                  
                </select></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style38">{$_lang.Post_Code} </span></td>
                <td><input name="zip" type="text" value="{$smarty.post.zip}" size="20" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style38">{$_lang.Telephone_Number} </span></td>
                <td><input name="phone" value="{$smarty.post.phone}" type="text" size="20" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>------------------------------------------------</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><div class="error" id="cmp_err" style="display: none;"> You Must Enter Your Company Name </div></td>
            </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style38">{$_lang.Company_Name}</span></td>
                <td><span class="style47">
                  <input name="company" type="text" id="company" value="{$smarty.post.company}" size="20" onkeyup="javascript: document.getElementById('cmp_err').style.display = 'none';" />
                </span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style38">{$_lang.Preferred_Payment_Method} </span></td>
                <td>{section name=num loop=$payment_methods}
						<label><input name="pm_id" value="{$payment_methods[num].id}" type="radio" {if $smarty.post.paymethod_id == $payment_methods[num].id} checked="checked" {/if} onClick="document.getElementById('pay_info').innerHTML='{$payment_methods[num].req_info}'; ">{$payment_methods[num].name}</label>
						{/section}</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span id="pay_info" class="style52">
						{section name=num loop=$payment_methods}
						{if $smarty.post.pm_id == $payment_methods[num].id}{$payment_methods[num].req_info}{/if}
						{/section}
						{if $smarty.post.pm_id == ""}{$payment_methods[0].req_info}{/if}
						</span></td>
                <td><span class="style47">
                  <input name="pinfo" type="text" value="{$smarty.post.paymethod_info}" size="20" onchange="remove_err('pi')" />
                </span></td>
              </tr>
              
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style39">{$_lang.Update_Password}: </span></td>
                <td>&nbsp;</td>
              </tr>
              
              <tr>
                <td>&nbsp;</td>
                <td><span class="style38">{$_lang.New_Password} </span></td>
                <td><input name="text_ad_pass" type="password" id="text_ad_pass" size="20" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style38">{$_lang.Confirm_New_Password} </span></td>
                <td><input name="text_ad_pass2" type="password" id="text_ad_pass2" size="20" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="Submit" value="{$_lang.Update_Details}" class="button" /></td>
                <td>&nbsp;</td>
              </tr>
            </table>
		  </form>
            
          </div>
        </div>
      </div>
      {$TIP}
</div>