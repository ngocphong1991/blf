<div id="maininner">
		  <h1><a href="browse.php" class="style27">{$_lang.Browse_Websites_To_Advertise_On}...</a></h1>
				
			<h1 align="right">Step 2 </h1>
			<div class="splitleft">
              <div class="box">
                <table width="100%" border="0" align="center">
                  <tr>
                    <td width="100%"><h1>{$_lang.buying_ppc} {if $ad_space.ad_type == 'txt_ad' ||  $ad_space.ad_type == 'ppc_txt_ad'}{$_lang.Text}{elseif $ad_space.ad_type == 'img_ad' ||  $ad_space.ad_type == 'ppc_img_ad' }{$_lang.Image}{elseif $ad_space.ad_type == 'vdo_ad' ||  $ad_space.ad_type == 'ppc_vdo_ad'}{$_lang.Video}{/if} {$_lang.Ad} {$_lang.On}, <span class="green">{$winfo.websitename}</span></h1></td>
                  </tr>
                  
                  <tr>
                    <td><h1><span class="style6 style22 style51">{$_lang.buy_ppc2}<strong> {$winfo.websitename} </strong></span></h1></td>
                  </tr>
                </table>
				<form name="ppc" action="" method="post"><table width="80%" border="0" align="center">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" border="0" align="absmiddle" /></span><strong>{$_lang.buy_ppc3} </strong></td>
                    <td></span><strong>{$CURRENCY}{$ad_space.cost}</strong></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td></span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" border="0" align="absmiddle" /></span><strong>{$_lang.pay_for} <span class="style44">({$_lang.Minimum_Spend_Is} {$CURRENCY}{$ad_space.min_spend})</span></strong></span></td>
                    <td></span> <input name="cost" type="hidden" id="cost" value="{$ad_space.cost}">
                      <input name="min_spend" type="hidden" id="min_spend" value="{$ad_space.min_spend}">
                      <input name="clicks" type="text" id="clicks" size="10" onKeyUp="check_ppc();" />
                    <strong>Clicks</strong></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><img src="{$template_dir}/images/Bullet_green.gif" width="19" height="16" border="0" align="absmiddle" /></span><strong>{$_lang.This_will_cost_you} </strong></td>
                    <td>{$CURRENCY}
                    <input name="total" type="text" id="total" value="00.00" size="10" readonly />
                    <input name="ppc_balance" type="hidden" id="ppc_balance"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="submit_ppc" type="submit" disabled="disabled" class="button" id="submit_ppc" value="{$_lang.Add_To_Basket}" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table></form>
                
              </div>
		  </div>
			{$TIP}
	  </div>