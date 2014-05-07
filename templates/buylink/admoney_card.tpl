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
                    <h4 class="border-bold">Nạp tiền bằng thẻ coupon của Buylink</h4>
                    <div class="full" id="content">
                        {if $msn}<div class="alert-success alert">{$msn}</div>{/if}
                        {if $error}<div class="alert-danger alert">{$msn}</div>{/if}
                        <div class="clear"></div>
                        <form class="form-horizontal" method="post" action="" id="link-filter">
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-3 control-label" for="ref_code">Mã thẻ</label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="col-sm-5 col-xs-5" name="ref_code" id="ref_code" />
                                </div>
                            </div>
                            <input type="hidden" name='charge' value="1">
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-xs-offset-3 col-sm-9 col-xs-9">
                                    <button class="button gray jquery-corner">Nạp tiền</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>