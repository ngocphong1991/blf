<div class="wrapper container">
    <div class="container">
        <div class="row inner-content">
            {include file='left-menu-user.tpl'}
            <div class="col-sm-9 right-content">
                <h4>JOIN THOUSANDS OF OTHER USERS</h4>
                <form class="form-horizontal" method="post" action="" id="registerForm" name="registerForm">
                    <fieldset class="user-type">
                        <div class="control-group">
                            <p class="note"><span>Can be changed later!</span></p>
                            <h5>Choose Your Account Type</h5>
                            <div class="row">
                                <div class="one col-sm-4 col-xs-4">
                                    <label class="active" for="type_0">
                                        <input type="radio" checked="checked" id="type_0" value="adv" name="type">
                                        Advertiser
                                    </label>
                                    <p>Buy ads and improve your natural search engine ranking</p>
                                </div>
                                <div class="one col-sm-4 col-xs-4">
                                    <label for="type_1">
                                        <input type="radio" id="type_1" value="pub" name="type">
                                        Publisher
                                    </label>
                                    <p>Sell simple text link ads on your website and make money</p>
                                </div>
                                <div class="one col-sm-4 col-xs-4">
                                    <label for="type_3">
                                        <input type="radio" id="type_3" value="pub+adv" name="type">
                                        Advertiser + Publisher
                                    </label>
                                    <p>Buy ads from other websites and sell text link ads on your owner site.</p>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="user-detail">
                        <div class="control-group">
                            <h5>Your personal details</h5>
                            {if isset($msg)}<div class="message-error">{$msg}</div>{/if}
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-3 control-label" for="firstName">First & Last Name <span>*</span></label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" id="firstName" style="margin-right: 5px" name="firstName" value="{$smarty.post.firstName}" class="col-sm-4 col-xs-5 required">
                                    <input type="text" id="lastName" name="lastName" value="{$smarty.post.lastName}" class="col-sm-4 col-xs-5 required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-3 control-label" for="username">User name <span>*</span></label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="col-sm-4 col-xs-5 required" id="username" name="username" value="{$smarty.post.username}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-3 control-label">
                                    <label class="" for="company">Company name</label>
                                    <p><span>(if applicable)</span></p>
                                </div>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="col-sm-4 col-xs-5" id="company" name="company" value="{$smarty.post.company}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-3 control-label" for="email">Email address<span>*</span></label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="col-sm-4 col-xs-5 required email" value="{$smarty.post.email}" id="email" name="email" />
                                </div>
                                <div class="col-sm-offset-3 col-xs-offset-3 col-sm-9 col-xs-9">
                                    <p>MediaWhiz SEO Privacy Pollicy: Your email address will not be sold or rented to ANYBODY</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-3 control-label" for="mobile">Phone </label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="col-sm-4 col-xs-5" value="{$smarty.post.mobile}" id="mobile" name="mobile" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-3 control-label">
                                    <label for="text_ad_pass">Password<span>*</span></label>
                                    <p><span>(twice to confirm)</span></p>
                                </div>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="password" style="margin-right: 5px" class="col-sm-4 col-xs-5 required password" id="text_ad_pass" name="text_ad_pass" />
                                    <input type="password" id="text_ad_pass2" equalto="#text_ad_pass" minlength="6"  name="text_ad_pass2" class="col-sm-4 col-xs-5 required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-3 control-label" for="address">Address<span>*</span></label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="col-sm-4 col-xs-5 required" value="{$smarty.post.address}" id="address" name="address" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-3 control-label" for="city">City<span>*</span></label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="col-sm-4 col-xs-5 required" id="city" value="{$smarty.post.city}" name="city" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-3 control-label" for="country">Country</label>
                                <div class="col-sm-9 col-xs-9">
                                    <select id="country" name="country"onchange="changeUserCountry(this);">
                                        {section name=i loop=$allCountry}
                                            <option value="{$allCountry[i].countrysel}" {if $allCountry[i].countrysel==218}selected="selected"{/if}>{$allCountry[i].country}</option>
                                        {/section}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-3 control-label" for="state">State or Province<span>*</span></label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="col-sm-4 col-xs-5 required" value="{$smarty.post.state}" id="state" name="state" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-3 control-label" for="zip">Zip<span>*</span></label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="col-sm-4 col-xs-5 required" id="zip" value="{$smarty.post.zip}" name="zip" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-xs-offset-3 col-sm-9 col-xs-9">
                                    <button class="submit button blue jquery-corner">Create my Account now</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    {literal}
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery.validator.messages.required = "";
            jQuery("#registerForm").validate();
        });
    </script>
    {/literal}
</div>