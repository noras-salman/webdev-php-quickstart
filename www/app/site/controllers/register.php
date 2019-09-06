<?php
 
if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"])){
    
    $firebase=new FirebaseAuth();
    $result=$firebase->signup($_POST["email"],$_POST["password"]);
    if($result->success){
        $user=new UserDao();
        $insert=$user->insert($_POST);
 
        if($insert->success){
            $profile=new ProfileDao();
            $_POST["user_id"]=$insert->id;
            $profile->insert($_POST);
        }

        $firebase->send_email_verification($result->idToken);
        SessionManager::setUser($result->user,$result->refreshToken);
        header("Location: /dashboard");
        exit();

    }else{
        header("Location: ?error=".$result->message);
        exit();
    }
}

?>