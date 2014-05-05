<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="{$template_dir}/css/style.css" />
<link rel="stylesheet" href="{$template_dir}/css/nivo-style.css" type="text/css" />
{if $smarty.session.uid ne ''}
<link rel="stylesheet" href="{$template_dir}/css/base.css" type="text/css">
<link rel="stylesheet" href="{$template_dir}/css/lightbox.css" type="text/css">
<link rel="stylesheet" href="{$template_dir}/css/screen.css" type="text/css">
{/if}
<script type="text/javascript" src="{$template_dir}/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="{$template_dir}/js/jquery.nivo.slider.js"></script>
{literal}
<script>
var base_url ="http://localhost/textlinkvn";
var loc = "'"+this.location+"'";
loc = loc.substring(1, loc.lastIndexOf('/')+1);
</script>

<!--
<script src="{$_config.www}//js/ajax.js" type="text/javascript" language="javascript"></script>
<script src="{$_config.www}//js/js.js" type="text/javascript" language="javascript"></script>
-->

{/literal}
<title>Textlink - Trang chủ</title>
</head>

<body>
<div class="container">
	<div class="container-inner">
    	{include file='header.tpl'}
		{include file='sub_header.tpl'}
		<!--head wrp-->
        <hr class="h" />
        {$content}
        <hr class="h" />
        {include file='footer.tpl'}
		<!--Foot wrp-->
    </div><!--container-inner-->
</div><!--contaner-->

</body>
</html>
