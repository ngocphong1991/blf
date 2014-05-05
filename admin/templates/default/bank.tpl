<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">
        
        <tr>
          <td class="style39"><h1><span class="green">Bank Manager</span></h1></td>
        </tr>
      </table>
	  
      <table width="100%" border="0" align="center" style="min-width: 769px">
        
        <tr>
          <td width="100%"><div class="splitleft">
		  
            <div class="box">
              <div align="left">
			     <form action="" method="post" name="frm_bank">
                 <table class="tbl-list" id="lst-submit-url">
                    <tr style="font-weight: bold">
                        <td width="169">Ngân hàng</td>
                        <td width="169">Chi nhánh</td>
                        <td width="169">Chủ tài khoản</td>
                        <td width="169">Số tài khoản</td>
                        <td>Logo</td>
                        <td></td>
                    </tr>
                    {section name=i loop=$all_bank}
                    <tr>
                        <td><strong>{$all_bank[i].name}</strong></td>
                        <td>{$all_bank[i].branch}</td>
                        <td>{$all_bank[i].holders}</td>
                        <td>{$all_bank[i].bank_no}</td>
                        <td><img src="{$all_bank[i].image}" width="25" /></td>
                        <td>
                            <a href="?del={$all_bank[i].bank_id}" class="smart-btn btn-openfrm">Del</a>
                        </td>
                    </tr>
                    
                 
                    {/section}
                    <tr class="frm_submit" style="display: nonez">
                        <td><input type="text" class="" name="data[name]" /></td>
                        <td><input type="text" class="" name="data[branch]" /></td>
                        <td><input type="text" class="" name="data[holders]" /></td>
                        <td><input type="text" class="" name="data[bank_no]" /></td>
                        <td><input type="text" class="" name="data[image]" style="width: 20px" /></td>
                        <td>
                            <button class="smart-btn btn-add" onclick="frm_bank.submit()">Add</button>
                        </td>
                    </tr>
                 </table>
                 </form>
                 <div class="paging" style="margin-top: 20px">
                    {section name=i loop=$paging}
                    <a title="{$paging[i][1]}" href="{$protocol}?page={$paging[i][0]}" class="{if $cursorPage==$paging[i][0]}btn3{else}btn2{/if}">{$paging[i][1]}</a>
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
</style>
{/literal}