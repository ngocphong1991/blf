<div id="main">
    <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
    <table width="100%" border="0">

        <tr>
            <td class="style39"><h1><span class="green">Pay Card Manager</span></h1></td>
        </tr>
    </table>

    <table width="100%" border="0" align="center" style="min-width: 769px">

        <tr>
            <td width="100%"><div class="splitleft">

                    <div class="box">
                        <div align="left">
                            {if $smarty.get.update}
                                <div style="padding: 20px; background: #DFF0D8; color: #3C763D; font-size: 14px; border-radius: 5px; margin: 10px 5px">Update successful !</div>
                            {else}
                                <div style="padding: 15px; border: 1px solid ##EBCCD1; background: #EBCCD1; color: #A94442; font-size: 14px; border-radius: 5px; margin: 10px 5px 30px">
                                    <p><b>Warning !</b></p> <p>This is information very importance of website. If you don't understand it. Please not change anything!</p>
                                </div>
                            {/if}
                            <form action="" method="post">
                            <table width="100%" cellspacing="1" cellpadding="5" border="0">
                                {foreach from=$config key=k item=v}
                                <tr>
                                    <td width="30%" class="td"><b>{$k|replace:'_':' '|upper}</b></td>
                                    <td class="td"><input name="{$k}" type="text" size="40" class="effect" id="new_pass2" value="{if $k == 'template' && $v=='default'}buylink{else}{$v}{/if}" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                {/foreach}
                                <tr>
                                    <td class="td"><div align="right">
                                            <button>Update</button>
                                        </div></td>
                                    <td class="td">&nbsp;</td>
                                </tr>
                            </table>
                            </form>
                        </div>
                    </div>
                </div></td>
        </tr>
    </table>

</div>