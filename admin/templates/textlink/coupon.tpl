<div id="main">
      <h1><a href="../admin/" class="style27">{$_lang.Admin} {$_lang.control_panel}</a></h1>
      <table width="100%" border="0">
        
        <tr>
          <td class="style39"><h1><span class="green">Advertisersinfo Manager</span></h1></td>
        </tr>
      </table>	  
      <table width="100%" border="0" align="center" style="min-width: 979px">
        
        <tr>
          <td width="100%"><div class="splitleft">
		  
            <div class="box">
              <div align="left">
			     <form action="" method="get" name="frm_coupon">
                 <div class="frm_search" style="padding: 20px 0; text-align: center; background: #fff">
                    <label>Code </label>
                    <input type="text" name="keyword" value="{$keyword}" />
                    <label>Active</label>                                   
                   
                    <input type="submit" value="Find" />
					
                 </div>
                 <table  class="tbl-list"  id="lst-submit-url">
                    <tr style="font-weight: bold">
					
					<td>Code</td>
					<td>Start Date</td>
					<td>End Date</td>
					<td>Percent</td>
					<td width="10px">Lenght</td>		
					<td>Ref Code</td>			
				    <td>Status</td>
                    </tr>
                    {section name=i loop=$all_coupon}
                    <tr>                       
                                 
                        <td>{$all_coupon[i].code}</td>
                        <td>{$all_coupon[i].start_date}</td>                    	
						<td>{$all_coupon[i].end_date}</td>
						<td>{$all_coupon[i].percent}</td>	
						<td>{$all_coupon[i].length}</td>
						<td>{$all_coupon[i].ref_code}</td>					
						<td>{if $all_coupon[i].status == '0'} Pending <a href="?confirm={$all_coupon[i].coupon_id}&type=yes" class="smart-btn btn-openfrm btn-pay-atm-conf-yes">Active now</a>{else} Actived 	<a href="?confirm={$all_coupon[i].coupon_id}&type=no" class="smart-btn btn-openfrm btn-pay-atm-conf-no">inactive</a>{/if} <a href="?confirm={$all_coupon[i].coupon_id}&type=delete" class="smart-btn btn-openfrm btn-pay-atm-conf-yes">Delete</a></td>	                          					
                    </tr>           
                 
                    {/section}
					   </form>
					    <form action="" method="post">
				
				  	<tr>                               
						<input type="hidden" value="addmore" name="admore_coupon" />        
                        <td><input type="text" name="code"  /></td>					
			
		
                        <td><input type="text" id="start_date" name="start_date" class="date-picker">
						
						<div class="popup-calendar-wrapper"><div class="popup-calendar" style="display: none;"></div></div></td>                    	
						<td><div class="date-picker-holder"><input type="text" id="end_date" name="end_date" class="date-picker"><div class="popup-calendar-wrapper"><div class="popup-calendar" style="display: none;"></div></div></div></td>
						<td><input type="text" name="percent" /></td>	
						<td><input type="text" name="length" /></td>		
						<td><input type="text" name="ref_code" /></td>				
						<td><input type="hidden" value="" name="status" /></td>
                    </tr> 
					 
				 <tr>
				 <td colspan="4">
				 <input type="submit"  style="float:right" value="Admore coupon" />
				 </td>
				 </tr>	
				 			 
				 </form>
				 
				 
                 </table>
              
				
                 <div class="paging" style="margin-top: 20px">
                    {section name=i loop=$paging}
                    <a title="{$paging[i][1]}" href="?keyword={$keyword}&approved={$approved}&paid={$paid}&auth={$auth}&page={$paging[i][0]}" class="{if $cursorPage==$paging[i][0]}btn3{else}btn2{/if}">{$paging[i][1]}</a>
                    {/section}
                 </div>
                 <script type="text/javascript" src="templates/default/js/jquery-1.7.1.min.js"></script>
                 <script type="text/javascript" src="templates/default/js/js_bank.js"></script>
                 <script type="text/javascript" src="templates/default/js/datePicker.js"></script>
              </div>
            </div>
          </div></td>
        </tr>
      </table>
      
</div>
{literal}
<style>
.smart-btn {display: inline-block}
.frm_search label {display: inline; margin: 0 8px 0 3px;}
/* Styles for the example page */


/* Date picker specific styles follow */

a.date-picker {
	width: 16px;
	height: 16px;
	border: none;
	color: #fff;
	padding: 0;
	margin: 0;
	float: left;
	overflow: hidden;
	cursor: pointer;
	background:url(templates/default/images/calendar.png)
}
a.date-picker span {
	margin: 0 0 0 -2000px;
}
div.date-picker-holder, div.date-picker-holder * {
	margin: 0;
	padding: 0;
}
div.date-picker-holder {
	position: relative;
}
div.date-picker-holder input {
	float: left;
}
div.popup-calendar {
	display: none;
	position: absolute;
	z-index: 2;
	top: 0;
	left: -16px; /* value for IE */
	padding: 4px;
	border: 2px solid #000;
	background: #fff;
	color: #000;
	overflow:hidden;
	width: 163px;
}
html>body div.popup-calendar {
	left: 99px; /* value for decent browsers */
}
div.popup-calendar div.link-close {
	float: right;
}
div.popup-calendar div.link-prev {
	float: left;
}
div.popup-calendar h3 {
	font-size: 1.3em;
	margin: 2px 0 5px 3px;
}
div.popup-calendar div.link-next {
	float: right;
}
div.popup-calendar div a {
	padding: 1px 2px;
	color: #000;
}
div.popup-calendar div a:hover {
	background-color: #000;
	color: #fff;
}
div.popup-calendar table {
	margin: 0;
}
* html div.popup-calendar table {
	display: inline;
}
div.popup-calendar table th, div.popup-calendar table td {
	background: #eee;
	width: 21px;
	height: 17px;
	text-align: center;
}
div.popup-calendar table td.inactive {
	color: #aaa;
	padding: 1px 0 0;
}
div.popup-calendar table th.weekend, div.popup-calendar table td.weekend {
	background: #f6f6f6;
}
div.popup-calendar table td a {
	display: block;
	border: 1px solid #eee;
	width: 19px;
	height: 15px;
	text-decoration: none;
	color: #333;
}
div.popup-calendar table td.today a {
	border-color: #aaa;
}
div.popup-calendar table td a.selected, div.popup-calendar table td a:hover {
	background: #333; 
	color: #fff;
}

</style>
.smart-btn {display: inline-block}
</style>
<script type="text/javascript">
$(document).ready(init);
function init()
{

	// OPTIONALLY SET THE DATE FORMAT FOR ALL DATE PICKERS ON THIS PAGE
	$.datePicker.setDateFormat('ymd', '-');
	
	// OPTIONALLY SET THE LANGUAGE DEPENDANT COPY IN THE POPUP CALENDAR
	/*
	$.datePicker.setLanguageStrings(
		['Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'S�bado'],
		['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		{p:'Anterior', n:'Siguiente', c:'Cierre', b:'Elija la fecha'}
	);
	*/
	
	// DIFFERENT OPTIONS SHOWING HOW YOU MIGHT INITIALISE THE DATE PICKER (UNCOMMENT ONE AT A TIME) //
	
	// all inputs with a class of "date-picker" have a date picker which lets you pick any date in the future
	//$('input.date-picker').datePicker();
	// OR
	// all inputs with a class of "date-picker" have a date picker which lets you pick any date after 05/03/2006
	//$('input.date-picker').datePicker({startDate:'05/03/2006'});
	// OR
	// all inputs with a class of "date-picker" have a date picker which lets you pick any date from today till 05/011/2006
	//$('input.date-picker').datePicker({endDate:'05/11/2006'});
	// OR
	// all inputs with a class of "date-picker" have a date picker which lets you pick any date from 05/03/2006 till 05/11/2006
	//$('input.date-picker').datePicker({startDate:'05/03/2006', endDate:'05/11/2006'});
	// OR 
	// the input with an id of "date" will have a date picker that lets you pick any day in the future...
	$('input#date1').datePicker();
	// ...and the input with an id of "date2" will have a date picker that lets you pick any day between the 02/11/2006 and 13/11/2006
	$('input#date2').datePicker({startDate:'02/6/2012', endDate:'13/11/2013'});

	/*
	// testing code to check the change event is fired...
	$('input#date1').bind(
		'change',
		function()
		{
			alert($(this).val());
		}
	);
	*/
	
	// END DIFFERENT OPTIONS //
}
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('.btn-pay-atm-conf-yes').click(function(){
        if(!confirm("Bạn muốn tiếp tục?")) {
            return false;
        }
    });
    $('.btn-pay-atm-conf-no').click(function(){
        if(!confirm("Bạn muốn tiếp tục?")) {
            return false;
        }
    });
});
</script>
{/literal}