<div id="content">
	  <h1>Websites</h1>
	  <div style="margin-left: 20px;" class="right website" id="form-280x400">
	    <div class="arrow-loop-right" id="arrow-website-form"></div>
	    <a href="publishers-guide.html" target="_blank"><img height="63" alt="Publisher's Guide" widht="250" src="{$_config.www}/templates/{$_config.template}/images/publishers-guide.png"></a>
	    <div id="websiteErrors" class="formErrors"></div>
	    <h2>Submit a website</h2>
	    <form onsubmit="return false;" action="/account/websites/" method="post" id="submitWebsiteForm">
	      <div id="submitWebsiteStep1">
		  <input type="hidden" name="update_pid" value="{$info_edit.pid}" />
	        <label class="block">Your Website URL: *</label>
	        <input type="text" value="{$info_edit.url}" name="url" id="websiteUrl" class="txt">
	        <p style="margin: 0; padding: 0;" class="small grey">Please submit your homepage URL.</p>
	        <label class="block">Website Title: *</label>
	        <input type="text" value="{$info_edit.title}" name="wname" id="websiteTitle" class="txt">
	        <label class="block">Describe your website: *</label>
	        <textarea rows="4" cols="30" name="wdes" onkeydown="updateWebsiteDescriptionLength(this);" onkeyup="updateWebsiteDescriptionLength(this);" id="websiteDescription" class="txt">{$info_edit.description}</textarea>
	        <p style="margin: 0; padding: 0;" class="small grey"> Minimum of 150 characters.
	          Current: <span id="websiteDescriptionLength">0</span> </p>
	        <p style="font-weight: bold; margin: 5px 0 0 0; padding: 0;">
	          <input type="checkbox" value="1" name="guide" id="publisherGuide">
	          <label for="publisherGuide"> I've read the <a href="(alert('Tai 1 file pdf huong dan ve may'))" target="_blank">Publisher's Guide</a></label>
	        </p>
	        <a onclick="submitWebsiteStep1(); return false;" href="#" style="margin-top: 12px;" class="btn-green-240" id="btnSubmitWebsite1">Submit website</a> </div>
		  <input type="hidden" name="edit_site" value="1" />
	      <div class="hidden" id="submitWebsiteStep2">
	        <label class="block">{$_lang.Category}: *</label>
			
	        <select size="1" name="cats" onChange="javascript: sendReqPost(loc+'js/get_scats.php?cid='+this.value,'sc');" style="width: 200px">
					{html_options values=$cat_ids output=$cats selected=$smarty.post.cats}
                    </select>
	        <label class="block">{$_lang.Sub_Category}: </label>
	       <div id='sc'>
			<select size="1" name="subcats" style="width: 200px">
			{html_options values=$scat_ids output=$scats selected=$smarty.post.subcats}
			</select>
			</div>	
	       
	        <label class="block">URL is the homepage of your website?</label>
	        <div>
	          <input type="radio" checked="checked" value="Y" name="is_homepage" id="isHomepageY">
	          <label for="isHomepageY"> Yes</label>
	          &nbsp; &nbsp;
	          <input type="radio" value="N" name="is_homepage" id="isHomepageN">
	          <label for="isHomepageN"> No</label>
	        </div>
	        <a onclick="submitWebsiteStep2(); return false;" href="#" class="btn-green-240" id="btnSubmitWebsite2">Submit website</a> <a onclick="cancelWebsiteStep2(); return false;" href="#" style="margin-top: 10px" class="btn-tan-80" id="btnWebsiteGoBack">Go back</a> </div>
	      <div class="hidden" id="submitWebsiteStep3">
	        <p> <strong>Your website is currently being processed.</strong> We will contact you shortly regarding the status of your website. <br>
	          <br>
	        </p>
	        <div class="clear"> <a onclick="submitWebsiteNew(); return false;" href="#" class="btn-green-240">Submit another</a> </div>
	      </div>
	      <img alt="" src="images/loader-lrg.gif" style="margin-top: 10px;" class="hidden" id="websiteFormLoading">
	    </form>
	  </div>
	  <p class="large"> Below is a listing of your websites that are currently in our system. You have earned <span class="bold green">$0.00</span> so far this month. Given your current links, your
	    earnings at the end of the month will be <span class="bold green">$0.00</span>.<br>
	    <em class="small">(Please note that these earnings can change if links are canceled or missing.)</em> </p>
	  <table class="data large width-600" id="website-table">
	    <thead>
	      <tr>
	        <th><a href="#">Website Details</a> <img src="images/sorted-asc.gif"></th>
	        <th style="width: 60px;"><a href="#">Added</a></th>
	        <th style="width: 60px;">Earnings</th>
	        <th style="width: 80px;" class="last">Manage</th>
	      </tr>
	    </thead>
	    <tbody>
		{section name=num loop=$www}
		  	
	      <tr class="row1">
		  {if $www[num].pid != $smarty.get.pid}	
		  <a href="seller_mywebsites.php?pid={$www[num].pid}" class="style37">{/if}  
		  
		  {if $www[num].pid != $smarty.get.pid}</a>	  
		   
	        <td class="alignleft"><strong>
			
			{$www[num].title}
			
			</strong><span class="lbl lbl-pending">Pending</span><br>
	          <span class="grey">(<a href="#" target="_blank">{$www[num].url}</a>)</span><br>
	          {$www[num].description}</td>
	        <td class="alignleft">{$www[num].date}</td>
	        <td class="alignright large bold green">$0.00</td>
	        <td class="centered last"><a href="publishers.php?pid={$www[num].pid}&do=edit" class="btn-tan-80">Edit</a><a href="website-earnings.html" style="margin-top: 5px;" class="btn-tan-80">Earnings</a></td>
	      </tr>
		  
		   {/if}
		  {/section}
	    </tbody>
	  </table>
	  <div class="clear"></div>
	</div>