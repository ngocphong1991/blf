<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">
        
        <tr>
          <td class="style39"><h1><span class="green">Advertisersinfo Manager</span></h1></td>
        </tr>
      </table>
	  
      <table width="100%" border="0" align="center" style="min-width: 869px">
        
        <tr>
          <td width="100%"><div class="splitleft">
		  
            <div class="box">
              <div align="left">
			    {if $smarty.get.action == 'view'}
				
				<table class="tbl-list" id="lst-submit-url">                
				 <tr>                                               
					<td> <label>Title </label></td><td>{$new_info.Title}</td>                       
				</tr> 				
                 </table>
				{else}		
				<form action="" method="post" name="frm_post">
				{if $smarty.get.Id >0}				
				{else}
				<input type="hidden" name="action" value="insert" />
				{/if}
			 	<table class="tbl-list" id="lst-submit-url">                
				 <tr>                                               
					<td> <label>Title </label></td><td><input type="text" name="Title" value="{$new_info.Title}" style="width:300px"  /></td>                       
				</tr>  
				<tr>
				<td></td><td><input type="submit" class="smart-btn btn-show" value="Submit" style="float:right" /></td>                       
				</tr>
					  
				
                 </table>
                 </form>
				  <table class="tbl-list" id="lst-submit-url">
				  {section name=i loop=$all_news}
				   <tr>                       
                        <td><a href="?Id={$all_news[i].Id}&action=view">{$all_news[i].Title}</a></td>
						<td> <a href="?Id={$all_news[i].Id}&action=edit" class="smart-btn btn-openfrm btn-pay-atm-conf-yes">Edit</a> <a href="?Id={$all_news[i].Id}&action=view" class="smart-btn btn-openfrm btn-pay-atm-conf-yes">View</a> <a href="?Id={$all_news[i].Id}&action=delete" class="smart-btn btn-openfrm btn-pay-atm-conf-yes">Del</a></td>                  
                    </tr>                    
				  {/section}
				  </table>
                 <div class="paging" style="margin-top: 20px">
                    {section name=i loop=$paging}
                    <a title="{$paging[i][1]}" href="?keyword={$keyword}&approved={$approved}&paid={$paid}&auth={$auth}&page={$paging[i][0]}" class="{if $cursorPage==$paging[i][0]}btn3{else}btn2{/if}">{$paging[i][1]}</a>
                    {/section}
                 </div>
				
                 <script type="text/javascript" src="templates/default/js/jquery-1.7.1.min.js"></script>
                 <script type="text/javascript" src="templates/default/js/js_bank.js"></script>
                 {/if}
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