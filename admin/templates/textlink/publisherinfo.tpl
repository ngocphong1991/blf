<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">        
        <tr>
          <td class="style39"><h1><span class="green">Publisher Info Manager</span></h1></td>
        </tr>
      </table>	  
      <table width="100%" border="0" align="center" style="min-width: 869px">        
        <tr>
          <td width="100%"><div class="splitleft">
		  		{if $smarty.get.edit>0} 
				<div class="box">
              	<div align="left">
				<form action="" method="post" name="frm_edit">
				  <table class="tbl-list" id="lst-submit-url">
                    <tr style="font-weight: bold">                   
						<td width="300">Title</td>
                      	<td>Description</td>                        
						<td></td>                     
                    </tr>                    
                    <tr>                                              
                        <td><textarea name="websitename">{$pub_info.websitename}</textarea></td>
                        <td><textarea name="description">{$pub_info.description}</textarea></td>                        	
						<td> <input class="smart-btn btn-show" style="float:right; margin-right:10px" type="submit" value="Submit" />  </td>					
                    </tr>					                
                 </table>				
				</form>
				</div></div>
				{/if}
            <div class="box">
              <div align="left">			 
			     <form action="" method="get" name="frm_bank">
                 <div class="frm_search" style="padding: 20px 0; text-align: center; background: #fff">
                    <label>User </label>
                    <input type="text" name="keyword" value="{$keyword}" />
                    <label>Active</label>
                    <select name="status">
                        <option {if $status==''}selected="selected"{/if} value="">All</option>
                        <option {if $status=='2'}selected="selected"{/if} value="2">Active</option>
                        <option {if $status=='1'}selected="selected"{/if} value="1">Pending</option>
                    </select>
                    <label>Is Manual</label>
                    <select name="is_manual">
                        <option {if $is_manual==''}selected="selected"{/if} value="">All</option>
                        <option {if $is_manual=='Y'}selected="selected"{/if} value="Y">Yes</option>
                        <option {if $is_manual=='N'}selected="selected"{/if} value="N">No</option>
                    </select>                   
                    <input type="submit" value="Find" />
                 </div>
                 <table class="tbl-list" id="lst-submit-url">
                    <tr style="font-weight: bold">
                        <td>User</td>
                        <td>Url</td>
						 <td>Title</td>
                        <td>Is Manual</td>
						<td>Udate Date</td>
                        <td>Set Price</td>
                        <td>Sale Price</td>
                       <td>Active/Edit</td>
                    </tr>
                    {section name=i loop=$all_publishersinfo}
                    <tr>                       
                        <td>{$cls_user->getUserName($all_publishersinfo[i].uid)}</td>                       
                        <td><a href="{$all_publishersinfo[i].url}">{$all_publishersinfo[i].url}</a></td>
                        <td>{$all_publishersinfo[i].websitename}</td>
                        <td>{$all_publishersinfo[i].is_manual}</td>
                    	 <td>{$all_publishersinfo[i].update_date}</td>
						  <td>{$all_publishersinfo[i].set_price}</td>
						 <td>{$all_publishersinfo[i].sale_price}</td>
						 <td>{$all_publishersinfo[i].status} <a class="smart-btn btn-show" href="../admin/publisherinfo.php?edit={$all_publishersinfo[i].pid}">Edit</a></td>
                    </tr>                 
                    {/section}
                 </table>
                 </form>
                 <div class="paging" style="margin-top: 20px">
                    {section name=i loop=$paging}
                    <a title="{$paging[i][1]}" href="?keyword={$keyword}&approved={$approved}&paid={$paid}&auth={$auth}&page={$paging[i][0]}" class="{if $cursorPage==$paging[i][0]}btn3{else}btn2{/if}">{$paging[i][1]}</a>
                    {/section}
                 </div>
                 <script type="text/javascript" src="templates/default/js/jquery-1.7.1.min.js"></script>
                 <script type="text/javascript" src="templates/default/js/js_bank.js"></script>                 
              </div>
            </div>
          </div></td>
        </tr>
      </table>      
</div>
{literal}
<style>
.smart-btn {display: inline-block}
.frm_search label {display: inline; margin: 0 8px 0 3px;}
</style>
{/literal}