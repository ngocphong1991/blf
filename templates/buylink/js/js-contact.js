jQuery(document).ready(function(){
    jQuery('#contactForm').validate();
    jQuery('#contactForm').submit(function(){
        var rand1 = jQuery('#veri_num1').text(); rand1 = parseInt(rand1);
        var rand2 = jQuery('#veri_num2').text(); rand2 = parseInt(rand2);
        var res = jQuery('#human_auth').val(); res = parseInt(res);
        if(res != rand1+rand2) {
            jQuery('#human_auth').val('');
            return false;
        }
    });
    jQuery('#btn-submit-contact').click(function(){
        jQuery('#contactForm').submit();
        return false;
    });
});