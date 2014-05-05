<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">
        
        <tr>
          <td class="style39"><h1><span class="green">Pay Direct Manager</span></h1></td>
        </tr>
      </table>
	  
      <table width="100%" border="0" align="center" style="min-width: 769px">
        
        <tr>
          <td width="100%"><div class="splitleft">
		  
            <div class="box">
              <div align="left">
			     <form action="" method="post" name="frm_bank">
                 <table class="tbl-list" id="lst-submit-url">
                    <tr style="font-weight: bold">
                        <td width="35">UID</td>
                        <td>Họ và tên</td>
                        <td>Địa chỉ</td>
                        <td>Thời gian thu</td>
                        <td>Reg Date</td>
                        <td width="80">Xác nhận</td>
                    </tr>
                    {section name=i loop=$all_pay_direct}
                    <tr>
                        <td>{$all_pay_direct[i].uid}</td>
                        <td><strong><a href="" title="Phone: {$all_pay_direct[i].phone}
Email: {$all_pay_direct[i].email}">{$all_pay_direct[i].fullname}</a></strong></td>
                        <td><a href="" title="Add: {$all_pay_direct[i].address}
Quận/Huyện: {$all_pay_direct[i].district}">{$all_pay_direct[i].city}</a></td>
                        <td>{$all_pay_direct[i].to_date}</td>
                        <td>{$all_pay_direct[i].reg_date|date_format:"%d/%m/%Y - %H:%M"}</td>
                        <td>
                            {if $all_pay_direct[i].status=='0'}
                            <a href="?confirm={$all_pay_direct[i].pay_direct_id}&type=yes" class="smart-btn btn-openfrm btn-pay-atm-conf-yes">Yes</a>
                            <a href="?confirm={$all_pay_direct[i].pay_direct_id}&type=no" class="smart-btn btn-openfrm btn-pay-atm-conf-no">No</a>
                            {/if}
                            {if $all_pay_direct[i].status=='-1'}
                            <span>No</span>
                            {/if}
                            {if $all_pay_direct[i].status=='1'}
                            <span>Yes</span>
                            {/if}
                        </td>
                    </tr>
                    
                 
                    {/section}
                    
                 </table>
                 </form>
                 <div class="paging" style="margin-top: 20px">
                    {section name=i loop=$paging}
                    <a title="{$paging[i][1]}" href="{$protocol}?page={$paging[i][0]}" class="{if $cursorPage==$paging[i][0]}btn3{else}btn2{/if}">{$paging[i][1]}</a>
                    {/section}
                 </div>
                 <script type="text/javascript" src="templates/default/js/jquery-1.7.1.min.js"></script>
                 <script type="text/javascript" src="templates/default/js/js_bank.js"></script>
                 
              </div>
            </div>
          </div></td>
        </tr>
      </table>
      
</div>
{literal}
<style>
.smart-btn {display: inline-block}
</style>
<script type="text/javascript">
$(document).ready(function(){
    $('.btn-pay-atm-conf-yes').click(function(){
        if(!confirm("Hệ thống sẽ cộng tiền vào tài khoản và gửi email cho khách hàng. Bạn có muốn tiếp tục?")) {
            return false;
        } else {
            var value = prompt("Hãy nhập số tiền!", "");
            var iHref = $(this).attr('href');
            self.location = iHref+"&val="+value;
            return false;
        }
    });
    $('.btn-pay-atm-conf-no').click(function(){
        if(!confirm("Hệ thống sẽ xác nhận tài khoản chưa nhận được và gửi email cho khách hàng. Bạn có muốn tiếp tục?")) {
            return false;
        }
    });
});
</script>
{/literal}