<?php
if(isset($_POST["email"])){
  
        $firebase=new FirebaseAuth();
        $result=$firebase->reset_password($_POST["email"]);
        if($result->success){
            
            header("Location: /login?info=RESET_PASSWORD");
            exit();
        }else{
            header("Location: ?error=".$result->message);
        }

        // on prod better dont check for result only say ok we have sent  header("Location: /login?ref=reset_password");
}
?>