{if $smarty.session.uid ne ''}
<link type="text/css" rel="stylesheet" href="{$template_dir}/css/style_tab.css">
{literal}
<script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();		
    });	
    function setupLabel() {
        if ($('.label_check input').length) {
            $('.label_check').each(function(){ 
                $(this).removeClass('c_on');
            });
            $('.label_check input:checked').each(function(){ 
                $(this).parent('label').addClass('c_on');
            });                
        };
        if ($('.label_radio input').length) {
            $('.label_radio').each(function(){ 
                $(this).removeClass('r_on');
            });
            $('.label_radio input:checked').each(function(){ 
                $(this).parent('label').addClass('r_on');
            });
        };
    };
    $(document).ready(function(){
        $('body').addClass('has-js');
        $('.label_check, .label_radio').click(function(){
            setupLabel();
        });
        setupLabel(); 
    });
	$(function() {
		$("#example-one").organicTabs();
	});
</script>
 {/literal}  
<script src="{$template_dir}/js/organictabs.jquery.js"></script>
	<!--main content-->
	<div class="main-wrp aff-main pkg">
	  <div class="main pkg">
		<div class="reffral">	  
		  <a class="btn-tan-180 right" href="{$_config.www}/affiliate_coupons" style="margin-right: 10px;">Tạo Coupon</a><h3>Links for Referring Advertisers and Publisher</h3>
		  <div id="example-one">
			<ul class="nav">
			  <li class="nav-one"><a href="#tab-adv" class="current">Advertiser</a></li>
			  <li class="nav-four last"><a href="#tab-pub">Publisher</a></li>
			</ul>
			<div class="list-wrap">
			  <div id="tab-adv">
				<table class="aff-table" width="100%">
					<tr>
						<td width="30%" align="center" class="first"><img src="{$template_dir}/images/125x125.gif" /></td>
						<td width="20%" align="center"><p align="center"><strong>125x125</strong></p></td>
						<td width="50%" class="last"><textarea class="code"><a href=http://textlink.vn?ref={$ref_val}"><img src="{$template_dir}/images/125x125.gif" width="125" height="125" border="" alt="" /></a>
						</textarea>
						</td>
					</tr>
					<tr class="last">
						<td width="30%" align="center"  class="first"><img src="{$template_dir}/images/468x90.gif" width="250" /></td>
						<td width="20%" align="center"><p align="center"><strong>468x90</strong></p></td>
						<td width="50%" class="last"><textarea class="code"><a href=http://textlink.vn?ref=x49zsr17"><img src="{$template_dir}/images/125x125.gif" width="125" height="125" border="" alt="" /></a>
						</textarea>
						</td>
					</tr>
				</table>
			  </div>
			  <div id="tab-pub" class="hide">
				<table class="aff-table" width="100%">
					<tr>
						<td width="30%" align="center" class="first"><img src="{$template_dir}/images/pub_125x125.gif" /></td>
						<td width="20%" align="center"><p align="center"><strong>125x125</strong></p></td>
						<td width="50%" class="last"><textarea class="code"><a href=http://textlink.vn?ref={$ref_val}"><img src="{$template_dir}/images/125x125.gif" width="125" height="125" border="" alt="" /></a>
						</textarea>
						</td>
					</tr>
					<tr class="last">
						<td width="30%" align="center"  class="first"><img src="{$template_dir}/images/pub_468x90.gif" width="250" /></td>
						<td width="20%" align="center"><p align="center"><strong>468x90</strong></p></td>
						<td width="50%" class="last"><textarea class="code"><a href=http://textlink.vn?ref={$ref_val}"><img src="{$template_dir}/images/125x125.gif" width="125" height="125" border="" alt="" /></a>
						</textarea>
						</td>
					</tr>
				</table>
			  </div>
			</div>
			<!-- END List Wrap --> 
		  </div>
		  <!-- END Organic Tabs (Example One) --> 
		</div><!--referral-->
	  </div><!--main-->
	</div><!--main wrp-->
	 <div class="main-wrp pkg">
	<p class="m-h" style="padding:4px 0; font-size:19px;">Bạn vẫn còn thắc mắc ? Hãy liên lạc với chúng tôi ngay hôm nay <img src="{$template_dir}/images/sdt.jpg" /></p>
	</div>
  <div class="main-wrp pkg">
    <div class="main pkg">
      <div class="textlink-info pkg">
        <div class="info">
          <p><img src="{$template_dir}/images/intro_textlink.png" />
          <h4 class="head">Giới thiệu về Textlink</h4>
          <span>Trong thế giới Internet ngày nay, việc website của bạn xuất hiện trên những vị trí đầu của các cỗ máy tìm kiếm không chỉ giúp mang lại lượng khách hàng tiềm năng lớn mà còn giúp...</span> <a href="{$_config.www}/abouts" class="btn-detail">Chi tiết...</a>
          </p>
        </div>
        <!--info-->
        <div class="faq-q">
			<h3 class="green-h">Câu hỏi thường gặp</h3>
			<ul class="list pkg">
			{section name=i loop=$allnews}
			 <li><a href="{$_config.www}/faq?id={$allnews[i].Id}#ques-{$allnews[i].Id}">{$allnews[i].Title|html_entity_decode|strip_tags|truncate:50}</a></li>
			 {/section}
			</ul>
			<a href="{$_config.www}/faq" class="more">Xem thêm</a>
		   </div>
		<div class="faq-q qkl">
				<h3 class="h">Liên kết nhanh</h3>
				<ul class="list pkg">
					<li><a href="{$_config.www}/advertisers">Dành cho Advertiser</a></li>
					<li><a href="{$_config.www}/publishers">Dành cho Publisher</a></li>
					<li><a href="{$_config.www}/account.php">Đăng nhập</a></li>
					<li><a href="{$_config.www}">Đăng ký</a></li>
				</ul>                            
			</div>
      </div>
    
    </div>
  </div>
{else}
<div class="main-content pkg">
<div class="main aff-intro pkg">
<div class="main-inner pkg">
<div class="left">
	<h3 class="head aff-head">Hãy trở thành Affiliate (người môi giới) của Textlink.vn!</h3>
	<h4 style="color:#CFF1F9; text-shadow:1px 1px #1289BA;">Kiếm tiền bằng cách giới thiệu khách hàng đến với textlink.vn!</h4>
	<h4 style="color:#000; text-shadow:1px 1px #fff;">Bạn sẽ kiếm được 10% doanh thu hàng tháng cho bất kỳ Publisher hay Advertiser nào bạn giới thiệu.</h4>                    
</div><!--left-->
<div class="right">
	<div class="aff aff-adv"><h3 style="display:none;">Publisher Refferal</h3>
		<p>Nếu bạn giới thiệu một "Advertiser", bạn sẽ nhận được  10% doanh thu trên tổng số tiền khách hàng sử dụng mỗi tháng</p>
		<p align="center"><img src="{$template_dir}/images/adv_chart.jpg" /></p>
		<p style="font-size:11px; color:#666;"><em><strong>Ví dụ: </strong></em> nếu khách hàng tiêu <strong style="color:#000;">1000$</strong> vào tháng 10, bạn sẽ nhận được <strong style="color:#000"></strong> vào tuần đầu tiên của tháng 11.</p>
	</div>
	<div class="aff aff-pub"><h3 style="display:none;">Publisher Refferal</h3>
		<p>Nếu bạn giới thiệu một "Publisher", bạn sẽ nhận được  10% doanh thu trên tổng số tiền nhà phân phối kiếm được mỗi tháng.</p>
		<p align="center"><img src="{$template_dir}/images/pub_chart.jpg" /></p>
		<p style="font-size:11px; color:#666;"><em><strong>Ví dụ: </strong></em> nếu nhà phân phối kiếm được <strong style="color:#000;">1000$</strong> vào tháng 10, bạn sẽ nhận được <strong style="color:#000"></strong> vào tuần đầu tiên của tháng 11.</p>
	</div>
</div>
</div>
</div><!--adv-intro-->
</div><!--main content-->    
<div class="main-wrp aff-main pkg">
<div class="main pkg">
	<div class="aff-reg">
		<img src="{$template_dir}/images/affiliate.png" />	
			
		<form action="{$_config.www}/register" method="post" class="aff-form pkg">
			<h3>Đăng ký</h3>
			<input type="text"  onblur="if(this.value=='') this.value='Tên đăng nhập'" onfocus="if(this.value=='Tên đăng nhập') this.value=''" class="txt2" name="name"  />
			<input type="text"  onblur="if(this.value=='') this.value='Email của bạn'" onfocus="if(this.value=='Email của bạn') this.value=''" class="txt2" name="email" value="" />
			<input type="submit" class="aff-reg-btn" value="Đăng ký thành viên" />
		</form>
	</div><!--aff reg-->			
<ul class="pub-feat aff-feat pkg">
		<li>
			<span class="pub-icon icon-1"></span>
			<h4>Bạn còn chần chừ
gì nữa? </h4>
			<p>Hãy tham gia ngay để trở thành nhà phân phối số 1 của chúng tôi để nhận được tỉ lệ chia thưởng cực kỳ hấp dẫn bằng cách giới thiệu khách hàng và nhà phân phối đến với chúng tôi. </p>
		</li>
		<li>
			<span class="pub-icon icon-2"></span>
			<h4>Kiếm tiền đơn giản!</h4>
			<p>Khi bạn đã đăng ký làm Nhà Môi Giới, bạn sẽ ngay lập tức có những công cụ như đường link và hình ảnh để giới thiệu Textlink.vn. Bất kỳ ai khi đăng ký thông qua bạn sẽ được đánh dấu là được giới thiệu thông qua bạn và bạn sẽ được chia thưởng ngay khi khách hàng tiêu hoặc kiếm được tiền.</p>
		</li>
		
		<li class="last">
			<span class="pub-icon icon-4"></span>
			<h4>Thanh toán bằng paypal
và chuyển khoản</h4>
			<p>Bạn có thể đặt links, hình ảnh giới thiệu về Textlink.vn trên website của bạn, gửi email tới bạn bè hoặc quảng bá chúng trên các diễn đàn. Khi bạn đã bắt đầu kiếm tiền, bạn sẽ được thanh toán qua Paypal hoặc chuyển khoản.</p>
		</li>
	</ul>                    
</div>
</div><!--main wrp-->
<div class="main-wrp pkg">
	<p class="m-h" style="padding:4px 0; font-size:19px;">Bạn vẫn còn thắc mắc ? Hãy liên lạc với chúng tôi ngay hôm nay <img src="{$template_dir}/images/sdt.jpg" /></p>
</div>
<div class="main-wrp pkg">
<div class="main pkg">
	<div class="textlink-info pkg">
		<div class="info">
			<p><img src="{$template_dir}/images/intro_textlink.png" /> <h4 class="head">Giới thiệu về Textlink</h4>
				<span>Trong thế giới Internet ngày nay, việc website của bạn xuất hiện trên những vị trí đầu của các cỗ máy tìm kiếm không chỉ giúp mang lại lượng khách hàng tiềm năng lớn mà còn giúp...</span>
				<a href="{$_config.www}/abouts" class="btn-detail">Chi tiết...</a>
			</p>
		</div><!--info-->		
		<div class="faq-q">
			<h3 class="green-h">Câu hỏi thường gặp</h3>
			<ul class="list pkg">
							{section name=i loop=$allnews}
			 <li><a href="{$_config.www}/faq?id={$allnews[i].Id}#ques-{$allnews[i].Id}">{$allnews[i].Title|html_entity_decode|strip_tags|truncate:50}</a></li>
			 {/section}
			</ul>
			<a href="{$_config.www}/faq" class="more">Xem thêm</a>
		   </div>
		<div class="faq-q qkl">
				<h3 class="h">Liên kết nhanh</h3>
				<ul class="list pkg">
					<li><a href="{$_config.www}/advertisers">Dành cho Advertiser</a></li>
					<li><a href="{$_config.www}/publishers">Dành cho Publisher</a></li>
					<li><a href="{$_config.www}/account.php">Đăng nhập</a></li>
					<li><a href="{$_config.www}">Đăng ký</a></li>
				</ul>                            
			</div>
	</div>
	<div class="pkg" style="margin:5px 0 15px 0;"><a class="reg-3-button" style="margin-left:375px; font-size:16px;" href="{$_config.www}/register.php">Đăng ký thành viên!</a></div>
</div>
</div>
{/if}