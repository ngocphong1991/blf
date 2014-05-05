<div class="wrapper paper">
    <div class="container">
        <div class="row">
            {include file='left-menu.tpl'}
            <div class="col-sm-9 right-content-paper plus">
                <div class="banner">
                    <img src="{$template_dir}/images/ad.png">
                </div>
                <div class="right-inner">
                    <h4 class="border-bold super-bold">Quản lý article link </h4>
                    <div class="weblike">
                        <form method="get" id="marketplaceFilter" class="form-horizontal">
                            <div class="control-group">

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <input type="text" class="col-sm-12 border-blue" name="keywords" value="Nhập từ khóa cần tìm 1" onfocus="updateTextFieldLabel(this, true, 'Nhập từ khóa cần tìm');" onblur="updateTextFieldLabel(this, false, 'Nhập từ khóa cần tìm');">

                                    </div>
                                    <div class="col-sm-4">
                                        <select class="col-sm-12" id="filterCategory" name="category_id" size="1">
                                            <option label="-- All Categories --" value="0">Goi article Link</option>
                                            <option value="35" label="Agriculture">Ten Mien</option>
                                        </select>
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
                            <th>TIEU DE BAI VIET</th>
                            <th>THONG TIN CHI TIET</th>
                            <th>NGAY TAO</th>
                            <th>TRANG THAI</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <a href="http://localhost/buylink/view-site.php?pid=197" target="_blank">tieu de</a>
                            </td>
                            <td>THONG TIN CHI TIET</td>
                            <td>20-11-2014</td>
                            <td width="13%">dang chay</td>

                        </tr>
                        <tr>
                            <td>1</td>
                            <td>
                                <a href="http://localhost/buylink/view-site.php?pid=197" target="_blank">tieu de</a>
                            </td>
                            <td>THONG TIN CHI TIET</td>
                            <td>20-11-2014</td>
                            <td width="13%">dang chay</td>

                        </tr>
                        <tr>
                            <td>1</td>
                            <td>
                                <a href="http://localhost/buylink/view-site.php?pid=197" target="_blank">tieu de</a>
                            </td>
                            <td>THONG TIN CHI TIET</td>
                            <td>20-11-2014</td>
                            <td width="13%">dang chay</td>

                        </tr>
                        <tr>
                            <td>1</td>
                            <td>
                                <a href="http://localhost/buylink/view-site.php?pid=197" target="_blank">tieu de</a>
                            </td>
                            <td>THONG TIN CHI TIET</td>
                            <td>20-11-2014</td>
                            <td width="13%">dang chay</td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>