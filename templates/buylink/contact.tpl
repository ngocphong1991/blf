<div class="wrapper paper">
    <div class="container">
        <div class="row cms-page">
            <h4>CONTACT WITH BUYLINK</h4>
            <div class="row">
                <iframe style="width: 100%; margin: 20px 0" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=vi&amp;geocode=&amp;q=s%E1%BB%91+1,+%C4%91%C6%B0%E1%BB%9Dng+o,+m%E1%BB%B9+giang+2,+t%C3%A2n+phong+qu%E1%BA%ADn+7,+h%E1%BB%93+ch%C3%AD+minh&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=60.54737,135.263672&amp;ie=UTF8&amp;hq=&amp;hnear=M%E1%BB%B9+Giang+2B,+T%C3%A2n+Phong,+Qu%E1%BA%ADn+7,+H%E1%BB%93+Ch%C3%AD+Minh,+Vi%E1%BB%87t+Nam&amp;t=m&amp;ll=10.722936,106.71587&amp;spn=0.040479,0.054932&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
                <div class="row">
                    {if $msg_contact!=''}
                        <div class="message-error">{$msg_contact}</div>
                    {/if}
                    <form method="post" action="" class="form-horizontal" name="frm_contact" id="contactForm">
                        <fieldset>
                            <div class="control-group">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Full name <span>*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="col-sm-4 required" placeholder="Your full name" value="" id="name"  name="data[name]" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">Email <span>*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="col-sm-4 required email" placeholder="Your email" value="" id="email"  name="data[email]" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="subject" class="col-sm-3 control-label">Subject <span>*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="col-sm-4 required" placeholder="Subject" value="" id="subject"  name="data[subject]" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="body" class="col-sm-3 control-label">Content <span>*</span></label>
                                    <div class="col-sm-9">
                                        <textarea name="data[body]" rows="10" id="body" class="col-sm-6 required" placeholder="Content"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <input type="hidden" name="action" value="submit" />
                                        <button class="submit button blue jquery-corner">Send</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery.validator.messages.required = "";
        jQuery('#contactForm').validate();
    })
</script>
{/literal}