<?php
include ("include/config.php");
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';

		foreach ($_POST as $key => $value) 
		{
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}

		// post back to PayPal system to validate
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Host: www.paypal.com:80\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

		// assign posted variables to local variables
		$item_name			= $_POST['item_name'];
		$item_number		= $_POST['item_number'];
		$payment_status		= $_POST['payment_status'];
		$payment_amount		= $_POST['mc_gross'];
		$payment_currency	= $_POST['mc_currency'];
		$txn_id				= $_POST['txn_id'];
		$receiver_email		= $_POST['receiver_email'];
		$payer_email		= $_POST['payer_email'];

		if (!$fp) 
		{
			// HTTP ERROR
		} 
		else 
		{
			fputs ($fp, $header . $req);
			while (!feof($fp))
			{
				$res = fgets ($fp, 1024);
				if (strcmp ($res, "VERIFIED") == 0) 
				{
				}
				else if (strcmp ($res, "INVALID") == 0)
				{
				}
			}
			fclose ($fp);
		}


		$arrInvalidStatus = array('Denied', 'Expired', 'Failed', 'Voided');
		$ifFlag			  = 0;
		$msg			  = '';
		$sql			  = '';

		if ( !in_array($payment_status, $arrInvalidStatus) )
		{
			$ids	= $item_number;
			$ifFlag = 1;
			
			if ( $ids != '' )
			{
				$sql	= "UPDATE ".PREFIX."USER_AD_SOLD SET ISPAYED='Y' WHERE ID IN (".$ids.")";
				

				if ( $result > 0 )
					$msg = "Payment Successfuly Made.";
				else
					$msg = "Payment Partially Made. Please contact administrator.";
				
				$arrIds = explode(",", $ids);
				foreach ( $arrIds as $id )
				{
					//sendEmailBuyerAdBought('', $id);
					//sendEmailSellerAdSold('', $id);
				}
			}
			else
				$msg = "Item number passed by paypal is empty.";

		}
		else
		{
		}

		$msg = "
Hello,

IPN called:

item_name			= $item_name
item_number			= $item_number
payment_status		= $payment_status
payment_amount		= $mc_gross
payment_currency	= $mc_currency
txn_id				= $txn_id
receiver_email		= $receiver_email
payer_email			= $payer_email	
i f - flag			= $ifFlag
msg					= $msg
sql					= $sql

Following data was sent back to paypal:

$req		


";

mail("adnan.eee@gmail.com, kisyrua@gmail.com","TextLink PayPal Debugging...",$msg);

?>