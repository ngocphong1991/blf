<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">        
        <tr>
          <td class="style39"><h1><span class="green">User Manager</span></h1></td>
        </tr>
      </table>	  
      <table width="100%" border="0" align="center" style="min-width:869px">      
        <tr>
		<form action="" method="get" name="frm_coupon">
		<div style="text-align: left; background: #fff" class="frm_search">
			Username:
			<input type="text" value="" name="keyword"> 
		   
			<input type="submit" value="Find">
			</form>
		 </div>
          <td width="100%"><div class="splitleft">		  
            <div class="box">
              <div align="left">
			     <form action="" method="post" name="frm_bank">
                 <table class="tbl-list" id="lst-submit-url">
                    <tr style="font-weight: bold">
                        <td width="28">ID</td>
                        <td>Username</td>
                        <td>Full name</td>
                        <td>Mobile</td>
                        <td>Email</td>
                        <td>Type</td>
                        <td>Adv Money</td>
                        <td>Pub Money</td>
						<td>Affiliate Earnings</td>
                    </tr>
                    {section name=i loop=$all_user}
                    <tr>
                        <td>{$all_user[i].uid}</td>
                        <td><strong><a href="pay-session.php?uid={$all_user[i].uid}">{$all_user[i].username}</a></strong></td>
                        <td>{$all_user[i].fullname}</td>
                        <td>{$all_user[i].phone}</td>
                        <td><a title="Add Coupon TextLink card" href="/admin/coupon-card.php?uid={$all_user[i].uid}">{$all_user[i].email}</a></td>
                        <td>{$all_user[i].utype}</td>
                        <td>${$all_user[i].adv_money}</td>
                        <td>${$all_user[i].pub_money}</td>
						<td><a href="/admin/affiliateinfo.php?uid={$all_user[i].uid}">${$cls_ref_user->getAffiliateEarning($all_user[i].uid)}</a><br />
						<span style="color:#9EC630">Advertiser: ${$cls_ref_user->getAffiliateEarning($all_user[i].uid,'advertiser')}<br />
						Publisher: ${$cls_ref_user->getAffiliateEarning($all_user[i].uid,'publisher')}<br /></span>
						</td>
                    </tr>               
                    {/section}
                 </table>
                 </form>
                 <div class="paging" style="margin-top: 20px">
                    {section name=i loop=$paging}
                    <a title="{$paging[i][1]}" href="{$protocol}?page={$paging[i][0]}&keyword={$keyword}" class="{if $cursorPage==$paging[i][0]}btn3{else}btn2{/if}">{$paging[i][1]}</a>
                    {/section}
                 </div>
                 <script type="text/javascript" src="templates/default/js/jquery-1.7.1.min.js"></script>
                 <script type="text/javascript" src="templates/default/js/js_bank.js"></script>
                 
              </div>
            </div>
          </div></td>
        </tr>
      </table>      
</div>
{literal}
<style>
.smart-btn {display: inline-block}
</style>
{/literal}