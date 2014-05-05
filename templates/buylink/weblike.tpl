<div class="wrapper paper">
<div class="container">
<div class="row">
{include file='left-menu.tpl'}
<div class="col-sm-9 right-content-paper plus">
<div class="banner">
    <img src="{$template_dir}/images/ad.png">
</div>
<div class="right-inner">
<h4 class="border-bold super-bold">Texlink đang chạy </h4>
    <div class="weblike">
        <form method="get" id="marketplaceFilter" class="form-horizontal">
        <div class="control-group">
            <div class="form-group">
                <div class="col-sm-3">
                    <select class="col-sm-12" id="filterCategory" name="category_id" size="1">
                        <option label="-- All Categories --" value="0">Pagerank</option>
                        <option value="35" label="Agriculture">Ten Mien</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select class="col-sm-12" id="filterCategory" name="category_id" size="1">
                        <option label="-- All Categories --" value="0">Ten Mien</option>
                        <option value="35" label="Agriculture">Outlink</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select class="col-sm-12" id="filterCategory" name="category_id" size="1">
                        <option label="-- All Categories --" value="0">Site Premium</option>
                        <option value="35" label="Agriculture">Agriculture</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select class="col-sm-12" id="filterCategory" name="category_id" size="1">
                        <option label="-- All Categories --" value="0">Outlink</option>
                        <option value="35" label="Agriculture">Agriculture</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select class="col-sm-12" id="filterCategory" name="category_id" size="1">
                        <option label="-- All Categories --" value="0">Dat Link</option>
                        <option value="35" label="Agriculture">Agriculture</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <input type="text" class="col-sm-12 border-blue" name="keywords" value="Nhập từ khóa cần tìm 1" onfocus="updateTextFieldLabel(this, true, 'Nhập từ khóa cần tìm');" onblur="updateTextFieldLabel(this, false, 'Nhập từ khóa cần tìm');">

                </div>
                <div class="col-sm-3 wldanhmuc">
                    Danh muc website
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
    </form>
    </div>

<table class="table table-striped">
    <thead>
    <tr>
        <th>STT</th>
        <th>Thông tin chi tiet </th>
        <th>OUT LINK</th>
        <th>PR</th>
        <th>ALEXA</th>
        <th>DOMAIN AGE</th>
        <th>GIA/THANG</th>
        <th>MUA</th>
    </tr>
    </thead>
    <tbody>

        <tr>
            <td>1</td>
            <td>
                <a href="http://localhost/buylink/view-site.php?pid=197" target="_blank">Thong tin</a>
            </td>
            <td>0</td>
            <td>0</td>
            <td width="13%">THANHTHANG</td>
            <td>GOOGLE</td>
            <td width="13%">10$</td>
            <td>0</td>

        </tr>
        <tr>
            <td>1</td>
            <td>
                <a href="http://localhost/buylink/view-site.php?pid=197" target="_blank">{$ids[i].websitename}n</a>
            </td>
            <td>0</td>
            <td>0</td>
            <td width="13%">THANHTHANG</td>
            <td>GOOGLE</td>
            <td width="13%">10$</td>
            <td>0</td>

        </tr>
        <tr>
            <td>1</td>
            <td>
                <a href="http://localhost/buylink/view-site.php?pid=197" target="_blank">{$ids[i].websitename}n</a>
            </td>
            <td>0</td>
            <td>0</td>
            <td width="13%">THANHTHANG</td>
            <td>GOOGLE</td>
            <td width="13%">10$</td>
            <td>0</td>

        </tr>





    </tbody>
</table>
</div>
</div>
</div>
</div>
</div>