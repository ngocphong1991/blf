<div id="content" class="full">
		<a class="btn-tan-180 right" style="margin-right: 10px;" href="{$_config.www}/affiliates">Affiliate Program</a>
		<h1>Manage Affiliate Coupons </h1>
		<span class="bold green">{$msg.success}</span> <span style="color:#CE3305" class="bold">{$msg.error}</span>	
		<form action="" method="post">
		<table class="basic_form">
	    <tbody><tr class="important">
		<td style="width:120px;"> Coupon Code </td>
		<td>
		<input type="text" value="084" size="20" name="code" id="" class="txt2">
		</td>
	    </tr>
	    <tr class="important">
		<td style="width:120px;"> Discount </td>
		<td>		  
		<select class="txt2" name="discount">
			<option value="1">10% OFF</option>	
		</select>					
		</td>
	    </tr>
	    <tr>
		<td colspan="2">
		<input style="float:right" type="submit" class="reg-3-button" value="Tạo Coupon" />		   
		</td>
	    </tr>
	</tbody></table>
	</form>
	<p>		
	<h2 style="padding-bottom: 10px;">View Current Coupons</h2>	
	<div class="description">
    <div class="text">
	Below is a list of all of your previously created coupons with commission statistics for them.					
    </div>
	</div>	
	<table class="data large">
	  <tbody>
		<tr>
		  <td width="5%"><b>#</b></td>
		  <td width="25%"><b>Coupon Code</b></td>
		  <td width="25%"><b>Created Date</b></td>
		  <td width="25%"><b>End Date</b></td>
		  <td width="10%"><b>Delete</b></td>
		</tr>
		{section name=i loop=$all_coupon}	
		<tr>
		  <td><strong>{$all_coupon[i].coupon_id}</strong></td>
		  <td>{$all_coupon[i].code}</td>
		  <td>{$all_coupon[i].start_date}</td>
		  <td>  {$all_coupon[i].end_date}
 </td>
		  <td> <strong>{if $all_coupon[i].status == '0'} Pending {else} Actived {/if} <a href="{$_config.www}/affiliates.php?do=manage&confirm={$all_coupon[i].coupon_id}&type=delete" class="smart-btn btn-openfrm btn-pay-atm-conf-yes">Del</a></strong> </td>
		 
		</tr>
			{/section}		           
	  </tbody>
	</table>	
	</div>