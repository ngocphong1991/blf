<!-- START THE HEADER -->
<div class="header">
    <div class="container">
        <ul class="customer button blue jquery-corner">
            {if $smarty.session.uid ne ''}
            <li class="active"><a href="{$_config.www}/profile" title="My Account">My Account</a></li>
            <li><i class="ds"></i></li>
            <li><a href="{$_config.www}/account.php?logout=1" title="Logout">Logout</a></li>
            {else}
            <li class="active"><a href="{$_config.www}/register.php" title="SignUp">SignUp</a></li>
            <li><i class="ds"></i></li>
            <li><a href="{$_config.www}/account.php" title="Login">Login</a></li>
            {/if}
        </ul>
        <ul class="nav nav-pills pull-right play-block">
            <li class="active"><a title="Home" href="{$_config.www}"><i class="icon-home"></i></a></li>
            <li><i class="ds"></i></li>
            <li><a title="1900 6891" href="#"><i class="icon-call"></i>1900 6891</a></li>
            <li><i class="ds"></i></li>
            <li><a title="Contact us" href="{$_config.www}/contact"><i class="icon-contact"></i>Contact us</a></li>
        </ul>
        <h3><a href="{$_config.www}" title="Home page"><img src="{$template_dir}/images/logo.png" alt="TextlinkVN"></a></h3>
    </div>
</div>
<!-- /END THE HEADER -->

<!-- START THE MENU TOP -->
<div class="tl-masthead">
    <div class="container">
        <nav class="tl-nav">
            <a href="{$_config.www}/advertisers" title="Advertisers" class="tl-nav-item active advertisers">Advertisers <i class="icon-advertisers"></i></a>
            <a href="{$_config.www}/publishers" title="Publishers" class="tl-nav-item publishers">Publishers <i class="icon-publishers"></i></a>

            <div style="float: right;padding-top: 5px">
               <a target="_blank" href="http://www.facebook.com/sharer.php?u={$_config.www}"><img src="{$template_dir}/images/iconfacebook.png"></a>
               <a target="_blank" href="https://twitter.com/share"><img src="{$template_dir}/images/icontwitter.png"></a>
               <a target="_blank" href="https://plus.google.com/share?url={$_config.www}"><img src="{$template_dir}/images/icongoogle.png"></a>

            </div>
            <!--
            <a href="#" title="Agencies" class="tl-nav-item agencies">Agencies <i class="icon-agencies"></i></a>
            -->
        </nav>
    </div>
</div>
<!-- /END THE MENU TOP -->