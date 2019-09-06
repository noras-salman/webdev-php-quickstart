<?php
  
    if( isset($_POST["email"]) && isset($_POST["password"]) ){
        $firebase=new FirebaseAuth();
        $result=$firebase->signin($_POST["email"],$_POST["password"]);
        if($result->success){
            SessionManager::setUser($result->user,$result->refreshToken);
            header("Location: /dashboard");
            exit();
        }else{
            header("Location: ?error=".$result->message);
            exit();
        }
    } 

?>