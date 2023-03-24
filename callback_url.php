<?php
header("Content-Type:application/json");
$response='{
    "ResultCode": 0,
    "ResultDesc":"confirmation Received Successfully"
}';
//DATA
$mpesaResponse = file_get_contents('php://input');
//log the response
$logFile="M_PESAConfrimationResponse.txt";
//write to file
$log = fopen($logFile, "a");
fwrite($log, $mpesaResponse);
fclose($log);
echo $response;
?>