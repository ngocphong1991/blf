
<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">

        <tr>
          <td class="style39"><h1><span class="green">Admin user Manager</span></h1></td>
        </tr>
      </table>

      <table width="100%" border="0" align="center" style="min-width: 869px">

        <tr>
          <td width="100%"><div class="splitleft">

            <div class="box">
              <div align="left">
			    {if $smarty.get.action == 'view'}

				<table class="tbl-list" id="lst-submit-url">
				 <tr>
					<td> <label>Title </label></td><td>{$new_info.Title}</td>
				</tr>
				<tr>
					<td> <label>Intro </label></td><td>{$new_info.Intro}</td>
				</tr>
				<tr>
					<td> <label>Conten </label></td><td>{$new_info.Content}</td>
				</tr>
                 </table>
				{else}
				<span style="color:red"> {$msn} </span>
				<form action="" method="post" name="frm_post">
				<input type="hidden" value="1" name="create_admin" />

				{if $smarty.get.uid >0}
				{else}
				<input type="hidden" name="action" value="insert" />
				{/if}

			 	<table class="tbl-list" id="lst-submit-url">
				<tr>
					<td> <label>Username </label></td><td><input type="text" style="width:300px" id="user" name="user" value="{$admin_info.user}" /></td>
				</tr>
				<tr>
					<td> <label>Password </label></td><td><input type="text" style="width:300px"  id="pass" name="pass" value="{$admin_info.pass}" /></td>
				</tr>
				<tr>
					<td> <label>User type </label></td><td>
					<select id="filterLanguage" name="utype" class="txt2" onchange="">
					<option selected="selected" value="2">Mod</option>
					<option value="1">Admin</option>
		            </select>
					</td>
				</tr>
				<tr>
					<td> <label>Email </label></td><td><input type="text" style="width:300px"  id="email" name="email" value="{$admin_info.email}" /></td>
				</tr>
				<tr>
				<td></td><td><input type="submit" class="smart-btn btn-show" value="Submit" style="float:right" /></td>
				</tr>
                 </table>
                 </form>
				  <table class="tbl-list" id="lst-submit-url">
                    <tr style="font-weight: bold">
						<td width="30">No</td>
                        <td>User name</td>
                        <td>Email</td>
						<td>User Type</td>
						<td>Action</td>
                    </tr>
				  {section name=i loop=$list_all}
				   <tr>
                        <td>{$list_all[i].uid}</td>
                        <td>{$list_all[i].user}</td>
                        <td>{$list_all[i].email}</td>
						<td>{if $list_all[i].utype==1} Admin {else} Mod {/if}</td>
						<td>{$list_all[i].utype}</td>
						<td> <a href="?uid={$list_all[i].uid}&action=edit" class="smart-btn btn-openfrm btn-pay-atm-conf-yes">Edit</a>
						 <a href="?uid={$list_all[i].uid}&action=delete" class="smart-btn btn-openfrm btn-pay-atm-conf-yes">Del</a></td>
                    </tr>
				  {/section}
				  </table>


                 <script type="text/javascript" src="templates/default/js/jquery-1.7.1.min.js"></script>
                 <script type="text/javascript" src="templates/default/js/js_bank.js"></script>
                 {/if}
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