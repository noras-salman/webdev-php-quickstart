<?php
require(__DIR__."/CookieManager.php");
require(__DIR__."/SessionManager.php");
class AccessManager{

    function __construct(){
        if(SessionManager::userAvailable()){
            //update latest session token
            CookieManager::setAccessCookie(SessionManager::getAccessToken());
            SessionManager::refreshDatabaseUser();

        }else{
            if(CookieManager::accessCookieAvailable()){
                
                $this->validateCookieRefresh();
            }
        }
    }

    /** Todo implement */
    function validateCookieRefresh(){
        $result=CookieManager::refreshCookie();
        if($result->success){
                SessionManager::setUser($result->user,$result->refreshToken);

        }else{
            CookieManager::clearAccessCookie();
        }
    }
}

?>