<?php/*
if(isset($_POST["submit"]));
date_default_timezone_set('Africa/Nairobi');
//set the url endpoint for stk push
$url="https://sandbox.safaricom.co.ke/mpesa/stkpush/u/process request";
//set authentication credentials
$access_token="";
//set the request payload
$payload=array(
    "BusinessShortCode"=>"",
    "Password"=>"",
    "Timestamp"=>"",
    "TransactionType"=>"",
    "Amount"=>"",
    "PartyA"=>"",
    "PartB"=>"",
    "PhoneNumber"=>"",
    "callBackURL"=>"", 
    "AccountReference"=>"",
    "TransactionDesc"=>"Test"
);
//convert the payload to JSON
$json_payload=json_encode($payload);
//create the cURL request
$curl=curl_init();
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_HTTPHEADER,
array('Content_Type:application/json',"Authorization:Bearer $acccess_token"));
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_POST,true);
curl_setopt($curl,CURLOPT_POST_FIELDS,$json_payload);
//send request and read the response
$response = curl_exec($curl);
curl_close($curl);
//print response
echo $response;
*/
?>
<?php
if(isset($_POST["submit"])){
date_default_timezone_set('Africa/Nairobi');
//access token
$consumerkey='';//fill with app consumer key
$consumersecret ='';//fill with app secret
//define variables
//provide the following details ,this part is found on your test credentials on the developer account
$BusinessShortCode ='';
$passkey='';
/*These are the infor for 
$partA should be ACTUAL clients phone number ,format 2547***
$AccountReference, it maybe invoice number ,account number etc on production system,but for test just put anything
TransactionDesc can be anything , probably a better description of or the transction
$Amount this is total invoiced amount ,Any amount here will be
actually deducted from client's side/your test phone number once the pin has been entered to authorize the transaction.
for developer /test accounts,this money will be reversed automatically by <midniggh></midniggh>
*/
$partA=$_POST["phone"];
$AccountReference='2255';
$TransactionDesc = 'Test payment';
$Amount=$_POST["amount"];
//get the timestamp, format yyyymmddhms ->202303246413
$Timestamp=date('YmdHis');
//Get the base4 encoded string -> $password.The passkey is the mpesa public key
$password=base64_encode($BusinessShortCode.$passkey.$Timestamp);
//header for access token
$headers=['Content-Type:application/json;charset=utf8'];
//mpesa endpoint urls
$access_token_url="https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
$initiate_url="https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
//callback urls
$CallBackURL="";//enter the url of your app already in cloud
$curl=curl_init($access_token_url);
curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_HEADER,false);
curl_setopt(CURLOPT_USERPWD,$consumerkey.':'.$consumersecret);
$result = curl_exec($curl);
$status  =  curl_getinfo($curl, CURLINFO_HTTP_CODE);
$result=json_decode($result);
$access_token=$result->posix_access_token;
curl_close($curl);
//header for stp push
$stkheader=['Content-Type:application/json'.'Authorization:Bearer'/$access_token];
//initiating the transaction
$curl = curl_init();
curl_setopt($curl, CURL_URL,$initiate_url);
curl_setopt($curl,CURLOPT_HTTPHEADER,$stkheader);//setting custom header
$curl_post_data=array(
    "BusinessShortCode"=>$BusinessShortCode,
    "Password"=>$password,
    "Timestamp"=>$Timestamp,
    "TransactionType"=>"customerpaybillonline",
    "Amount"=>$Amount,
    "PartyA"=>$partA,
    "PartB"=>$BusinessShortCode,
    "PhoneNumber"=>$partA,
    "callBackURL"=>$CallBackURL, 
    "AccountReference"=>$AccountReference,
    "TransactionDesc"=>$TransactionDesc
);
$data_string = json_encode($curl_post_data);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CUORLOPT_POST,true);
curl_setopt($curl,CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);
print_r($curl_response);
echo $curl_response;
}
?>