<div id="body">
     <div class="full" id="content"> <!-- <a href="#" onclick="(alert('Xuat ra 1 file pdf'))" style="margin-right: 10px;" class="btn-tan-180 right">Export All Invoices</a>-->
        <h1>Hóa Đơn</h1>
        <p class="large"> Chúng tôi sẽ suất hóa đơn hàng tháng khi bạn yêu cầu. Nếu bạn muốn xem chi phí cho các link bạn đã đặt mua có thể vào mục <a href="http://textlink.vn/orders.php".</strong> để xem. </p>
        </p>
        <table class="data large" id="order-table">
          <thead>
            <tr>
              <th style="width: 40px;"><a href="http://textlink.vn/orders.php/?action=orders&amp;sort=order_entry.id&amp;order=ASC">ID #</a> <img src="{$template_dir}/images/sorted-desc.gif"></th>
              <th><a href="http://textlink.vn/orders.php/?action=orders&amp;sort=date_created&amp;order=ASC">Ngày Đặt</a></th>
              <th style="width: 70px;"><a href="http://textlink.vn/orders/?action=orders&amp;sort=total&amp;order=ASC">Tổng tiền</a></th>
            
              <th style="width: 70px;"><a href="http://textlink.vn/orders.php/?action=orders&amp;sort=active_total&amp;order=ASC">Thực Trả</a></th>
              <th style="width: 80px;">Quản Lý</th>
              <th style="width: 80px;" class="last">Hóa Đơn</th>
            </tr>
          </thead>
          <tbody>
		  {section name=num loop=$lastest_order}		  
         	<tr class="row1">
			<td class="alignleft">{$lastest_order[num].pid}</td>
			<td class="alignleft">{$lastest_order[num].req_date}</td>
			<td class="alignright bold grey">{$lastest_order[num].price}</td>
			<td class="alignright bold green">{$lastest_order[num].price}</td>
			<td class="centered"><a href="{$_config.www}/links.php?status_id=ALL&amp;order_id={$lastest_order[num].adv_id}" class="btn-tan-80">Quản Lý</a></td>
			<td class="centered last"><a href="{$_config.www}/links.php?id={$lastest_order[num].adv_id}" class="btn-tan-80">Hóa Đơn</a></td>
			</tr>
			{/section}            
          </tbody>
        </table>
      </div>
    </div>
	
	
	