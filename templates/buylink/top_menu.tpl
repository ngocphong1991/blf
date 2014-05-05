			<li {if $cp == 'index.php'}id="current"{/if}><a href="index.php"><span>{$_lang.Home}</span></a></li>
			<li {if $cp == 'browse.php' || $cp == 'buy_ads.php' || $cp == 'website_page.php'}id="current"{/if}><a href="browse.php"><span>{$_lang.Browse_Ads} </span></a></li>
			<li {if $cp == 'register.php' || $cp == 'seller_mywebsites.php'} id="current" {/if}><a href="seller_mywebsites.php"><span>{$_lang.Sell_Ads} </span></a></li>
			<li {if $cp=='account.php'} id="current"{/if}><a href="account.php"><span>{$_lang.My_Account} </span></a></li>
			<li {if $cp=='cart.php'} id="current"{/if}><a href="cart.php"><span>{$_lang.View_Cart} <img  src="{$template_dir}/images/shopping_cart.gif" alt="sc" width="15" height="13" hspace="0" vspace="0" border="0" align="absmiddle" class="no_class" /></span></a></li>
