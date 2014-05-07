<div class="wrapper paper">
    <div class="container">
        <div class="row inner-content">
            {include file='left-menu.tpl'}
            <div class="col-sm-9 right-content-paper plus">
                <div class="banner">
                    <img src="{$template_dir}/images/ad.png">
                </div>
                <div class="right-inner">
                    {if $msg_profile!=''}
                        <p style="border: 1px solid #2769A1; padding: 10px; colora: #2769A1;">{$msg_profile}</p>
                    {/if}
                    <div>
                        <h4 class="border-bold super-bold">Thông tin tài khoản</h4>
                        <form id="profileForm" class="default" action="/profile/" method="get" onsubmit="return false;">
                            <fieldset>
                                <b>Publishers:</b>
                                <span>{$pub_money_str} USD</span><br>
                                <b>Affiliates:</b>
                                <span>{$affiliate_money_str} USD</span>
                            </fieldset>
                        </form>
                        <h4 class="border-bold super-bold">Rút tiền từ tài khoản</h4>
                        <div>
                            <p class="alert-warning alert">Chú ý: chỉ rút tiền từ tài khoản của publisher</p>
                            {if count($error)}
                                <div class="alert alert-danger">
                                    {section name = num loop = $error}
                                        {$error[num]}<br>
                                    {/section}
                                </div>
                            {/if}
                            {if $msg}<div class="alert alert-success">{$msg}</div>{/if}
                            {if $success}<div class="alert alert-success">{$success}</div>{/if}

                            <form id="aboutForm" action="" method="post" name="frm_update_info">
                                <fieldset>

                                    <div class="left half-box no-pad">

                                        <label for="" class="field bold">Số tiền rút: *</label>
                                        <div style="padding: 2px 0 6px 0"><input class="txt" type="text" id="data_trans" name="data_trans" value="" /></div>
                                    </div>
                                    <div class="clear no-pad"></div>
                                    <label for="" class="field">Tổng tiền <strong>Publishers</strong> hiện tại:</label>
                                    <div style="padding: 2px 0 6px 0"><input disabled="disabled" class="txt" type="text" id="data_pub_remain" name="" value="{$pub_money_str}" size="40"></div>
                                    <div class="clear no-pad"></div>


                                    <label for="" class="field">Tổng <strong>số tiền</strong> rút:</label>
                                    <div style="padding: 2px 0 6px 0"><input disabled="disabled" class="txt" type="text" id="data_adv_remain" name="" value="{$adv_money_str}" size="40"></div>
                                    <div>
                                        <input type="radio" {if $smarty.post.payment_method == '1'} checked="checked" {/if} id="payment_method_paypal" name="payment_method" value="1" onclick="jQuery('#advertiserDataBlock').css('display', 'none'); jQuery('#publisherDataBlock').css('display', 'block');"/><label for="publisherYes"> Chuyển tiền vào tài khoản Paypal</label><br/>
                                        <input type="radio" {if $smarty.post.payment_method == '2'} checked="checked" {/if} id="payment_method_vn" name="payment_method" value="2" onclick="jQuery('#paypalEmailField').value = ''; jQuery('#publisherDataBlock').css('display', 'none'); jQuery('#advertiserDataBlock').css('display', 'block');"/><label for="publisherNo">Chuyển tiền vào tài khoản ở Việt Nam </label><br/>
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
                                        <a id="aboutUpdateButton" class="button blue" href="#" >Rút tiền</a>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var pub_money = parseInt({$my_profile.pub_money});
    var adv_money = parseInt({$my_profile.adv_money});
</script>
{literal}
<script type="text/javascript">
jQuery(document).ready(function(){

    jQuery('#data_trans').keyup(function(){
        var value =jQuery(this).val();
        if(value=='') value=0;
        value = parseInt(value);
        jQuery('#data_pub_remain').val(numberFormat(pub_money-value));
        jQuery('#data_adv_remain').val(numberFormat(0+value));
    });

    jQuery('#aboutUpdateButton').click(function(){
        var value = jQuery('#data_trans').val();
        value = parseInt(value);
        if(isNaN(value)) {alert('We did not support this kind of money'); return false;}
        if(value<0) alert('Your money you tranfer must be greater than 0');
        else {
            if(value>pub_money) alert('Your money tranfer must be less than your publisher money');
            else {
                jQuery('#aboutForm').submit();
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