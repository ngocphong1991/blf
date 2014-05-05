<div class="home-reg-form pkg">
			<h3 class="blk-label">Tạo tài khoản</h3>
			<form action="{$_config.www}/register.php?step=1" method="post" class="pkg">
				<input type="hidden" value="1" name="register_step">
				<div class="pkg" >
					<div class="one" style="float:left; width:110px; margin-right:10px;">
						<label>Họ và đệm</label>
						<input type="text" class="txt2" value="" name="first_name" style="width:104px;" />
					</div>
					<div class="one" style="float:left; width:110px;">
						<label>Tên</label>
						<input type="text" class="txt2" value="" name="name" style="width:104px;" />
					</div>
					<div class="one">
						<label>Email</label>
						<input type="text" class="txt2" value="" name="email" style="width:224px;" />
					</div>
					<div class="one chk">
						<p style="font-size:14px; color:#912828; font-weight:bold; margin-bottom:15px; margin-top:15px;">Bạn là:</p>
						
						<div class="pkg">
							<div class="radios">
								<label class="label_radio r_on" for="radio-01"><input name="ad_type" id="radio-01" value="adv" checked="checked" type="radio"> Advertiser</label>
								<label class="label_radio" for="radio-02"><input name="ad_type" id="radio-02" value="pub" type="radio">Publisher</label>
								<label class="label_radio" for="radio-03"><input name="ad_type" id="radio-03" value="pub+adv" type="radio"> Cả hai</label>
							</div>
						</div>
					</div>
					<div class="pkg"><input type="submit" value="Đăng ký" class="home-reg-btn" /></div>
				</div>
			</form>
		</div>