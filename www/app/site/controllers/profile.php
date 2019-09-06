<?php
if(isset($_POST["update"])){
    
    if($_POST["name"]==""){
        header("Location: ?error=MISSING");
    exit();
    }

    $profile=new ProfileDao();
 
    $profile->updateManual($_POST,SessionManager::getUser()->db_user->id,"user_id");
    //reload to see reflected changes
    header("Location: #");
    exit();
}else if(isset($_POST["delete"])){
    //delete account
}else if(isset($_POST["reset"])){
    $firebase=new FirebaseAuth();
    $result=$firebase->reset_password(SessionManager::getUser()->email);
    if($result->success){
       
            header("Location: ?info=RESET_PASSWORD");
            exit();
      
    }

    header("Location: ?erroe=".$result->message);
    exit();
}
   
?>