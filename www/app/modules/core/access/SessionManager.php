<?php

class SessionManager{

    public static function setUser($user,$access_token,$set_access=true){

        $_SESSION["user"]=$user;
        $email=$user->email;
        SessionManager::refreshDatabaseUser();
        if($set_access){
            CookieManager::setAccessCookie($access_token);
            $_SESSION["access"]=$access_token;
  
        }
      
    }

    public static function refreshDatabaseUser(){
        $session_user=new UserDao();
        $email=$_SESSION["user"]->email;
        $query=$session_user->queryExtended("WHERE email='$email'");
        if($query->row_count>0){
            $_SESSION["user"]->db_user=$query->results[0];
        }
    }

    public static function userAvailable(){
        return isset($_SESSION["user"]);
    }

    public static function getUser(){
       
        return $_SESSION["user"];
    }

    public static function getAccessToken(){
        return $_SESSION["access"];
    }

    public static function distroy(){
        // remove all session variables
        session_unset(); 

        // destroy the session 
        session_destroy(); 
        CookieManager::clearAccessCookie();

    }
}

?>