<div class="wrapper paper">
<!--test de commit-->
<div class="container">
<div class="row inner-content">
{include file='left-menu.tpl'}
<div class="col-sm-9 right-content-paper plus">
<div class="banner">
    <img src="{$template_dir}/images/ad.png">
</div>
{if $edit}
    <div class="right-inner">
        <h4 class="border-bold super-bold">Quản lý link </h4>
        {if $msg}<div class="alert-success alert">{$msg}</div>{/if}
        {if $err}<div class="alert-danger alert">{$err}</div>{/if}
        <form method="get" id="marketplaceFilter" class="form-horizontal">
            <table class="table table-striped links">
                <thead>
                <tr>
                    <th>Website deial</th>
                    <th>Ngày đặt</th>
                    <th>Hết hạn</th>
                    <th>Link Detail</th>
                    <th>Giá/Tháng</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                {section name=i loop=$objectOderEdit}
                    <tr>
                        <td>{$objectOderEdit[i].websitename}</td>
                        <td>{$objectOderEdit[i].buying_date}</a></td>
                        <td>{$objectOderEdit[i].end_date}</td>
                        <td>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" value="{$objectOderEdit[i].ad_des}" name="link_text" class="col-sm-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" value="{$objectOderEdit[i].ad_url}" name="link_url" class="col-sm-12">
                                </div>
                            </div>
                        </td>
                        <td>USD {$objectOderEdit[i].price|number_format}</td>
                        <td>
                            <a href="{$_config.www}/links"><button style="width: 100px" class="button blue-bold" type="button">Cancel</button></a>
                            <br/>
                            <br/>
                            <a href="{$_config.www}/renew.php?id={$objectOderEdit[i].adv_id}"><button style="width: 100px" class="button blue-bold" type="button">Renew</button></a>

                        </td>
                    </tr>
                    <input type="hidden" name="order_id"  value="{$objectOderEdit[i].adv_id}">
                {/section}
                </tbody>
            </table>
            <input type="hidden" name="edit"  value="edit">
            <input type="hidden" name="update"  value="update">

            <div class="form-group">
                <div class="col-sm-3 pull-left">
                    <button class="button blue-bold" type="submit">Cập nhật</button>
                </div>
                <div class="col-sm-9 pull-right">
                    <div class="paging pull-right">

                    </div>
                </div>
            </div>
        </form>
    </div>
{else}
    <div class="right-inner">
    <h4 class="border-bold super-bold">Texlink đang chạy </h4>

    <div class="buylinkmanage">
    <div class="col-sm-12">
    <div class="blog-tabs">
    <ul id="blog-tab" class="nav nav-tabs">
        <li class="{if !$tabactive or $tabactive eq 2}active{/if}"><a href="#blmtab2" data-toggle="tab">Textlink đang chạy</a></li>
        <li class="{if $tabactive eq 3}active{/if}"><a href="#blmtab3" data-toggle="tab">Textlink hết hạn</a></li>

    </ul>
    <div id="myTabContent" class="tab-content">
    <div class="tab-pane fade {if !$tabactive or $tabactive eq 2}active in{/if}" id="blmtab2">
        <form method="get" id="marketplaceFilter" class="form-horizontal">
            <div class="control-group">
                <div class="form-group">
                    <div class="col-sm-5 col-xs-5">
                        <input type="text" class="col-sm-12 col-xs-12 border-blue" name="keywords" value="{if $keywords}{$keywords}{else}Nhập từ khóa cần tìm{/if}" onfocus="updateTextFieldLabel(this, true, 'Nhập từ khóa cần tìm');" onblur="updateTextFieldLabel(this, false, 'Nhập từ khóa cần tìm');">

                    </div>
                    <div class="col-sm-4 col-xs-4">
                        <select class="col-sm-12 col-xs-12" id="filterCategory" name="adv_id" size="1">
                            <option label="-- All Categories --" value="0">-- Mã text --</option>
                            {section name=i loop=$all}
                                <option {if $all[i].adv_id  == $order_id} selected="selected" {/if} value="{$all[i].adv_id}">{$all[i].ad_des}</option>
                            {/section}

                        </select>
                    </div>
                </div>
                <div class="form-group">

                    <label for="inputEmail3" class="col-sm-2 col-xs-2 control-label"><strong>Từ ngày:</strong></label>
                    <div class="col-sm-3 col-xs-3">
                        <input type="text" value="{if $buying_date}{$buying_date}{else}{$smarty.now|date_format:"%Y/%m/%d"}{/if}" name="buying_date" class="col-sm-12 col-xs-12">
                    </div>
                    <label for="inputEmail3" class="col-sm-2 col-xs-2 control-label"><strong>Đến:</strong></label>
                    <div class="col-sm-3 col-xs-3">
                        <input type="text" value='{if $end_date}{$end_date}{else}{$smarty.now|date_format:"%Y/%m/%d"}{/if}' name="end_date" class="col-sm-12 col-xs-12">
                    </div>
                    <input type="hidden" value="2" name="tabactive">
                </div>
                <div class="form-group">
                    <div class="col-sm-3 pull-left">
                        <button type="submit" class="button blue-bold">Tìm Kiếm</button>
                    </div>
                    <div class="col-sm-9 pull-right">
                        <div class="paging pull-right">
                            {$Template_Pagignation_Data}
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <table class="table table-striped links">
            <thead>
            <tr>
                <th width="2%">STT</th>
                <th>Thông tin</th>
                <th>Textlink</th>
                <th>Trên trang</th>
                <th>Thời gian</th>
                <th><img src="{$template_dir}/images/pencel.png"></th>
            </tr>
            </thead>
            <tbody>

            {section name=i loop=$ids}
                <tr>
                    <td>{$smarty.section.i.index+1}</td>
                    <td width="30%"><a href="{$all[i].url}" target="_blank">{$ids[i].websitename}n</a></td>
                    <td>{$ids[i].ad_des}</td>
                    <td>{$ids[i].ad_url}</td>
                    <td width="13%">{$ids[i].buying_date} - {$ids[i].end_date}</td>
                    <td><a href="{$_config.www}/links?edit=edit&order_id={$ids[i].adv_id}"><img src="{$template_dir}/images/pencel.png"></a></td>

                </tr>
            {/section}



            </tbody>
        </table>
    </div>
    <div class="tab-pane fade {if $tabactive eq 3}active in{/if} " id="blmtab3">
        <form method="get" id="marketplaceFilter" class="form-horizontal">
            <div class="control-group">
                <div class="form-group">
                    <div class="col-sm-5 col-xs-5">
                        <input type="text" class="col-sm-12 col-xs-12 border-blue" name="keywords" value="{if $keywords}{$keywords}{else}Nhập từ khóa cần tìm{/if}" onfocus="updateTextFieldLabel(this, true, 'Nhập từ khóa cần tìm');" onblur="updateTextFieldLabel(this, false, 'Nhập từ khóa cần tìm');">

                    </div>
                    <div class="col-sm-4 col-xs-4">
                        <select class="col-sm-12 col-xs-12" id="filterCategory" name="adv_id" size="1">
                            <option label="-- All Categories --" value="0">-- Mã text --</option>
                            {section name=i loop=$allexpire}
                                <option {if $allexpire[i].adv_id  == $order_id} selected="selected" {/if} value="{$allexpire[i].adv_id}">{$allexpire[i].ad_des}</option>
                            {/section}

                        </select>
                    </div>


                </div>
                <div class="form-group">

                    <label for="inputEmail3" class="col-sm-2 col-xs-2 control-label"><strong>Từ ngày:</strong></label>
                    <div class="col-sm-3 col-xs-3">
                        <input type="text" value="{if $buying_date_expire}{$buying_date_expire}{else}{$smarty.now|date_format:"%Y/%m/%d"}{/if}" name="buying_date_expire" class="col-sm-12 col-xs-12">
                    </div>
                    <label for="inputEmail3" class="col-sm-2 col-xs-2 control-label"><strong>Đến:</strong></label>
                    <div class="col-sm-3 col-xs-3">
                        <input type="text" value='{if $end_date_expire}{$end_date_expire}{else}{$smarty.now|date_format:"%Y/%m/%d"}{/if}' name="end_date_expire" class="col-sm-12 col-xs-12">
                    </div>
                    <input type="hidden" value="3" name="tabactive">
                </div>
                <div class="form-group">
                    <div class="col-sm-3 col-xs-3 pull-left">
                        <button type="submit" class="button blue-bold">Tìm Kiếm</button>
                    </div>
                    <div class="col-sm-9 col-xs-9 pull-right">
                        <div class="paging pull-right">

                        </div>
                    </div>
                </div>
            </div>
        </form>
        <table class="table table-striped links">
            <thead>
            <tr>
                <th width="2%">STT</th>
                <th>Thông tin</th>
                <th>Textlink</th>
                <th>Trên trang</th>
                <th>Thời gian</th>
                <th><img src="{$template_dir}/images/pencel.png"></th>
            </tr>
            </thead>
            <tbody>

            {section name=i loop=$idsexpire}
                <tr>
                    <td>{$smarty.section.i.index+1}</td>
                    <td width="30%"><a href="{$all[i].url}" target="_blank">{$idsexpire[i].websitename}n</a></td>
                    <td>{$idsexpire[i].ad_des}</td>
                    <td>{$idsexpire[i].ad_url}</td>
                    <td width="13%">{$idsexpire[i].buying_date} - {$idsexpire[i].end_date}</td>
                    <td><a href="{$_config.www}/links?edit=edit&order_id={$idsexpire[i].adv_id}"><img src="{$template_dir}/images/pencel.png"></a></td>

                </tr>
            {/section}



            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="blmtab7">
        <!--<form method="get" id="marketplaceFilter" class="form-horizontal">
            <div class="control-group">
                <div class="form-group">
                    <div class="col-sm-3">
                        <input type="text" class="col-sm-12 border-blue" name="keywords" value="Nhập từ khóa cần tìm 1" onfocus="updateTextFieldLabel(this, true, 'Nhập từ khóa cần tìm');" onblur="updateTextFieldLabel(this, false, 'Nhập từ khóa cần tìm');">

                    </div>
                    <div class="col-sm-3">
                        <select class="col-sm-12" id="filterCategory" name="category_id" size="1">
                            <option label="-- All Categories --" value="0">-- Danh mục website --</option>
                            <option value="35" label="Agriculture">Agriculture</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="col-sm-12" id="filterCategory" name="category_id" size="1">
                            <option label="-- All Categories --" value="0">-- Danh mục website --</option>
                            <option value="35" label="Agriculture">Agriculture</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" value="Mã textlink" onfocus="updateTextFieldLabel(this, true, 'Mã textlink');" onblur="updateTextFieldLabel(this, false, 'Mã textlink');" name="domain" class="col-sm-12">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3">
                        <select class="col-sm-12" id="filterCategory" name="category_id" size="1">
                            <option label="-- All Categories --" value="0">-- Danh mục website --</option>
                            <option value="35" label="Agriculture">Agriculture</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="col-sm-12" id="filterCategory" name="category_id" size="1">
                            <option label="-- All Categories --" value="0">-- Danh mục website --</option>
                            <option value="35" label="Agriculture">Agriculture</option>
                        </select>
                    </div>
                    <label for="inputEmail3" class="col-sm-2 control-label"><strong>Hết hạn:</strong></label>
                    <div class="col-sm-2">
                        <input type="text" value="Mã textlink" onfocus="updateTextFieldLabel(this, true, 'Mã textlink');" onblur="updateTextFieldLabel(this, false, 'Mã textlink');" name="domain" class="col-sm-12">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" value="Mã textlink" onfocus="updateTextFieldLabel(this, true, 'Mã textlink');" onblur="updateTextFieldLabel(this, false, 'Mã textlink');" name="domain" class="col-sm-12">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3 pull-left">
                        <button class="button blue-bold">Tìm Kiếm</button>
                    </div>
                    <div class="col-sm-9 pull-right">
                        <div class="paging pull-right">
                            <span>1</span>&nbsp;&nbsp;<a class="adminmenu" href="/buylink/marketplace.php?offset=10&amp;numrows=25&amp;">2</a> &nbsp;<a class="adminmenu" href="/buylink/marketplace.php?offset=20&amp;numrows=25&amp;">3</a> &nbsp;<a class="adminmenu" href="/buylink/marketplace.php?offset=10&amp;numrows=25&amp;"><i class="icon-next"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </form>-->
    </div>
    </div>
    </div>
    </div>

    </div>


    </div>
{/if}
</div>
</div>
</div>
</div>