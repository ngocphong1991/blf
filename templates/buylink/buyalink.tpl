<div class="wrapper paper">
    <div class="container">
        <div class="row">
            {include file='left-menu.tpl'}
            <div class="col-sm-9 right-content-paper plus">
                <div class="banner">
                    <img src="{$template_dir}/images/ad.png">
                </div>
                <h4 class="title super-bold">Mua Article Buylink</h4>
                <div class="action_status2">
                    <ul>
                        <li class="status1">Chọn Website</li>
                        <li class="status2"><strong>Nhập Thông Tin</strong></li>
                        <li class="status3">Thanh Toán</li>
                        
                    </ul>
                </div>
                
                
                <div style="width:30%;float:left">
                <h4 class="title super-bold">Nhập Thông Tin</h4>
                </div>
                <div style="margin-left:115px;margin-top:28px;" class="line">&nbsp;</div>
                <div style="clear:both"></div>
              
                
                <form role="form">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nhập tiêu đề cho bài viết</label>
                    <input type="title" class="form-control" id="title" >
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nhập mô tả cho bài viết</label>
                    <textarea class="form-control"></textarea>
                  </div>
                  
                

                
                <div class="title-artile">
                <div class="title2" style="float:left">Danh sách website đăng bài</div>
                <div class="line" style="width:64%;float:left;margin-left:10px">&nbsp;</div>
                <div class="show-hiden"><a href="#">Ẩn [-]</a></div>
                </div>
                
                <div class="clear"></div>
                <div class="title-artile">
                <div class="title2" style="float:left">Nội dung bài viết</div>
                <div class="line" style="width:81%;float:left;margin-left:10px">&nbsp;</div>
               
                </div>
                <div class="clear"></div>
                <p style="margin-top:30px"><span class="color-red">Chú ý: </span> Mỗi bài viết chỉ cho phép một link liên kết dạng text và 1 link liên kết dạng hình ảnh</p>
                <textarea id="detail"></textarea>              
	
                <script>		
        			CKEDITOR.replace( 'detail' );
        		</script>
                
                </form>
                
                <div class="checknd">
                
                <button type="button" class="btn btn-primary">Kiểm tra nội dung</button> kiểm tra số lượng link và ảnh trong bài viết
                </div>
                
                <div class="action-button-buylink">
                    <div class="abb1"> <a href="#" title="Bước 1"><strong>Bước 1 &nbsp; &nbsp; &nbsp; CHỌN WEBSITE</strong></a></div>
                    <div class="abb2"><strong>Bước 2</strong></div>
                    <div class="abb3"><a href="#" title="Bước 3"><strong>Bước 3 &nbsp; &nbsp;&nbsp;  THANH TOÁN</strong></a></div>
                </div>
            </div>
        </div>
    </div>
</div>