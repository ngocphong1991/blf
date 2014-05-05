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
              <form action="" method="get" name="frm_bank">
             		 <div style=" text-align:left; padding:10px">
                     <div style="float:left; display:block; width:120px;">
                    <label>User </label>
                    <input type="text" name="keyword" value="{$keyword}" />
                    </div>
                     <div style="float:left; display:block; width:120px; margin-left:50px">
                    <label>Url </label>
                    <input type="text" name="url" value="{$url}" />         
                 
                     </div>          
                    <input type="submit" style="float:right" value="Tìm kiếm" />
                 </div>
                 </form>
			     <table class="tbl-list lst-publishersinfo" id="lst-submit-url">
                  
                    <tr style="font-weight: bold">
                        <td style="min-width: 200px">Website Publisher</td>
                        <td>User Rate</td>
                        <td>Admin Rate</td>
                        <td>Sale Rate</td>
						<td>Create Date</td>
                        <td>Status</td>                        
                        <td></td>
                    </tr>
                    {section name=i loop=$all_publishersinfo}
                    <tr class="tr-submiturl-{$all_publishersinfo[i].pid}" accesskey="{$all_publishersinfo[i].pid}">
                        <td><strong>{$all_publishersinfo[i].websitename}</strong><br />
						<a href="{$all_publishersinfo[i].url}" target="_blank">{$all_publishersinfo[i].url}</a></td>
                        <td>{$all_publishersinfo[i].pay_rate} {$all_publishersinfo[i].unit_price}</td>                      
                        <td align="center"><input name="eAdminRate" class="eAdminRate" value="{$all_publishersinfo[i].set_price}" style="width: 40px" /><button class="smart-btn btn-update">Update</button></td>
                        <td align="center"><input name="eSaleRate" class="eSaleRate" value="{$all_publishersinfo[i].sale_price}" style="width: 40px" /><button class="smart-btn btn-update-sale">Update</button></td>
						 <td>{$all_publishersinfo[i].member_since}</td>
                        <td align="center">{$cls_publishersinfo->getStatus($all_publishersinfo[i].pid)}</td>					 
                        <td align="center">
						{if $all_publishersinfo[i].status==2}
                         <a class="smart-btn btn-show" href="{$_config.www}/admin/pay_rates.php?rates&hide={$all_publishersinfo[i].pid}">Hide</a>
						 {else}
						 <a class="smart-btn btn-show" href="{$_config.www}/admin/pay_rates.php?rates&show={$all_publishersinfo[i].pid}">Show</a>
						 {/if}
                        </td>
                    </tr>                    
                    {assign var=lstItem value=$cls_publishersinfo->getChild($all_publishersinfo[i].pid)}
                    {section name=j loop=$lstItem}
                    <tr class="tr-submiturl-{$all_publishersinfo[i].pid}" accesskey="{$lstItem[j].pid}" id="submit_url_{$lstItem[j].pid}" style="display: none">
                        <td style="border-left: 2px solid #77AAFC; padding-left: 20px">{$lstItem[j].websitename}</td>
                        <td>{$lstItem[j].pay_rate} {$lstItem[j].unit_price}</td>
                        <td><input name="eAdminRate" class="eAdminRate" value="{$lstItem[j].set_price}" style="width: 40px" /><button class="smart-btn btn-update">Update</button></td>
                        <td><input name="eSaleRate" class="eSaleRate" value="{$lstItem[j].sale_price}" style="width: 40px" /><button class="smart-btn btn-update-sale">Update</button></td>
                        <td>{$cls_publishersinfo->getStatus($lstItem[j].pid)}</td>
                        <td></td>
                    </tr>
                    {/section}                    
                    <tr class="frm_submit" id="frm_submit{$all_publishersinfo[i].pid}" style="display: none">
                        <td style="border-left: 2px solid #77AAFC; padding-left: 20px">
                            <input type="text" class="iTitle" />
                        </td>
                        <td>
                            <input type="text" class="iUrl" />
                        </td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="smart-btn btn-add">Add</button>
                            <button class="smart-btn btn-can">Cancel</button>
                            <input type="hidden" class="iDomain" value="{$all_publishersinfo[i].pid}" />
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    {/section}
                 </table>                 
                 <div class="paging" style="margin-top: 20px">
                    {section name=i loop=$paging}
                    <a title="{$paging[i][1]}" href="{$_config.www}/admin/pay_rates.php?rates&page={$paging[i][0]}&keyword={$keyword}&url={$url}" class="{if $cursorPage==$paging[i][0]}btn3{else}btn2{/if}">{$paging[i][1]}</a>
                    {/section}
                 </div>
                 <script type="text/javascript" src="templates/default/js/jquery-1.7.1.min.js"></script>
                 <script type="text/javascript" src="templates/default/js/script.js"></script>
              </div>
            </div>
          </div></td>
        </tr>
      </table>
      
</div>