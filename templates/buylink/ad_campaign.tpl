{if isset($smarty.post.submit_cmp)}
<div id="maininner">
		  <h1><a href="browse.php" class="style27">{$_lang.Browse_Websites_To_Advertise_On}...</a></h1>
				
			<h1 align="right">{$_lang.Step2} </h1>
			<div class="splitleft">
              <div class="box">
              <form action="" method="post"><table width="100%" border="0" align="center">
                  <tr>
                    <td width="100%"><h1>{$_lang.campaign_page}  <span class="green"></span></h1></td>
                  </tr>
                  
                  <tr>
                    <td><h1><span class="green">{$_lang.campaign_page3} </span></h1>
                      <h1>{$CURRENCY}
                        <input name="total_budget" type="text" id="total_budget" value="{$cdata.total_budget}" size="5" />
                      </h1></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><h1><span class="green">{$_lang.campaign_page4} </span></h1>
                      <h1>{$CURRENCY}
                          <input name="max_cpc" type="text" id="max_cpc" value="{$cdata.max_cpc}" size="5" />
                      </h1></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><h1><span class="green">{$_lang.campaign_page5} </span></h1>
                      <h1>{$CURRENCY}
                          <input name="daily_budget" type="text" id="daily_budget" value="{$cdata.daily_budget}" size="5" />
                      </h1></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="right">
                      <input name="type" type="hidden" id="type" value="{$type}" />
                      <input name="cmp_id" type="hidden" id="cmp_id" value="{$cmp_id}" />
<input type="submit" name="spend" value="{$_lang.next_step_create_ad}" class="button" id="spend" />
                    </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table></form>
                
              </div>
			</div>
				<BR />
</div>
{else}
<div id="maininner">
		  <h1><a href="browse.php" class="style27">{$_lang.Browse_Websites_To_Advertise_On}...</a></h1>
				
			<h1 align="right">{$_lang.Step1} </h1>
			<div class="splitleft">
              <div class="box">
              <form action="" method="post"><table width="100%" border="0" align="center">
                  <tr>
                    <td width="100%"><h1>{$_lang.Target_Your_Ad_Campaign} <span class="green"></span></h1></td>
                  </tr>
                  
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><h1><span class="green">{$_lang.Please_Name_Your_Advertising_Campaign}<BR />
                      <input name="title" type="text" id="title" value="{$cdata.title}" />
</span></h1></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><h1><span class="green">{$_lang.what_kind_of_ads}</span></h1>
                      <h1><span class="green">
                        <input name="ad_type" type="radio" value="txt" {if $cdata.ad_type == 'txt'} checked="checked" {/if} /> 
                      <strong> </strong></span>{$_lang.Text_Ads} <span class="green">
                      <input name="ad_type" type="radio" value="img" {if $cdata.ad_type == 'img'} checked="checked" {/if} />
                      <strong> </strong></span>{$_lang.Image_Ads}
                      <select name="img_size" id="img_size">
                      	{section name=num loop=$img_ad_sizes.width}		
                              <option value="{$img_ad_sizes.id[num]}">{$img_ad_sizes.width[num]}x{$img_ad_sizes.height[num]}</option>                 
						{/section}
                      </select> 
                      <script type="text/javascript">
                      		document.getElementById('img_size').value = '{$cdata.size}';
                      </script>
                      
                      
                      {if $_config.video_ad == 'on'}
                      <span class="green">
                      <input name="ad_type" type="radio" value="vdo" {if $cdata.ad_type == 'vdo'} checked="checked" {/if} />
                      <strong> </strong></span>{$_lang.Video_Ads} 
                      <select name="vdo_size" id="vdo_size">
                      	{section name=num loop=$vdo_ad_sizes.width}
                              <option value="{$vdo_ad_sizes.id[num]}">{$vdo_ad_sizes.width[num]}x{$vdo_ad_sizes.height[num]}</option>
						{/section}
                      </select> 
                      <script type="text/javascript">
                      		document.getElementById('vdo_size').value = '{$cdata.size}';
                      </script>
                      
                      {/if}
                      
                      </h1></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><h1 class="green">{$_lang.Geographic_Targeting} </h1>
                      <h1>
                      <input name="geo_target" type="radio" value="all" {if $cdata.geo_target == ''} checked="checked" {/if} />
                      <strong> </strong>{$_lang.Show_My_Ads_Everywhere} <BR />
                      <input name="geo_target" type="radio" value="not_all" {if $cdata.geo_target != ''} checked="checked" {/if} />
                      <strong> </strong>{$_lang.Show_My_Ads_Regions}                      </h1>
                      <table width="50%" border="0">
                        <tr>
                          <td colspan="3">{html_checkboxes name="geo" output=$geo.location values=$geo.gid selected=$geo_sel}</td>
                        </tr>
                        
                        <tr>
                          <td colspan="3"><span class="style47">({$_lang.You_Can_Add_More_Than_One}) </span></td>
                        </tr>
                    </table>                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><h1 class="green">{$_lang.Category_Targeting} </h1>
                      <h1><span class="green">
                      <input name="cat_target" type="radio" value="all"  {if $cdata.cat_target == ''} checked="checked" {/if} />
                      </span>{$_lang.Show_My_Ads_In_All_Categories} <br />
                       <input name="cat_target" type="radio" value="not_all" {if $cdata.cat_target != ''} checked="checked" {/if} />
                    {$_lang.Show_My_Ads_In_These_Categories_Only} </h1>
                      <table width="50%" border="0">
                        <tr>
                          <td colspan="3"> {html_checkboxes name="cats" output=$cats.category values=$cats.cid selected=$cat_sel} </td>
                        </tr>
                        
                        <tr>
                          <td colspan="3"><span class="style47">({$_lang.You_Can_Add_More_Than_One})</span></td>
                        </tr>
                      </table>
                    <h1>
                      <span class="green">
                      <input name="is_adult" type="radio" value="Y" {if $cdata.is_adult == 'Y'} checked="checked" {/if} />
                      </span>{$_lang.show_ads_adult} <br />
                      <input name="is_adult" type="radio" value="N" {if $cdata.is_adult == 'N'} checked="checked" {/if} />
{$_lang.show_ads_family} </h1>                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><h1><span class="green">{$_lang.Keyword_Targeting} </span></h1>
                      <p class="green">
                      <textarea name="key_target" id="key_target">{$cdata.key_target}</textarea>
                    </p><BR />
					{$_lang.keywords_seperated} </td>
                  </tr>
                  <tr>
                    <td><div align="right">
                      <input type="submit" name="submit_cmp" value="{$_lang.next_step_budget}" class="button" id="submit_cmp" />
                    </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table></form>
                
              </div>
			</div>
			{$TIP}<br />

	  </div>
{/if}      