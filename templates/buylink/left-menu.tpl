<!-- START THE SLIDER -->
<div class="col-sm-3 left-slider except no-padding">
    <div class="menu-block">
        <ul class="menu-left-wrap">
            <li class="menu-level-1">
                <h5>Mua quảng cáo</h5>
                <ul>
                    <li {if $module_name == 'marketplace'}class="menu-active"{/if}><a href="{$_config.www}/marketplace" title="Mua BuyLink">Mua BuyLink</a></li>                    
                    <!--
                    <li {if $module_name == 'buyalink'}class="menu-active"{/if}><a href="{$_config.www}/buyalink" title="Mua lẻ Article Link">Mua lẻ Article Link</a></li>
                    <li {if $module_name == 'buyarelink'}class="menu-active"{/if}><a href="{$_config.www}/buyarelink" title="Mua gói Article Link">Mua gói Article Link</a></li>
                    -->
                </ul>
            </li>
            <!--
            <li class="menu-level-1">
                <h5>Công cụ SEO</h5>
                <ul>
                    <li><a href="#" title="BUYLINK SEO APP">BUYLINK SEO APP</a></li>
                    <li {if $module_name == 'checklevel'}class="menu-active"{/if}><a href="{$_config.www}/checklevel" title="KT thứ hạng từ khóa">KT thứ hạng từ khóa</a></li>

                </ul>
            </li>-->
            <li class="menu-level-1">
                <h5>Quản lý quảng cáo</h5>
                <ul>
                    <li {if $module_name == 'links'}class="menu-active"{/if}><a href="{$_config.www}/links" title="Quản lý Buylink">Quản lý Buylink</a></li>

                  <!--  <li {if $module_name == 'managearticlelink'}class="menu-active"{/if}><a href="{$_config.www}/managearticlelink" title="Quản lý Buylink">Quản lý Article Link</a></li>
                    <li {if $module_name == 'manage-group-buylink'}class="menu-active"{/if}><a href="{$_config.www}/manage-group-buylink" title="Quản lý Nhóm Buylink">Quản lý Nhóm Buylink</a></li>
                    <li {if $module_name == 'weblike'}class="menu-active"{/if}><a href="{$_config.www}/weblike" title="Quản lý Nhóm Buylink">Website ưa thích</a></li>
                  -->
                </ul>
            </li>
            <li class="menu-level-1">
                <h5>Quản lý tài khoản</h5>
                <ul>
                    <li {if $module_name == 'profile' &&  $page == ''}class="menu-active"{/if}><a href="{$_config.www}/profile" title="Thông tin tài khoản">Thông tin tài khoản</a></li>
                    <li {if $module_name == 'profile' &&  $page == 'history'}class="menu-active"{/if}><a href="{$_config.www}/profile?page=history" title="Lịch sử giao dịch">Lịch sử giao dịch</a></li>
                    <li {if $module_name == 'payment'}class="menu-active"{/if}><a href="{$_config.www}/payment" title="Nạp tiền">Nạp tiền</a></li>
                    <li {if $module_name == 'admoney-card.php'}class="menu-active"{/if}><a href="{$_config.www}/admoney-card.php" title="Nạp tiền từ coupon">Nạp tiền từ coupon</a></li>
                    <li {if $module_name == 'profile' &&  $page == 'transfer'}class="menu-active"{/if}><a href="{$_config.www}/profile?page=transfer" title="Chuyển tiền">Chuyển tiền</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>