<script>
    var id = {$id_active};
</script>
{literal}
<script type="text/javascript">
$(document).ready(function(){
	
	$(".toggle_container").hide();

	$("h2.trigger").click(function(){
		$(this).toggleClass("active").next().slideToggle("slow");
	});    
    $('#trigger-'+id).click();
});
</script>
{/literal}
<div class="wrapper paper">
    <div class="container">
        <div class="row cms-page">
            <h4>FAQ</h4>
            <div class="row">
                <div class="alert-danger alert">The data is being updated. Please connect later!</div>
                <div class="right">
                    {section name=i loop=$item_cat}
                        <h3 class="sub">{$item_cat[i].Title}</h3>
                        {assign var=listChild value=$class_news->get_from_cat($item_cat[i].Id)}
                        <div class="faq-list">
                            {section name=k loop=$listChild}
                                {if $smarty.section.k.first}{else}<hr class="dot-line" />{/if}
                                <h2 class="trigger" id="trigger-{$listChild[k].Id}"><a name="ques-{$listChild[k].Id}" href="#ques-{$listChild[k].Id}" onclick="return false;">{$listChild[k].Title}</a></h2>
                                <div style="display: none;" class="toggle_container" id="toggle_container-{$listChild[k].Id}">
                                    <div class="block">
                                        <p>{$listChild[k].Content}</p>
                                    </div>
                                </div>
                            {/section}
                        </div>
                    {/section}
                </div>
            </div>
        </div>
    </div>
</div>