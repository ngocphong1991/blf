<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
	<title>For Sale on Textlink – {$list.url}</title>
	<meta name="description" content="Quick preview of website for sale on Flippa: noamdesign.com">
	<link rel="stylesheet" type="text/css" media="all" href="{$template_dir}/css/view-site.css">
	<link rel="stylesheet" type="text/css" media="all" href="{$template_dir}/css/screen.css">
	<link rel="stylesheet" type="text/css" media="all" href="{$template_dir}/css/cart.css">
	<script type="text/javascript" src="{$_config.www}/js/prototype.js"></script>
	<script type="text/javascript" src="{$_config.www}/js/lightbox.js"></script>
	<script type="text/javascript" src="{$_config.www}/js/global.js"></script>
	<meta name="robots" content="noindex, nofollow">	
	{literal}
	<!--[if IE ]>
	<style>
	div.stats {width:100px;}
	div.stats.wide {width:120px;}
	form#bidform{width:110px;}
	form#bidform input.bid{height:15px;margin-bottom:-1px}
	</style>
	<![endif]-->
	{/literal}
	<script>
	var base_url ="http://textlink.vn";
	var loc = "'"+this.location+"'";
	loc = loc.substring(1, loc.lastIndexOf('/')+1);
	</script>
  </head>  
  <body>
      <table class='default' height="100%" cellpadding="0" cellspacing="0" width="100%">
      <tbody><tr height="1%">
        <td class='price' style="top:0;width:100%">
          	<div id="sitebar">
				<a class="logo" target="_top" href="{$_config.www}/marketplace"><img height="48" src="{$template_dir}/images/logo.png" alt="Textlink - Buy and Sell Textlink"></a>			
				<div style="display:block; width:130px; float:left; margin-top:-5px">
					<a href="{$_config.www}/cart/" class="remove" style="text-decoration:none"> Mua ngay</a></div>
				<div style="display:block; float:left; padding-top:10px">
					<a href="#" onClick="addToCart(this, 'regular', {$list.pid}, '', '', ''); return false;"><img src="http://textlink.vn/templates/textlink/images/btn-add-cart.png" alt="Add to cart"></a></div>													
				<div class="statsbox">
					<a class="removeframe" rel="nofollow" href="{$site}" title="Remove Frame">
						<img src="{$template_dir}/images/close.png">
					</a>
						<div class="stats">
						<div>
							<strong>PageRank:</strong>{$list.google_page_rank} </div>
						<div>
							<strong>Alexa:</strong>{$list.alexa_rank}</div>
					</div>
						<div class="stats wide" style="width:180px">
						<div>
							<strong>Domain age:</strong>{$list.domain_age}</div>
						<div>
							<strong>Price:</strong> USD {$list.sale_price}	</div>
					</div>
				</div>
			</div>
        </td>
      </tr>
      <tr>
        <td>
          <iframe sandbox="allow-scripts" id="rf" src="{$list.url}" allowtransparency="true" style="width:100%;height:100%" frameborder="0" scrolling="auto"></iframe>
        </td>
      </tr>
    </tbody></table>
</body></html>