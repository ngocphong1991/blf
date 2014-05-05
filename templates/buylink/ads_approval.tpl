{if isset($smarty.post.approve) || isset($smarty.post.approve_edit)}
	<div id="main">
	  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ... </a></h1>
	  <table width="100%" border="0">
        <tr>
          <td><h1 class="green">{$_lang.New_Ad_Approved}</h1></td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <div class="splitleft">
        <div class="box">
          <div align="left">
            <table width="100%" border="0">
              
              <tr>
                <td width="10%">&nbsp;</td>
                <td width="83%">&nbsp;</td>
                <td width="7%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style39">{$_lang.ad_approval_page2}<br />
                    <br />
                </span><span class="style38">{$ad.site_name}<br />
                <br />
{$_lang.ad_approval_page3} {$ad.start_date|date_format:"%d/%m/%Y"} </span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
{$TIP}      <br />
    </div>
{elseif isset($smarty.post.reject) || isset($smarty.post.reject_edit)}
	<div id="main">
	  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ... </a></h1>
	  <table width="100%" border="0">
        <tr>
          <td><h1 class="green">{$_lang.New_Ad_Rejected}</h1></td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <div class="splitleft">
        <div class="box">
          <div align="left">
		  <form action="" method="post"><table width="100%" border="0">
              
              <tr>
                <td width="10%">&nbsp;</td>
                <td width="83%">&nbsp;</td>
                <td width="7%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><span class="style39">{$_lang.ad_approval_page4}<br />
                    <br />
                </span><span class="style38">{$ad.site_name}<br />
                <br />
{$_lang.ad_approval_page5} </span><span class="style39"><br />
<br />
<textarea name="why" cols="40" rows="6" id="why"></textarea>
<br />
<input name="reason" type="submit" class="button" id="reason" value="{$_lang.Submit}" />
</span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></form>
            
          </div>
        </div>
      </div>
          
     {$TIP}
      <br />
    </div>
{elseif isset($smarty.request.edit)}
<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ... </a></h1>
  <table width="100%" border="0">
        <tr>
          <td><h1 class="green">{$_lang.Edited_Ads_Approval}</h1></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
  </table>
      <div class="splitleft">
        <div class="box">
		<form action="" method="post"><table width="90%" border="0" align="center">
            <tr>
              <td><strong>{$user}</strong>, {$_lang.ad_approval_page6} <BR />                
                The <strong>{$_lang.new_edited_ads}</strong> {$_lang.can_be_viewed_below} <br />
              {$_lang.ad_approval_page7} <strong>{$new_url}</strong></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
			{if $offer == 'Y'}
            <tr>
              <td>{$_lang.ad_approval_page8} </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
			{/if}
            <tr>
              <td>
                  
                  
                  
                        <table width="100%" border="0" >
                          <tr>
                            <td>
					{if $ad.ad_type == 'txt_ad' || $ad.ad_type == 'ppc_txt_ad'} 
						<div id="ad-preview">
                            <div id="preview_text_ad_headline">{$new_hl}</div>
                            <div id="preview_text_ad_text">{$new_des}</div>
                          </div>
{else} 
			<div style="width: {$div_size[0]}px; height: {$div_size[1]}px; background-image: url(js/adbg.jpg)" >
			{if $has_file == 'Y'}
				{if $ext == 'swf'}
				<div id="ad_div"></div>
				<script type="text/javascript">
				var so = new SWFObject("{$ad.ad_img}", "image_ad_space", "{$div_size[0]}", "{$div_size[1]}", "8", "#ffffff");
				so.addParam("wmode", "transparent");
				so.write("ad_div");
				</script>
				{elseif $ext == 'flv'}
				<div id="ad_div"></div>
				<script type="text/javascript">
				var so = new SWFObject("adPlayer.swf", "video_ad_space", "{$div_size[0]}", "{$div_size[1]}", "8", "#ffffff");
				so.addParam("wmode", "opaque");
				so.addVariable("file", "{$ad.ad_img}");
				so.addVariable("ad_url", "{$ad.ad_url}?");	
				so.write("ad_div");
				
/*				
				var so = new SWFObject("js/AdQuick_player.swf", "video_ad_space", "{$div_size[0]}", "{$div_size[1]}", "8", "#ffffff");
				so.addParam("flashvars", "get_Path=../{$ad.ad_img}");
				so.addParam("wmode", "transparent");
				so.write("ad_div");
*/				</script>
				{else}
				<img src="{$ad.ad_img}" alt="Image Ad" width="{$div_size[0]}" height="{$div_size[1]}" />
				{/if}
			{/if}				</div>

{/if}							</td>
                          </tr>
                        </table>
              </td>
            </tr>
            
            <tr>
              <td><p class="style40"><strong>{$_lang.More_Info_on_This_Purchase} :</strong></p>
                  <p><span class="style40"><strong>{$_lang.Ad_Start_Date}: </strong></span><span class="style41">{$ad.start_date|date_format:"%e %B %Y"} </span><br />
                      <span class="style40"><strong>{$_lang.Offer_Made}?: </strong></span><span class="style41">{if $offer == 'Y'} {$_lang.Yes} {else} {$_lang.No} {/if}</span><br />
                      <span class="style41"><strong>{$_lang.Ad_Type}: </strong>
					  
					  {if $ad.ad_type == 'txt_ad' || $ad.ad_type == 'ppc_txt_ad'} {$_lang.Text_Ad} 
					  {elseif $ad.ad_type == 'img_ad' || $ad.ad_type == 'ppc_img_ad'} {$_lang.Image_Ad}
					  {elseif $ad.ad_type == 'vdo_ad' || $ad.ad_type == 'ppc_vdo_ad'} {$_lang.Video_Ad}
					  {/if}
					  <br />
                      <strong>{$_lang.Length}:</strong> {if $ad_space.length == '0'} N/A {else}{$ad_space.length} {$_lang.Day} {/if}</span></p></td>
            </tr>
            <tr>
              <td><div align="center">
                  <input name="adv_id" type="hidden" id="adv_id" value="{$ad.adv_id}" />
                  <input name="approve_edit" type="submit" id="approve_edit" value="Approve" class="button" />
                  <input name="reject_edit" type="submit" id="reject_edit" value="Reject" class="button" />
              </div></td>
            </tr>
          </table></form>
          
        </div>
      </div>
     
      {$TIP}
   <BR /> </div>	
{else}
<div id="main">
  <h1><a href="account.php" class="style27">{if $smarty.session.utype=='adv'}{$_lang.Advertiser} {else} {$_lang.Publisher} &amp; {$_lang.Advertiser} {/if} {$_lang.control_panel} ... </a></h1>
  <table width="100%" border="0">
        <tr>
          <td><h1 class="green">{$_lang.New_Ads_Approval}  {if $offer == 'Y'} - {$_lang.Offer_Made}{/if}</h1></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
  </table>
      <div class="splitleft">
        <div class="box">
		<form action="" method="post"><table width="90%" border="0" align="center">
            <tr>
              <td>
			  {if $offer == 'Y'}
			  <strong>{$user}</strong>, {$_lang.Has_Made_You_An_Offer}<BR />
			   <strong>{$user}</strong>, {$_lang.Would_Like_To_Pay_You}, {$CURRENCY}{$price} {$_lang.For_Your} {$product} {$_lang.Product} <br />{else}
			   
			   <strong>{$user}</strong>, {$_lang.has_bought_a} {$product} {$_lang.on_your_website_for} {$CURRENCY}{$price}<br /> {/if}
                {$_lang.The_ad_can_be_viewed_below}. <br />
                 {$_lang.ad_approval_page7}, <strong>{$ad.ad_url}</strong></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
			{if $offer == 'Y'}
            <tr>
              <td>{$_lang.ad_approval_page8} </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
			{/if}
            <tr>
              <td>
                  
                  
                  
                        <table width="100%" border="0" >
                          <tr>
                            <td>
					{if $ad.ad_type == 'txt_ad' || $ad.ad_type == 'ppc_txt_ad'} 
						<div id="ad-preview">
                            <div id="preview_text_ad_headline">{$ad.ad_hl}</div>
                            <div id="preview_text_ad_text">{$ad.ad_des}</div>
                          </div>
{else} 
			<div style="width: {$div_size[0]}px; height: {$div_size[1]}px; background-image: url(js/adbg.jpg)" >
			{if $has_file == 'Y'}
				{if $ext == 'swf'}
				<div id="ad_div"></div>
				<script type="text/javascript">
				var so = new SWFObject("{$ad.ad_img}", "image_ad_space", "{$div_size[0]}", "{$div_size[1]}", "8", "#ffffff");
				so.addParam("wmode", "transparent");
				so.write("ad_div");
				</script>
				{elseif $ext == 'flv'}
				<div id="ad_div"></div>
				<script type="text/javascript">
				var so = new SWFObject("adPlayer.swf", "video_ad_space", "{$div_size[0]}", "{$div_size[1]}", "8", "#ffffff");
				so.addParam("wmode", "opaque");
				so.addVariable("file", "{$ad.ad_img}");
				so.addVariable("ad_url", "{$ad.ad_url}?");	
				so.write("ad_div");

				
				</script>
				{else}
				<img src="{$ad.ad_img}" alt="Image Ad" width="{$div_size[0]}" height="{$div_size[1]}" />
				{/if}
			{/if}				</div>

{/if}							</td>
                          </tr>
                        </table>
              </td>
            </tr>
            
            <tr>
              <td><p class="style40"><strong>{$_lang.More_Info_on_This_Purchase} :</strong></p>
                  <p><span class="style40"><strong>{$_lang.Ad_Start_Date}: </strong></span><span class="style41">{$ad.start_date|date_format:"%e %B %Y"} </span><br />
                      <span class="style40"><strong>{$_lang.Offer_Made}?: </strong></span><span class="style41">{if $offer == 'Y'} {$_lang.Yes} {else} {$_lang.No} {/if}</span><br />
                      <span class="style41"><strong>{$_lang.Ad_Type}: </strong>
					  
					    {if $ad.ad_type == 'txt_ad' || $ad.ad_type == 'ppc_txt_ad'} {$_lang.Text_Ad} 
					  {elseif $ad.ad_type == 'img_ad' || $ad.ad_type == 'ppc_img_ad'} {$_lang.Image_Ad}
					  {elseif $ad.ad_type == 'vdo_ad' || $ad.ad_type == 'ppc_vdo_ad'} {$_lang.Video_Ad}
					  {/if}
					  <br />
                      <strong>{$_lang.Length}:</strong> {if $ad_space.length == '0'} N/A {else}{$ad_space.length} {$_lang.Day} {/if}</span></p></td>
            </tr>
            <tr>
              <td><div align="center">
                  <input name="adv_id" type="hidden" id="adv_id" value="{$ad.adv_id}" />
                  <input name="approve" type="submit" id="approve" value="{$_lang.Approve}" class="button" />
                  <input name="reject" type="submit" id="reject" value="{$_lang.Reject}" class="button" />
              </div></td>
            </tr>
          </table></form>
          
        </div>
      </div>
     
      {$TIP}
   <BR /> </div>
{/if}   