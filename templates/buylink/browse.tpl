<div id="maininner">

		  <h1><a href="browse.php" class="style27">{$_lang.Browse_Websites_To_Advertise_On}...</a></h1>				

			<div class="splitleft">

              <div class="box">

                <table width="100%" border="0">
                  <tr>
                    <td width="816" class="green"><h3 class="green"><strong>{$_lang.Currently_Showing}:</strong>                  
                    
                    {if $smarty.session.show_category == 0 } {$_lang.All_Category} {else}
                    {$_lang.Category}: 
                        {section name = num loop = $cat_menu.cid}
                            {if $cat_menu.cid[num] == $smarty.session.show_category} {$cat_menu.category[num]|capitalize:true} {/if}
                        {/section}                    
                    {/if}                    
                    -                     
                    {if $smarty.session.show_length == 1}1 {$_lang.Day} 

					{elseif $smarty.session.show_length == 7}1 {$_lang.Week} 
					{elseif $smarty.session.show_length == 30}1 {$_lang.Month} 
		
					{elseif $smarty.session.show_length == '0'}{$_lang.Pay_Per_Click} 
					{elseif $smarty.session.show_length == 'all'}{$_lang.All_Length} 
                    {else}{$smarty.session.show_length} {$_lang.Day}                     
                    {/if}
                    
                    {if $smarty.session.show_cat == 'txt_ad'} {$_lang.Text_Ads}
                    {elseif $smarty.session.show_cat == 'img_ad'} {$_lang.Image_Ads}
                    {elseif $smarty.session.show_cat == 'vdo_ad'} {$_lang.Video_Ads}
                    {else}
                    	, {$_lang.All_Types_Of_Ads}
                    {/if}                   
                    
                    </h3></td>
                    <td width="166">
                      <div align="left">
                            <select name="show_category"  onchange="javascript: if(this.value != '-1') window.location=location.pathname+'?show_category='+this.value;">

                              <option value="-1">{$_lang.Choose_Category}</option>

                              <option value="0">-- {$_lang.All} --</option>

                              {html_options values=$cat_menu.cid output=$cat_menu.category  selected=$smarty.session.show_category}

                            </select> 

                      </div></td>

                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="left"><span class="style44"><strong>

					{if $smarty.session.show_length != 1}<a href="?show_length=1">{/if}{$_lang.Show_1_Day_Ads}{if $smarty.session.show_length != 1}</a>{/if}

					</strong> | <strong>

					{if $smarty.session.show_length != 7}<a href="?show_length=7">{/if}{$_lang.Show_1_Week_Ads}{if $smarty.session.show_length != 7}</a>{/if}

					</strong> | <strong>{if $smarty.session.show_length != 30}<a href="?show_length=30">{/if}{$_lang.Show_1_Month_Ads}{if $smarty.session.show_length != 30}</a>{/if}

					</strong></span> | <strong>

					{if $smarty.session.show_length != '0'}<a href="?show_length=0">{/if}{$_lang.Show_Pay_Per_Click_Ads}{if $smarty.session.show_length != '0'}</a>{/if}</strong> | 

					{if $smarty.session.show_length != 'all'}<a href="?show_length=all">{/if}<strong>{$_lang.Show_All} </strong>{if $smarty.session.show_length != 'all'}</a>{/if}</div></td>

                    <td><span class="style46"><img src="{$template_dir}/images/txt_ad.png" alt="Text Ads" width="16" height="16" align="absmiddle" /> - {$_lang.Text_Ads} </span></td>

                  </tr>

                  <tr>

                    <td ><strong>{$_lang.Only_Show}:</strong> {if $smarty.session.show_cat != 'txt_ad'}<a href="?show_cat=txt_ad">{/if}{$_lang.Text_Ads}{if $smarty.session.show_cat != 'txt_ad'}</a>{/if} | {if $smarty.session.show_cat != 'img_ad'}<a href="?show_cat=img_ad">{/if}{$_lang.Image_Ads}{if $smarty.session.show_cat != 'img_ad'}</a>{/if} 
               {if $_config.video_ad == 'on'}
                   |   {if $smarty.session.show_cat != 'vdo_ad'}<a href="?show_cat=vdo_ad">{/if}{$_lang.Video_Ads}{if $smarty.session.show_cat != 'vdo_ad'}</a>{/if} 
               {/if}
                    | {if $smarty.session.show_cat != 'all'}<a href="?show_cat=all">{/if}{$_lang.Show_All}{if $smarty.session.show_cat != 'all'}</a> {/if}</td>

                    <td class="bold style46"><img src="{$template_dir}/images/img_ad.png" alt="Image Ads" width="16" height="16" align="absmiddle" /> - {$_lang.Image_Ads} </td>

                  </tr>

                  <tr>

                    <td class="bold"><select name="show_length" onChange="javascript: if(this.value != '-1') window.location=location.pathname+'?show_length='+this.value;">

                      <option value="-1">{$_lang.More_Ad_Lengths}</option>

                       <option value="all"> -- {$_lang.All} -- </option>

					  {html_options options=$len_menu selected=$smarty.session.show_length}



					  </select></td>

                    <td class="bold style46"><img src="{$template_dir}/images/vdo_ad.png" alt="Video Ads" width="16" height="16" align="absmiddle" /> - {$_lang.Video_Ads} </td>

                  </tr>

                  <tr>

                    <td colspan="2" class="bold">&nbsp;</td>

                  </tr>

                  <tr>

                    <td colspan="2" class="bold">

                      <div align="left"></div></td>

                  </tr>

                  <tr>

                    <td colspan="2"><div class="splitleft">

                        <div class="bluebox">

                          <div align="left">

						  <form action="" method="post">

                            <table width="100%" border="0">

							


                              {section name=num loop=$winfo}

                                

                              <tr>

                                <td colspan="4">&nbsp;</td>
                              </tr>

                              <tr>

                                <td width="7%">&nbsp;</td>

                                <td width="11%"><img src="wwwThumb/thumb_{$winfo[num].pid}_pic.jpg" alt="{$winfo[num].wname}" width="60" height="44" /></td>

                                <td width="82%" colspan="2"><span class="style510"><a href="website_page.php?pid={$winfo[num].pid}">{$winfo[num].wname}</a> </span>

								{if $winfo[num].T == 'T'}

								<img src="{$template_dir}/images/txt_ad.png" alt="{$_lang.Text_Ads}" width="16" height="16" align="absmiddle" /> 

								{/if}

								{if $winfo[num].I == 'I'}

								<img src="{$template_dir}/images/img_ad.png" alt="{$_lang.Image_Ads}" width="16" height="16" align="absmiddle" /> 

								{/if}

								{if $winfo[num].V == 'V'}

								<img src="{$template_dir}/images/vdo_ad.png" alt="{$_lang.Video_Ads}" width="16" height="16" align="absmiddle" />

								{/if}

								<br />

                                <span ><strong>{$_lang.Daily_Unique_Users}:</strong> {if $winfo[num].daily_users == ""}No Data Available Yet{else}{$winfo[num].daily_users}{/if} -<strong> {$_lang.Ad_Cost}:</strong> {$CURRENCY}{$winfo[num].cost} <a href="website_page.php?pid={$winfo[num].pid}" class="style45"><strong>{$_lang.More_Info} </strong></a></span></td>
                              </tr>

							  {/section}

                              <tr>

                                <td colspan="4">&nbsp;</td>
                              </tr>
                            </table>

							</form>

                            <strong><br />

                          </strong></div>

                        </div>

                    </div></td>

                  </tr>

                  <tr>

                    <td colspan="2"><div align="left"></div></td>

                  </tr>

                  <tr>

                    <td colspan="2">&nbsp;</td>

                  </tr>

                  <tr>

                    <td colspan="2"><div align="center">{$Template_Pagignation_Data}</div></td>

                  </tr>

                </table>

              </div>

		  </div>

			{$TIP}

			<BR />

	  </div>