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
                            <form action="" method="get" name="frm_search">
                                <div style="padding: 20px 0; text-align: center; background: #fff" class="frm_search">
                                    <label style="display: inline">Họ tên </label>
                                    <input type="text" value="{$smarty.get.fullname}" name="fullname">
                                    <label style="display: inline">Email</label>
                                    <input type="text" value="{$smarty.get.email}" name="email">
                                    <button>Find</button>
                                </div>
                                <table class="tbl-list" id="lst-submit-url">
                                    <tr style="font-weight: bold">
                                        <td width="35">UID</td>
                                        <td>Họ và tên</td>
                                        <td>Email</td>
                                        <td>Phone</td>
                                        <td>Số tiền</td>
                                        <td>Trạng thái</td>
                                        <td>Thời gian</td>
                                        <td></td>
                                    </tr>
                                    {section name=i loop=$tracking_info}
                                        <tr>
                                            <td>{$tracking_info[i].uid}</td>
                                            <td><strong>{$tracking_info[i].fullname}</strong></td>
                                            <td>{$tracking_info[i].email}</td>
                                            <td>{$tracking_info[i].phone}</td>
                                            <td>{$tracking_info[i].amount} {$tracking_info[i].currency_char}</td>
                                            <td>{if $tracking_info[i].error_text == '' && $tracking_info[i].payment_type == 1}Complete{else}{$tracking_info[i].error_text}{/if}</td>
                                            <td>{$tracking_info[i].date_order|date_format:"%d/%m/%Y - %H:%M"}</td>
                                            <td>

                                            </td>
                                        </tr>
                                    {/section}
                                </table>
                            </form>
                            <div class="paging" style="margin-top: 20px">
                                {section name=i loop=$paging}
                                    <a title="{$paging[i][1]}" href="http://textlink.vn/admin/pay-card.php?page={$paging[i][0]}" class="{if $cursorPage==$paging[i][0]}btn3{else}btn2{/if}">{$paging[i][1]}</a>
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