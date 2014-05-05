{if $ad_space.ad_type == 'txt_ad' ||  $ad_space.ad_type == 'ppc_txt_ad' }
<div id="maininner">
		  <h1><a href="browse.php" class="style27">{$_lang.Browse_Websites_To_Advertise_On}...</a></h1>
				
			<h1 align="right">{$_lang.Step} {if isset($smarty.get.cmp_id)}3{else}1{/if} </h1>
			<div class="splitleft">
              <div class="box">
                <table width="100%" border="0" align="center">
                  <tr>
                    <td width="100%"><h1>
                    {if isset($smarty.get.cmp_id)}
                    {$_lang.Create_Your_Ad}
                    {else}
                    {$_lang.You_Are} {if $smarty.get.edit == '1'}{$_lang.Editing}{else}{$_lang.Buying}{/if} {$_lang.a} {if $ad_space.length != '0'}{$ad_space.length} {$_lang.Day} {else} '{$_lang.Pay_Per_Click}' {/if} {$_lang.Text_Ad_On}, <span class="green">{$winfo.websitename}</span>
                    {/if}
                    </h1></td>
                  </tr>
                  {if $real_offer == 'Y'}
                  <tr>
                    <td align="center"><strong><span class="error">{$_lang.Your_Ad_Offer}: </span>{$_lang.Website}: </strong>{$winfo.websitename}<strong> {$_lang.Ad}: </strong>{if $ad_space.length != '0'}{$ad_space.length} {$_lang.Day} {else} '{$_lang.Pay_Per_Click}' {/if} {$_lang.Text_Ad}<strong> {$_lang.Offer}: </strong>{$CURRENCY}{$smarty.post.offer_price}</td>
                  </tr>
				  {/if}
                  <tr>
                    <td><h1><span class="green">{$_lang.Please_enter_your_ad_details_for_your} 
                    {if isset($smarty.get.cmp_id)}
                    {$_lang.Advertising_Campaign}</span>
                    {else}
                    {$_lang.ad_on} </span><span class="style48">{$winfo.websitename}</span>
                    {/if}
                    </h1></td>
                  </tr>
                </table>
                <table width="100%" border="0">
                  <tr>
                    <td width="134">&nbsp;</td>
                    <td width="762"><div class="general-content-area">
					<form name="txt" action="" method="post" onSubmit="MM_validateForm('ad_hl','','R','ad_des','','R','site_name','','R');return document.MM_returnValue">
					  <table width="100%" border="0">
                        <tr>
                          <td><div>
                            <label for="ad_hl"><span class="style50 style32">{$_lang.Ad_Headline}</span><BR />
                            <input name="ad_hl" type="text" id="Ad Headline" onKeyUp="javascript: document.getElementById('preview_text_ad_headline').innerHTML = this.value;" value="{if isset($smarty.get.edit) && $smarty.get.edit == '1'}{$ainfo.ad_hl}{/if}" size="40" maxlength="{if $ad_code.txt_hl_len eq ''}25{else}{$ad_code.txt_hl_len}{/if}"/>
                            <BR />
                            <span class="style47"><strong>{$_lang.maximum} {if $ad_code.txt_hl_len == ''}25{else}{$ad_code.txt_hl_len}{/if} {$_lang.characters}</strong></span></label>
                            <label for="ad_des"><span class="style50 style32">{$_lang.Ad_Description} </span><BR />
                            <input name="ad_des" type="text" id="Ad Description" value="{if isset($smarty.get.edit) && $smarty.get.edit == '1'}{$ainfo.ad_des}{/if}" size="40" maxlength="{if $ad_code.txt_des_len eq ''}70{else}{$ad_code.txt_des_len}{/if}" onKeyUp="javascript: document.getElementById('preview_text_ad_text').innerHTML = this.value;"/>
                            <BR />
                            <span class="style47"><strong>{$_lang.maximum} {if $ad_code.txt_des_len eq ''}70{else}{$ad_code.txt_des_len}{/if} {$_lang.characters}</strong></span></label>
                            <label for="al_url"><span class="style50 style32">{$_lang.Destination_URL}</span><BR />
                            <input type="text" id="Destination URL" name="ad_url" maxlength="255" value="{if isset($smarty.get.edit) && $smarty.get.edit == '1'}{$ainfo.ad_url}{else}http://{/if}"/>
                            </label>
							<label for="site_name"><span class="style50 style32">{$_lang.Destination_Website_Name}</span><BR />
                            <input type="text" id="Destination Website Name" name="site_name" value="{if isset($smarty.get.edit) && $smarty.get.edit == '1'}{$ainfo.site_name}{/if}" />
                            </label>
                            <span class="style50 style32">{$_lang.Ad_Start_Date} </span><BR />
                            {html_select_date time=$ainfo.start_date end_year="+1" field_order="DMY" }
                            <BR /><BR />
							<input type="hidden" id="adv_id" name="adv_id" value="{$ainfo.adv_id}" />
                            <input type="hidden" id="pub_uid" name="pub_uid" value="{$ad_space.uid}" />
                            <input type="hidden" id="pid" name="pid" value="{$ad_space.pid}" />
                            <input type="hidden" id="ad_type" name="ad_type" value="{$ad_space.ad_type}" />
                            <input type="hidden" id="ad_length" name="ad_length" value="{$ad_space.length}" />
                            <input type="hidden" id="AD_PRICE" name="AD_PRICE" value="{$AD_PRICE}" />
                            <input type="hidden" id="order_product_id" name="order_product_id" value="{$smarty.request.order_product_id}" />
                            
                            {if isset($smarty.get.cmp_id)}
                            	<input  class="button" name="cmp_txt_ad" type="submit" id="save-ad" value="{$_lang.Next_Step}" onClick="if(!isValidURL(document.forms['txt'].ad_url.value)) alert('Invalid URL. Please provide the complete url starting with http://'); return isValidURL(document.forms['txt'].ad_url.value)" />
                            {elseif $smarty.get.edit == '1'}
								<input  class="button" name="update" type="submit" id="save-ad" value="{$_lang.Update}" onClick="if(!isValidURL(document.forms['txt'].ad_url.value)) alert('Invalid URL. Please provide the complete url starting with http://'); return isValidURL(document.forms['txt'].ad_url.value)" />
							
                            {else}
								<input  class="button" name="next" type="submit" id="save-ad" value="{$_lang.Next_Step}" onClick="if(!isValidURL(document.forms['txt'].ad_url.value)) alert('Invalid URL. Please provide the complete url starting with http://'); return isValidURL(document.forms['txt'].ad_url.value)" />
                          	{/if}
						  </div></td>
                          <td width="50%"><strong>{$_lang.Live_Ad_Preview}</strong>
                            <div id="ad-preview">
                            <div id="preview_text_ad_headline"> {if isset($smarty.get.edit) && $smarty.get.edit == '1'}{$ainfo.ad_hl}{else}{$_lang.Ad_Headline_Sample}{/if}</div>
                            <div id="preview_text_ad_text"> {if isset($smarty.get.edit) && $smarty.get.edit == '1'}{$ainfo.ad_des}{else}{$_lang.Ad_Description_Sample_Text} {/if}</div>
                          </div></td>
                        </tr>
                      </table></form>                      
                      <div id="page-error" style="display:none;"></div>
                      <div id="msg-box"></div></td>
                    <td width="82">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div>
		  </div>
	{$TIP}<BR />
</div>
{else}
	  <div id="maininner">
		  <h1><a href="browse.php" class="style27">{$_lang.Browse_Websites_To_Advertise_On}...</a></h1>
				
			<h1 align="right">{$_lang.Step} {if isset($smarty.get.cmp_id)}3{else}1{/if} </h1>
			<div class="box"><table width="90%" border="0" align="center">
              <tr>
                <td width="100%"><h1>
                {if isset($smarty.get.cmp_id)}
                    {$_lang.Create_Your_Ad}
                    {else}
                {$_lang.You_Are} {if $smarty.get.edit == '1'}{$_lang.Editing}{else}{$_lang.Buying}{/if} {$_lang.a} {if $ad_space.length != '0'}{$ad_space.length} {$_lang.Day} {else} '{$_lang.Pay_Per_Click}' {/if}  <span class="green">{$ad_space.size} </span> {$_lang.Pixel} {if $ad_space.ad_type == 'vdo_ad' || $ad_space.ad_type == 'ppc_vdo_ad'}{$_lang.Video}{else}{$_lang.Image}{/if} {$_lang.Ad_On}, <span class="green"> {$winfo.websitename}</span>
                {/if}
                </h1></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>              
              <tr>
                <td><h1>{$_lang.buy_ads_page1} </h1></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>
                {if isset($smarty.get.cmp_id)}
                <form action="" method="post" enctype="multipart/form-data" name="img_vdo" id="form1" onsubmit="if(this.ad_file.value == '' && this.upload.value == 'Upload') alert('Please provide a valid file'); return (this.ad_file.value != '');">
                {else}
                <form action="buy_ads.php?edit=1" method="post" enctype="multipart/form-data" name="img_vdo" id="form1" onsubmit="if(this.ad_file.value == '' && this.upload.value == 'Upload') alert('Please provide a valid file'); return (this.ad_file.value != '');">
                {/if} 
				 <label for="al_url"><span class="style50 style32">{$_lang.Destination_URL}</span><BR />
                            <input type="text" id="Destination URL" name="ad_url" maxlength="255" value="{if isset($smarty.get.edit) && $smarty.get.edit == '1'}{$ainfo.ad_url}{else}http://{/if}"/>
                  </label>
							<label for="site_name"><span class="style50 style32">{$_lang.Destination_Website_Name}</span><BR />
                            <input type="text" id="Destination Website Name" name="site_name" value="{if isset($smarty.get.edit) && $smarty.get.edit == '1'}{$ainfo.site_name}{/if}" />
                            </label>
				 
				  <span class="style50 style32">{$_lang.Ad_Start_Date} </span><BR />
                            {html_select_date time=$ainfo.start_date end_year="+1" field_order="DMY" }
                            <BR /><br />
							<input type="hidden" id="adv_id" name="adv_id" value="{$ainfo.adv_id}" />
							<input type="hidden" id="pub_uid" name="pub_uid" value="{$ad_space.uid}" />
                            <input type="hidden" id="pid" name="pid" value="{$ad_space.pid}" />
                            <input type="hidden" id="ad_type" name="ad_type" value="{$ad_space.ad_type}" />
                            <input type="hidden" id="ad_length" name="ad_length" value="{$ad_space.length}" />
                            <input type="hidden" id="AD_PRICE" name="AD_PRICE" value="{$AD_PRICE}" />
                            <input type="hidden" id="order_product_id" name="order_product_id" value="{$smarty.request.order_product_id}" />
                            <span class="style50 style32">
							
							{if $ad_space.ad_type == 'vdo_ad' || $ad_space.ad_type == 'ppc_vdo_ad'}
							File  (.avi, .mpg, .mpeg, .wmv, .mp4, .mov, .flv)
							{else}
							 File  (.jpg, .jpeg, .gif{if $ad_space.allow_flash == 'Y'}, .swf{/if}) 
							 {/if}							 </span> <br />
                            <input name="ad_file" type="file"  class="button" id="ad_file" 
							{if $ad_space.ad_type == 'vdo_ad' || $ad_space.ad_type == 'ppc_vdo_ad'}
							onchange="javascript: checkme(this, 'avi', 'mpg', 'mpeg', 'wmv', 'mp4', 'mov', 'flv');" 
							{else} 
							onchange="javascript: checkme(this, 'jpg', 'jpeg', 'gif' {if $ad_space.allow_flash == 'Y'}, 'swf'{/if});" 
							{/if}
							/>
                
                {if isset($smarty.get.cmp_id)}
                	<input name="cmp_media_ad" type="submit" class="button" id="upload" value="{$_lang.Upload}" onClick="if(!isValidURL(document.forms['img_vdo'].ad_url.value)) alert('{$_lang.buy_ads_page2}'); return isValidURL(document.forms['img_vdo'].ad_url.value)" />  
				{elseif $smarty.get.edit == '1'}
                    <input name="update_file" type="submit" class="button" id="update_file" value="{$_lang.Update}" onClick="if(!isValidURL(document.forms['img_vdo'].ad_url.value)) alert('{$_lang.buy_ads_page2}'); return isValidURL(document.forms['img_vdo'].ad_url.value)" />
				
                {else}
					<input name="upload" type="submit" class="button" id="upload" value="{$_lang.Upload}" onClick="if(!isValidURL(document.forms['img_vdo'].ad_url.value)) alert('{$_lang.buy_ads_page2}'); return isValidURL(document.forms['img_vdo'].ad_url.value)" />
				{/if}
                </form>                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><h1>{$_lang.Ad_Preview} </h1></td>
              </tr>
              <tr>
                <td>

			<div style="width: {$div_size[0]}px; height: {$div_size[1]}px; background-image: url(js/adbg.jpg)" >
			{if $has_file == 'Y'}
				{if $ext == 'swf'}
				<div id="ad_div"></div>
				<script type="text/javascript">
				var so = new SWFObject("{$ainfo.ad_img}", "image_ad_space", "{$div_size[0]}", "{$div_size[1]}", "8", "#ffffff");
				so.addParam("wmode", "transparent");
				so.write("ad_div");
				</script>
				{elseif $ext == 'flv'}
				<div id="ad_div"></div>
				<script type="text/javascript">
				var so = new SWFObject("adPlayer.swf", "video_ad_space", "{$div_size[0]}", "{$div_size[1]}", "8", "#ffffff");
				so.addParam("wmode", "opaque");
				so.addVariable("file", "{$ainfo.ad_img}");
				so.addVariable("ad_url", "{$ainfo.ad_url}?");
				so.write("ad_div");
				</script>
				{else}
				<img src="{$ainfo.ad_img}" alt="Image Ad" width="{$div_size[0]}" height="{$div_size[1]}" />
				{/if}
			{/if}				</div>				</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right">
                  {if $ad_space.ad_type == 'ppc_img_ad' || $ad_space.ad_type == 'ppc_vdo_ad' }
				  <form id="form2" name="form2" method="get" action="buy_ads_ppc.php">
				  <input type="hidden" id="adv_id" name="adv_id" value="{$ainfo.adv_id}" />
				  <input type="hidden" id="order_product_id" name="order_product_id" value="{$smarty.request.order_product_id}" />
				  {else}
				  <form id="form2" name="form2" method="get" action="cart.php">
				  {/if}

                    <input type="submit" name="search2" class="button" value="{$_lang.Next_Step}" />
                                    </form>
                  </div></td>
              </tr>
          </table> 
			</div>
			
			{$TIP}
	  </div>
	  
	  {/if}