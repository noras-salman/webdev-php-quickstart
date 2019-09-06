<?php

 

    if(isset($_GET["oobCode"]) && isset($_GET["mode"])){

        $firebase=new FirebaseAuth();
        if($_GET["mode"]==="verifyEmail"){
                //verify code
                $result=$firebase->confirm_email_verification($_GET["oobCode"]);
                if($result->success){
                    if(SessionManager::userAvailable()){
                        if(SessionManager::getUser()->email==$result->email){
                            SessionManager::getUser()->email_verified=true;
                        }
                        header("Location: /dashboard?info=EMAIL_VERIFIED");
                        exit();
                    }
                    header("Location: ?info=EMAIL_VERIFIED");
                    exit();
                }else{
                    header("Location: ?error=".$result->message);
                    exit();
                }
                
        }

        if($_GET["mode"]==="resetPassword"){
                $result=$firebase->verify_reset_password($_GET["oobCode"]);
                if($result->success){
                    header("Location: /new_password?oobCode=".$_GET["oobCode"]);
                    exit();
                }
                header("Location: ?oobCode=".$_GET["oobCode"]."&error=".$result->message);
                exit();

        }
    }


    if(isset($_GET["mode"])){
        if(SessionManager::userAvailable() && $_GET["mode"]=="requestEmailVerification" ){
            $firebase=new FirebaseAuth();
            $result=$firebase->send_email_verification(SessionManager::getUser()->idToken);
            if($result->success){
                header("Location: ?info=VERIFICATION_REQUESTED");
                exit();
            }
            header("Location: ?error=".$result->message);
            exit();
        }
    }

    // waiting, error , success, sent
?>