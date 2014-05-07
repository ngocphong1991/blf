<div class="wrapper paper">
<div class="container">
<div class="row inner-content">
{include file='left-menu.tpl'}
<div class="col-sm-9 right-content-paper plus">
<div class="banner">
    <img src="{$template_dir}/images/ad.png">
</div>
<div class="right-inner">
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('table.cart-tla input.txt2').keyup(function(e){
                var $obj = jQuery(this).parents('table.cart-tla');
                var valBefore = $obj.find('.txtBefore').val();
                var valLink = $obj.find('.txtLink').val();
                var valAfter = $obj.find('.txtAfter').val();
                var valLinkHref = $obj.find('.txtLinkHref').val();


                $obj.find('.valBefore').text(valBefore);
                $obj.find('.valAfter').text(valAfter);
                $obj.find('.valLink').text(valLink);
                $obj.find('.valLink').attr('href',valLinkHref);
            });
            jQuery('#checkoutBtn').click(function(){
                jQuery('#frmCheckOut').submit();
            });
            jQuery.validator.messages.required = "";
            jQuery('#frmCheckOut').validate();

            var totalPrice = 0;
            jQuery('.valuePrice').each(function(){
                totalPrice+=parseInt(jQuery(this).val());
            });
            jQuery('#totalPrice').text(numberFormat(totalPrice));
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
    </script>
{/literal}
<div id="maininner">
    <!-- <h1><a href="cart.php" class="style27">Your Basket</a></h1>-->
    {if $act==''}
        <form action="" method="post" class="form-horizontal" id="frmCheckOut">
            <h4 class="border-bold super-bold">Thông tin giỏ hàng</h4>
            <table class="table table-striped">
                <tbody>
                {section name=i loop=$allAdvertisersinfo}
                    {assign var=onePublishersinfo value=$cls_publishersinfo->getOne($allAdvertisersinfo[i].pid)}
                    <tr>
                        <td>
                            <table class="table table-transparent">
                                <tbody>
                                <tr>
                                    <td colspan="2"><a target="_blank" href="{$_config.www}/view-site.php?pid={$onePublishersinfo.pid}"><strong>{$onePublishersinfo.websitename}</strong></a></td>
                                </tr>
                                <tr>
                                    <td width="40%">Chuyên mục</td>
                                    <td>
                                        {assign var=lstCat value=$cls_publishersinfo->getListCat($onePublishersinfo.pid)}
                                        {section name=j loop=$lstCat}
                                            {assign var=oneCat value=$cls_category->getOne($lstCat[j])}
                                            {$oneCat.category}{if $smarty.section.j.last}{else}<span> - </span>{/if}
                                        {/section}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Link popularity</td>
                                    <td>{$onePublishersinfo.google_page_rank}/10</td>
                                </tr>
                                <tr>
                                    <td>Alexa rank</td>
                                    <td>{$onePublishersinfo.alexa_rank}</td>
                                </tr>
                                <tr>
                                    <td>Giá/tháng</td>
                                    <td>{$cls_publishersinfo->getPrice($onePublishersinfo.pid)}</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="54%">
                            <div class="control-group">
                                {if $allAdvertisersinfo[i].ad_before || $allAdvertisersinfo[i].ad_des || $allAdvertisersinfo[i].ad_after}
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">Preview</label>
                                        <div class="col-sm-6 preview">
                                            <p> <span>{$allAdvertisersinfo[i].ad_before}</span><span> </span> <a target="_blank" href="{$allAdvertisersinfo[i].ad_url}">{$allAdvertisersinfo[i].ad_des}</a> <span> </span><span>{$allAdvertisersinfo[i].ad_after}</span> </p>
                                        </div>
                                    </div>
                                {/if}
                                <div  class="form-group">
                                    <label class="col-sm-6 control-label" for="ad_before">Nội dung trước từ khóa</label>
                                    <div class="col-sm-6">
                                        <input name="info[{$allAdvertisersinfo[i].adv_id}][ad_before]" id="ad_before" maxlength="40" class="txt2 txtBefore" type="text" value="{$allAdvertisersinfo[i].ad_before}">
                                    </div>
                                </div>
                                <div  class="form-group">
                                    <label class="col-sm-6 control-label" for="ad_des">Từ khóa</label>
                                    <div class="col-sm-6">
                                        <input  name="info[{$allAdvertisersinfo[i].adv_id}][ad_des]" id="ad_des" maxlength="40" class="txt2 txtLink required" type="text" value="{$allAdvertisersinfo[i].ad_des}">
                                    </div>
                                </div>
                                <div  class="form-group">
                                    <label class="col-sm-6 control-label" for="ad_after">Nội dung sau từ khóa</label>
                                    <div class="col-sm-6">
                                        <input  name="info[{$allAdvertisersinfo[i].adv_id}][ad_after]" id="ad_after" maxlength="40" class="txt2 txtAfter" type="text" value="{$allAdvertisersinfo[i].ad_after}">
                                    </div>
                                </div>
                                <div  class="form-group">
                                    <label class="col-sm-6 control-label" for="ad_url">Link website</label>
                                    <div class="col-sm-6">
                                        <input maxlength="268"  name="info[{$allAdvertisersinfo[i].adv_id}][ad_url]" id="ad_url" class="txt2 txtLinkHref required url" type="text" value="{if $allAdvertisersinfo[i].ad_url == ''}http://{else}{$allAdvertisersinfo[i].ad_url}{/if}">
                                    </div>
                                </div>
                                <div  class="form-group">
                                    <div class="col-sm-offset-6 col-sm-6">
                                        <a class="button gray" href="?remove={$allAdvertisersinfo[i].adv_id}"> Hủy</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                {/section}
                <tr class="danger checkout-total">
                    <td>Tổng cộng</td>
                    <td><span class="price">{$totalPriceStr} </span> <span class="font-grey">/ Tháng</span></td>
                </tr>
                <tr class="danger checkout-total">
                    <td>Số dư tài khoản</td>
                    <td><span class="price">{$yourMoneyStr}</span></td>
                </tr>
                </tbody>
            </table>
            <div class="pull-right">
                <button class="submit button blue jquery-corner" id="checkoutBtn">CHECK OUT</button>
            </div>
        </form>
    {/if}
    {if $act=='checkout'}
        <h4 class="border-bold super-bold">Checkout</h4>
        <div class="row">
            <form action="" method="post" id="frmUpdate">
                <table class="table table-transparent">
                    <tbody>
                    <tr>
                        <td width="30%">Số dư tài khoản Advertiser</td>
                        <td >{$yourMoney}</td>
                    </tr>
                    <tr>
                        <td>Số tiền phải trả</td>
                        <td >{$totalPrice}</td>
                    </tr>
                    <tr>
                        <td>Ngày bắt đầu</td>
                        <td> <input id="start_date" type="text" value="{$start_date}" name="start_date" class="date-pick" /></td>
                    </tr>
                    <tr>
                        <td>Thời hạn</td>
                        <td>
                            <select size="1" name="length" style="width:70px">
                                {html_options values=$length output=$length selected=$smarty.post.length}
                            </select> Ngày</td>
                    </tr>
                    </tbody>
                </table>
                <table border="0">
                    <tr>
                        <td colspan="2">
                            <button type="submit" value="Update"  name="update_card" class="button gray">Cập nhật</button>
                        </td>
                    </tr>
                </table>
            </form>
            <div id="promotion-section" class="alert-danger alert">
                {if $msg != ''}<p class="error"><span>{$msg}</span></p><br>{/if}
                <form action="" method="post" id="FormPromote">
                    <table class="data large border-top promo" id="promotion-table">
                        <tbody>
                        <tr>
                            <td width="35%">
                                <strong>Bạn có mã khuyến mại không?</strong><br>
                                Hãy điền chính xác để được chiết khấu!
                            </td>
                            <td width="65%">
                                <div class="col-sm-12">
                                    <div class="col-sm-5 col-xs-5">
                                        <input size="16" onblur="if(this.value=='') this.value='Điền mã coupon'" onfocus="if(this.value=='Enter code here') this.value=''" value="Enter code here" name="promotion" style="color: rgb(136, 136, 136);" class="txt2" type="text">
                                    </div>
                                    <div class="col-sm-7 col-xs-7">
                                        <button class="button red">Submit</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="row"> <a href="{$_config.www}/payment" class="button blue-bold">Nạp Tiền</a> <a class="button blue-bold" href="{$_config.www}/cart?act=pay">Thanh Toán</a> </div>
        </div>
    {/if}
    {if $act=='paysuccess'}
        <h4 class="border-bold super-bold">Xác nhận thanh toán</h4>
        <div>
            <table class="table table-transparent">
                <tbody>
                <tr>
                    <td width="30%">Tổng tài khoản hiện tại</td>
                    <td>{$yourMoney}</td>
                </tr>
                <tr>
                    <td>Tổng số tiền vừa thanh toán</td>
                    <td>USD {$smarty.get.price}</td>
                </tr>
                </tbody>
            </table>
            <div class="checkout_nav"> <a class="button blue-bold" href="{$_config.www}">Finish »</a> </div>
        </div>
    {/if}
    <br>
</div>
</div>
</div>
</div>
</div>
</div>
{literal}
    <script type="text/javascript">
        //new datepickr('start_date', { dateFormat: 'Y-m-d' });
    </script>
{/literal}