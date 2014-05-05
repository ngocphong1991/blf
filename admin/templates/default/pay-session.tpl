<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">
        
        <tr>
          <td class="style39">
            <h1><span class="green">Session Pay: {$oneUser.username} ({$oneUser.fullname})</span></h1>
            <p><a href="user.php">« Back</a></p>
          </td>
        </tr>
      </table>	  
      <table width="100%" border="0" align="center" style="min-width: 769px">
        
        <tr>
          <td width="100%"><div class="splitleft">
		  <div style="color:red"> {$msg} </div>
            <div class="box">
              <div align="left">
			     <form action="" method="post" name="frm_bank">
                 <table class="tbl-list" id="lst-submit-url">
                    <tr style="font-weight: bold">
                        <td width="33%">Hình thức</td>
                        <td width="33%">Số tiền</td>
                        <td width="33%">Thời gian</td>
                        <td width="20">ID</td>
                    </tr>
                    {section name=i loop=$all_session_pay}
                    <tr>
                        <td>{$all_session_pay[i].type}</td>
                        <td>${$all_session_pay[i].money}</td>
                        <td>{$all_session_pay[i].reg_date|date_format:"%d/%m/%Y - %H:%M"}</td>
                        <td>{$all_session_pay[i].session_pay_id}</td>
						<td> <a href="?del={$all_session_pay[i].session_pay_id}" class="smart-btn btn-openfrm">Del</a></td>
                    </tr>               
                    {/section}
                    <tr class="frm_submit" style="display: nonez">
                        <td><input type="text" class="" name="data[type]" /></td>
                        <td><input type="text" class="" name="data[money]" /></td>
                        <td>{$cursorTime|date_format:"%d/%m/%Y - %H:%M"}</td>
                        <td>
                            <button class="smart-btn btn-add" onclick="frm_bank.submit()">Add</button>
                        </td>
                    </tr>
                 </table>
                 </form>
                 <div class="paging" style="margin-top: 20px">
                    {section name=i loop=$paging}
                    <a title="{$paging[i][1]}" href="{$protocol}&page={$paging[i][0]}" class="{if $cursorPage==$paging[i][0]}btn3{else}btn2{/if}">{$paging[i][1]}</a>
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