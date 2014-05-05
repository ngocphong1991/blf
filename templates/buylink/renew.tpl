<link rel="stylesheet" type="text/css" href="{$template_dir}/css/cart.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="{$template_dir}/js/jquery.validate.js"></script>
{literal}
<style>
.style27 {font-size: 1.7em}
.style30 {
	color: #7594C0;
	font-weight: bold;
}
.style35 {color: #003366}
.style44 {font-size: 11px}
.style39 {font-size: 12px; font-weight: bold; }
.style54 {font-size: 11px; color: #333333; }
.style55 {
	color: #333333;
	font-weight: bold;
}
.style560 {color: #4284B0}
</style>
{/literal}
<!-- <h1><a href="cart.php" class="style27">{$_lang.Your_Basket}</a></h1>-->
{if $act=='checkout'}
<div id="content">
    <h1>Renew link</h1>
    <br />
    <div style="width: 655px">
    <table class="tbl_default" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; table-layout: auto;">
        <tr>
            <td>Your money advertising</td>
            <td>{$yourMoney}</td>
        </tr>
        <tr>
            <td>Total money have to pay</td>
            <td>{$totalPrice}</td>
        </tr>
		 <tr>
            <td>Start date - End date</td>
            <td>{$start_date} - {$end_date}</td>
        </tr>
		 <tr>
            <td>Link Renew</td>
            <td>{$allAdvertisersinfo.ad_before} <a href="{$allAdvertisersinfo.ad_url}">{$allAdvertisersinfo.ad_des}</a> {$allAdvertisersinfo.ad_after} </td>
        </tr>
		 <tr>
            <td>On Site</td>
            <td> {$cls_publishersinfo->getPublisherInfo($allAdvertisersinfo.pid, 'websitename')} - 
			<a href="{$cls_publishersinfo->getPublisherInfo($allAdvertisersinfo.pid, 'url')}">{$cls_publishersinfo->getPublisherInfo($allAdvertisersinfo.pid, 'url')}</a></td>
        </tr>			
    </table>
	<h2>Promotions</h2>
	{$msg}
	<div id="promotion-section">
	<img alt="" src="{$template_dir}/images/discount-tag.png" class="discount-tag"><table class="data large border-top promo" id="promotion-table">
	<tbody>
	<form action="" method="post" id="FormPromote">
	<tr class="row1">
	<td class="padding-left"><strong>Have a promotion code?</strong><br>Enter it on the right to save!</td>
	<td class="alignleft"><a onclick="$('#FormPromote').submit(); return false;" href="{$_config.www}/cart/" style="margin-right: 10px;" class="btn-tan-80 right">Submit</a>
	<input type="text" size="16" onblur="updateTextFieldLabel(this, false, 'Enter code here');" onfocus="updateTextFieldLabel(this, true, 'Enter code here');" value="Enter code here" name="promotion" style="color: rgb(136, 136, 136);" class="txt"></td>
	<td class="alignright red bold large"></td>
	<td class="centered last"></td>
	</tr>
	</form>
	</tbody>
	</table>
	</div>
    <div class="checkout_nav">	
        <a href="{$_config.www}/payment">Charge Money</a>
        <a href="{$_config.www}/renew.php?act=pay&id={$adv_id}">Payment</a>
    </div>
    </div>
</div>
{elseif $act=="success"}
<div id="content">
    <h1>Payment thành công!</h1>
    <br />
    <div style="width: 655px">
    <table class="tbl_default" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; table-layout: auto;">
        <tr>
            <td>Tổng tài khoản hiện tại</td>
            <td>{$yourMoney}</td>
        </tr>
        <tr>
            <td>Tổng số tiền vừa thanh toán</td>
            <td>{$totalPrice}</td>
        </tr>
    </table>
    <div class="checkout_nav">
        <a href="{$_config.www}" style="fload: right">Finish »</a>
    </div>
    </div>
</div>
{/if}<br />
</div>