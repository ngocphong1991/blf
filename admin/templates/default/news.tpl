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
				<tr>										   
					<td> <label>Intro </label></td><td>{$new_info.Intro}</td>                       
				</tr>
				<tr>										   
					<td> <label>Conten </label></td><td>{$new_info.Content}</td>
				</tr>				
                 </table>
				{else}		
				{literal}
				<script type="text/javascript">
				window.onload = function()
				{
					var oFCKeditor = new FCKeditor( 'Content' ) ;
					oFCKeditor.BasePath = "fckeditor/" ;
					oFCKeditor.ReplaceTextarea() ;
				}
				</script>	
				{/literal}	
				<form action="" method="post" name="frm_post">
				{if $smarty.get.Id >0}				
				{else}
				<input type="hidden" name="action" value="insert" />
				{/if}
			 	<table class="tbl-list" id="lst-submit-url">                
				 <tr>                                               
					<td> <label>Title </label></td><td><input type="text" name="Title" value="{$new_info.Title}" style="width:300px"  /><span style="margin-left: 30px">Order No </span><input type="text" name="order_no" value="{$new_info.order_no}" style="width:50px"  /></td>                       
				</tr>  
                <tr>                                               
					<td> <label>Category </label></td><td>
                    <select name="CatID">
                        {section name=i loop=$allcat}
                        <option value="{$allcat[i].Id}" {if $new_info.CategoryId==$allcat[i].Id}selected="selected"{/if}>{$allcat[i].Title}</option>
                        {/section}
                    </select>                       
				</tr>   
				<tr>										   
					<td> <label>Intro </label></td><td><textarea id="Intro" name="Intro">{$new_info.Intro}</textarea></td>                       
				</tr>
				<tr>										   
					<td> <label>Conten </label></td><td><textarea rows="10" id="Content" name="Content">{$new_info.Content}</textarea></td>
				</tr>    
				<tr>
				<td></td><td><input type="submit" class="smart-btn btn-show" value="Submit" style="float:right" /></td>                       
				</tr>
					  
				
                 </table>
                 </form>
				  <table class="tbl-list" id="lst-submit-url">
                    <tr style="font-weight: bold">
                        <td>Title</td>
                        <td width="30">No</td>
						<td>Create date</td>
						<td> </td>
                    </tr>
				  {section name=i loop=$all_news}
				   <tr>                       
                        <td><a href="?Id={$all_news[i].Id}&action=view">{$all_news[i].Title|html_entity_decode|strip_tags|truncate:130}</a></td>                     
                        <td>{$all_news[i].order_no}</td>
                        <td>{$all_news[i].NewsCreateTime}</td>  
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