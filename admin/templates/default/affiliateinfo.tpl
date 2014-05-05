<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">        
        <tr>
          <td class="style39"><h1><span class="green">Publisher Info Manager</span></h1></td>
        </tr>
      </table>	  
      <table width="100%" border="0" align="center" style="min-width: 869px"       
        <tr>
          <td width="100%"><div class="splitleft">
		  		
				<div class="box">
              	<div align="left">
				 <h4><span>Affiliate earnings:</span>USD {$affiliate_earnings.total}</h4>
				<p><span>From Publisher:</span> USD {$affiliate_earnings.publisher}</p>
				<p><span>Advertiser:</span> USD {$affiliate_earnings.advertiser}</p>
				<p><span>Refer coupon:</span> USD {$affiliate_earnings.refer_coupon}</p>
				</div></div>				
            <div class="box">
              <div align="left">			 
			   
                 </div>
                 <table class="tbl-list" id="lst-submit-url">
                    <tr style="font-weight: bold">
                        <td>User Affiliate (from: {$from_name})</td>
                        <td>User Type</td>
						<td>Full Name</td>
						<td width="250">Email</td>
                        <td>Phone</td>					
                    </tr>
                    {section name=i loop=$all_affiliateninfo}
                    <tr>                       
                        <td><a href="/admin/affiliateinfo.php?uid={$all_affiliateninfo[i].uid}">{$all_affiliateninfo[i].username}</a></td>			                    
                        <td>{$all_affiliateninfo[i].utype}</td>
						<td>{$all_affiliateninfo[i].fullname}</td> 
                        <td>{$all_publishersinfo[i].email}</td>                    
						<td>{$all_publishersinfo[i].phone}</td>  
                    </tr>                 
                    {/section}
                 </table>
                 </form>
                 <div class="paging" style="margin-top: 20px">
                    {section name=i loop=$paging}
                    <a title="{$paging[i][1]}" href="?page={$paging[i][0]}" class="{if $cursorPage==$paging[i][0]}btn3{else}btn2{/if}">{$paging[i][1]}</a>
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
.frm_search label {display: inline; margin: 0 8px 0 3px;}
</style>
{/literal}