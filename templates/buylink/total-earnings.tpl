<div id="content">
		  <form action="" method="get" class="filter-box right" id="website-filter">
		    <fieldset>		    
		      <strong>&nbsp;Xem Thu Nhập theo tháng</strong>
		      <div class="controls"> <a onclick="$('website-filter').submit(); return false;" href="#" style="margin-left: 10px;" class="btn-tan-80 right">Xem</a>
		        <select onchange="" class="txt" name="month" id="">
                {$str}
		        </select>
		        &nbsp;
		        <select onchange="" class="txt" name="year" id="">
		          <option value="2009">2009</option>
		          <option value="2010">2010</option>
		          <option value="2011">2011</option>
		          <option selected="selected" value="2012">2012</option>
		        </select>
		        &nbsp;
		        <div class="clear"></div>
		      </div>
		    </fieldset>
		  </form>
		  <h1 style="padding-bottom: 0;"></h1>          
		  <h2 class="black">Tổng thu nhập {$earning_date}</h2>
		  <p class="large"><strong>Lưu ý:</strong> Bạn đang xem thu nhập trong tháng này. Thu nhập được hiện thị ở đưới là được tính toán dựa trên link quảng cáo hiện tại. Thu nhập đó có thể bị thay đổi nếu link quảng cáo bị hủy bỏ hay không hiển thị. </p>          
      <table class="data large">
	  <tbody>
		<tr>
		  <td width="15%"><b>Website</b></td>
           <td width="15%"><b>Link on</b></td>
		  <td width="15%"><b>Start date</b></td>
		  <td width="10%"><b>End date</b></td>
		
		  <td width="20%"><b>Kiếm được/month (USD)</b></td>
		  <td width="10%"><b></b></td>
		</tr>
		{section name=i loop=$pub_arr}
		<tr>
		  <td><strong><a href="{$cls_publishersinfo->getPublisherInfo($pub_arr[i].pid, 'url')}">{$cls_publishersinfo->getPublisherInfo($pub_arr[i].pid, 'url')}</a></strong></td>
            <td><a href="{$pub_arr[i].ad_url}">{$pub_arr[i].ad_des}</a></td>
		  <td>{$pub_arr[i].start_date}</td>
		  <td>{$pub_arr[i].end_date}</td>	
		  <td> <strong>{$pub_arr[i].set_price} USD</strong> </td>
		  <td></td>
		</tr>
		{/section}           
	  </tbody>
	</table>    
		  <h2 class="right black">Tổng Thu Nhập: <span class="green"> {$my_website_earnings} USD</span><span style="font-size:12px; color:#666"> (tới thời điểm hiện tại)</span></h2>		
		  <div class="clear"></div>
		</div>