
<div id="maininner">
  <h1><a href="browse.php" class="style27">{$_lang.Advertise_On} {$winfo.websitename}</a></h1>
  <table width="90%" border="0" align="center">
    <tr>
      <td width="47"><img src="wwwThumb/thumb_{$smarty.get.pid}_pic.jpg" alt="{$winfo[num].wname}" width="201" height="147" /></td>
      <td width="12%">&nbsp;</td>
      <td><div align="justify">
          <ul id="maintab" class="shadetabs">
            <li class="selected"><a href="#" rel="tcontent1">{$_lang.Text_Ads}</a></li>
            <li><a href="#" rel="tcontent2">{$_lang.Image_Ads}</a></li>
			{if $_config.video_ad == 'on'}
            <li><a href="#" rel="tcontent3">{$_lang.Video_Ads}</a></li>
			{/if}
          </ul>
          <div class="tabcontentstyle">
            <div id="tcontent1" class="tabcontent">
              <div class="buy-area-call-to-action">
                <table width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="buy-area-call-to-action-main-table" id="producttable">
                  <tr>
                    <td valign="top">
					<form name="txt" action="buy_ads.php" method="post" onsubmit="javascript: return check_buy_form(this);"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        {section name=num loop=$tad_rates}
						<script type="text/javascript">
						{strip}
						txt_ad_{$smarty.section.num.rownum} = '<strong>{$_lang.Next_Ad_Available}: </strong>{if $tad_rates[num].next_ad_date != "NA"}{$tad_rates[num].next_ad_date|date_format:"%e %B %Y"}{else}{$_lang.Not_Available}{/if} <br /><br />{$_lang.Get_your_ad_on} <strong>{$winfo.websitename}</strong> {$_lang.for} 
							{if $tad_rates[num].length neq '0'} {$tad_rates[num].length} {$_lang.full_day}{else} {$CURRENCY}{$tad_rates[num].cost} per click{/if}.<br /><br /><strong>Days: </strong>
							{if $tad_rates[num].length neq '0'} {$tad_rates[num].length} {else} {$_lang.Variable} {/if}<br />
							{if $tad_rates[num].length neq '0'}
							<strong>Average 
							
							{if $tad_rates[num].length eq '30'}{$_lang.Monthly}{elseif $tad_rates[num].length eq '7'}{$_lang.Weekly}{elseif $tad_rates[num].length eq '1'}{$_lang.Daily}{else}{$tad_rates[num].length} {$_lang.Days}{/if}
							
							{$_lang.Clicks}:  </strong> 
							
							{$tad_rates[num].avg_clicks}
							
							{math equation="x * y * z" x=$tad_rates[num].avg_day_clicks y=$tad_rates[num].length z=1 format="%d"}
							
							<br /><strong>{$_lang.Average_Cost_Per_Click}:  </strong> 
							
							{$CURRENCY}{math equation="t / (x * y * z)" t=$tad_rates[num].cost x=$tad_rates[num].avg_day_clicks y=$tad_rates[num].length z=0.95 format="%.2f"}
							
							{else}
							 <strong>{$_lang.Set_Amount_Of_Clicks}: </strong> {$_lang.Add_to_basket_and_choose}  <strong><br />{$_lang.Set_Cost_Per_Click}: </strong> {$CURRENCY}{$tad_rates[num].cost}
							{/if}
							';
						{/strip}
						</script>
						<tr id='txt_ad_{$smarty.section.num.rownum}' style="cursor: pointer;" onmouseover="javascript: show_details(this, 'productdetails');" onclick="javascript: show_details_fixed(this, 'productdetails', '{$tad_rates[num].accept_offers}', 'txt_offer', {$tad_rates[num].cost});" onmouseout="javascript: show_details_restore(this, 'productdetails');">
                          <td valign="top" class="buy-area-call-to-action-choose"><input name="order_product_id" type="radio" value="{$tad_rates[num].ad_id}" id="txt_ad_{$smarty.section.num.rownum}_radio" /></td>
                          <td valign="top" class="buy-area-call-to-action-description"><span class="style38">{if $tad_rates[num].title neq ''} {$tad_rates[num].title} {elseif $tad_rates[num].length>0}{$tad_rates[num].length} {$_lang.Day_Text_Ad} {else}{$_lang.Pay_Per_Click}{/if} </span></td>
                          <td valign="top" class="buy-area-call-to-action-price"><span class="style38">{$CURRENCY}{$tad_rates[num].cost}</span></td>
                        </tr>
						{/section}
						
                        <tr>
                          <td colspan="3">
						    <div id="txt_offer">
						  <input name="offer" type="checkbox" id="toffer" value="Y" onclick="javascript: document.getElementById('Offer price').value='';" />
                            {$_lang.Make_an_Offer}* {$CURRENCY}
                            <input name="offer_price" type="text" id="Offer price" size="4" onfocus="javascript: document.getElementById('toffer').checked='checked';" />
						    </div>						  </td>
                        </tr>
						
                        <tr>
                          <td colspan="2">&nbsp;</td>
                          <td align="right"><div align="right">
                          {if $tad_rates[0].next_ad_date != "NA"}
                          <input name="buy_text_ad" type="image" id="buy_text_ad" src="{$template_dir}/images/buy.gif" alt="Buy Now" align="right" width="76" height="32" />
                          {/if}
                          </div></td>
                        </tr>
                      </table></form>
					</td>
                  </tr>
                </table>
              </div>
            </div>
            <div id="tcontent2" class="tabcontent">
              <div class="buy-area-call-to-action">
                <table width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="buy-area-call-to-action-main-table" id="producttable">
                  <tr>
                    <td valign="top">
					<form action="buy_ads.php" method="post" onsubmit="javascript: return check_buy_form(this);"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        {section name=num loop=$iad_rates}
						<script type="text/javascript">
						{strip}
						img_ad_{$smarty.section.num.rownum} = '<strong>{$_lang.Next_Ad_Available}: </strong> {if $iad_rates[num].next_ad_date != "NA"}{$iad_rates[num].next_ad_date|date_format:"%e %B %Y"}{else}Not Available{/if} <br /><br />{$_lang.Get_your_ad_on} <strong>{$winfo.websitename}</strong> {$_lang.for} 
							{if $iad_rates[num].length neq '0'} {$iad_rates[num].length} full day{else} {$CURRENCY}{$iad_rates[num].cost} per click{/if}.<br /><br /><strong>Days: </strong>
							{if $iad_rates[num].length neq '0'} {$iad_rates[num].length} {else} Variable {/if}<br />
							{if $iad_rates[num].length neq '0'}
							<strong>Average 
							
							{if $iad_rates[num].length eq '30'}Monthly{elseif $iad_rates[num].length eq '7'}Weekly{elseif $iad_rates[num].length eq '1'}Daily{else}{$iad_rates[num].length} Days{/if}
							
							Clicks:  </strong> 
							
							{$iad_rates[num].avg_clicks}
							
							{math equation="x * y * z" x=$iad_rates[num].avg_day_clicks y=$iad_rates[num].length z=1 format="%d"}
							
							<br /><strong>Average Cost Per Click:  </strong> 
							
							{$CURRENCY}{math equation="t / (x * y * z)" t=$iad_rates[num].cost x=$iad_rates[num].avg_day_clicks y=$iad_rates[num].length z=0.95 format="%.2f"}
							
							{else}
							 <strong>Set Amount of Clicks: </strong> Add to basket and choose  <strong><br />Set Cost Per Click: </strong> {$CURRENCY}{$iad_rates[num].cost}
							{/if}
							';
						{/strip}
						</script>
						<tr id='img_ad_{$smarty.section.num.rownum}' style="cursor: pointer;" onmouseover="javascript: show_details(this, 'productdetails');" onclick="javascript: show_details_fixed(this, 'productdetails', '{$iad_rates[num].accept_offers}', 'img_offer', {$iad_rates[num].cost});" onmouseout="javascript: show_details_restore(this, 'productdetails');">
                          <td valign="top" class="buy-area-call-to-action-choose"><input name="order_product_id" type="radio" value="{$iad_rates[num].ad_id}" id="img_ad_{$smarty.section.num.rownum}_radio" /></td>
                          <td valign="top" class="buy-area-call-to-action-description"><span class="style38">{if $iad_rates[num].title neq ''} {$iad_rates[num].title} {elseif $iad_rates[num].length>0}{$iad_rates[num].length} {$_lang.Day_Image_Ad}{else}{$_lang.Pay_Per_Click}{/if}({$iad_rates[num].size}){if $iad_rates[num].allow_flash == 'Y'}<img title="Flash Ad Allowed" src="{$template_dir}/images/allow_flash.png" border="0" width="16px" height="16px" align="absmiddle" alt="Flash Ad Allowed" />{/if} </span></td>
                          <td valign="top" class="buy-area-call-to-action-price"><span class="style38">{$CURRENCY}{$iad_rates[num].cost}</span></td>
                        </tr>
						{/section}
						
                        <tr>
                          <td colspan="3">
						    <div id="img_offer">
						  <input name="offer" type="checkbox" id="ioffer" value="Y" />                            
                            {$_lang.Make_an_Offer}* {$CURRENCY}
                            <input name="offer_price" type="text" id="Offer price" size="4" />
						    </div>						  </td>
                        </tr>
						
                        <tr>
                          <td colspan="2">&nbsp;</td>
                          <td align="right"><div align="right">
                          {if $iad_rates[0].next_ad_date != "NA"}
                          <input name="buy_image_ad" type="image" id="buy_image_ad" src="{$template_dir}/images/buy.gif" alt="Buy Now" align="right" width="76" height="32" />
                          {/if} 
                          </div></td>
                        </tr>
                      </table></form>
					</td>
                  </tr>
                </table>
              </div>
            </div>
            <div id="tcontent3" class="tabcontent">
              <div class="buy-area-call-to-action">
                <table width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="buy-area-call-to-action-main-table" id="producttable">
                  <tr>
                    <td valign="top">
					<form action="buy_ads.php" method="post" onsubmit="javascript: return check_buy_form(this);">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
                        {section name=num loop=$vad_rates}
						<script type="text/javascript">
						{strip}
						vdo_ad_{$smarty.section.num.rownum} = '<strong>Next Ad Available: </strong> {if $vad_rates[num].next_ad_date != "NA"}{$vad_rates[num].next_ad_date|date_format:"%e %B %Y"}{else}Not Available{/if} <br /><br />Get your ad on <strong>{$winfo.websitename}</strong> for 
							{if $vad_rates[num].length neq '0'} {$vad_rates[num].length} full day{else} {$CURRENCY}{$vad_rates[num].cost} per click{/if}.<br /><br /><strong>Days: </strong>
							{if $vad_rates[num].length neq '0'} {$vad_rates[num].length} {else} Variable {/if}<br />
							{if $vad_rates[num].length neq '0'}
							<strong>Average 
							
							{if $vad_rates[num].length eq '30'}Monthly{elseif $vad_rates[num].length eq '7'}Weekly{elseif $vad_rates[num].length eq '1'}Daily{else}{$vad_rates[num].length} Days{/if}
							
							Clicks:  </strong> 
							
							{$vad_rates[num].avg_clicks}
							
							{math equation="x * y * z" x=$vad_rates[num].avg_day_clicks y=$vad_rates[num].length z=1 format="%d"}
							
							<br /><strong>Average Cost Per Click:  </strong> 
							
							{$CURRENCY}{math equation="t / (x * y * z)" t=$vad_rates[num].cost x=$vad_rates[num].avg_day_clicks y=$vad_rates[num].length z=0.95 format="%.2f"}
							
							{else}
							 <strong>Set Amount of Clicks: </strong> Add to basket and choose  <strong><br />Set Cost Per Click: </strong> {$CURRENCY}{$vad_rates[num].cost}
							{/if}
							';
						{/strip}
						</script>
						<tr id='vdo_ad_{$smarty.section.num.rownum}' style="cursor: pointer;" onmouseover="javascript: show_details(this, 'productdetails');" onclick="javascript: show_details_fixed(this, 'productdetails', '{$vad_rates[num].accept_offers}', 'vdo_offer', {$vad_rates[num].cost});" onmouseout="javascript: show_details_restore(this, 'productdetails');">
                          <td valign="top" class="buy-area-call-to-action-choose"><input name="order_product_id" type="radio" value="{$vad_rates[num].ad_id}" id="vdo_ad_{$smarty.section.num.rownum}_radio" /></td>
                          <td valign="top" class="buy-area-call-to-action-description"><span class="style38">{if $vad_rates[num].title neq ''} {$vad_rates[num].title} {elseif $vad_rates[num].length>0}{$vad_rates[num].length} {$_lang.Day_Video_Ad}{else}{$_lang.Pay_Per_Click}{/if}({$vad_rates[num].size}) </span></td>
                          <td valign="top" class="buy-area-call-to-action-price"><span class="style38">{$CURRENCY}{$vad_rates[num].cost}</span></td>
                        </tr>
						{/section}
						{section name=num loop=$ppc_tad_rates}
						{/section}
                        <tr>
                          <td colspan="3">
						    <div id="vdo_offer">
						  <input name="offer" type="checkbox" id="voffer" value="Y" />
                            {$_lang.Make_an_Offer}* {$CURRENCY}
                            <input name="offer_price" type="text" id="Offer price" size="4" />
						    </div>						  </td>
                        </tr>
						
                        <tr>
                          <td colspan="2">&nbsp;</td>
                          <td align="right"><div align="right">
                          {if $vad_rates[0].next_ad_date != "NA"}
                            <input name="buy_video_ad" type="image" id="buy_video_ad" src="{$template_dir}/images/buy.gif" alt="Buy Now" align="right" width="76" height="32" />
                           {/if} 
                          </div></td>
                        </tr>
                      </table>
					</form>
					</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <script type="text/javascript">
			//Start Tab Content script for UL with id="maintab" Separate multiple ids each with a comma.
			initializetabcontent("maintab")
          </script>
        </div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td width="41%" rowspan="7" valign="top"><div id="productdetails" class="box"><strong>{$_lang.move_mouse_over}...</strong></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="left"><span class="green style45"><strong>{$winfo.websitename} {$_lang.Website_Stats} </strong></span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><div align="left"><strong>{$_lang.Alexa_Ranking}: </strong>{if $winfo.alexa_rank == 0}No Alexa Rating{else}{$winfo.alexa_rank}{/if}</div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="left"><strong>{$_lang.Google_Pagerank}: <img src="{$template_dir}/images/gpr/{$winfo.google_page_rank}.gif" alt="{$winfo.google_page_rank}" width="58" height="5" border="0" /></strong></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="left"><strong>{$_lang.Pageviews_Per_Day}: </strong>{if $pvpd == ""}No Data Available Yet{else}{$pvpd}{/if}</div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="left"><strong>{$_lang.Daily_Unique_Users}: </strong> {if $max_u_u == ""}No Data Available Yet{else}{$max_u_u}{/if} </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="left"><strong>{$_lang.Member_Since}:</strong>   {$winfo.member_since|date_format:"%e %B %Y"}</div></td>
      <td><div align="right"><strong>{$_lang.Click_Through_Stat}: </strong></div></td>
    </tr>
    <tr>
      <td><div align="left"><a href="{$winfo.url}" target="_blank">{$winfo.url}</a></div></td>
      <td>&nbsp;</td>
      <td><div align="right">
      {if $max_u == ""}No Data Available Yet{else}
	      On the {$max_u_date|date_format:"%e %B %Y"}, <strong>{$winfo.websitename}</strong> sent <strong> {$max_u} </strong> users to one advertiser. 
      {/if}
      </div></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><strong>{$_lang.Website_Owners_Description}: </strong></td>
    </tr>
    <tr>
      <td colspan="3">{$winfo.description|nl2br}</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><strong>{$_lang.Any_Advert_Restrictions}? </strong> {if $winfo.isrestricted == 'Y'} {$winfo.restriction} {else}{$_lang.No}{/if}<br />
        <strong>{$_lang.Does_This_Website_Have_Any_Adult_Content}? </strong> {if $winfo.isadult == 'Y'} {$_lang.Yes} {else} {$_lang.No} {/if}<br />
        <strong>{$_lang.Language_Of_Website}:</strong> {$lang} <br />
        <strong>{$_lang.Where_Will_Your_Ads_Appear}? </strong>{$winfo.adposition}<BR />
      <strong>{$_lang.Types_Of_Ads_Available}: </strong>{$T}  {$I}  {$V} </td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><strong>{$_lang.Website}</strong> <strong>{$_lang.Tags}</strong>:<br />
        
			{section name=num loop=$keywords} 
				<a href="browse.php?qry={$keywords[num]|trim}"> {$keywords[num]|trim} </a>
			{/section}
		
	  </td>
    </tr>
  </table>
  {$TIP}
  <br />
</div>
