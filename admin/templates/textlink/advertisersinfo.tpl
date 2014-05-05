<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">        
        <tr>
          <td class="style39"><h1><span class="green">Advertisersinfo Manager</span></h1></td>
        </tr>
      </table>
	  
      <table width="100%" border="0" align="center" style="min-width: 869px">
        
        <tr>
          <td width="100%"><div class="splitleft">
		  
            <div class="box">
              <div align="left">
			     <form action="" method="get" name="frm_bank">
                 <div class="frm_search" style="padding: 20px 0; text-align: center; background: #fff">
                    <label>User </label>
                    <input type="text" name="keyword" value="{$keyword}" />
                    <label>Approved</label>
                    <select name="approved">
                        <option {if $approved==''}selected="selected"{/if} value="">All</option>
                        <option {if $approved=='Y'}selected="selected"{/if} value="Y">Active</option>
                        <option {if $approved=='N'}selected="selected"{/if} value="N">Pending</option>
                    </select>
                    <label>Auth</label>
                    <select name="auth">
                        <option {if $auth==''}selected="selected"{/if} value="">All</option>
                        <option {if $auth=='Y'}selected="selected"{/if} value="Y">Yes</option>
                        <option {if $auth=='N'}selected="selected"{/if} value="N">No</option>
                    </select>
					  <label>Is Manual</label>
                    <select name="is_manual">
                        <option {if $is_manual==''}selected="selected"{/if} value="">All</option>
                        <option {if $is_manual=='Y'}selected="selected"{/if} value="Y">Yes</option>
                        <option {if $is_manual=='N'}selected="selected"{/if} value="N">No</option>
                    </select>
					
                    <label>Paid</label>
                    <select name="paid">
                        <option {if $paid==''}selected="selected"{/if} value="">All</option>
                        <option {if $paid=='Y'}selected="selected"{/if} value="Y">Yes</option>
                        <option {if $paid=='N'}selected="selected"{/if} value="N">No</option>
                    </select>
					
					 <label>Today</label>
                    <select name="today">
                        <option {if $today==''}selected="selected"{/if} value="">All</option>
                        <option {if $today=='Y'}selected="selected"{/if} value="Y">Yes</option>
                        <option {if $today=='N'}selected="selected"{/if} value="N">No</option>
                    </select>
                    <input type="submit" value="Find" />
                 </div>
                 <table class="tbl-list" id="lst-submit-url">
                    <tr style="font-weight: bold">
                        <td>User</td>
                        <td>Pub User</td>
                        <td width="300">Ad Text</td>
						<td align="center">On Site</td>                        
                        <td width="60" align="center">State</td>
						<td width="50" align="center">Approved</td>
                        <td width="50" align="center">Auth</td>
                        <td width="10" align="center">Paid</td>
                    </tr>
                    {section name=i loop=$all_advertisersinfo}
                    <tr style="border-bottom:2px solid #FFFFFF">
                        <td>{$cls_user->getUserName($all_advertisersinfo[i].uid)}</td>
                        <td>{$cls_user->getUserName($all_advertisersinfo[i].pub_uid)}</td>
                        <td><b>{$all_advertisersinfo[i].ad_before} <a target="_blank" href="{$all_advertisersinfo[i].ad_url}">{$all_advertisersinfo[i].ad_des}</a> {$all_advertisersinfo[i].ad_after}</b><br />
						    Start date / End date:{$all_advertisersinfo[i].start_date} / {$all_advertisersinfo[i].end_date}<br />
							Sale price: ${$all_advertisersinfo[i].price}<br />
						</td>
						<td align="center"><a target="_blank" href="{$cls_Publishersinfo->getPublisherUrl($all_advertisersinfo[i].pid)}">{$cls_Publishersinfo->getPublisherUrl($all_advertisersinfo[i].pid)}</a><br />
						Add type: {if $cls_Publishersinfo->getPublisherInfo($all_advertisersinfo[i].pid,'is_manual')=='Y'} Manual {else} Regular {/if}<br />
						Buying date: {$all_advertisersinfo[i].buying_date}
						</td>                   
                        <td align="center"><span style="color:#4D90FE">{if $all_advertisersinfo[i].is_paid=='Y' && $all_advertisersinfo[i].is_auth=='Y'}Earnling {else} Pending {/if}</span></td>
						<td align="center">{$all_advertisersinfo[i].approved}</td>
						
                        <td align="center">{$all_advertisersinfo[i].is_auth} {if $all_advertisersinfo[i].is_auth=='Y'}<a class="smart-btn btn-show" href="../admin/advertiserinfo.php?auth={$all_advertisersinfo[i].adv_id}&action=cancel">Cancel</a>{else} <a class="smart-btn btn-show" href="../admin/advertiserinfo.php?auth={$all_advertisersinfo[i].adv_id}&action=active">Active</a>{/if}</td>
                        <td align="center" accesskey="{$all_advertisersinfo[i].adv_id}">{$all_advertisersinfo[i].is_paid}<a onclick="javascript:click_refund({$all_advertisersinfo[i].adv_id}, {$all_advertisersinfo[i].price})" class="smart-btn btn-refunds">Refund</a></td>
                    </tr>					          
                    {/section}
                 </table>
                 </form>
                 <div class="paging" style="margin-top: 20px">
                    {section name=i loop=$paging}
                    <a title="{$paging[i][1]}" href="?keyword={$keyword}&approved={$approved}&paid={$paid}&auth={$auth}&today={$today}&is_manual={$is_manual}&page={$paging[i][0]}" class="{if $cursorPage==$paging[i][0]}btn3{else}btn2{/if}">{$paging[i][1]}</a>
                    {/section}
                 </div>
                 <script type="text/javascript" src="templates/default/js/jquery-1.7.1.min.js"></script>                 
                 <script type="text/javascript" src="templates/default/js/script.js"></script>              
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