<div class="wrapper paper">
    <div class="container">
        <div class="row inner-content">
            {include file='left-menu.tpl'}
            <div class="col-sm-9 right-content-paper plus">
                <div class="banner">
                    <img src="{$template_dir}/images/ad.png">
                </div>
                <div class="right-inner">
                    <h4 class="border-bold super-bold">Lịch sử rút tiền</h4>
                    <table class="table table-striped">
                        <thead>
                            <th width="15%"><b>Số Tiền (USD)</b></th>
                            <th width="15%"><b>Ngày Rút</b></th>
                            <th width="10%"><b>Ngày Trả</b></th>
                            <th width="35%"><b>Bank/PayPal</b></th>
                            <th width="10%"><b>Tình Trạng</b></th>
                            <th width="20%"><b>Mã Số</b></th>
                        </thead>
                        <tbody>
                        {section name=i loop=$all_withdraw}
                            <tr>
                                <td><strong>{$all_withdraw[i].money} USD</strong></td>
                                <td>{$all_withdraw[i].withdraw_date}</td>
                                <td>{$all_withdraw[i].pay_date}</td>
                                <td> {if $all_withdraw[i].method == '1'} PayPal: email {$all_withdraw[i].email_paypal}
                                    {else} VN Bank (Name:{$all_withdraw[i].name_card} | Card Number: {$all_withdraw[i].number_card} | Name of Bank: {$all_withdraw[i].name_bank}){/if} </td>
                                <td> <strong>{if $all_withdraw[i].status == '1'} Đã trả {else} Đang chờ {/if}</strong> </td>
                                <td>{$all_withdraw[i].code}</td>
                            </tr>
                        {/section}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>