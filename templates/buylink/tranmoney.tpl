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
				<div class="">{$pub_money_str} VNĐ</div>
				
				<label for="" class="field bold">Advertisers:</label>
                <div class="">{$adv_money_str} VNĐ</div>
				
					
			</fieldset>
			</form>
			
			
			

		</div>
        <div class="right half-box">

			<h1>Transfer Details</h1>
            <p>Note: Only transfer money from publishers money to advertisers money</p>

			{if $msg}<div style="border: 1px solid #3980B4; padding: 10px; margin: 10px 0 20px">{$msg}</div>{/if}
			
			
			<form id="aboutForm" action="" method="post" name="frm_update_info">
			<fieldset>
				
				<div class="left half-box no-pad">

				<label for="" class="field bold">Money transfer: *</label>
				<div style="padding: 2px 0 6px 0"><input class="txt" type="text" id="data_trans" name="data_trans" value="" /></div>

				</div>
				
				
				<div class="clear no-pad"></div>

				<label for="" class="field">Total money <strong>Publishers</strong> remain:</label>
				<div style="padding: 2px 0 6px 0"><input disabled="disabled" class="txt" type="text" id="data_pub_remain" name="" value="{$pub_money_str}" size="40"></div>
				<div class="clear no-pad"></div>

				
				<label for="" class="field">Total money <strong>Advertisers</strong> remain:</label>
				<div style="padding: 2px 0 6px 0"><input disabled="disabled" class="txt" type="text" id="data_adv_remain" name="" value="{$adv_money_str}" size="40"></div>
				<div class="clear no-pad"></div>
				
				
				
				

				
				
				<input type="hidden" name="action" value="update_info" />
				
				<div class="clear" style="padding-top: 10px;">
					<a id="aboutUpdateButton" class="btn-green-180" href="#" >Transfer</a>
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
        $('#data_adv_remain').val(numberFormat(adv_money+value));
    });
    
    $('#aboutUpdateButton').click(function(){
        var value = $('#data_trans').val();
        value = parseInt(value);
        if(isNaN(value)) {alert('Số tiền chuyển không đúng định dạng'); return false;}
        if(value<0) alert('Số tiền chuyển phải lớn hơn 0');
        else {
            if(value>pub_money) alert('Số tiền chuyển phải nhỏ hơn số tiền publishers');
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