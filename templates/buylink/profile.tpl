<div class="wrapper paper">
    <div class="container">
        <div class="row inner-content">
            {include file='left-menu.tpl'}
            <div class="col-sm-9 right-content-paper plus">
                <div class="banner">
                    <img src="{$template_dir}/images/ad.png">
                </div>
                <div class="right-inner">
                    {if $page == ''}
                        <!-- START PROFILE INDEX PAGE-->
                        <h4 class="border-bold">Thông tin tài khoản</h4>
                        {if isset($msg_profile)}<div class="alert-success alert">{$msg_profile}</div>{/if}
                        {if isset($msg_error)}<div class="alert-danger alert">{$msg_error}</div>{/if}
                        <!--Start panel-->
                        <div class="panel-group" id="accordion">
                            <!--Start the Account Information-->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h6>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                            Thông tin tài khoản
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <form method="post" enctype="multipart/form-data" class="form-horizontal" action="" id="profileChange" name="profileChange">
                                            <input type="hidden" name="action" value="update_info">
                                            <fieldset>
                                                <div class="control-group">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="username">Tên đăng nhập *</label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="text" class="col-sm-8 col-xs-8 required" id="username" readonly name="username" value="{$myProfile.username}" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="email">Email *</label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="text" class="col-sm-8 col-xs-8 required email" id="email" readonly name="email" value="{$myProfile.email}" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="fullname">Họ và tên *</label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="text" id="fullname" name="data[fullname]" value="{$myProfile.fullname}" class="col-sm-4 required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="cmnd">Số CMND</label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="text" class="col-sm-8 col-xs-8 number" id="cmnd" name="data[cmnd]" value="{$myProfile.cmnd}" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="avatar">Ảnh Scan CMND <span class="error">(nếu có)</span></label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="file" class="col-sm-8 col-xs-8" id="avatar" name="avatar" value="{$myProfile.avatar}" />
                                                            {if $myProfile.avatar}
                                                                <div class="col-sm-5 col-xs-5">
                                                                    <img src="{$myProfile.avatar}" alt="{$myProfile.fullname}" class="img-thumbnail">
                                                                </div>
                                                            {/if}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="tax_code">Mã số thuế cá nhân <span class="error">(nếu có)</span> </label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="text" class="col-sm-8 col-xs-8" value="{$myProfile.tax_code}" id="tax_code" name="data[tax_code]" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="address_cmnd">Địa chỉ thường trú (trên CMND) <span class="error">(nếu có)</span> </label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="text" class="col-sm-8 col-xs-8" value="{$myProfile.address_cmnd}" id="address_cmnd" name="data[address_cmnd]" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="mobile">Giới tính </label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <select id="gender" name="gender">
                                                                {foreach from=$genders key=k item=v}
                                                                    <option value="{$k}" {if $myProfile.gender == $k}selected="selected"{/if}>{$v}</option>
                                                                {/foreach}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="phone">Điện thoại di động </label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="text" class="col-sm-8 col-xs-8 number" value="{$myProfile.phone}" id="phone" name="data[phone]" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="city">Thành phố</label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="text" class="col-sm-4" id="city" value="{$myProfile.city}" name="data[city]" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="address">Địa chỉ (không bắt buộc)</label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="text" class="col-sm-8 col-xs-8" value="{$myProfile.address}" id="address" name="data[address]" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-3 col-xs-offset-3 col-sm-9 col-xs-9">
                                                            <button class="submit-gray button gray jquery-corner">LƯU THAY ĐỔI</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--End the Account Information-->
                            <!--Start change email-->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h6>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                            Thay đổi địa chỉ email
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <form method="post" enctype="multipart/form-data" class="form-horizontal" action="" id="emailChange" name="emailChange">
                                            <input type="hidden" name="action" value="update_email">
                                            <fieldset>
                                                <div class="control-group">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="email">Email mới</label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="text" class="col-sm-8 col-xs-8 required email" id="email_change" name="data[email_change]" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="email_confirm">Nhập lại email</label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="text" class="col-sm-8 col-xs-8" equalto="#email_change" id="email_change_confirm" name="data[email_change_confirm]"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-3 col-xs-offset-3 col-sm-9 col-xs-9">
                                                            <button class="submit-gray button gray jquery-corner">LƯU THAY ĐỔI</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--End the change email-->
                            <!--Start change password-->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h6>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                            Thay đổi mật khẩu
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <form method="post" enctype="multipart/form-data" class="form-horizontal" action="" id="passChange" name="passChange">
                                            <input type="hidden" name="action" value="update_pass">
                                            <fieldset>
                                                <div class="control-group">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="password">Mật khẩu mới</label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="password" class="col-sm-8 col-xs-8 required" id="password" name="data[password]" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 col-xs-3 control-label" for="password_confirm">Nhập lại mật khẩu</label>
                                                        <div class="col-sm-9 col-xs-9">
                                                            <input type="password" class="col-sm-8 col-xs-8" equalto="#password" minlength="6" id="password_confirm" name="data[password_confirm]"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-3 col-xs-offset-3 col-sm-9 col-xs-9">
                                                            <button class="submit-gray button gray jquery-corner">LƯU THAY ĐỔI</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--Start change password-->
                        </div>
                        <!--End panel-->
                        <!-- END PROFILE INDEX PAGE-->
                    {elseif $page == 'history'}
                        <!-- START PROFILE HISTORY PAGE-->
                        <h4 class="border-bold">Lịch sử giao dịch</h4>
                        {if $cls_tracking && count($cls_tracking)}
                        <table class="table" style="margin-top: 30px">
                            <tbody>
                            <tr class="info">
                                <td><b>#</b></td>
                                <td><b>Số Tiền</b></td>
                                <td><b>Ngày Nạp</b></td>
                                <td><b>Tình Trạng</b></td>
                            </tr>
                            {section name=i loop=$cls_tracking}
                                <tr>
                                    <td>{$smarty.section.i.index+1}</td>
                                    <td>{$cls_tracking[i].amount} {$cls_tracking[i].currency_char}</td>
                                    <td>{$cls_tracking[i].date_order|date_format:"%D"}</td>
                                    <td>{if $cls_tracking[i].error_text != ''}{$cls_tracking[i].error_text}{else}Thành công{/if}</td>
                                </tr>
                            {/section}
                            </tbody>
                        </table>
                        {else}
                            <div class="alert alert-danger">Bạn chưa từng nạp tiền vào tài khoản</div>
                        {/if}
                        <!-- END PROFILE HISTORY PAGE-->
                    {elseif $page == 'money'}
                        <!-- START PROFILE MONEY PAGE-->
                        <h4 class="border-bold">Nạp tiền</h4>
                        {if isset($msg_profile)}<div class="message-error">{$msg_profile}</div>{/if}
                        <!-- END PROFILE MONEY PAGE-->
                    {elseif $page == 'money_coupon'}
                        <!-- START PROFILE MONEY COUPON PAGE-->
                        <h4 class="border-bold">Nạp tiền từ coupon</h4>
                        {if isset($msg_profile)}<div class="message-error">{$msg_profile}</div>{/if}
                        <!-- END PROFILE MONEY COUPON PAGE-->
                    {elseif $page == 'transfer'}
                        <!-- START PROFILE TRANSFER PAGE-->
                        <h4 class="border-bold">Chuyển tiền</h4>
                        <p>Chú ý: Bạn chỉ có thể chuyển tiền từ số dư tài khoản Publishers sang tài khoản Advertiser</p>
                        {if isset($msg_profile)}<div class="message-error">{$msg_profile}</div>{/if}
                        <form name="frm_transfer" class="form-horizontal" method="post" action="" id="frm_transfer">
                            <input type="hidden" name="action" value="data_trans">
                            <fieldset>
                                <div class="control-group">
                                    <div class="form-group">
                                        <label class="col-sm-3 col-xs-3 control-label" for="data_trans">Số Tiền Chuyển:</label>
                                        <div class="col-sm-9 col-xs-9">
                                            <input type="text" class="col-sm-8 col-xs-8 required number" id="data_trans" name="data_trans" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 col-xs-3 control-label" for="data_trans">Tổng Số Dư Tài Khoản <strong>Publishers</strong>:</label>
                                        <div class="col-sm-9 col-xs-9">
                                            <input type="text" readonly class="col-sm-8 col-xs-8" value="{$pub_money_str}" id="data_pub_remain" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 col-xs-3 control-label" for="data_trans">Tổng Số Dư Tài Khoản <strong>Advertisers</strong>:</label>
                                        <div class="col-sm-9 col-xs-9">
                                            <input type="text" readonly class="col-sm-8 col-xs-8" value="{$adv_money_str}" id="data_adv_remain" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-xs-offset-3 col-sm-9 col-xs-9">
                                            <button class="submit-gray button gray jquery-corner">CHUYỂN TIỀN</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <!-- END PROFILE TRANSFER PAGE-->
                    {/if}
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
        jQuery.validator.messages.required = "";
        jQuery.validator.messages.number = "Dữ liệu trường này phải là số tự nhiên";
        jQuery("#profileChange").validate();
        jQuery("#emailChange").validate();
        jQuery("#passChange").validate();
        jQuery("#frm_transfer").validate({
            success: function(){
                var transfer_money = parseInt(jQuery("#data_trans").val());
                if(transfer_money == '') transfer_money=0;
                jQuery('#data_pub_remain').val(numberFormat(pub_money-transfer_money) != 'NaN' ? numberFormat(pub_money-transfer_money) : numberFormat(pub_money));
                jQuery('#data_adv_remain').val(numberFormat(adv_money+transfer_money) != 'NaN' ? numberFormat(adv_money+transfer_money) : numberFormat(adv_money));
            }
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