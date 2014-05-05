<div id="body">
      <div class="full profile" id="content">
        <div class="left half-box">
          <h1 class="less-padding">Xin Chào, {$fullname}.</h1>
          <p class="large grey"> Bảng điều khiển này là nơi bạn có thể quản lý tài khoản của mình một cách dễ dàng. </p>
          <div class="splitleft">
            <div class="box">
              <div align="left">
                <table border="0" width="100%">
                  <tbody>
                    <tr>
                      <td width="33%"><span class="style39"><strong>Tình Trạng </strong></span></td>
                      <td width="33%"><span class="style39"><strong>Loại Tài Khoản </strong></span></td>
                      <td width="33%"><span class="style39"><strong>Nâng Cấp</strong></span></td>
                    </tr>
                    <tr>
                      <td><img src="images/Bullet_green.gif" height="16" width="19"></td>
                      <td><img src="images/Bullet_green.gif" height="16" width="19"></td>
                      <td><img src="images/Bullet_green.gif" height="16" width="19"></td>
                    </tr>
                    <tr>
                      <td><span class="style38">Live</span></td>
                      <td><span class="style38"> {if $user_info.utype=='pub+adv'}Publisher &amp; Advertiser {elseif $user_info.utype == 'pub'} Publisher {else} Advertiser {/if} </span></td>
                      <td>Already Upgraded</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="padding-bottom" id="profileOrders"><h2> Order mới nhất</h2><table class="data large border-top" id="order-table">
<tbody>
{section name=num loop=$lastest_order}
<tr class="row1">
<td style="width: ;" class="alignleft"><a href="/account/links-advertiser/?status_id=ALL&amp;order_id=101875" class="bold blue">Order #{$lastest_order[num].pid}</a>
				<span class="grey">(Placed {$lastest_order[num].buying_date})</span>
				<br>
				<span class="small">
					1 Link đã kích hoạt,
					0 Link đang chờ,
					0 Link đã bị hủy
				</span></td>
<td style="width: 80px;" class="alignright large bold green last">{$lastest_order[num].price}/mo</td>
</tr>
{/section}
</tbody>
</table>
<div class="right padding-top"><a href="{$_config.www}/orders.php" class="blue bold noline">Xem Tất Cả</a></div><div class="clear"></div></div>
          <div class="padding-bottom" id="profileWebsites">
            <p class="right small grey">Doanh thu hàng tháng sẽ được cập nhật hàng ngày. *</p>
            <h2>Website của bạn</h2>
            <table class="data large border-top" id="website-table">
              <tbody>
			  {section name=num loop=$www}
                <tr class="row{$www[num].key}">
                  <td style=""><a href="{$_config.www}/publishers.php?pid=26&amp;do=edit" class="bold">{$www[num].title}</a>{if $www[num].status  == 2}
				<span class="lbl lbl-active">Active</span>
			{else}
				<span class="lbl lbl-pending">Pending</span>			
			{/if}<br>
                    <span class="grey small">(<a href="{$www[num].url}" target="_blank">{$www[num].url}</a>)</span><span class="small"><span class="small">{$www[num].description}</span></span></td>
                  <td style="width: 90px;" class="alignright green bold large last"><a href="{$_config.www}/earnings.php?pid=26">{$www[num].price}/mo</a></td>
                </tr>
				{/section}                
              </tbody>
            </table>
            <div class="right padding-top"><a href="{$_config.www}/publishers.php?step=1" class="blue bold noline">Xem tất cả websites</a></div>
            <a href="{$_config.www}/publishers.php?step=1" style="margin: 10px 10px 0px 0px;" class="btn-tan-180 left">Submit a website</a>
            <div class="clear"></div>
          </div>
        </div>
        <div style="width:48%;" class="right half-box">
          <div id="dashboard-marketplace" class="pkg">
            <h2>Marketplace</h2>
            <form method="get" action="{$_config.www}/marketplace/" id="marketplaceForm" class="pkg">
              <div class="left half-box">
                <input onfocus="updateTextFieldLabel(this, true, 'Từ khóa cần tìm(s)');" style="color: rgb(136, 136, 136);" size="27" value="Enter your keyword(s)" name="keywords" class="txt2" type="text">
                <select name="category_id" class="txt2">
                  <option selected="selected" value="">-- All Categories --</option>
                 {section name=num loop=$cats}
		            <option value="{$cat_ids[num]}">{$cats[num]}</option>
		            {/section}
                </select>
                <select name="link_score" class="txt2">
                  <option selected="selected" value="">-- All Page Ranks --</option>
                  <option value="1">1+</option>
                  <option value="2">2+</option>
                  <option value="3">3+</option>
                  <option value="4">4+</option>
                  <option value="5">5+</option>
                  <option value="6">6+</option>
                  <option value="7">7+</option>
                </select>
                <select onchange="" class="txt2" name="language" id="filterLanguage">
                  <option selected="selected" value="">-- All Languages --</option>
                  {section name=num loop=$langs}
				  <option value="{$lang_ids[num]}">{$langs[num]}</option>
				  {/section}	
                </select>
              </div>
              <div class="right half-box">
                <select name="type" class="txt2">
                </select>
                <p class="small"><a href="{$_config.www}/dashboard/marketplace-help.html" class="lbOn">What's the difference?</a></p>
                <a onclick="$('marketplaceForm').submit(); return false;" href="#" class="btn-green-180">Tìm Kiếm</a> </div>
            </form>
            <p class="cat-browers"><strong>Hoặc Tìm theo danh mục:</strong></p>
            <ul class="pkg">
			{section name=num loop=$cats}
		   	<li><a href="{$_config.www}/marketplace?category_id={$cat_ids[num]}">{$cats[num]}</a></li>		     
		   	{/section}	
            </ul>
          </div>
          <div class="pkg">
            <p> <img alt="" src="images/icon-lifesaver.png" style="padding: 0px 15px 30px 0px;" class="left"> <strong>Hỗ Trợ?</strong><br>
              Bạn có muốn chúng tôi tạo một <a href="{$_config.www}/contact/">personalized proposal</a> cho bạn không? Nếu có bất kỳ câu hỏi hay cần sự trợ giúp về kỹ thuật, Bạn có thể tham khảo qua<a href="{$_config.www}/faq/">FAQ</a> Hoặc <a href="{$_config.www}/contact/">liên hệ với chúng tôi</a>. </p>
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>