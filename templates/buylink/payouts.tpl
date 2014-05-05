<div id="body">
  <div class="full" id="content">
	<h1>Payouts</h1>	
	<table class="data large">
	  <tbody>
		<tr>
		  <td width="15%"><b>Số Tiền (USD)</b></td>
		  <td width="15%"><b>Ngày Rút</b></td>
		  <td width="10%"><b>Ngày Trả</b></td>
		  <td width="35%"><b>Bank/PayPal</b></td>
		  <td width="10%"><b>Tình Trạng</b></td>
		  <td width="20%"><b>Mã Số</b></td>
		</tr>
		{section name=i loop=$all_withdraw}
		<tr>
		  <td><strong>{$all_withdraw[i].money} USD</strong></td>
		  <td>{$all_withdraw[i].withdraw_date}</td>
		  <td>{$all_withdraw[i].pay_date}</td>
		  <td> {if $all_withdraw[i].method == '1'} PayPal: email {$all_withdraw[i].email_paypal}
{else} VN Bank (Name:{$all_withdraw[i].name_card} | Card Number: {$all_withdraw[i].number_card} | Name of Bank: {$all_withdraw[i].name_bank}){/if} </td>
		  <td> <strong>{if $all_withdraw[i].status == '1'} Đã trả {else} Đang chờ {/if}</strong> </td>
		  <td>{$all_withdraw[i].code}</td>
		</tr>
		{/section}           
	  </tbody>
	</table>		
	<div style="margin-bottom:20px;"></div>
  </div>
</div>