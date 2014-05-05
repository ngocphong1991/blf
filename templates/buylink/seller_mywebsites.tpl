<div id="maininner">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}Advertiser {else} Publisher &amp; Advertiser {/if} Control Panel ...</a></h1>
  <table width="100%" border="0">
        <tr>
          <td><h1 class="green">{$_lang.My_Websites}</h1></td>
        </tr>
        <tr>
          <td class="style39">{$_lang.my_websites1} <u>{$_lang.Please_Note}:</u> {$_lang.my_websites2} </td>
        </tr>
  </table>
      <table width="100%" border="0" align="center">
        
        <tr>
          <td width="100%"><h2 align="right">
		  {section name=num loop=$www}
		  {if $www[num].pid != $smarty.get.pid}<a href="seller_mywebsites.php?pid={$www[num].pid}" class="style37">{/if}{$www[num].web}{if $www[num].pid != $smarty.get.pid}</a>{/if} - 
		  {/section}
		   <span class="green green">{if $smarty.get.pid neq ''}<a href="seller_mywebsites.php">{/if}{$_lang.Add_New_Website}{if $smarty.get.pid neq ''}</a>{/if} </span></h2></td>
        </tr>
      </table>
      <div class="splitleft">
  <div class="box">
    <div align="left">
	<form action="" method="post" enctype="multipart/form-data">
      <table width="100%" border="0">
        <tr>
		  <td class="error" colspan="3">{$msg}</td>
          </tr>
        <tr>
          <td width="32%"><span class="style39">{$_lang.Website_Name}: </span></td>
          <td colspan="2"><input name="wname" type="text" id="wname" value="{$smarty.post.wname}" size="30" onChange="remove_err('wn')" />
          * 
          (ie yahoo.com)  <span id=wn class="error"></span></td>
        </tr>
        <tr>
          <td><span class="style39">{$_lang.Website_URL}:</span></td>
          <td colspan="2"><input name="url" type="text" id="url" value="{$smarty.post.url}" size="30" onChange="remove_err('ur')" />
          * (ie http://www.yahoo.com) <span id=ur class="error"></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><span class="style39">{$_lang.Website_Description}: * </span></td>
          <td colspan="2"><textarea name="wdes" cols="35" rows="5" id="wdes" onChange="remove_err('wd')" >{$smarty.post.wdes}</textarea> <span id=wd class="error"></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><span class="style39">{$_lang.Product_Group}: </span></td>
          <td colspan="2"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td><span class="style38">{$_lang.Category}: </span><br />				
                    <select size="1" name="cats" onChange="javascript: sendReqPost(loc+'js/get_scats.php?cid='+this.value,'sc');" style="width: 200px">
					{html_options values=$cat_ids output=$cats selected=$smarty.post.cats}
                    </select></td>
              </tr>
              <tr>
                <td><span class="style38">{$_lang.Sub_Category} : </span><br />
                    <div id='sc'>
					<select size="1" name="subcats" style="width: 200px">
					{html_options values=$scat_ids output=$scats selected=$smarty.post.subcats}
                  	</select>
					</div>					</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td><span class="style39">{$_lang.Website_Tags}: ({$_lang.Very_Important}) * <br />
          </span><span class="style38">{$_lang.my_websites3} {$_config.website_name} {$_lang.Website}. <strong>{$_lang.keyword_sep} </strong></span></td>
          <td colspan="2"><textarea name="keywords" cols="35" rows="5" id="keywords" onChange="remove_err('wk')" >{$smarty.post.keywords}</textarea><span id=wk class="error"></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td nowrap="nowrap">&nbsp;</td>
          <td>{$_lang.my_websites4}</td>
        </tr>
        <tr>
          <td><strong>{$_lang.my_websites5} </strong><span class="style48"> </span></td>
          <td width="5%" valign="top" nowrap="nowrap"><input name="tad" type="radio" value="Y" {if $smarty.post.tad == 'Y'} checked="checked" {/if}  />
            {$_lang.Yes}<br />
            <input name="tad" type="radio" value="N" {if $smarty.post.tad == 'N'} checked="checked" {/if}  onChange="remove_err('cr')" />
            {$_lang.No}</td>
          <td width="63%" valign="top"><strong>{$CURRENCY}</strong>
            <input name="clickrate" type="text" id="clickrate" value="{$smarty.post.clickrate}" size="5" onChange="remove_err('cr')" /><span id=cr class="error"></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td><strong>{$_lang.my_websites6} </strong></td>
          <td colspan="2"><input name="isadult" type="radio" value="Y" {if $smarty.post.isadult eq 'Y'} checked="checked" {/if}  />
            {$_lang.Yes}<br />
            <input name="isadult" type="radio" value="N" {if $smarty.post.isadult eq 'N'} checked="checked" {/if} />
            {$_lang.No}</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td><strong>{$_lang.my_websites7} </strong></td>
          <td colspan="2"><select name="lang" id="lang" style="width: 200px" >
		  <option value="0">English</option>
		  {html_options values=$lang_ids output=$langs selected=$smarty.post.lang}
           </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td><strong>{$_lang.my_websites8} </strong></td>
          <td colspan="2"><input name="adposition" type="text" id="adposition" value="{$smarty.post.adposition}" size="40" onChange="remove_err('ap')" />
             * <span id="ap" class="error"></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td><strong>{$_lang.my_websites9} </strong></td>
          <td colspan="2"><input name="isrestricted" type="radio" value="Y" {if $smarty.post.isrestricted eq 'Y'} checked="CHECKED" {/if} />
Yes <input name="restriction" type="text" id="restriction" value="{$smarty.post.restriction}" size="40" onChange="remove_err('ar')" />  <span id="ar" class="error"></span>
 <br />
<input name="isrestricted" type="radio" value="N" {if $smarty.post.isrestricted eq 'N'} checked="CHECKED" {/if} onChange="remove_err('ar')" />
No </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><strong>{$_lang.my_websites10} <br>
            </strong><span class="style47">({$_lang.add_more_one}) * </span></td>
          <td colspan="2"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><select name="src" size="10" multiple="multiple" id="src" style="width:200px; border-color:#cccccc; border:thin; border-width:1px;" >
		{html_options values=$g_id output=$geo}
                
                </select>                </td>
                <td align="center"><input type="button" name="add" value="&nbsp;&nbsp;&gt;&nbsp;&nbsp;" onclick="javascript: addEntry();"  class="button"/><br />
                  <br /><input type="button" name="rem" value="&nbsp;&nbsp;&lt;&nbsp;&nbsp;" onclick="javascript: removeEntry();"  class="button" /></td>
                <td><span style="padding-top:16px">
                  <select name="dest[]" size="10" style="width:200px; border-color:#cccccc; border:thin; border-width:1px;" multiple="multiple" id="dest" >
				  {html_options values=$r_g_id output=$r_geo}
                  </select>
                </span></td>
              </tr>
            </table>
              <span id="ds" class="error"></span></td>
        </tr>
        <tr>
          <td>
		  {if $smarty.get.pid != ''}
		  <input name="update_pid" type="hidden" id="update_pid" value="{$smarty.get.pid}" />
		  {/if}
		  </td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td><input type="submit" id="sub_button" name="Submit22" value="{if $smarty.get.pid != ''}{$_lang.Update_Details}{else}{$_lang.Add_New_Website}{/if}" class="button" /></td>
          <td colspan="2"><div align="right">{if $smarty.get.pid != ''}
		  <input name="del_pid" type="hidden" value="{$smarty.get.pid}" />
            <input class="button" type="submit" name="delete_pid" value="{$_lang.delete_web}" onclick="javascript: document.getElementById('update_pid').value=''; return confirm('Do Your Really want to Delete this website?'); " />
			{/if}
          </div></td>
        </tr>
      </table>
    </form>
	</div>
  </div>
</div>
      {$TIP}


    </div>