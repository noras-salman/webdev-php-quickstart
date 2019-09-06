<?php

 
require 'vendor/autoload.php';
use Lcobucci\JWT\Parser;
 
class FirebaseAuth{
    function decode($idToken){
        $token=(new Parser())->parse((string) $idToken);
        $info=new stdClass();
        $info->expired=$token->isExpired();
        $info->aud=$token->getClaim('aud');
        $info->user_id=$token->getClaim('user_id');
        $info->email=$token->getClaim('email');
        $info->email_verified=$token->getClaim('email_verified');
        return $info;
    }
    
    /**
     * REFERENCE: https://firebase.google.com/docs/reference/rest/auth
     */
    
    function signin($email,$password){
        $fields = new stdClass();
        $fields->email= $email;
        $fields->password= $password;
        $fields->returnSecureToken=True;
        $headers = array(
            'Content-Type: application/json'
        );
    
      
        $request=new Request();
        $response=json_decode($request->post('https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key='.FIREBASE_API_KEY,$fields,true,$headers));
        $success=new stdClass();
        $success->success=ture;
        if(isset($response->error)){
            /**
            EMAIL_NOT_FOUND: There is no user record corresponding to this identifier. The user may have been deleted.
            INVALID_PASSWORD: The password is invalid or the user does not have a password.
            USER_DISABLED: The user account has been disabled by an administrator.
            */
            $success->success=false;
            $success->message=$response->error->message;
        }else{
              /**
                localId ,email ,displayName ,idToken ,registered,refreshToken,expiresIn
             */
            $success->email=$response->email;
            $success->idToken=$response->idToken;
            $success->registered=$response->registered;
            $success->refreshToken=$response->refreshToken;
            $success->expiresIn=$response->expiresIn;
            $decoded=$this->decode($response->idToken);
            $success->expired=$decoded->expired;
            $success->aud=$decoded->aud;
            $success->user_id=$decoded->user_id;
            $success->token_email=$decoded->email;
            $success->email_verified=$decoded->email_verified;

            $user=new stdClass();
            $user->email=$response->email;
            $user->idToken=$response->idToken;
            $user->email_verified=$decoded->email_verified;
            $success->user=$user;
            $success->has_user=true;
        }
        
        return $success;
    }
    
     
    function signup($email,$password){
        $fields = new stdClass();
        $fields->email= $email;
        $fields->password= $password;
        $fields->returnSecureToken=True;
        $headers = array(
            'Content-Type: application/json'
        );
    
      
        $request=new Request();
        $response=json_decode($request->post('https://identitytoolkit.googleapis.com/v1/accounts:signUp?key='.FIREBASE_API_KEY,$fields,true,$headers));
        $success=new stdClass();
        $success->success=ture;
        if(isset($response->error)){
            /**
            EMAIL_EXISTS: The email address is already in use by another account.
            OPERATION_NOT_ALLOWED: Password sign-in is disabled for this project.
            TOO_MANY_ATTEMPTS_TRY_LATER: We have blocked all requests from this device due to unusual activity. Try again later.
            */
            $success->success=false;
            $success->message=$response->error->message;
        }else{
              /**
                idToken ,email ,refreshToken ,expiresIn , localId
             */
            $success->email=$response->email;
            $success->idToken=$response->idToken;
            $success->localId=$response->localId;
            $success->refreshToken=$response->refreshToken;
            $success->expiresIn=$response->expiresIn;
            $decoded=$this->decode($response->idToken);
            $success->expired=$decoded->expired;
            $success->aud=$decoded->aud;
            $success->user_id=$decoded->user_id;
            $success->token_email=$decoded->email;
            $success->email_verified=$decoded->email_verified;

            $user=new stdClass();
            $user->email=$response->email;
            $user->idToken=$response->idToken;
            $user->email_verified=$decoded->email_verified;
            $success->user=$user;
            $success->has_user=true;
        }
        
        return $success;
    }
    
    function reset_password($email){
        $fields = new stdClass();
        $fields->email= $email;
        $fields->requestType= "PASSWORD_RESET";
        $headers = array(
            'Content-Type: application/json',
            'X-Firebase-Locale: '.project_locale
        );
    
      
        $request=new Request();
        $response=json_decode($request->post('https://identitytoolkit.googleapis.com/v1/accounts:sendOobCode?key='.FIREBASE_API_KEY,$fields,true,$headers));
        $success=new stdClass();
        $success->success=ture;
        if(isset($response->error)){
            /**
            EMAIL_NOT_FOUND: There is no user record corresponding to this identifier. The user may have been deleted.
            */
            $success->success=false;
            $success->message=$response->error->message;
        }else{
              /**
               array:: email
             */
            $success->email=$response->email;
        }
        
        return $success;
    }
    
    function verify_reset_password($oobCode){
        $fields = new stdClass();
        $fields->oobCode= $oobCode;
        $headers = array(
            'Content-Type: application/json'
        );
    
      
        $request=new Request();
        $response=json_decode($request->post('https://identitytoolkit.googleapis.com/v1/accounts:resetPassword?key='.FIREBASE_API_KEY,$fields,true,$headers));
        $success=new stdClass();
        $success->success=ture;
        if(isset($response->error)){
            /**
            OPERATION_NOT_ALLOWED: Password sign-in is disabled for this project.
            EXPIRED_OOB_CODE: The action code has expired.
            INVALID_OOB_CODE: The action code is invalid. This can happen if the code is malformed, expired, or has already been used.
            */
            $success->success=false;
            $success->message=$response->error->message;
        }else{
              /**
               email
             */
           
            $success->email=$response->email;
            $success->requestType=$response->requestType;
        }
        
        return $success;
    }
    
    
    function confirm_reset_password($oobCode,$newPassword){
        $fields = new stdClass();
        $fields->oobCode=$oobCode;
        $fields->newPassword=$newPassword;
        $headers = array(
            'Content-Type: application/json'
        );
    
      
        $request=new Request();
        $response=json_decode($request->post('https://identitytoolkit.googleapis.com/v1/accounts:resetPassword?key='.FIREBASE_API_KEY,$fields,true,$headers));
        $success=new stdClass();
        $success->success=ture;
        if(isset($response->error)){
            /**
            OPERATION_NOT_ALLOWED: Password sign-in is disabled for this project.
            EXPIRED_OOB_CODE: The action code has expired.
            INVALID_OOB_CODE: The action code is invalid. This can happen if the code is malformed, expired, or has already been used.
           USER_DISABLED: The user account has been disabled by an administrator.
            */
            $success->success=false;
            $success->message=$response->error->message;
        }else{
              /**
               email
             */
            $success->email=$response->email;
            $success->requestType=$response->requestType;
        }
        
        return $success;
    }
    
    
    
    function change_email($idToken,$email){
        $fields = new stdClass();
        $fields->idToken= $idToken;
        $fields->email= $email;
        $fields->returnSecureToken= true;
        $headers = array(
            'Content-Type: application/json',
            'X-Firebase-Locale: '.project_locale
        );
    
      
        $request=new Request();
        $response=json_decode($request->post('https://identitytoolkit.googleapis.com/v1/accounts:update?key='.FIREBASE_API_KEY,$fields,true,$headers));
        $success=new stdClass();
        $success->success=ture;
        if(isset($response->error)){
            /**
            EMAIL_EXISTS: The email address is already in use by another account.
            INVALID_ID_TOKEN:The user's credential is no longer valid. The user must sign in again.
            */
            $success->success=false;
            $success->message=$response->error->message;
        }else{
              /**
               localId ,email ,passwordHash ,providerUserInfo ,idToken ,refreshToken ,expiresIn
             */
            $success->localId=$response->localId;
            $success->idToken=$response->idToken;
            $success->email=$response->email;
            $success->passwordHash=$response->passwordHash;
            $success->providerUserInfo=$response->providerUserInfo;
            $success->refreshToken=$response->refreshToken;
            $success->expiresIn=$response->expiresIn;
            $decoded=$this->decode($response->idToken);
            $success->expired=$decoded->expired;
            $success->aud=$decoded->aud;
            $success->user_id=$decoded->user_id;
            $success->token_email=$decoded->email;
            $success->email_verified=$decoded->email_verified;

            $user=new stdClass();
            $user->idToken=$response->idToken;
            $user->email=$response->email;
            $user->email_verified=$decoded->email_verified;
            $success->user=$user;
            $success->has_user=true;
        }
        
        return $success;
    }
    
    function change_password($idToken,$password){
        $fields = new stdClass();
        $fields->idToken= $idToken;
        $fields->password= $password;
        $fields->returnSecureToken= true;
        $headers = array(
            'Content-Type: application/json'
        );
    
      
        $request=new Request();
        $response=json_decode($request->post('https://identitytoolkit.googleapis.com/v1/accounts:update?key='.FIREBASE_API_KEY,$fields,true,$headers));
        $success=new stdClass();
        $success->success=ture;
        if(isset($response->error)){
            /**
            INVALID_ID_TOKEN:The user's credential is no longer valid. The user must sign in again.
            WEAK_PASSWORD: The password must be 6 characters long or more.
            */
            $success->success=false;
            $success->message=$response->error->message;
        }else{
              /**
               localId ,email ,passwordHash ,providerUserInfo ,idToken ,refreshToken ,expiresIn
             */
            $success->localId=$response->localId;
            $success->idToken=$response->idToken;
            $success->email=$response->email;
            $success->passwordHash=$response->passwordHash;
            $success->providerUserInfo=$response->providerUserInfo;
            $success->refreshToken=$response->refreshToken;
            $success->expiresIn=$response->expiresIn;
            $decoded=$this->decode($response->idToken);
            $success->expired=$decoded->expired;
            $success->aud=$decoded->aud;
            $success->user_id=$decoded->user_id;
            $success->token_email=$decoded->email;
            $success->email_verified=$decoded->email_verified;

            $user=new stdClass();
            $user->idToken=$response->idToken;
            $user->email=$response->email;
            $user->email_verified=$decoded->email_verified;
            $success->user=$user;
            $success->has_user=true;
        }
        
        return $success;
    }
     
    
    function send_email_verification($idToken){
        $fields = new stdClass();
        $fields->idToken= $idToken;
        $fields->requestType= "VERIFY_EMAIL";
        $headers = array(
            'Content-Type: application/json',
            'X-Firebase-Locale: '.project_locale
        );
    
      
        $request=new Request();
        $response=json_decode($request->post('https://identitytoolkit.googleapis.com/v1/accounts:sendOobCode?key='.FIREBASE_API_KEY,$fields,true,$headers));
        $success=new stdClass();
        $success->success=ture;
        if(isset($response->error)){
            /**
            INVALID_ID_TOKEN: The user's credential is no longer valid. The user must sign in again.
            USER_NOT_FOUND: There is no user record corresponding to this identifier. The user may have been deleted.
            */
            $success->success=false;
            $success->message=$response->error->message;
        }else{
              /**
               array:: email
             */
            $success->email=$response->email;
        }
        
        return $success;
    }
    
    function confirm_email_verification($oobCode){
        $fields = new stdClass();
        $fields->oobCode= $oobCode;
     
        $headers = array(
            'Content-Type: application/json'
        );
    
      
        $request=new Request();
        $response=json_decode($request->post('https://identitytoolkit.googleapis.com/v1/accounts:update?key='.FIREBASE_API_KEY,$fields,true,$headers));
        $success=new stdClass();
        $success->success=ture;
        if(isset($response->error)){
            /**
            EXPIRED_OOB_CODE: The action code has expired.
            INVALID_OOB_CODE: The action code is invalid. This can happen if the code is malformed, expired, or has already been used.
            USER_DISABLED: The user account has been disabled by an administrator.
            EMAIL_NOT_FOUND: There is no user record corresponding to this identifier. The user may have been deleted.
            */
            $success->success=false;
            $success->message=$response->error->message;
        }else{
              /**
               array:: email
             */
            $success->email=$response->email;
            $success->displayName=$response->displayName;
            $success->photoUrl=$response->photoUrl;
            $success->passwordHash=$response->passwordHash;
            $success->providerUserInfo=$response->providerUserInfo;
            $success->emailVerified=$response->emailVerified;

            $user=new stdClass();
            $user->email=$response->email;
            $user->email_verified=$response->emailVerified;
            $success->user=$user;
            $success->has_user=true;
        }
        
        return $success;
    }
    
    
    function delete_account($idToken){
        $fields = new stdClass();
        $fields->idToken= $idToken;
     
        $headers = array(
            'Content-Type: application/json'
        );
    
      
        $request=new Request();
        $response=json_decode($request->post('https://identitytoolkit.googleapis.com/v1/accounts:delete?key='.FIREBASE_API_KEY,$fields,true,$headers));
        $success=new stdClass();
        $success->success=ture;
        if(isset($response->error)){
            /**
            INVALID_ID_TOKEN:The user's credential is no longer valid. The user must sign in again.
            USER_NOT_FOUND: There is no user record corresponding to this identifier. The user may have been deleted.
            */
            $success->success=false;
            $success->message=$response->error->message;
        }else{
                //nothing
        }
        
        return $success;
    }
    
    
    function refreshToken($refresh_token){
        $fields = new stdClass();
        $fields->refresh_token=$refresh_token;
        $fields->grant_type="refresh_token";
    
        
        $headers = array(
            'Content-Type: application/json'
        );
    
      
        $request=new Request();
        $response=json_decode($request->post('https://securetoken.googleapis.com/v1/token?key='.FIREBASE_API_KEY,$fields,true,$headers));
        $success=new stdClass();
        $success->success=ture;
        if(isset($response->error)){
           /**
            TOKEN_EXPIRED: The user's credential is no longer valid. The user must sign in again.
            USER_DISABLED: The user account has been disabled by an administrator.
            USER_NOT_FOUND: The user corresponding to the refresh token was not found. It is likely the user was deleted.
            API key not valid. Please pass a valid API key. (invalid API key provided)
            INVALID_REFRESH_TOKEN: An invalid refresh token is provided.
            Invalid JSON payload received. Unknown name \"refresh_tokens\": Cannot bind query parameter. Field 'refresh_tokens' could not be found in request message.
            INVALID_GRANT_TYPE: the grant type specified is invalid.
            MISSING_REFRESH_TOKEN: no refresh token provided.
            */
            $success->success=false;
            $success->message=$response->error->message;
        }else{
                //nothing
                /**
                 expires_in,token_type,refresh_token,id_token,user_id,project_id
                 */
                $success->expires_in=$response->expires_in;
                $success->token_type=$response->token_type;
                $success->refreshToken=$response->refresh_token;
                $success->idToken=$response->id_token;
                $success->user_id=$response->user_id;
                $success->project_id=$response->project_id;
             
                $decoded=$this->decode($response->id_token);
                $success->expired=$decoded->expired;
                $success->aud=$decoded->aud;
                $success->user_id=$decoded->user_id;
                $success->email=$decoded->email;
                $success->token_email=$decoded->email;
                $success->email_verified=$decoded->email_verified;

                $user=new stdClass();
                $user->idToken=$response->id_token;
                $user->email=$decoded->email;
                $user->email_verified=$decoded->email_verified;
                $success->user=$user;
                $success->has_user=true;
        }
        
        return $success;
    }
    
}
?>