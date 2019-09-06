<?php

require_once(__DIR__."/firebase_functions.php");

class FirebaseSession{

    function __construct(){
      

         if(!isset($_SESSION["user"]) && isset($_COOKIE["access"])){
            $response=refreshToken($_COOKIE["access"]);
            if($response->success){
                 
                $_SESSION["user"]=$response;
            }
        }

        if(isset($_SESSION["user"])){
            //logedin
            if(isset($_SESSION["user"]->refreshToken))
                $_COOKIE["access"]=$_SESSION["user"]->refreshToken;
            
            if(isset($_SESSION["user"]->refresh_token))
                $_COOKIE["access"]=$_SESSION["user"]->refresh_token;

           
        }

    }

    function userLoggedIn(){
        return isset($_SESSION["user"]);
    }

    function login($email,$password){
        $response=signin($email,$password);
         
        if($response->success){
            
            if(email_verification_required && !$response->email_verified){
                $_COOKIE["access"]=$response->refreshToken;
                $_SESSION["user"]=$response;

                header('Location: '.verification_path."?waiting=1");
                exit();
            }else{
                $_COOKIE["access"]=$response->refreshToken;
                $_SESSION["user"]=$response;
                header('Location: '.success_path);
                exit();
            }
        }else{
            header('Location: ?error='.$response->message);
            exit();
        }
    }

    function register($email,$password){
        $response=signup($email,$password);
        if(!$response->success){
            header('Location: ?error='.$response->message);
            exit();
        }

        $_COOKIE["access"]=$response->refreshToken;
        $_SESSION["user"]=$response;
        $success=send_email_verification($response->idToken);
        if($success->success){
            return True;
        }

        header('Location: ?error='.$success->message);
 
    }

    function verify_email_code($code){
        $response=confirm_email_verification($code);
        if($response->success){
     
            header('Location: ?success=1');


        }else{
            header('Location: ?error='.$response->message);
        }
    }


  
    

}
?>