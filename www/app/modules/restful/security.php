<?php

require('database_includes.php');
require('firebase_security.php');


 
/*Converts JSON post to ARRAY*/
if(!isset($_SERVER["CONTENT_TYPE"]) || $_SERVER["CONTENT_TYPE"]!='application/x-www-form-urlencoded')
	$_POST=jsonPOSTtoArrayPost();

$token_verification=null; //this is reurned after verififcation 

/* $response Always contains success: boolean */


if(isset($_POST['firebaseToken'])){
	
	try {
		$token_verification=verifyJWT($_POST['firebaseToken']);
	} catch (Exception $e) {
		 throwError($e->getMessage()); 
	}	
	if(!$token_verification->success)
         die(json_encode($token_verification));
	else{
		updateUserPresenceByEmail($token_verification->email);
	}
	 
	

}else{
     
        throwError('AUTHENTICATION_TOKEN_MISSING');
}


function throwError($message){
    $response=new stdClass();
       $response->success=false;
       $response->message=$message;
       die(json_encode($response));
}

function putResponse($content){
     $response=new stdClass();
     $response->success=true;
     $response->response=$content;
     die(json_encode($response));
}

function putSuccess($content){
     $response=new stdClass();
     $response->success=true;
     $response->message=$content;
     die(json_encode($response));
}

function isEmptyObject($object){
	$tmp = (array) $object;
	return empty($tmp);
}

function jsonPOSTtoArrayPost(){
	$data = json_decode(file_get_contents('php://input'), true);
	return (array)$data;
}

function check_base64_image($base64) {
    $img = imagecreatefromstring(base64_decode($base64));
    if (!$img) {
        return false;
    }
	
	$t = microtime(true);
	$micro = sprintf("%06d",($t - floor($t)) * 1000000);
	$d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );

	$tmp_file_name='/tmp/tmp'.$d->format("Y-m-d-H-i-s-u").'.png';
	
    imagepng($img, $tmp_file_name);
    $check = getimagesize($tmp_file_name);
    unlink($tmp_file_name);

    if ($check) {
        return true;
    }

    return false;
}
?>