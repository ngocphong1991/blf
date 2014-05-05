<div id="rightbar"> {if $show_alexa_gpr=='Y'}
  <h1> {$_lang.Best_Buys} </h1>
  <table width="95%" border="0" cellpadding="2" cellspacing="1" class="tmain small">
    <tr class="trow2">
      <td colspan="2"></td>
    </tr>
    <tr class="trow2">
      <td colspan="2"><span class="style32">{$_lang.Highest_Alexa_Rankings} </span></td>
    </tr>
    <tr class="trow2">
      <td></td>
      <td align="right" colspan="2"><span class="style32">{$_lang.Rank}</span>&nbsp;</td>
    </tr>
   {section name=num loop=$alexa_top} 
    <tr>
      <td ><a href="website_page.php?pid={$alexa_top[num].pid}" class="style28 style31" title="{$alexa_top[num].wname}"><b>
      
      {$alexa_top[num].wname|truncate:9:"..":true}
      
      </b></a></td>
      <td align="right" class="trow1 style34">{$alexa_top[num].a_rank}</td>
    </tr>
	{/section}
    <tr>
      <td class="trow1">&nbsp;</td>
      <td class="trow1" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="trow1"><span class="style32">{$_lang.Highest_Google_Pagerank} </span></td>
    </tr>
    <tr>
      <td class="trow1">&nbsp;</td>
      <td align="right" class="trow1"><span class="style32">PR</span></td>
    </tr>
    {section name=num loop=$google_top} 
    <tr>
      <td ><a href="website_page.php?pid={$google_top[num].pid}" class="style28 style31" title="{$google_top[num].wname}"><b>
      
      {$google_top[num].wname|truncate:9:"..":true}
      
      </b></a></td>
      <td align="right" class="trow1 style34">{$google_top[num].g_rank}</td>
    </tr>
	{/section}
  </table>
  {/if}
  
  
  {if $smarty.session.uid ne ''}
  {if $show_alexa_gpr!='Y'}
  <h1 align="center">{if $smarty.session.show_pub_stat=='Y'}{$_lang.Publisher}{else}{$_lang.Advertiser}{/if} {$_lang.Stats} </h1>
  {if $smarty.session.utype=='pub+adv'}
  <div align="center" class="style48"><a href="account.php?toggle_stat">({$_lang.Show} {if $smarty.session.show_pub_stat=='Y'}{$_lang.Advertiser}{else}{$_lang.Publisher}{/if} {$_lang.Stats})</a></div>
  {/if}
  <table width="95%" border="0" cellpadding="2" cellspacing="1" class="tmain small">
    <tr class="trow2">
      <td colspan="3"></td>
    </tr>
    <tr class="trow2">
      <td colspan="3"><span class="style46">{$_lang.Money}</span></td>
    </tr>
    <tr>
      <td width="141" ><span class="style47"><b>{$_lang.My_Balance} </b></span></td>
      <td width="40" align="right" class="trow1 style34 style47">{$CURRENCY}{$balance}</td>
    </tr>
    {if $smarty.session.utype == 'pub+adv'}
    <tr>
      <td ><span class="style47"><b>{$_lang.Earnings_Today}  </b></span></td>
      <td width="40" align="right" class="trow1 style34 style47">{$earningsToday}</td>
    </tr>
    {/if}
    <tr>
      <td class="trow1 style47">&nbsp;</td>
      <td align="right" class="trow1 style47">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="trow1"><span class="style46">{$_lang.Ads}</span></td>
    </tr>
    <tr>
      <td ><span class="style47"><strong>{$_lang.Live_Ads}</strong></span></td>
      <td width="40" align="right" class="trow1 style34 style47">{$liveAds}</td>
    </tr>
    <tr>
      <td ><span class="style47"><strong>{$_lang.Ads_Pending} </strong></span></td>
      <td width="40" align="right" class="trow1 style34 style47">{$pendingAds}</td>
    </tr>
    <tr>
      <td ><span class="style47"><b>{$_lang.Clicks_Today} </b></span></td>
      <td width="40" align="right" class="trow1 style34 style47">{$clicksToday}</td>
    </tr>
    <tr>
      <td >&nbsp;</td>
      <td align="right" class="trow1 style34 style47">&nbsp;</td>
    </tr>
    
	{if $smarty.session.show_pub_stat == 'Y'}
	
	<tr>
      <td ><span class="style46">{$_lang.Your_Websites} </span></td>
      <td align="right" class="trow1 style34 style47">&nbsp;</td>
    </tr>
    <tr>
      <td ><span class="style47"><strong>{$_lang.Websites_Listed} </strong></span></td>
      <td align="right" class="trow1 style34 style47">{$websiteListed}</td>
    </tr>
    <tr>
      <td ><span class="style47"><strong>{$_lang.Total_Ad_Products} </strong></span></td>
      <td align="right" class="trow1 style34 style47">{$totalAdProducts}</td>
    </tr>
	
	{/if}
	
  </table>
  {/if}
  <table width="95%" border="0" cellpadding="2" cellspacing="1" class="tmain small">
    <tr class="trow2">
      <td ><div align="center"><strong>-------------------</strong></div></td>
    </tr>
    <tr class="trow2">
      <td ><span class="style34"><strong>{$_lang.Welcome}, </strong>{$smarty.session.username} </span></td>
    </tr>
    <tr>
      <td class="trow1"><span class="style34"><strong>{$_lang.Quick_Stats} </strong></span></td>
    </tr>
    <tr>
      <td class="trow1 style34">{$_lang.You_have} <strong>{$smarty.session.liveAds}</strong> {$_lang.Ads_running}.</td>
    </tr>
    <tr>
      <td class="trow1 style34"><b>{$smarty.session.clicksToday}</b> {$_lang.Clicks_Today}.</td>
    </tr>
    <tr>
      <td class="trow1 style34"><strong>{$smarty.session.endingToday}</strong> {$_lang.Ads_Ending_Today}.</td>
    </tr>
    <tr>
      <td class="trow1"><a href="account.php?logout" class="style34">{$_lang.Logout}</a></td>
    </tr>
  </table>
  {/if} 
</div>
