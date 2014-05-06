<div class="wrapper paper">
    <div class="container">
        <div class="row inner-content">
            {include file='left-menu.tpl'}
            <div class="col-sm-9 right-content-paper plus">
                <div class="banner">
                    <img src="{$template_dir}/images/ad.png">
                </div>
                <div class="right-inner">
                    <h4 class="border-bold super-bold">Cập nhật thông tin WEBSITE</h4>
                    <div class="right website">
                        <p class="alert alert-success"><b>Website đã được đăng ký</b><br> Bạn hãy tải đoạn mã quảng cáo đúng với định dạng, cài đặt nó trên website của bạn và Hệ thống của chúng tôi giúp bạn kiếm tiền ngay khi đang ngủ! </p>
                        <div class="row">
                           <form method="post" class="form-horizontal" onsubmit="updateWebsite(); return false;" id="updateWebsiteForm">
                            <fieldset>
                              <input type="hidden" value="{$smarty.post.pid}" name="pid">
                              <div id="updateWebsiteErrors" class="formErrors"></div>
                              <div class="control-group">
                                  <div class="form-group">
                                      <label class="col-sm-4 col-xs-4 control-label" for="websiteTitle">Tiêu Đề Website :</label>
                                      <div class="col-sm-8 col-xs-8">
                                          <input type="text" class="col-sm-8 col-xs-8 required"  maxlength="255" value="{$smarty.post.wname}" name="wname" id="websiteTitle" />
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-4 col-xs-4 control-label" for="websiteDescription">Miêu tả Website*:</label>
                                      <div class="col-sm-8 col-xs-8">
                                          <textarea cols="45" rows="6" name="wdes" id="websiteDescription" class="col-sm-8 col-xs-8 required">{$smarty.post.wdes}</textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-4 col-xs-4 control-label" for="websiteKeywords">Từ khóa: (Rất quan trọng) * </label>
                                      <div class="col-sm-8 col-xs-8">
                                          <textarea cols="45" rows="2" name="keywords" id="websiteKeywords" class="col-sm-8 col-xs-8 required">{$smarty.post.keywords}</textarea>
                                          <p style="margin-top: 10px" class="small alert col-sm-9 col-xs-12 alert-warning">Từ Khóa là thứ miêu tả tốt nhất về Website của bạn. Nó sẽ giúp người dùng dễ dàng tìm thấy website của bạn trong khi tìm kiếm các site cho quảng cáo Text Link. Mỗi từ khóa phải được phân cách bằng một dấu phẩy.</p>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-4 col-xs-4 control-label" for="websiteSale">Giá Sale :</label>
                                      <div class="col-sm-8 col-xs-8">
                                          <input type="text" class="col-sm-5 col-xs-5 required"  maxlength="255" value="{$smarty.post.wsale}" name="wsale" id="websiteSale" />
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-4 col-xs-4 control-label" for="langid">Ngôn Ngữ *:</label>
                                      <div class="col-sm-8 col-xs-8">
                                          <select id="langid" name="langid" size="1" class="col-sm-5 col-xs-5">
                                              {html_options values=$lang_ids output=$langs selected=$smarty.post.langid}
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-4 col-xs-4 control-label" for="cats1">Chuyên mục (1) *:</label>
                                      <div class="col-sm-8 col-xs-8">
                                          <select size="1" name="cats1" onchange="javascript: sendReqPost(loc+'js/get_scats.php?cid='+this.value,'sc');" id="cats1" class="col-sm-5 col-xs-5">
                                              {html_options values=$cat_ids output=$cats selected=$smarty.post.catIds[1]}
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-4 col-xs-4 control-label" for="cats2">Chuyên mục (2):</label>
                                      <div class="col-sm-8 col-xs-8">
                                          <select size="1" name="cats2" onchange="javascript: sendReqPost(loc+'js/get_scats.php?cid='+this.value,'sc');" id="cats2" class="col-sm-5 col-xs-5">
                                              <option value=""></option>
                                              {html_options values=$cat_ids output=$cats selected=$smarty.post.catIds[2]}
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-4 col-xs-4 control-label" for="adposition">Vị trí bạn muốn đặt quảng cáo:</label>
                                      <div class="col-sm-8 col-xs-8">
                                          <select id="adposition" name="adposition" class="col-sm-5 col-xs-5" size="1">
                                              <option value=""></option>
                                              <option selected="selected" value="header" label="Header">Đầu trang</option>
                                              <option value="footer" label="Footer">Chân trang</option>
                                              <option value="left" label="Left">Sidebar bên trái</option>
                                              <option value="right" label="Right">Sidebar bên phải</option>
                                              <option value="in_content" label="In Contents">Trong bài viết</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-4 col-xs-4 control-label" for="websiteTitle">Url này là trang chủ?</label>
                                      <div class="col-sm-8 col-xs-8">
                                          <label class="radio-inline">
                                              <input checked="checked" value="Y" name="is_homepage" id="isHomepageY" type="radio"> Có
                                          </label>
                                          <label class="radio-inline">
                                              <input value="N" name="is_homepage" id="isHomepageN" type="radio"> Không
                                          </label>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-4 col-xs-4 control-label" for="websiteTitle">Website của bạn có bị chặng ?</label>
                                      <div class="col-sm-8 col-xs-8">
                                          <label class="radio-inline">
                                              <input value="Y" name="restriction" id="restriction" type="radio"> Có
                                          </label>
                                          <label class="radio-inline">
                                              <input value="N" checked="checked" name="restriction" id="is_restrictionN" type="radio"> Không
                                          </label>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-4 col-xs-4 control-label" for="websiteTitle">Phương Thức Kiểm Duyệt:</label>
                                      <div class="col-sm-8 col-xs-8">
                                          <label class="radio-inline">
                                              <input id="ApprovalA" name="approval_method" value="A" checked="checked" type="radio"> Tự động
                                          </label>
                                          <label class="radio-inline">
                                              <input id="ApprovalB" name="approval_method" value="B" type="radio"> Thủ công
                                          </label>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="col-sm-offset-4 col-xs-offset-4 col-sm-8 col-xs-8">
                                          <a onclick="updateWebsite(); return false;" href="#" class="button gray">Cập nhật</a>
                                      </div>
                                  </div>
                                  <div class="col-sm-offset-4 col-xs-offset-4 col-sm-6 col-xs-6 alert alert-success" style="display: none" id="updateWebsiteResults"></div>

                                </div>
                            </fieldset>
                          </form>
                        </div>
                    </div>
                    <h4 class="border-bold super-bold">Cài đặt code/plugin trên website của bạn</h4>
                    <div class="row">
                        <div class="pkg">
                            <div class="form-group">
                                <label for="websiteDescription"><b>Bạn muốn đặt link trên site của bạn như thế nào ?</b></label>
                                <div class="radio">
                                    <label>
                                        <input {if $smarty.post.is_manual=='Y'}checked="checked" {/if} onclick="websitePlacementOption({$smarty.post.pid}, 'Y');" value="Y" name="is_manual" id="isManualY" type="radio">
                                        Tôi sẽ đặt link bằng tay.
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input {if $smarty.post.is_manual=='N'}checked="checked"{/if} onclick="websitePlacementOption({$smarty.post.pid}, 'N');" value="N" name="is_manual" id="isManualN" type="radio">
                                        Tôi muốn đặt mã code của Buylink
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="hidden alert alert-info" id="scriptPanel" style="display: block;">
                            <h4>Tải mã code của chúng tôi</h4>
                            <form action="" method="post" id="pluginForm">
                                <fieldset>
                                    <input type="hidden" name="script" value="{$smarty.post.script}" />
                                    <input type="hidden" name="do" value="edit" />
                                    <input type="hidden" value="{$smarty.post.url}" name="url" />
                                    <input type="hidden" value="{$smarty.post.script}" name="download_script">
                                    <label class="field bold" for="">Mã nguồn bạn đang sử dụng:</label>
                                    <div style="padding: 2px 0 6px 0">
                                        <select onchange="pluginInstructions();" name="script_type" class="txt2" id="pluginDropdown">
                                            <option  value="php">PHP</option>
                                            <option  value="vbulletin3.0.x">Vbulletin3.0.x</option>
                                            <option selected="selected" value="wordpress">Wordpress</option>
                                        </select>
                                    </div>
                                    <a onclick="$('pluginForm').submit(); return false;" href="#" class="button blue-bold">Tải Về</a>
                                </fieldset>
                            </form>
                            <p> XML KEY: {$smarty.post.script} </p>
                        </div>
                        <h4 class="border-bold super-bold">Hướng Dẫn Cài Đặt</h4>
                        <div class="instructions hidden alert-info alert" id="instructions-wordpress" style="display: block;">
                            <ol>
                                <li>Bước 1: Đầu tiên bạn hãy tải Plugin WordPress ở trên về.</li>
                                <li>Bước 2: Upload Plugin đó sử dụng công cụ Wordpress backend. Hoặc, bạn có thể upload trực tiếp file zip chứa plugin lên website của bạn, thường thì ở trong mục "wp-content/plugins".</li>
                                <li>Bước 3: Đăng nhập vào Wordpress backend và di chuyển tới thanh "Plugins". Sau đó kích hoạt "Textlink.vn Advertiser Plugin".</li>
                                <li>Bước 4: Nếu bạn đặt regular link vào trong giao diện trang website của bạn, Hãy kích hoạt Textlink Widget (Nó sẽ hiển thị như là 1 widget theo đường dẫn được đặt tên sau tên miền). Hoặc, nếu bạn không muốn sử dụng widget, hãy chèn đoạn mã sau vào trong giao diện website của bạn:<br>
                                    &lt;?php if(function_exists('outputHtmlAds')) outputHtmlAds(); ?&gt;</li>
                                <li>Cài đặt thành công! Bạn sẽ nhận được email thông báo khi quảng cáo trên site của bạn được bán.</li>
                            </ol>
                        </div>
                        <div class="instructions hidden alert-info alert" id="instructions-php" style="display: none;">
                            <ol>
                                <li>Bước 1: Tải đoạn mã PHP ở trên về.</li>
                                <li>Bước 2: Tạo một file trống đặt tên "148CE622E038AFE3DA3A.xml" ở cùng đường dẫn nơi mà bạn dự định chạy nội dung quảng cáo của chúng tôi. Chmod
                                    "148CE622E038AFE3DA3A.xml" thành 666 để mà Web server có thể viết đè lên nó.</li>
                                <li>Bước 3: Sao chép và dán chính xác đoạn code vào Website của bạn nơi mà quảng cáo sẽ suất hiện. <em>Hoặc</em> upload file PHP và đưa nó vào chính xác nơi mà bạn muốn hiện quảng cáo, Sử dụng câu lệnh <em>include()</em>.</li>
                                <li>Bước 4: Upload những thay đổi cho Website của bạn.</li>
                                <li>Cài đặt thành công! Bạn sẽ nhận được email thông báo khi quảng cáo trên site của bạn được bán.</li>
                            </ol>
                        </div>
                        <div class="instructions hidden alert-info alert" id="instructions-vbulletin3.0.x" style="display: none;">
                            <ol>
                                <li>Nếu bạn đang cài đặt phiên bản VBulletin 3.5 trở lên, thì hãy xem kỹ phần hướng dẫn cài đặt cho Vbullentin 3.5.+</li>
                                <li> Sao chép đoạn code dưới đây sau đó truy cập vào trang quản trị vBulletin trên site của bạn và dán nó vào phần giao diện forum hiện tại "phpinclude_start".</li>
                            </ol>
                        </div>
                        <script type="text/javascript">
                            {if $smarty.post.domain_age<=0}
                            setTimeout ( "updateDomainAge('{$smarty.post.url}',{$smarty.post.pid})", 1 );
                            {/if}
                            //setTimeout("updateDomainAge('dantri.com.vn');",100);
                            //pluginInstructions();
                            //scriptPanel();
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>