<div class="wrapper paper">
    <div class="container">
        <div class="row inner-content">
            {include file='left-menu.tpl'}
            <div class="col-sm-9 right-content-paper plus">
                <div class="banner">
                    <img src="{$template_dir}/images/ad.png">
                </div>
                <div class="right-inner">
                    <!-- START PROFILE INDEX PAGE-->
                    <h4 class="border-bold">Nạp tiền</h4>
                    <div class="alert alert-success">Thanh toán trực tuyến an toàn dùng tài khoản ngân hàng (VietComBank, TechComBank, Đông Á, VIB, SHB, VietinBank,...) và thẻ quốc tế (Visa, Master...) qua ví điện tử NgânLượng.vn, ĐÃ ĐƯỢC NGÂN HÀNG NHÀ NƯỚC CẤP PHÉP!</div>
                    <form class="form-horizontal" method="post" action="" id="payment" name="payment">
                        {if $msg}<div class="alert alert-danger">{$msg}</div>{/if}
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-3 control-label" for="amount">Số tiền nạp (USD)</label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="col-sm-4" id="amount" name="amount" value="{$myProfile.username}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-xs-offset-3 col-sm-9 col-xs-9">
                                    <a href="javascript:void(0)" id="pay"><img src="https://www.nganluong.vn/data/images/merchant/button/btn-paynow-125.png"></a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
<script type="text/javascript">
    jQuery('#pay').click(function(){
        jQuery('#payment').submit();
    })
</script>
{/literal}