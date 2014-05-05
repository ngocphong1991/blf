{if $smarty.session.admin_uid neq ''}
<div id="rightbar">
      <h1 align="center"> Quick Stats </h1>
      <table width="95%" border="0" cellpadding="2" cellspacing="1" class="tmain small">
        <tr class="trow2">
          <td colspan="3"></td>
        </tr>
        <tr class="trow2">
          <td colspan="3"><span class="style46">Info</span></td>
        </tr>
        <tr>
          <td width="129" ><span class="style47"><b>Server Time </b></span></td>
          <td align="right" class="trow1 style34 style47">{$smarty.now|date_format:"%H.%M"}</td>
        </tr>
        <tr>
          <td class="style47 trow1"><strong>Last Login </strong></td>
          <td align="right" nowrap="nowrap" class="trow1 style47">{$smarty.session.last_login|date_format:"%d/%m/%y %H.%M"}</td>
        </tr>
        <tr>
          <td colspan="2" class="trow1"><span class="style46">Users</span></td>
        </tr>
        <tr>
          <td ><span class="style47"><strong>User Accounts </strong></span></td>
          <td align="right" class="trow1 style34 style47">{$tu}</td>
        </tr>
        
        
        <tr>
          <td >&nbsp;</td>
          <td align="right" class="trow1 style34 style47">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" ><div align="center"><strong>-------------------</strong></div></td>
        </tr>
      </table>
      <p><br />
      </p>
    </div>
{/if}	