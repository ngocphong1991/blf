var bank_select = 0;
function scrollGo(id) {
    var x = jQuery('#'+id+'').offset().top - 100; // 100 provides buffer in viewport
    jQuery('html,body').animate({scrollTop: x}, 500);
}

function _show(a){
    var d = jQuery('#'+a+'').css('display');
    
    if (d == 'none'){
        jQuery('#'+a+'').css('display','block');
    }
}

function _hide(a){
    var d = jQuery('#'+a+'').css('display');    
    if (d != 'none'){
        jQuery('#'+a+'').css('display','none');
    }
}

function _showbox(id){
    jQuery('#check_'+id+'').attr('checked',true);
    jQuery('#img_'+id+'').css('display','inline');
    jQuery('#nav_'+id+'').css('display','block').fadeIn('slow');
    scrollGo('nav_'+id);
}

function _hidebox(id){
    jQuery('#check_'+id+'').attr('checked',false);
    jQuery('#img_'+id+'').css('display','none');
    jQuery('#nav_'+id+'').css('display','none');
}

function resetForm(id) {
    jQuery('#'+id).each(function(){
            this.reset();
    });
}

function paygateSubmit(obj){
        var amount_check = /^[0-9]+jQuery/;
        if(document.getElementById('visa_amount').value==""){
            alert("Bạn chưa điền số tiền muốn nạp");
            return false;            
        }
        if(amount_check.test(document.getElementById('visa_amount').value) == false){
            alert("Số tiền muốn nạp chỉ bao gồm số");
            return false;
        }
        if(document.getElementById('visa_amount').value < 1000){
            alert("Số tiền ít nhất là 10,000 VNĐ");
            return false;
        }
        jQuery('#paygate').submit();        
    }

function ajaxCard(obj){
    var card_check = /^[0-9-]+jQuery/;
    if(card_check.test(jQuery('#card_code_card').val()) == false){
        alert("Mã bạn điền vào chưa đúng");
        return false;
    }
    //xử lý ajax
    var pm_card_code = jQuery('#card_code_card').val();
    var pm_coupon = jQuery('#card_code_coupon').val();
    var pm_card_serial = jQuery('#card_serial_card').val();
    
    pm_card_type = jQuery('input[name="cardtype"]:checked').val();
    
    jQuery.ajax({
        url: "/",
        type: "POST",
        data: {
            act:'ajaxCard',
            //pm_phone : phone_number,
            pm_card_code:pm_card_code,
            pm_coupon : pm_coupon,
            pm_card_type : pm_card_type,
            pm_card_serial : pm_card_serial
        },
        beforeSend : function(){
            jQuery('input[name="continue"]').css('display','none');
            jQuery('img[name="loading"]').css('display','block');
        },
        success : function(html){
            jQuery('input[name="continue"]').css('display','block');
            jQuery('img[name="loading"]').css('display','none');
            jQuery('#TB_window').trigger("unload").unbind();
            jQuery('#card_code_card').attr('value','');
            jQuery('#card_code_coupon').attr('value','');
            jQuery('#TB_ajaxContent').html(html);
        }
    });
    
    
    
    //url = "http://advertiser.ad360.vn/index.php?act=ajaxCard&pm_phone=0988888888&pm_card_code="+pm_card_code+"&pm_code="+pm_code+"&pm_card_type="+pm_card_type+"&pm_coupon="+pm_coupon;      
}

jQuery(document).ready(function(){   
    jQuery('#h4op1').click(function(){
        _showbox('addfund1');
        _hidebox('addfund2');
        _hidebox('addfund3');
        _hidebox('addfund4');
    });
    jQuery('#h4op2').click(function(){
        _showbox('addfund2');
        _hidebox('addfund1');
        _hidebox('addfund3');
        _hidebox('addfund4');
    });
    jQuery('#h4op3').click(function(){
        _showbox('addfund3');
        jQuery('#addfund3').css('display','block');
        _hidebox('addfund1');
        _hidebox('addfund2');
        _hidebox('addfund4');
    });
    jQuery('#h4op4').click(function(){
        _showbox('addfund4');
        _hidebox('addfund1');
        _hidebox('addfund3');
        _hidebox('addfund2');
    });
    jQuery('#h4op1').hover(
        function(){
            jQuery('#img_addfund1').css('display','inline');
        },
        function(){
            if (!jQuery('#check_addfund1').attr('checked')){
                jQuery('#img_addfund1').css('display','none');
            }
        }
    );
    jQuery('#h4op2').hover(
        function(){
            jQuery('#img_addfund2').css('display','inline');
        },
        function(){
            if (!jQuery('#check_addfund2').attr('checked')){
                jQuery('#img_addfund2').css('display','none');
            }
        }
    );
    jQuery('#h4op3').hover(
        function(){
            jQuery('#img_addfund3').css('display','inline');
        },
        function(){
            if (!jQuery('#check_addfund3').attr('checked')){
                jQuery('#img_addfund3').css('display','none');
            }
        }
    );
    jQuery('#h4op4').hover(
        function(){
            jQuery('#img_addfund4').css('display','inline');
        },
        function(){
            if (!jQuery('#check_addfund4').attr('checked')){
                jQuery('#img_addfund4').css('display','none');
            }
        }
    );
    
    jQuery('#nav_addfund1').click(function(){
        url = '#TB_inline?height=250&width=450&inlineId=card&modal=true';
        tb_show('Nạp tiền bằng thẻ điện thoại',url,false);
    });
    jQuery('#nav_addfund2').click(function(){
        url = '#TB_inline?height=250&width=470&inlineId=addfund2&modal=true';
        tb_show('Nạp tiền qua cổng thanh toán',url,false);
    });
    jQuery('#nav_addfund3').click(function(){
        if (bank_select == 0){
            alert('Quý khách chưa chọn ngân hàng để chuyển tiền vào');
            return false;
        }
        url = '#TB_inline?height=300&width=500&inlineId=info-form&modal=true';
        jQuery('#atm_name').attr('value',username);
        jQuery('#atm_email').attr('value',useremail);
        jQuery('#atm_phone').attr('value',userphone);
        tb_show('Nạp tiền qua chuyển khoản atm',url,false);
    });
    jQuery('#nav_addfund4').click(function(){
        url = '#TB_inline?height=370&width=600&inlineId=addfund4&modal=true';
        jQuery('#name').attr('value',username);
        jQuery('#email').attr('value',useremail);
        jQuery('#phone').attr('value',userphone);
        tb_show('Nạp tiền trực tiếp',url,false);
    });
});

function _assign(a){
    jQuery('#atm_bank').val(a);
    bank_select = 1;
    //alert(jQuery('#atm_bank').val());
}
function ajaxAtm(obj){

    var email_check = /^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})jQuery/;
    var phone_check = /^[0-9]+jQuery/;
    var money_check = /^[0-9]+jQuery/;
    if((document.getElementById('atm_name').value=="") || (document.getElementById('atm_email').value=="") ||
    (document.getElementById('atm_phone').value=="") || (document.getElementById('atm_money').value=="")){                    
        
        alert("Vui lòng điền đầy đủ các thông tin");
        return false;
    }
    if(email_check.test(document.getElementById('atm_email').value) == false)
    {
        alert("Chưa nhập đúng email");
        return false;
    }
    if(phone_check.test(document.getElementById('atm_phone').value) == false)
    {
        alert("Chưa nhập đúng số điện thoại");
        return false;
    }
    if(money_check.test(document.getElementById('atm_money').value) == false)
    {
        alert("Chưa nhập đúng số tiền");
        return false;
    }
    if(document.getElementById('atm_money').value=="" < 100000)
    {
        alert("Số tiền ít nhất là 100.000VNĐ");
        return false;
    }
    //xử lý ajax
    var pm_name = jQuery('#atm_name').val();            
    var pm_email = jQuery('#atm_email').val();        
    var pm_phone = jQuery('#atm_phone').val();
    var pm_money = jQuery('#atm_money').val();        
    var pm_bank = jQuery('#atm_bank').val();                                            
    jQuery.ajax({
        url: "/",
        type: "POST",
        data: {
            act:'ajaxAtm',
            pm_name : pm_name,
            pm_email : pm_email,
            pm_money : pm_money,            
            pm_bank : pm_bank,
            pm_phone : pm_phone,            
        },
        beforeSend : function(){
            jQuery('input[name="bank_continue"]').css('display','none');
            jQuery('img[name="bank_loading"]').css('display','block');
        },
        success : function(html){
            jQuery('input[name="bank_continue"]').css('display','block');
            jQuery('img[name="bank_loading"]').css('display','none');
            jQuery('#TB_window').trigger("unload").unbind();
            resetForm('info-form');
            jQuery('#TB_ajaxContent').html(html);
        }
    });                           
}

function ajaxTructiep(obj){
    var email_check = /^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})jQuery/;
    var phone_check = /^[0-9]+jQuery/;
    if((document.getElementById('name').value=="") || (document.getElementById('address').value=="") || (document.getElementById('email').value=="") ||
    (document.getElementById('district').value=="") || (document.getElementById('city').value=="") ||(document.getElementById('phone').value=="") ||
    (document.getElementById('time').value=="")){
        alert("Vui lòng điền đầy đủ các thông tin");
        return false;
    }
    if(email_check.test(document.getElementById('email').value) == false)
    {
        alert("Chưa nhập đúng email");
        return false;
    }
    if(phone_check.test(document.getElementById('phone').value) == false)
    {
        alert("Chưa nhập đúng số điện thoại");
        return false;
    }
    //xử lý ajax
    var pm_name = jQuery('#name').val();            
    var pm_email = jQuery('#email').val();
    var pm_address = jQuery('#address').val();
    var pm_phone = jQuery('#phone').val();
    var pm_district = jQuery('#district').val();
    var pm_city = jQuery('#city').val();
    var pm_time = jQuery('#time').val();    
    
    jQuery.ajax({
        url: "/",
        type: "POST",
        data: {
            act:'ajaxTrucTiep',
            pm_name : pm_name,
            pm_email : pm_email,
            pm_address : pm_address,            
            pm_district : pm_district,
            pm_city : pm_city,
            pm_time : pm_time,
            pm_phone : pm_phone,            
        },        
        beforeSend : function(){
            jQuery('input[name="tructiep_continue"]').css('display','none');
            jQuery('img[name="tructiep_loading"]').css('display','block');
        },
        success : function(html){            
            jQuery('input[name="tructiep_continue"]').css('display','block');
            jQuery('img[name="tructiep_loading"]').css('display','none');
            jQuery('#TB_window').trigger("unload").unbind();
            resetForm('truc-tiep');
            jQuery('#TB_ajaxContent').html(html);
        }
    });        
}

function resetForm(id) {
    jQuery('#'+id).each(function(){
        this.reset();
    });
}
function _hidebank(){
    var a= jQuery('#atm_bank').attr('value');
    jQuery('#atm_bank').val('0');
    bank_select = 0;
    _hide(a);
}
