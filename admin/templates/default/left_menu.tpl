{if $smarty.session.admin_uid neq ''}
<div id="sidebar" >
      <h1>Main Menu</h1>
      <ul class="sidemenu style38">   
      	<li><a href="../admin/"><strong>Home</strong></a></li>
		
        <li><a href="../admin/?new_acc"><strong>Approvals</strong></a></li>
		
		<li><a href="../admin/payouts.php"><strong>Payouts</strong> </a></li>	
       
		<!--
        <li><a href="../admin/?tips"><strong>{$_config.website_name} {$_lang.tips}  </strong></a></li>
		-->
		<li><a href="../admin/?lang"><strong>{$_lang.langs}</strong> </a></li>	
		
		<li><a href="../admin/advertiserinfo.php"><strong>Advertiser Info</strong> </a></li>
		
		<li><a href="../admin/publisherinfo.php"><strong>Publisher Info</strong> </a></li>
			  
        <li><a href="../admin/?cat"><strong>{$_lang.prod_cats}</strong> </a></li>
        
		<li><a href="../admin/coupon.php"><strong>Coupon code</strong> </a></li>	
		
		<li><a href="../admin/coupon-card.php"><strong>Coupon TextLink card</strong> </a></li>			
  
        <li><a href="../admin/pay_rates.php?rates"><strong>Pay Rates </strong></a></li>
        
        <li><a href="../admin/tracking_order.php"><strong>Payment</strong></a></li>
        
        <li><a href="../admin/user.php"><strong>User Manage</strong></a></li>
	  
	 	<li><a href="../admin/news.php"><strong>News</strong> </a></li>
		
		<li><a href="../admin/submit_url.php"><strong>Submit URL</strong></a></li>
		
		<li><a href="../admin/admin.php"><strong>Admin manage </strong></a></li>
		
	    <li><a href="../admin/?pass"><strong>Admin Password </strong></a></li>

        <li><a href="../admin/config.php"><strong>Configuration </strong></a></li>
		
        <li><a href="../admin/?logout"><strong>Logout</strong></a></li>
      </ul>
      <h1>&nbsp;</h1>
    </div>
{/if}	