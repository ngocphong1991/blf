<div class="full" id="content">
    {if $msg_profile!=''}
    <p style="border: 1px solid #2769A1; padding: 10px; colora: #2769A1;">{$msg_profile}</p>
    {/if}
        <div>
            <div class="left half-box">

			<h1>Account Details</h1>
			<form id="profileForm" class="default" action="/profile/" method="get" onsubmit="return false;">
			<fieldset>								
				<label for="" class="field bold">Publishers:</label>
				<div class="">USD {$pub_money_str}</div>				
				<label for="" class="field bold">Affiliates:</label>
				<div class="">USD {$affiliate_money_str}</div>					
			</fieldset>
			</form>
		</div>
        <div class="right half-box">
			<h1>Withdraw Money</h1>
            <p>Note: Only transfer withdraw money from your publisher account</p>
			 {section name = num loop = $error}
                           <div style="border: 1px solid #3980B4; padding: 6px; margin: 10px 0 5px"><span style="color:{$color}">{$error[num]}</span></div>
             {/section} 
						
			{if $msg}<div style="border: 1px solid #3980B4; padding: 10px; margin: 10px 0 20px">{$msg}</div>{/if}
			
			
			<form id="aboutForm" action="" method="post" name="frm_update_info">
			<fieldset>
				
				<div class="left half-box no-pad">

				<label for="" class="field bold">Money withdraw: *</label>
				<div style="padding: 2px 0 6px 0"><input class="txt" type="text" id="data_trans" name="data_trans" value="" /></div>
				</div>				
				<div class="clear no-pad"></div>
				<label for="" class="field">Total money <strong>Publishers</strong> remain:</label>
				<div style="padding: 2px 0 6px 0"><input disabled="disabled" class="txt" type="text" id="data_pub_remain" name="" value="{$pub_money_str}" size="40"></div>
				<div class="clear no-pad"></div>

				
				<label for="" class="field">Total <strong>money</strong> withdraw:</label>
				<div style="padding: 2px 0 6px 0"><input disabled="disabled" class="txt" type="text" id="data_adv_remain" name="" value="{$adv_money_str}" size="40"></div>
				<div>				
					<input type="radio" {if $smarty.post.payment_method == '1'} checked="checked" {/if} id="payment_method_paypal" name="payment_method" value="1" onclick="$('#advertiserDataBlock').css('display', 'none'); $('#publisherDataBlock').css('display', 'block');"/><label for="publisherYes"> We will transfer money to your PayPal account</label><br/>
					<input type="radio" {if $smarty.post.payment_method == '2'} checked="checked" {/if} id="payment_method_vn" name="payment_method" value="2" onclick="$('#paypalEmailField').value = ''; $('#publisherDataBlock').css('display', 'none'); $('#advertiserDataBlock').css('display', 'block');"/><label for="publisherNo">For Vietnam publishers </label><br/>							
					</div>
					<div id="advertiserDataBlock" style="clear: left; display: {if $smarty.post.payment_method == '2'}block {else} none {/if};">
					<label for="" class="field bold">Tên chủ tài khoản: *<br/></label>
					<div>
						<input class="txt" type="text" id="proposalUrlField" name="fullname" value="" size="60" maxlength="255"/>
						<br/><span class="small lightgrey">Nhập tên chủ tài khoản ngân hàng của bạn.</span>
					</div>
					<label for="" class="field bold">Số tài khoản: *<br/></label>
					<div>
						<input class="txt" type="text" id="number_account_bank" name="number_account_bank" value="" size="60" maxlength="255"/>
						<br/><span class="small lightgrey">Nhập đầy đủ số tài khoản ngân hàng của bạn, chúng tôi sẽ gửi tiền cho bạn theo số tài khoản này.</span>
					</div>
					<label for="" class="field bold">Tại ngân hàng: *<br/></label>
					<div>
						<input class="txt" type="text" id="name_of_bank" name="name_of_bank" value="" size="60" maxlength="255"/>
						<br/><span class="small lightgrey">Nhập tên ngân hàng của bạn.</span>
					</div>
					
					<label for="" class="field bold">Số điện thoại của bạn: *<br/></label>
					<div>
						<input class="txt" type="text" id="mobile" name="mobile" value="" size="60" maxlength="255"/>
						<br/><span class="small lightgrey">Chúng tôi sẽ liên lạc với bạn theo số điện thoại này.</span>
					</div>					
				</div>
				<div style="clear: left; display: {if $smarty.post.payment_method == '1'}block {else} none {/if};" id="publisherDataBlock">
					<label class="field" for="">Your PayPal E-mail:<br><br></label>							
					<div>
						<input type="text" maxlength="255" size="30" value="" name="paypal_email" id="paypalEmailField" class="txt">
						<br><span class="small lightgrey">This is the e-mail address where payments will be sent.</span>
					</div>							
				</div>						
				<div class="clear no-pad"></div>			
				<input type="hidden" name="action" value="update_info" />				
				<div class="clear" style="padding-top: 10px;">
					<a id="aboutUpdateButton" class="btn-green-180" href="#" >Withdraw</a>
				</div>
			</fieldset>
			</form>
		
		</div>
        </div>
		<div class="clear"></div>
	</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
    var pub_money = parseInt({$my_profile.pub_money});
    var adv_money = parseInt({$my_profile.adv_money});
</script>
{literal}
<script type="text/javascript">
$(document).ready(function(){
    
    $('#data_trans').keyup(function(){
        var value = $(this).val();
        if(value=='') value=0;
        value = parseInt(value);
        $('#data_pub_remain').val(numberFormat(pub_money-value));
        $('#data_adv_remain').val(numberFormat(0+value));
    });
    
    $('#aboutUpdateButton').click(function(){
        var value = $('#data_trans').val();
        value = parseInt(value);
        if(isNaN(value)) {alert('We did not support this kind of money'); return false;}
        if(value<0) alert('Your money you tranfer must be greater than 0');
        else {
            if(value>pub_money) alert('Your money tranfer must be less than your publisher money');
            else {
                $('#aboutForm').submit();
            }
        }
        return false;
    });
    
    function numberFormat(nStr){
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
      return x1 + x2;
    }
});
</script>
{/literal}