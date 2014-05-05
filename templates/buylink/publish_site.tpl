<div class="section website" id="form-280x400">		
			<div class="arrow-loop-right"></div>
			
			<a href="/account/publishers-guide/"><img height="63" alt="Publisher's Guide" widht="250" src="{$_config.www}/templates/{$_config.template}/images/publishers-guide.png"></a>		
			<h2>Đăng ký website</h2>	
			
			<form action="{$_config.www}/publishers.php?step=1" method="post" id="hp-bottom-website">		
				<label class="block">Địa chỉ URL: *</label>
				<input type="text" value="http://" name="url" class="txt2">
				<p style="margin: 0; padding: 0;" class="small grey">Vui lòng điền địa chỉ trang chủ website.</p>
				
				<label class="block">Tiêu đề website: *</label>
				<input type="text" value="" name="wname" class="txt2">
				
				<label class="block">Mô tả: *</label>
				
				<textarea rows="5" cols="30" name="wdes" class="txt2"></textarea>
			
				<a onclick="$('hp-bottom-website').submit(); return false;" href="#" class="btn-green-240">Đăng ký</a>
				
			</form>		
		</div>