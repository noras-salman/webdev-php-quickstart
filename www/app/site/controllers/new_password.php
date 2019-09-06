<?php
//confirm_reset_password

if(!isset($_GET["oobCode"])){
    header("Location: /login");
    exit();
}

if( isset($_POST["repassword"]) && isset($_POST["password"]) && isset($_GET["oobCode"])){

    if($_POST["password"]!=$_POST["repassword"]){
        header("Location: ?error=PASSWORD_MISSMATCH&oobCode=".$_GET["oobCode"]);
        exit();
    }

    $firebase=new FirebaseAuth();
    $result=$firebase->confirm_reset_password($_GET["oobCode"],$_POST["password"]);
    if($result->success){
        if(SessionManager::userAvailable()){
            header("Location: /dashboard?info=RESET_SUCCESS");
            exit();
        }

        $_POST["email"]=$result->email[0];
        $_POST["password"]=$_POST["password"];
        require(__DIR__."/login.php");
        exit();
    }else{
        header("Location: ?error=".$result->message."&oobCode=".$_GET["oobCode"]);
        exit();
    }
}

?>