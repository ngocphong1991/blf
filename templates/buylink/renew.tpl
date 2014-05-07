<div class="wrapper paper">
    <!--test de commit-->
    <div class="container">
        <div class="row inner-content">
            <div class="row">
                {include file='left-menu.tpl'}
                <div class="col-sm-9 right-content-paper plus">
                    <div class="banner">
                        <img src="{$template_dir}/images/ad.png">
                    </div>

                    <div class="right-inner">
                        <h4 class="border-bold super-bold">Renew link </h4>
                        {if $msg}<div class="alert-success alert">{$msg}</div>{/if}
                        {if $err}<div class="alert-danger alert">{$err}</div>{/if}
                        {if $act=='checkout'}
                            <form method="get" id="marketplaceFilter" class="form-horizontal">
                                <table class="table table-striped links">
                                    <thead>
                                    <tr>
                                        <td>Số dư tài khoản Advertiser</td>
                                        <td>{$yourMoney}</td>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <tr>
                                        <td>Số tiền phải trả</td>
                                        <td>{$totalPrice}</td>
                                    </tr>
                                    <tr>
                                        <td>Ngày bắt đầu - Hết hạn</td>
                                        <td>{$start_date} - {$end_date}</td>
                                    </tr>
                                    <tr>
                                        <td>Textlink</td>
                                        <td>{$allAdvertisersinfo.ad_before} <a href="{$allAdvertisersinfo.ad_url}">{$allAdvertisersinfo.ad_des}</a> {$allAdvertisersinfo.ad_after}</td>
                                    </tr>
                                    <tr>
                                        <td>Trên trang</td>
                                        <td>{$cls_publishersinfo->getPublisherInfo($allAdvertisersinfo.pid, 'websitename')} -
                                            <a href="{$cls_publishersinfo->getPublisherInfo($allAdvertisersinfo.pid, 'url')}">{$cls_publishersinfo->getPublisherInfo($allAdvertisersinfo.pid, 'url')}</a></td>
                                    </tr>


                                    </tbody>
                                </table>

                            </form>
                            <div id="promotion-section" class="alert-danger alert">
                                {if $msg != ''}<p class="error"><span>{$msg}</span></p><br>{/if}
                                <form action="" method="post" id="FormPromote">
                                    <table STYLE="font-size: 12px" class="data large border-top promo" id="promotion-table">
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
                            <div class="form-group">
                                <div class="col-sm-3 pull-left">
                                    <a href="{$_config.www}/payment"><button class="button blue-bold" type="button">Nạp Tiền</button></a>

                                </div>
                                <div class="col-sm-9 pull-right">
                                    <div class="paging pull-right">
                                        <a href="{$_config.www}/renew.php?act=pay&id={$adv_id}"><button class="button blue-bold" type="button">Thanh toán</button></a>
                                    </div>
                                </div>
                            </div>
                        {elseif $act=="success"}
                            <h4 style="color: green">Payment thành công!</h4>
                            <br />
                            <div style="width: 655px">

                                <table class="table table-striped links">
                                    <tbody>


                                    <tr>
                                        <td>Tổng tài khoản hiện tại</td>
                                        <td>{$yourMoney}</td>
                                    </tr>
                                    <tr>
                                        <td>Tổng số tiền vừa thanh toán</td>
                                        <td>{$totalPrice}</td>
                                    </tr>
                                    </tbody>
                                </table>



                                <div class="checkout_nav">
                                    <a href="{$_config.www}" style="fload: right"><button style="width: 100px" class="button blue-bold" type="button">Finish</button></a>
                                </div>
                            </div>
                        {/if}

                    </div>

                </div>
            </div>
        </div>
    </div>