<div class="wrapper paper">
    <div class="container">
        <div class="row inner-content">
            {include file='left-menu.tpl'}
            <div class="col-sm-9 right-content-paper plus">
                <div class="banner">
                    <img src="{$template_dir}/images/ad.png">
                </div>
                <div class="right-inner">
                    <h4 class="border-bold super-bold">WEBSITE Earning</h4>
                    <form action="earnings.php" method="get" class="filter-box right" id="website-filter">
                        <fieldset>
                            <input type="hidden" value="{$smarty.post.pid}" name="pid">
                            <div class="controls alert alert-info">
                                <select onchange="" class="txt" name="month" id="">
                                    <option value="01">01 (January)</option>
                                    <option value="02">02 (February)</option>
                                    <option selected="selected" value="03">03 (March)</option>
                                    <option value="04">04 (April)</option>
                                    <option value="05">05 (May)</option>
                                    <option value="06">06 (June)</option>
                                    <option value="07">07 (July)</option>
                                    <option value="08">08 (August)</option>
                                    <option value="09">09 (September)</option>
                                    <option value="10">10 (October)</option>
                                    <option value="11">11 (November)</option>
                                    <option value="12">12 (December)</option>
                                </select>
                                &nbsp;
                                <select onchange="" class="txt" name="year" id="">
                                    <option value="2009">2009</option>
                                    <option value="2010">2010</option>
                                    <option value="2011">2011</option>
                                    <option selected="selected" value="2012">2012</option>
                                </select>
                                &nbsp;
                                <a onclick="$('website-filter').submit(); return false;" href="#" style="margin-left: 10px;" class="button blue-bold">Xem Thu Nhập theo tháng</a>
                            </div>
                        </fieldset>
                    </form>
                    <h4><a href="{$smarty.post.url}" title="{$smarty.post.url}">{$smarty.post.url}</a></h4>
                    <h4 class="black">Website Earnings for {$earning_date}</h4>
                    <p class="large"><strong>Lưu ý:</strong> Bạn đang xem thu nhập trong tháng này. Thu nhập được hiện thị ở đưới là được tính toán dựa trên link quảng cáo hiện tại. Thu nhập đó có thể bị thay đổi nếu link quảng cáo bị hủy bỏ hay không hiển thị. </p>
                    <h4 class="right black">Tổng Thu Nhập: <span class="green">{$my_website_earnings}</span></h4>
                    <a href="websites.html" class="button gray">Chuyển tới Websites</a>
                    <div class="clear"></div>
            </div>
            </div>
        </div>
    </div>
</div>