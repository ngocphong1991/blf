<div class="full" id="content">
		  <div class="right alignright">
		    <h3></span></h3>
		  </div>
		  <h1 style="padding-bottom: 0px;">Quản Lý Link</h1>
		  <div class="clear"></div>
		  <form style="margin: 10px 0 20px 0;" method="get"  class="filter-box" id="link-filter">
		    <fieldset>
		      <div class="controls">
		        <div class="third-box left">
		          <select style="width: 80%" class="txt2" name="link-filter">
		            <option value="ALL">-- All Statuses --</option>
		            <option selected="selected" value="6">Active Links</option>
		            <option value="4">Pending Links</option>
		            <option value="8">Canceled Links</option>
		            <option value="2">Rejected Links</option>
		          </select>
		          <br>
		          <br>
		          <select style="width: 80%" class="txt2" name="order_id">
		            <option value="">-- All Orders --</option>
					{section name=i loop=$all}
					<option {if $all[i].adv_id  == $order_id} selected="selected" {/if} value="{$all[i].adv_id}">#{$all[i].adv_id}</option>
					{/section}
		          </select>
		          &nbsp; </div>
		        <div class="third-box left">
		          <select style="width: 80%" class="txt2" name="adv_id">
		            <option value="">-- All Link Text --</option>
					{section name=i loop=$all}
					<option {if $all[i].adv_id  == $order_id} selected="selected" {/if} value="{$all[i].adv_id}">{$all[i].ad_des}</option>
					{/section}
		          </select>
		          &nbsp; </div>
		        <div class="third-box left"> <a onclick="$('link-filter').action = '{$_config.www}/links.php'; $('link-filter').submit(); return false;" href="#" class="btn-tan-80 left">View</a> <a onclick="$('link-filter').action = '{$_config.www}/export-excel.php'; $('link-filter').submit(); return false;" href="#" style="margin-left: 10px;" class="btn-tan-80 left">Export</a> </div>
		        <div class="clear"></div>
		      </div>		     
		    </fieldset>
		  </form>
		  <div class="clear"></div>		 
		  <form method="post" id="linkForm">
		    <fieldset>			
			  <input type="hidden" value="1" name="update" />
		    </fieldset>		
		  <h2 class="black">Regular Links</h2>
		  <table class="data large" id="regular-link-table">
			<thead>
			<tr>
			<th><a href="#">Nôi Dung Website</a></th>
			<th style="width: 50px;"><a href="/#">Ngày đặt</a></th>
			<th style="width: 50px;"><a href="#">Ngày hết hạn</a></th>
			<th style="width: 35px;"><a href="#">PR</a></th>
			<th style="width: 190px;"><a href="#">Link Details</a></th>
			<th style="width: 55px;"><a href="#">Giá/tháng</a></th>
			<th style="width: 80px;" class="last"></th>
			</tr>
			</thead>
			<tbody>
			{section name=i loop=$ids}
			<tr class="row1">
			<td><strong>{$ids[i].websitename}</strong><br><span class="small grey">(<a href="{$all[i].url}" target="_blank">{$ids[i].url}</a>)</span><br>{$ids[i].description}</td>
			<td class="alignleft">{$ids[i].buying_date}</td>
			<td class="alignleft">{$ids[i].end_date}</td>
			<td class="alignleft">{$ids[i].google_page_rank}</td>
			<td class="alignleft">
			<input type="hidden" value="{$ids[i].adv_id}" name="order_id" />
			<a href="{$ids[i].ad_url}">{$ids[i].ad_des}</a><br>
			{$ids[i].ad_url}</td>
			<td class="alignright large green bold">USD {$ids[i].set_price|number_format}</td>
			<td class="centered last">{if $ids[i].cancel  == 1} <a onclick="cancelLinkAd(this, 'regular', {$all[i].adv_id}, {$all[i].pid}); return false;" href="#" class="btn-tan-80">Hủy Bỏ</a> {else}{/if} {if $ids[i].approved  == 'N' and $ids[i].approval_method  == 'B'} <a onclick="ActiveManualSite(this, 'is_manual', {$all[i].adv_id}, {$all[i].pid}); return false;" href="#" class="btn-tan-80">Duyệt</a> {/if}</td>
			</tr>
			{/section}			
			</tbody>
			</table>
		 </form>		 
		  <div class="clear"></div>
		</div>