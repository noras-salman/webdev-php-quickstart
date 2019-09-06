<?php

class CookieManager{

    /** TODO: IMPLEMENT */
    public static function refreshCookie(){
        $firebase=new FirebaseAuth();
        return $firebase->refreshToken($_COOKIE["access"]);
    }

    public static function setAccessCookie($value){
        CookieManager::setCookie("access",$value);
    }

    public static function accessCookieAvailable(){
        return isset($_COOKIE["access"]);
    }

    public static function getAccessCookie(){
        return $_COOKIE["access"];
    }

    public static function clearAccessCookie(){
        CookieManager::deleteCookie("access");
    }


    public static function setCookie($name,$value){
        setcookie($name, $value, time() + (86400 * 30), "/");
    }

    public static function deleteCookie($name){
        setcookie($name, "", time() - 3600);
    }

   
}

?>