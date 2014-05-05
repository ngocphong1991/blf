<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">
        
        <tr>
          <td class="style39"><h1><span class="green">Submit URL</span></h1></td>
        </tr>
      </table>
	  
      <table width="100%" border="0" align="center">
        
        <tr>
          <td width="100%"><div class="splitleft">
		  
            <div class="box">
              <div align="left">
			     
                 <table class="tbl-list" id="lst-submit-url">
                    <tr style="font-weight: bold">
                        <td style="min-width: 200px">Website</td>
                        <td style="min-width: 330px">URL</td>
                        <td>Status</td>
                        <td style="min-width: 30px">PR</td>
                        <td>Tool</td>
                    </tr>
                    {section name=i loop=$all_publishersinfo}
                    <tr class="tr-submiturl-{$all_publishersinfo[i].pid}" accesskey="{$all_publishersinfo[i].pid}">
                        <td><strong>{$all_publishersinfo[i].websitename}</strong></td>
                        <td>{$all_publishersinfo[i].url}</td>
                        <td>{$cls_publishersinfo->getStatus($all_publishersinfo[i].pid)}</td>
                        <td></td>
                        <td>
                            <button class="smart-btn btn-show">Show</button>
                            <button class="smart-btn btn-openfrm">Add</button>
                        </td>
                    </tr>
                    
                    {assign var=lstItem value=$cls_publishersinfo->getChild($all_publishersinfo[i].pid)}
                    {section name=j loop=$lstItem}
                    <tr class="tr-submiturl-{$all_publishersinfo[i].pid}" accesskey="{$lstItem[j].submit_url_id}" id="submit_url_{$lstItem[j].submit_url_id}" style="display: none">
                        <td style="border-left: 2px solid #77AAFC; padding-left: 20px">{$lstItem[j].websitename}</td>
                        <td>{$lstItem[j].url}</td>
                        <td></td>
                        <td>{$lstItem[j].google_page_rank}</td>
                        <td>
                            <button class="smart-btn btn-del">Del</button>
                        </td>
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
                    <a title="{$paging[i][1]}" href="{$protocol}?page={$paging[i][0]}" class="{if $cursorPage==$paging[i][0]}btn3{else}btn2{/if}">{$paging[i][1]}</a>
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