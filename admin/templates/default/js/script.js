function click_refund(adv_id,money){ 
	var r_confirm=confirm("Do you want refund money Advertiser?. The money Advertiser pay for this link will return Advertiser.");
	if(!r_confirm) return false;		
	// $obj.find('.loading').show();
	$.ajax({
		type: "POST",
		url: loc+"ajax.php",
		data:  {adv_id: adv_id, money: money, refunds:"refunds"},
		dataType: "html",
		success: function(msg){
			if(parseInt(msg)!=0)
			{
			  alert('Success!');
			} else {
				 alert('Error!');
			}
		}
	});    
}


$(document).ready(function(){
    $('.lst-publishersinfo .btn-update').click(function(){
        var $obj = $(this).parents('tr');
        var pid = $obj.attr('accesskey');
        var admin_rate = $obj.find('.eAdminRate').val();
        $obj.find('.loading').show();
        $.ajax({
    		type: "POST",
    		url: "?rates&act=ajax",
    		data:  {pid: pid, admin_rate: admin_rate},
    		dataType: "html",
    		success: function(msg){
    			if(parseInt(msg)!=0)
    			{
    			 var r=confirm("Update thành công. Bạn có muốn gửi email cho khách hàng?");
			     if(r) {
			         $.ajax({
                		type: "POST",
                		url: "?rates&act=send_mail",
                		data:  {pid: pid},
                		dataType: "html",
                		success: function(msg){
                		  if(parseInt(msg)!=0){
                		      alert('Gửi email thành công!');
                		  }
                          else alert('Error!');
                		}
                     });
			     }
    			} else {
                     alert('Error!');
    			}
    		}
    	});
    });
    $('.lst-publishersinfo .btn-update-sale').click(function(){
        var $obj = $(this).parents('tr');
        var pid = $obj.attr('accesskey');
        var sale_rate = $obj.find('.eSaleRate').val();
        $obj.find('.loading').show();
        $.ajax({
    		type: "POST",
    		url: "?rates&act=update_sale",
    		data:  {pid: pid, sale_rate: sale_rate},
    		dataType: "html",
    		success: function(msg){
    			if(parseInt(msg)!=0)
    			{
    			  alert('Success!');
    			} else {
                     alert('Error!');
    			}
    		}
    	});
    });
	// refunds money
	  
		// end refund money
    $('#lst-submit-url .btn-show').click(function(){
        var pid = $(this).parents('tr').attr('accesskey');
        if($(this).hasClass('active')) {
            $('.tr-submiturl-'+pid).hide();
            $('.tr-submiturl-'+pid+':first').show();
            $(this).text('Show').removeClass('active');
        }
        else {
            $('.tr-submiturl-'+pid).show();
            $(this).text('Hide').addClass('active');
        }
    });
    $('#lst-submit-url .btn-can').click(function(){
        $(this).parents('tr.frm_submit').hide();
    });
    $('#lst-submit-url .btn-openfrm').click(function(){
        var pid = $(this).parents('tr').attr('accesskey');
        $('#frm_submit'+pid).show().find('input:first').focus();
    });
    
    $('#lst-submit-url .btn-add').click(function(){
        var $obj = $(this).parents('tr');
        var iTitle = $obj.find('.iTitle').val();
        var iUrl = $obj.find('.iUrl').val();
        var pid = $obj.find('.iDomain').val();
        $.ajax({
    		type: "POST",
    		url: "?act=add_url",
    		data:  {title: iTitle, url: iUrl, pid: pid},
    		dataType: "html",
    		success: function(msg){
    		  if(msg!='0'){
    		      $obj.find('.iTitle').val('').focus();
                  $obj.find('.iUrl').val('');
                  $('.tr-submiturl-'+pid+':last').after(msg);
    		  }
              else alert('Error!');
    		}
         });
    });
    $('#lst-submit-url .frm_submit').keypress(function(e){
        if(e.which==13) {
            $(this).find('.btn-add').click();
        }
    });
    $('#lst-submit-url .btn-del').live('click',function(){
        if(confirm("Bạn có chắc chắn xóa?")) {
            var $obj = $(this).parents('tr');
            var pid = $obj.attr('accesskey');
            $.ajax({
        		type: "POST",
        		url: "?act=del_url",
        		data:  {pid: pid},
        		dataType: "html",
        		success: function(msg){
        		  if(msg!='0'){
                      $('#submit_url_'+pid).hide();
        		  }
                  else alert('Error!');
        		}
             });
          }
    });
});
