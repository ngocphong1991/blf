jQuery(document).ready(function(){
    jQuery('#btnsub_pay_atm').click(function(){
        var atm_name = jQuery('#atm_name').val();
        var atm_email = jQuery('#atm_email').val();
        var atm_phone = jQuery('#atm_phone').val();
        var atm_money = jQuery('#atm_money').val();
        var atm_bank = jQuery('#atm_bank').val();
        if(atm_name=='' || atm_email=='' || atm_phone=='' || atm_money=='' || atm_bank=='') {
            alert('Vui lòng nhập đủ thông tin');
            return false;
        }
        if((toString(atm_money)!=toString(parseInt(atm_money)))) {
            alert('Số tiền chưa đúng định dạng');
            return false;
        }
        if(atm_money<10000) {
            alert('Số tiền phải lớn hơn 10.000');
            return false;
        }
        jQuery('#load_pay_atm').show();
        jQuery.ajax({
    		type: "POST",
    		url: "?act=pay_atm",
    		data:  {atm_name: atm_name, atm_email: atm_email, atm_phone: atm_phone, atm_money: atm_money, atm_bank: atm_bank},
    		dataType: "html",
    		success: function(msg){			
    			if(parseInt(msg)!=0)
    			{				
    				jQuery('#load_pay_atm').fadeOut();
                    jQuery('#pay_card_now').html(msg);
    			} else alert(msg);
    		}
    	});
    });
    
    jQuery('#direct_name').val(username);
    jQuery('#direct_email').val(useremail);
    jQuery('#direct_phone').val(userphone);
    jQuery('#btnsub_pay_direct').click(function(){
        var direct_name = jQuery('#direct_name').val();
        var direct_email = jQuery('#direct_email').val();
        var direct_phone = jQuery('#direct_phone').val();
        var direct_address = jQuery('#direct_address').val();
        var direct_district = jQuery('#direct_district').val();
        var direct_city = jQuery('#direct_city').val();
        var direct_time = jQuery('#direct_time').val();
        
        
        
        var atm_email = jQuery('#atm_email').val();
        var atm_phone = jQuery('#atm_phone').val();
        
        if(direct_name=='' || direct_email=='' || direct_phone=='' || direct_address=='' || direct_district=='' || direct_city=='' || direct_time=='') {
            alert('Vui lòng nhập đủ thông tin');
            return false;
        }
        jQuery('#load_pay_direct').show();
        jQuery.ajax({
    		type: "POST",
    		url: "?act=pay_direct",
    		data:  {direct_name: direct_name,
                direct_email: direct_email,
                direct_phone: direct_phone,
                direct_address: direct_address,
                direct_district: direct_district,
                direct_city: direct_city,
                direct_time: direct_time
            },
    		dataType: "html",
    		success: function(msg){
    			if(parseInt(msg)!=0)
    			{
    				jQuery('#load_pay_direct').fadeOut();
                    jQuery('#truc-tiep').html(msg);
    			} else alert(msg);
    		}
    	});
    });
});