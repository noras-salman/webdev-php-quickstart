<?php
	

	//for the vendor package
	require 'vendor/autoload.php';
	require_once(__DIR__ ."/../../config.php");
	
	use Lcobucci\JWT\Parser;

	//another library used to verify the signature
	use \Firebase\JWT\JWT;

	function verifyJWT($jwt)
	{
		$response=new stdClass();
		$response->success=true;	
		$token=(new Parser())->parse((string) $jwt);
		
	

		//jwt header 	
		$alg=$token->getHeader('alg');
	
		if($alg!="RS256"){
			$response->message='WRONG_ALGORATHIM';
			return $response;
		}

		$kid=$token->getHeader('kid');
		/*here we have to validate the key against the keys in the gserviceaccount.json file,search there if it is found or not
		
		 the gserviceaccoung is  a json file pulled from https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com
		 maybe it is better to pull it each time in case it is changing
		*/
		
		$keys=json_decode(file_get_contents("https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com"),true);
		$found_kid=false;
		foreach ($keys as $key=>$value) {	
			if($kid==$key)
				$found_kid=true;
		}

		if(!$found_kid)
			{
				
				$response->message='KID_NOT_FOUND';
			return $response;
			}
			
		//check the time values
		//expiretion time
		if($token->isExpired()){
				
				$response->message='TOKEN_EXPIRED';
			/*return $response;*/
			throwError('TOKEN_EXPIRED');
		}
		
		//issued at time
		$iat=$token->getClaim('iat');
		if(strtotime($iat) >= time()){
		
				$response->message='ISSUED_TIME_NOT_IN_THE_PAST';
			return $response;
		}
		
		//audience claim
		$aud=$token->getClaim('aud');
	 
		if($aud !=FIREBASE_PROJECT_ID){
			
			$response->message='WRONG_AUDIENCE';
			return $response;
		}
				
		//issuer claim
		$issuer_url="https://securetoken.google.com/".FIREBASE_PROJECT_ID;

		$iss=$token->getClaim('iss');
		
		if( $iss!=$issuer_url){
				
			$response->message='WRONG_ISSUER_URL';
			return $response;
		}
		

		//the subject claim which hold the user or the device uid
		$sub=$token->getClaim('sub');
		if($sub==null){
			
			$response->message='EMPTY_SUB';
			return $response;
		}
		//verify that the this token  was signed with firebase private key
		//get the public key from the file
		$public_key=$keys[$kid];
		
			try{
				$decoded = JWT::decode($jwt, $public_key, array('RS256'));
				
			}
			catch(Firebase\JWT\SignatureInvalidException $excption){
			
			$response->message='VERIFICATION_FAILED';
			return $response;
			}
			catch( Firebase\JWT\BeforeValidException $excption){

				//ignore
			}
			
			
			
			$email_verified=$token->getClaim('email_verified');
			$response->email=$token->getClaim('email');
			$response->uid=$sub;
			$response->email_verified=$email_verified;
			
		if(!$email_verified){
			$response->message='EMAIL_VERIFICATION_MISSING';
			return $response;
		}
			
			
			
			$response->success=true;
			$response->message='SUCCESS';
			$response->token=$jwt;
			
			return $response;
	
	}
	
	
	
?>