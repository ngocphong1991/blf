<div class="wrapper paper">
    <div class="container">
        <div class="row inner-content">
            {include file='left-menu.tpl'}
            <div class="col-sm-9 right-content-paper plus">
                <div class="banner">
                    <img src="{$template_dir}/images/ad.png">
                </div>
                <div class="right-inner">
                    <h4 class="border-bold super-bold">Quản lý link đã bán </h4>
                    <div class="weblike"><!--
                        <form method="get" class="filter-box form-horizontal" id="link-filter">
                            <fieldset>
                                <div class="controls">
                                    <div class="third-box left">
                                        <select style="width: 80%" class="txt2" name="link-filter">
                                            <option value="ALL">-- All Statuses --</option>
                                            <option selected="selected" value="6">Active Links</option>
                                            <option value="4">Pending Links</option>
                                            <option value="8">Canceled Links</option>
                                            <option value="2">Rejected Links</option>
                                        </select>
                                        <br>
                                        <br>
                                        <select style="width: 80%" class="txt2" name="order_id">
                                            <option value="">-- All Orders --</option>
                                            {section name=i loop=$all}
                                                <option {if $all[i].adv_id  == $order_id} selected="selected" {/if} value="{$all[i].adv_id}">#{$all[i].adv_id}</option>
                                            {/section}
                                        </select>
                                        &nbsp; </div>
                                    <div class="third-box left">
                                        <select style="width: 80%" class="txt2" name="adv_id">
                                            <option value="">-- All Link Text --</option>
                                            {section name=i loop=$all}
                                                <option {if $all[i].adv_id  == $order_id} selected="selected" {/if} value="{$all[i].adv_id}">{$all[i].ad_des}</option>
                                            {/section}
                                        </select>
                                        &nbsp; </div>
                                    <div class="third-box left"> <button class="button blue">View</button> <a onclick="$('link-filter').action = '{$_config.www}/export-excel.php'; $('link-filter').submit(); return false;" href="#" class="btn-tan-80 left">Export</a> </div>
                                    <div class="clear"></div>
                                </div>
                            </fieldset>
                        </form>
                        <div class="clear"></div>-->
                        <form method="post" id="linkForm">
                            <fieldset>
                                <input type="hidden" value="1" name="update" />
                            </fieldset>
                            <table class="table table-striped" id="regular-link-table">
                                <thead>
                                <tr>
                                    <th>Nôi Dung Website</th>
                                    <th>Ngày đặt</th>
                                    <th>Ngày hết hạn</th>
                                    <th>PR</th>
                                    <th>Link Details</th>
                                    <th>Giá/tháng</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                {section name=i loop=$ids}
                                    <tr>
                                        <td><strong>{$ids[i].websitename}</strong><br><span class="small grey">(<a href="{$all[i].url}" target="_blank">{$ids[i].url}</a>)</span><br>{$ids[i].description}</td>
                                        <td>{$ids[i].buying_date}</td>
                                        <td>{$ids[i].end_date}</td>
                                        <td>{$ids[i].google_page_rank}</td>
                                        <td>
                                            <input type="hidden" value="{$ids[i].adv_id}" name="order_id" />
                                            <a href="{$ids[i].ad_url}">{$ids[i].ad_des}</a><br>
                                            {$ids[i].ad_url}</td>
                                        <td>{$ids[i].set_price|number_format} USD</td>
                                        <td width="13%">{if $ids[i].cancel  == 1} <a style="padding-left: 10px; padding-right: 10px" onclick="cancelLinkAd(this, 'regular', {$all[i].adv_id}, {$all[i].pid}); return false;" href="#" class="button gray">Hủy Bỏ</a> {else}{/if} {if $ids[i].approved  == 'N' and $ids[i].approval_method  == 'B'} <a onclick="ActiveManualSite(this, 'is_manual', {$all[i].adv_id}, {$all[i].pid}); return false;" style="padding-left: 10px; padding-right: 10px" href="#" class="button blue">Duyệt</a> {/if}</td>
                                    </tr>
                                {/section}
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>