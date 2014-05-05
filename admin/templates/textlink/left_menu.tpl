{if $smarty.session.admin_uid neq ''}
<div id="sidebar" >
      <h1>Main Menu</h1>
      <ul class="sidemenu style38">   
      	<li><a href="../admin/"><strong>Home</strong></a></li>
		<!--
        <li><a href="../admin/?new_acc"><strong>Approvals</strong></a></li>
        <li><a href="../admin/?tips"><strong>{$_config.website_name} {$_lang.tips}  </strong></a></li>
		-->
        <li><a href="../admin/?cat"><strong>{$_lang.prod_cats}</strong> </a></li>
        <li><a href="../admin/?lang"><strong>{$_lang.langs}</strong> </a></li>		
        <li><a href="../admin/?size"><strong>Ad Layout Size/Length</strong> </a></li>		
        <li><a href="../admin/?stat"><strong>Website Stats </strong></a></li>
        <li><a href="../admin/?money"><strong>Money Page </strong></a></li>
        <li><a href="../admin/?newsl"><strong>Newsletter</strong></a></li>
        <li><a href="../admin/?featured"><strong>Featured Retailers </strong></a></li>
        <li><a href="../admin/?rates"><strong>Pay Rates </strong></a></li>
	    <li><a href="../admin/?acc"><strong>User Accounts </strong></a></li>
	    <li><a href="../admin/?credit"><strong>Credit User Accounts </strong></a></li>
	    <li><a href="../admin/?pref"><strong>{$_lang.sys_pref}</strong></a></li>
	    <li><a href="../admin/?pass"><strong>Admin Password </strong></a></li>
        <li><a href="../admin/?logout"><strong>Logout</strong></a></li>
      </ul>
      <h1>&nbsp;</h1>
    </div>
{/if}	