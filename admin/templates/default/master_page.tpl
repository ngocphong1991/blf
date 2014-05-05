<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>{$_config.website_name}</title>
<link rel="stylesheet" href="{$template_dir}/css/textlink.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="{$template_dir}/css/tabcontent.css" />

{literal}
<script>
var loc = "'"+this.location+"'";
loc = loc.substring(1, loc.lastIndexOf('/')+1);
var base_url = "http://textlink.vn/admin/";
</script>
{/literal}

{if $colorpop_js == 'Y'}
<script language="javascript" src="../js/colorpop.js"></script>
{/if}
{if $tabcontent == 'Y'}
<script language="javascript" src="tabcontent.js"></script>
{/if}
{if $swf_object == 'Y'}
<script language="javascript" src="../js/container.js"></script>
{/if}
{if $number_format_js == 'Y'}
<script language="javascript" src="../js/number_format.js"></script>
{/if}


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{literal}
<style type="text/css">
<!--
body,td,th {
	font-size: 11px;
}
.style25 {	color: #FE9B37;
	font-weight: bold;
}
.style26 {	color: #FE9A36;
	font-weight: bold;
}
.style27 {font-size: 1.7em}

.style30 {
	color: #7594C0;
	font-weight: bold;
}
.style31 {
	font-size: 11px;
	color: #4284B0;
}
.style32 {
	font-size: 12px;
	font-weight: bold;
}
.style35 {color: #003366}


-->
</style>
{/literal}
</head>

<body>
<div id="wrap">
	
	<div id="header">				
			
		{include file='header.tpl'}
			
		
		
													
  </div>	
				
	
<div id="content-wrap">
	  {include file='left_menu.tpl'}
			
		{$content}	
			
		<!--{if $right_panel ne 'off'}{include file='right_panel.tpl'}{/if}-->
			
			
  </div>

	
    {include file = 'footer.tpl'}

	

</div>

</body>
</html>
