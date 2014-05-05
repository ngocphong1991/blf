



function updateProposal(url)
{
	new Ajax.Request("/user.ajax.php", {

		onSuccess : function(resp) {
            goTo(url);
        },

		onFailure : function(resp) {},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=update_proposal&' + Form.serialize($("proposal-form"))

	});
}


function copyCartInfo(type, rowNum)
{
	if(type == 'regular') $('link-txt-regular-'+(rowNum+1)).value = $('link-txt-regular-'+rowNum).value;
	$('link-url-'+type+'-'+(rowNum+1)).value = $('link-url-'+type+'-'+rowNum).value;	
}





function websitePlacementOption(websiteId, manual)
{
	scriptPanel();
	
	new Ajax.Request("/user.ajax.php", {

		onSuccess : function(resp) {},

		onFailure : function(resp) {},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=update_website_placement&id=' + websiteId + '&is_manual=' + manual

	});
}


function scriptPanel()
{
	if($('isManualN').checked){
	
		$('ApprovalA').disabled = false;
		$('ApprovalB').disabled = false;
	
		$('scriptPanel').style.display = 'block';
		
	}else{
	
		$('ApprovalA').checked = false;
		$('ApprovalB').checked = true;
				
		$('ApprovalA').disabled = true;
		$('ApprovalB').disabled = true;
	
		$('scriptPanel').style.display = 'none';
		
	}
}


function changeUserCountry(countrySelect)
{
	if(countrySelect.options[countrySelect.selectedIndex].value == 'USA' || countrySelect.options[countrySelect.selectedIndex].value == 'usa'){
		$('inputDivProvince').style.display = 'none';
		$('inputDivState').style.display = 'block';
	}else{
		$('inputDivState').style.display = 'none';
		$('inputDivProvince').style.display = 'block';
	}
}





function pluginInstructions()
{
	var select = $('pluginDropdown');
	
	if(select.options[select.selectedIndex].value == 'php'){
		$('instructions-php').style.display = 'block';
		$('instructions-wordpress').style.display = 'none';
	}else{
		$('instructions-php').style.display = 'none';
		$('instructions-wordpress').style.display = 'block';
	}
}


function updateWebsiteDescriptionLength(txt)
{
	$('websiteDescriptionLength').innerHTML = txt.value.length;
}


function submitWebsiteStep1()
{
	$('websiteErrors').style.display = 'none';
	$('websiteErrors').innerHTML = '';
	$('btnSubmitWebsite1').style.display = 'none';
	$('websiteFormLoading').style.display = 'inline';

	new Ajax.Request("/user.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();
			
			$('arrow-website-form').style.display = 'none';
			
			if(data.result == 'success'){
				$('submitWebsiteStep1').style.display = 'none';
				$('submitWebsiteStep2').style.display = 'block';
			}else{
				$('websiteErrors').innerHTML = data.output;
				$('websiteErrors').style.display = 'block';
			}
			$('websiteFormLoading').style.display = 'none';
			$('btnSubmitWebsite1').style.display = 'block';
		},

		onFailure : function(resp) {
			alert('Sorry, a problem occurred. Your site has not been submitted.');
			$('websiteFormLoading').style.display = 'none';
			$('btnSubmitWebsite1').style.display = 'block';
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=check_website&' + Form.serialize($("submitWebsiteForm"))

	});

	
}


function submitWebsiteStep2()
{	
	$('btnSubmitWebsite2').style.display = 'none';
	$('btnWebsiteGoBack').style.display = 'none';
	$('websiteFormLoading').style.display = 'inline';

	new Ajax.Request("/user.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();
			if(data.result == 'accepted'){
				goTo('/account/website-edit/?id='+data.id+'&accepted=true');
			}else{
				$('submitWebsiteStep2').style.display = 'none';
				$("submitWebsiteStep3").style.display = 'block';
				
				$('websiteFormLoading').style.display = 'none';
				$('btnSubmitWebsite2').style.display = 'block';
				$('btnWebsiteGoBack').style.display = 'block';
			}
			
		},

		onFailure : function(resp) {
			alert('Sorry, a problem occurred. Your site has not been submitted.');
			$('websiteFormLoading').style.display = 'none';
			$('btnSubmitWebsite2').style.display = 'block';
			$('btnWebsiteGoBack').style.display = 'block';
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=submit_website&' + Form.serialize($("submitWebsiteForm"))

	});
}


function cancelWebsiteStep2(){
	$('submitWebsiteStep2').style.display = 'none';
	$('submitWebsiteStep1').style.display = 'block';
}


function submitWebsiteNew()
{
	$('websiteUrl').value = 'http://';
	$('websiteTitle').value = '';
	$('websiteDescription').value = '';
	
	$('websiteCategory1').selectedIndex = 0;
	$('websiteCategory2').selectedIndex = 0;
	$('websiteCategory3').selectedIndex = 0;

	$('submitWebsiteStep3').style.display = 'none';
	$('submitWebsiteStep1').style.display = 'block';
}


function updateWebsite()
{

	$('updateWebsiteErrors').style.display = 'none';
	$('updateWebsiteResults').style.display = 'none';

	new Ajax.Request("/user.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();
			if(data.result == 'success'){
				$('updateWebsiteResults').innerHTML = data.output;
				$('updateWebsiteResults').style.display = 'block';
				setTimeout("$('updateWebsiteResults').style.display = 'none'", 3000);
			}else{
				$('updateWebsiteErrors').innerHTML = data.output;
				$('updateWebsiteErrors').style.display = 'block';
			}
		},

		onFailure : function(resp) {
			alert('Sorry, a problem occurred. Your site has not been updated.');
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=update_website&' + Form.serialize($("updateWebsiteForm"))

	});
}


function rejectLink(btn, type, id)
{
	if(confirm('Are you sure you want to reject this link?'))
	new Ajax.Request("/order.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();
			btn.parentNode.parentNode.style.display = 'none';
		},

		onFailure : function(resp) {
			alert('Sorry, a problem occurred. This item was not rejected.');
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=reject_link&type='+type+'&id='+id

	});

}


function acceptLink(btn, type, id, manual)
{
	if(manual == true){
		
		var linkPlaced = confirm("Because you are placing your links manually on this site, you must add this link before accepting it.\n\nHave you added this link to your site yet?");
		
		if(!linkPlaced){
			alert("Please add this link to you site first, then accept the link.");
			return;
		}
	}

	new Ajax.Request("/order.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();
			
			if(data.result == 'missing'){
				alert("We have scanned your site for this link, but we cannot find it. You must place this link on the *exact* URL shown before you can accept it.\n\nIf you have confirmed that the link is present and are still receving this notice, please contact support.");
			}else{
				goTo('/account/');
			}
			
		},

		onFailure : function(resp) {
			alert('Sorry, a problem occurred. This item was not accepted.');
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=accept_link&type='+type+'&id='+id

	});
	
}



function cancelLink(btn, type, id, orderId)
{
	if(confirm('Are you sure you want to cancel this link?'))
	new Ajax.Request("/order.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();
			goTo('/account/links-advertiser/?status_id=ALL&order_id='+orderId);
		},

		onFailure : function(resp) {
			alert('Sorry, a problem occurred. This item was not canceled.');
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=cancel_link&type='+type+'&id='+id

	});

}


function addToCart(btn, type, id, text, url, snippet)
{

	new Ajax.Request("/marketplace.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();
			btn.parentNode.parentNode.className = 'bought';
			btn.parentNode.innerHTML = '<a href="#" onclick="removeFromCartMarketplace(this, \''+type+'\', \''+data.id+'\', \''+id+'\', \''+text+'\', \''+url+'\', \''+snippet+'\'); return false;"><img style="padding-bottom: 4px;" src="/images/btn-trash.png" alt="Remove" /></a>';
			updateCartLabels();
			
			//var btnCart = $('btnViewCart');
			//if(btnCart) btnCart.style.display = 'block';
		},

		onFailure : function(resp) {
			alert('Sorry, a problem occurred. This item was not added to your cart.');
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=add_to_cart&type='+type+'&id='+id+'&text='+text+'&url='+url+'&snippet='+snippet

	});

}



function removeFromCartMarketplace(btn, type, id, itemId, text, url, snippet)
{

	new Ajax.Request("/marketplace.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();
			btn.parentNode.parentNode.className = '';
			btn.parentNode.innerHTML = '<a href="#" onclick="addToCart(this, \''+type+'\', \''+itemId+'\', \''+text+'\', \''+url+'\', \''+snippet+'\'); return false;"><img src="/images/btn-add-cart.png" alt="Add to cart" /></a>';
			updateCartLabels();
		},

		onFailure : function(resp) {
			alert('Sorry, a problem occurred. This item was not removed from your cart.');
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=remove_from_cart&type='+type+'&id='+id

	});

}



function removeFromCart(btn, type, id)
{

	new Ajax.Request("/marketplace.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();
			btn.parentNode.parentNode.style.display = 'none';
			updateCartLabels();
		},

		onFailure : function(resp) {
			alert('Sorry, a problem occurred. This item was not removed from your cart.');
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=remove_from_cart&type='+type+'&id='+id

	});

}


function removePromotion(btn, id)
{

	new Ajax.Request("/marketplace.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();

			btn.parentNode.parentNode.style.display = 'none';
			updateCartLabels();
		},

		onFailure : function(resp) {
			alert('Sorry, a problem occurred. This item was not removed from your cart.');
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=remove_promotion&id='+id

	});

}




function updateCartLabels()
{

	new Ajax.Request("/marketplace.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();
			var labels;
			
			labels = document.getElementsByClassName('cart-item-count');
			for(var i = 0; i < labels.length; i++){
				labels[i].innerHTML = data.items;
			}
			
			labels = document.getElementsByClassName('cart-regular-count');
			for(var i = 0; i < labels.length; i++){
				labels[i].innerHTML = data.num_regular;
			}
			
			labels = document.getElementsByClassName('cart-context-count');
			for(var i = 0; i < labels.length; i++){
				labels[i].innerHTML = data.num_context;
			}
			
			labels = document.getElementsByClassName('cart-subtotal');
			for(var i = 0; i < labels.length; i++){
				labels[i].innerHTML = data.subtotal;
			}
			
			labels = document.getElementsByClassName('cart-discount');
			for(var i = 0; i < labels.length; i++){
				labels[i].innerHTML = data.discount;
			}
			
			labels = document.getElementsByClassName('cart-initial');
			for(var i = 0; i < labels.length; i++){
				labels[i].innerHTML = data.initial;
			}
			
			labels = document.getElementsByClassName('cart-total');
			for(var i = 0; i < labels.length; i++){
				labels[i].innerHTML = data.total;
			}
			
		},

		onFailure : function(resp) {},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=get_cart_labels'

	});

}


function sortMartketplace(sort, sortOrder)
{
	$('filterSort').value = sort;
	$('filterSortOrder').value = sortOrder;
	
	searchMarketplace();
}



function changeLinkType()
{
	var select = $('filterLinkType');
	
	if(select.options[select.selectedIndex].value == 'context'){
		$('postGrouping').style.display = 'block';
	}else{
		$('postGrouping').style.display = 'none';
	}
}


function marketplaceShowPage(pageNum)
{
	$('filterPageNum').value = pageNum;
	searchMarketplace();
}

function marketplaceShowPageBottom(pageNum)
{
	marketplaceShowPage(pageNum);
	$('marketplaceFilter').scrollTo();
}


function changeMarketplaceFilter(search)
{
	if(search){
		$('mkt-fields-browse').style.display = 'none';
		$('mkt-fields-search').style.display = 'block';
		
		$('mkt-btn-browse').className = '';
		$('mkt-btn-search').className = 'active';
	}else{
		$('mkt-fields-search').style.display = 'none';
		$('mkt-fields-browse').style.display = 'block';
		
		$('mkt-btn-search').className = '';
		$('mkt-btn-browse').className = 'active';
	}
	
	var keywordField = $('filterKeywords');
	keywordField.value = '';
	updateTextFieldLabel(keywordField, false, 'Enter your keyword(s)');
		
	$('filterLinkType').selectedIndex = 0;
	//$('filterCategory').selectedIndex = 0;
	$('filterLinkScore').selectedIndex = 0;
	$('postGrouping').style.display = 'none';
}


function browseMarketplace(catId)
{
	$('filterLinkType').selectedIndex = 0;
	changeLinkType();
	
	var cats = $('filterCategory').options;
	var catCount = cats.length;
	
	for(var i = 0; i < catCount; i++)
	{
		if(cats[i].value == catId){
			$('filterCategory').selectedIndex = i;
			break;
		}
	}
	
	searchMarketplace();
}


function searchMarketplace()
{
	var type = $('filterLinkType');
	var keywords = $('filterKeywords').value;
	var action = '';
	
	if(type.options[type.selectedIndex].value == 'context'){

		if(keywords == 'keywords' || keywords == 'Enter your keyword(s)'){
			alert("Please enter your keyword(s)");
			return false;
		}
	
		action = 'search_context';
		
		// make sure sorting fields are valid
		var filterSort = $('filterSort');
		if(filterSort.value == 'title' || filterSort.value == 'alexa_rank'){
			filterSort.value = 'link_score';
			$('filterSortOrder').value = 'DESC';
		}
		
	}else{

		var cats = $('filterCategory');
		var langs = $('filterLanguage');
		var pr = $('filterLinkScore');
	
		// (langs.options[langs.selectedIndex].value == '' || langs.options[langs.selectedIndex].value == 'English')
		
		if(cats.options[cats.selectedIndex].value == '' && (keywords == 'keywords' || keywords == 'Enter your keyword(s)') && pr.options[pr.selectedIndex].value == ''){
			alert("Please enter keyword(s), category or pagerank");
			return false;
		}
	
		action = 'search_regular';
		
		// make sure sorting fields are valid
		var filterSort = $('filterSort');
		if(filterSort.value == 'homepage_link_score' || filterSort.value == 'date_published'){
			filterSort.value = 'link_score';
			$('filterSortOrder').value = 'DESC';
		}
		
	}
	
	$('marketplaceIntro').style.display = 'none';
	

	//if(type.options[type.selectedIndex].value == 'context'){
		$('btnSearchSubmit').style.display = 'none';
		$('searchLoading').style.display = 'block';
	//}
	
	new Ajax.Request("/marketplace.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();
			$('marketplaceListing').innerHTML = data.output;
			//if(type.options[type.selectedIndex].value == 'context'){
				$('searchLoading').style.display = 'none';
				$('btnSearchSubmit').style.display = 'block';
			//}
		},

		onFailure : function(resp) {
			$('marketplaceListing').innerHTML = '';
			//if(type.options[type.selectedIndex].value == 'context'){
				$('searchLoading').style.display = 'none';
				$('btnSearchSubmit').style.display = 'block';
			//}
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=' + action + '&' + Form.serialize($("marketplaceFilter"))

	});
	
}





function updateTextFieldLabel(box, focus, text)
{	
	if(focus && box.value == text){
		box.value = '';
		box.style.color = '#000';
	}else if(!focus && box.value == ''){
		box.style.color = '#888';
		box.value = text;
	}
}





function createUser()
{
	$('createUserButton').style.display = 'none';
	$('submitLoading').style.display = 'block';
	
	$('registerErrors').style.display = 'none';

	new Ajax.Request("/user.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();

			if(data.result == 'success'){
				if(data.proposal != ''){
					goTo('/cart/?action=add_proposal&id='+data.proposal);
				}else{
					goTo('/account/');
				}
				//$('registerForm').style.display = 'none';
				//$('registerResults').innerHTML = data.output;
				//$('registerResults').style.display = 'block';
			}else{
				$('registerErrors').innerHTML = data.output;
				$('registerErrors').style.display = 'block';
				
				$('submitLoading').style.display = 'none';
				$('createUserButton').style.display = 'block';
				
			}


		},

		onFailure : function(resp) {
			$('registerErrors').innerHTML = "<p>An error occured during processing.</p>";
			$('registerErrors').style.display = 'block';
			
			$('submitLoading').style.display = 'none';
			$('createUserButton').style.display = 'block';
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : Form.serialize($("registerForm"))

	});

}


function requestProposal(formId)
{
	$('proposal-arrow').style.display = 'none';
	$('proposalErrors').style.display = 'none';
	
	
	new Ajax.Request("/user.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();

			if(data.result == 'success'){
				//$('proposalForm').style.display = 'none';
				//$('proposalResults').innerHTML = data.output;
				//$('proposalResults').style.display = 'block';
				goTo('/account/proposals/?submitted=true');
			}else{
				$('proposalErrors').innerHTML = data.output;
				$('proposalErrors').style.display = 'block';
			}


		},

		onFailure : function(resp) {
			$('proposalErrors').innerHTML = "<p>An error occured during processing.</p>";
			$('proposalErrors').style.display = 'block';
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=request_proposal&' + Form.serialize($(formId))

	});

}


function resetPassword()
{

	$('resetErrors').style.display = 'none';

	new Ajax.Request("/user.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();

			if(data.result == 'success'){
				$('resetResults').innerHTML = data.output;
				$('resetResults').style.display = 'block';
				$('resetForm').style.display = 'none';
			}else{
				$('resetErrors').innerHTML = data.output;
				$('resetErrors').style.display = 'block';
			}


		},

		onFailure : function(resp) {
			$('resetErrors').innerHTML = "<p>An error occured during processing.</p>";
			$('resetErrors').style.display = 'block';
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : Form.serialize($("resetForm"))

	});

}


function showCreditCardForm()
{
	$('emailForm').style.display = 'none';
	$('passwordForm').style.display = 'none';
	$('creditCardForm').style.display = 'block';
}


function showPasswordForm()
{
	$('emailForm').style.display = 'none';
	$('creditCardForm').style.display = 'none';
	$('passwordForm').style.display = 'block';
}


function showEmailForm()
{
	$('passwordForm').style.display = 'none';
	$('creditCardForm').style.display = 'none';
	$('emailForm').style.display = 'block';
}


function updatePassword()
{
	$('passwordErrors').style.display = 'none';

	new Ajax.Request("/user.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();

			if(data.result == 'success'){
				$('passwordForm').style.display = 'none';
				$('passwordDisplay').className = 'green';
			}else{
				$('passwordErrors').innerHTML = data.output;
				$('passwordErrors').style.display = 'block';
			}

		},

		onFailure : function(resp) {
			$('passwordErrors').innerHTML = "<p>An error occured during processing.</p>";
			$('passwordErrors').style.display = 'block';
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=update_password&'+Form.serialize($("passwordForm"))

	});

}


function updateEmailAddress()
{
	$('emailErrors').style.display = 'none';

	new Ajax.Request("/user.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();

			if(data.result == 'success'){
				$('emailForm').style.display = 'none';
				$('emailDisplay').innerHTML = data.email;
				$('emailDisplay').className = 'green';
			}else{
				$('emailErrors').innerHTML = data.output;
				$('emailErrors').style.display = 'block';
			}

		},

		onFailure : function(resp) {
			$('emailErrors').innerHTML = "<p>An error occured during processing.</p>";
			$('emailErrors').style.display = 'block';
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=update_email&'+Form.serialize($("emailForm"))

	});

}


function updateAbout()
{

	//$('aboutUpdateButton').disabled = true;
	$('aboutErrors').style.display = 'none';
	$('aboutResults').style.display = 'none';

	new Ajax.Request("/user.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();

			if(data.result == 'success'){
				$('aboutResults').innerHTML = data.output;
				$('aboutResults').style.display = 'block';
				setTimeout("$('aboutResults').style.display = 'none'", 3000);
			}else{
				$('aboutErrors').innerHTML = data.output;
				$('aboutErrors').style.display = 'block';
			}

			//$('aboutUpdateButton').disabled = false;

		},

		onFailure : function(resp) {
			$('aboutErrors').innerHTML = "<p>An error occured during processing.</p>";
			$('aboutErrors').style.display = 'block';
			//$('aboutUpdateButton').disabled = false;
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : 'action=update_about&'+Form.serialize($("aboutForm"))

	});

}



function unsubscribe()
{

	$('unsubscribeErrors').style.display = 'none';

	new Ajax.Request("/unsubscribe.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();

			if(data.result == 'success'){
				$('unsubscribeForm').style.display = 'none';
				$('unsubscribeResults').innerHTML = data.output;
				$('unsubscribeResults').style.display = 'block';
			}else{
				$('unsubscribeErrors').innerHTML = data.output;
				$('unsubscribeErrors').style.display = 'block';
			}


		},

		onFailure : function(resp) {
			$('unsubscribeErrors').innerHTML = "<p>An error occured during processing.</p>";
			$('unsubscribeErrors').style.display = 'block';
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : Form.serialize($('unsubscribeForm'))

	});

}


function submitContact()
{

	$('contactErrors').style.display = 'none';

	new Ajax.Request("/contact.ajax.php", {

		onSuccess : function(resp) {
			var data = resp.responseText.evalJSON();

			if(data.result == 'success'){
				$('contactForm').style.display = 'none';
				$('contactResults').innerHTML = data.output;
				$('contactResults').style.display = 'block';
			}else{
				$('contactErrors').innerHTML = data.output;
				$('contactErrors').style.display = 'block';
			}


		},

		onFailure : function(resp) {
			$('contactErrors').innerHTML = "<p>An error occured during processing.</p>";
			$('contactErrors').style.display = 'block';
		},

		method:'post',
		requestHeaders: {Accept: 'application/json'},
		parameters : Form.serialize($('contactForm'))

	});

}


function popupWindow(name, url, width, height)
{
	var left = (screen.width-width) / 2;
	var top = (screen.height-height) / 2;
	eval(name + " = window.open(url, '" + name + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=yes,width=" + width + ",height=" + height + ",left=" + left + ",top=" + top + "');");
	eval(name + ".opener = self;");
}



function goTo(url)
{
	window.location.href = url;
}
