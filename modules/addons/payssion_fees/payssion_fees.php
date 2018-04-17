<?php

if (!defined("WHMCS")) die("This file cannot be accessed directly");

function payssion_fees_config()
{
	$configarray = array(
		"name" => "Payssion Gateway Fees",
		"description" => "Add fees based on the payment methods.",
		"version" => "1.0.0",
		"author" => "Payssion"
	);
	
	$result = mysql_query("select * from tblpaymentgateways where gateway like 'payssion%' group by gateway");
	while ($data = mysql_fetch_array($result)) {
		$name = substr($data['gateway'], strlen('payssion'));
		$configarray['fields']["fee_1_" . $data['gateway']] = array(
			"FriendlyName" => $name,
			"Type" => "text",
			"Default" => "0.00",
			"Description" => "$"
		);
		$configarray['fields']["fee_2_" . $data['gateway']] = array(
			"FriendlyName" => $name,
			"Type" => "text",
			"Default" => "0.00",
			"Description" => "%<br />"
		);
	}

	return $configarray;
}

function payssion_fees_activate()
{
	$result = mysql_query("select * from tblpaymentgateways where gateway like 'payssion%' group by gateway");
	while ($data = mysql_fetch_array($result)) {
		$query2 = "insert into `tbladdonmodules` (module,setting,value) value ('gateway_fees','fee_1_" . $data['gateway'] . "','0.00' )";
		$result2 = mysql_query($query2);
		$query3 = "insert into `tbladdonmodules` (module,setting,value) value ('gateway_fees','fee_2_" . $data['gateway'] . "','0.00' )";
		$result3 = mysql_query($query3);
	}
}

?>