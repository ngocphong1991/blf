<div class="wrapper paper">
    <div class="container">
        <div class="row inner-content">
            {include file='left-menu.tpl'}
            <div class="col-sm-9 right-content-paper plus">
                <div class="banner">
                    <img src="{$template_dir}/images/ad.png">
                </div>
                <div class="right-inner">
                    <div class="cart-tool">
                        <p>
                            <i class="icon-cart"></i> <span>Giỏ hàng:</span>
                            <strong class="cart-regular-count">{$total_cart} link</strong>
                             - Tổng tiền: <strong class="cart-total">{$total_price}</strong>
                            <a href="{$_config.www}/cart" title="Thanh Toán" class="button red" id="btnViewCart">Thanh toán</a>
                        </p>
                    </div>
                    <h4 class="border-bold super-bold">Mua Buylink</h4>
                    <div class="row">
                        <form class="form-horizontal" id="marketplaceFilter" method="get">
                            <div class="control-group">
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">
                                        <select class="col-sm-12 col-xs-12" name="link_score">
                                            <option value="">Pageranks</option>
                                            <option value="1">1+</option>
                                            <option value="2">2+</option>
                                            <option value="3">3+</option>
                                            <option value="4">4+</option>
                                            <option value="5">5+</option>
                                            <option value="6">6+</option>
                                            <option value="7">7+</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-xs-4">
                                        <select size="1" name="category_id" id="filterCategory" class="col-sm-12 col-xs-12">
                                            <option value="0" label="-- All Categories --">-- Danh mục website --</option>
                                            {html_options values=$cat_ids output=$cats selected=$smarty.post.cats1}
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-xs-3">
                                        <input type="text" class="col-sm-12 col-xs-12" name="domain" onblur="updateTextFieldLabel(this, false, 'Tên miền');" onfocus="updateTextFieldLabel(this, true, 'Tên miền');" value="{if isset($smarty.get.domain) && $smarty.get.domain !=''}{$smarty.get.domain}{else}Tên miền{/if}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6 col-xs-4">
                                        <input type="text" onblur="updateTextFieldLabel(this, false, 'Nhập từ khóa cần tìm');" onfocus="updateTextFieldLabel(this, true, 'Nhập từ khóa cần tìm');" value="{if isset($smarty.get.keywords) && $smarty.get.keywords !=''}{$smarty.get.keywords}{else}Nhập từ khóa cần tìm{/if}" name="keywords" class="col-sm-12 col-xs-12 border-blue">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3 pull-left">
                                        <button class="button blue-bold">Tìm Kiếm</button>
                                    </div>
                                    <div class="col-sm-9 col-xs-9 pull-right">
                                        <div class="paging pull-right">
                                            {$Template_Pagignation_Data}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Thông tin chi tiết</th>
                                <th>PR</th>
                                <th>Alexa</th>
                                <th>Domain age</th>
                                <th>TLD</th>
                                <th>Giá/Tháng</th>
                                <th>Mua</th>
                            </tr>
                            </thead>
                            <tbody>
                            {section name=num loop=$winfo}
                                <tr>
                                    <td>{$smarty.section.num.index+1}</td>
                                    <td>
                                        <a target="_blank" href="{$_config.www}/view-site.php?pid={$winfo[num].pid}">{$winfo[num].description}</a>
                                    </td>
                                    <td>{$winfo[num].google_page_rank}</td>
                                    <td>{$winfo[num].alexa_rank}</td>
                                    <td width="13%">{$winfo[num].domain_age}</td>
                                    <td>{$winfo[num].domain_ext}</td>
                                    <td>{$winfo[num].sale_price}</td>
                                    <td width="12%"><a class="add-cart" onclick="addToCart(this, 'regular', {$winfo[num].pid}, '', '', ''); return false;" href="#">	&#43; Đặt mua</a></td>
                                </tr>
                            {/section}
                            </tbody>
                        </table>
                        <div class="paging pull-right">
                            {$Template_Pagignation_Data}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>