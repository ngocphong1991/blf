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
			     <form action="" method="get" name="frm_bank">
                 <div class="frm_search" style="padding: 20px 0; text-align: center; background: #fff">
                    <label>User </label>
                    <input type="text" name="keyword" value="{$keyword}" />
                    <label>Active</label>
                    <select name="status">
                        <option {if $status==''}selected="selected"{/if} value="">All</option>
                        <option {if $status=='1'}selected="selected"{/if} value="1">Paid</option>
                        <option {if $status=='0'}selected="selected"{/if} value="0">Waiting</option>
                    </select>                  
                   
                    <input type="submit" value="Find" />
                 </div>
                 <table  class="tbl-list"  id="lst-submit-url">
                    <tr style="font-weight: bold">
					<td>User</td>
					<td>Money</td>
					<td>Withdraw date</td>
					<td>Method</td>
					<td>Email paypal</td>
					<td>Name card</td>
					<td>Number card</td>
				    <td>Name of Bank</td>
				    <td>Phone</td>
				    <td>Code</td>
				    <td>Status</td>
                    </tr>
                    {section name=i loop=$all_withdraw}
                    <tr>                       
                        <td>{$cls_user->getUserName($all_withdraw[i].user_id)}</td>                 
                        <td>{$all_withdraw[i].money} USD</td>
                        <td>{$all_withdraw[i].withdraw_date}</td>
                    	<td>{if $all_withdraw[i].method == '1'}PayPal {else} VN Bank{/if}</td>
						<td>{$all_withdraw[i].email_paypal}</td>						
						<td>{$all_withdraw[i].name_card}</td>
						<td>{$all_withdraw[i].number_card}</td>
						<td>{$all_withdraw[i].name_bank}</td>
						<td>{$all_withdraw[i].phone}</td>
						<td>{$all_withdraw[i].code}</td>
						<td>{if $all_withdraw[i].status == '0'} Pending <a href="?confirm={$all_withdraw[i].withdraw_id}&type=yes" class="smart-btn btn-openfrm btn-pay-atm-conf-yes">Pay now</a>{else} Paid 	<a href="?confirm={$all_withdraw[i].withdraw_id}&type=no" class="smart-btn btn-openfrm btn-pay-atm-conf-no">No</a></td>	{/if} 
                          					
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
<script type="text/javascript">
$(document).ready(function(){
    $('.btn-pay-atm-conf-yes').click(function(){
        if(!confirm("Bạn đã gửi tiền tới tài khoản của publisher?")) {
            return false;
        }
    });
    $('.btn-pay-atm-conf-no').click(function(){
        if(!confirm("Bạn chưa gửi tiền tới publisher?")) {
            return false;
        }
    });
});
</script>
{/literal}