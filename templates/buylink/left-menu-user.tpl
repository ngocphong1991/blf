<div class="col-sm-3 left-slider" id="left-top">
    <div class="col-xs-4 col-sm-12 register-block">
        <h6>SIGN UP IN UNDER 1 MINUTE</h6>
        <form id="quickRegister" name="quickRegister" action="register.php" method="post">
            {if isset($msg_quick)}<div class="alert alert-danger">{$msg_quick}</div>{/if}
            <ul>
                <input type="hidden" value="1" name="quick-register">
                <li><label for="username">Your username*</label></li>
                <li><input type="text" class="required" value="{$smarty.post.username}" id="username" name="username"/></li>
                <li><label for="password">Your password*</label></li>
                <li><input type="password" class="required" id="password" name="password"></li>
                <li><label for="email">Your email address*</label></li>
                <li><input type="text" class="required email" value="{$smarty.post.email}" id="email" name="email"></li>
                <li><button>Complete registration</button></li>
            </ul>
        </form>
    </div>
    <div class="col-xs-4 col-sm-12 ad-block">
        <h4>Become an affiliate</h4>
        <p>Earn additional money by placing an affiliate link to MediaWhiz SEO on your website. Set-up only takes 2 minutes!</p>
        <p><a href="{$_config.www}/register.php" title="Join Now">Join Now!</a>
    </div>

    <div class="col-xs-4 col-sm-12 fanpagefacebook">

    <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FFacebookDevelopers&amp;width=245&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:245px; height:258px;" allowTransparency="true"></iframe>
    </div>
</div>
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery.validator.messages.required = "";
            jQuery("#quickRegister").validate();
        })
    </script>
{/literal}