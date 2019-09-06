<?php

$_ROUTE_MANGER=new RouteManager();

/** -------- ------- -------- -------- ----------- */
/** Inser your routes here */
$root=new Route("root","index.php");
$root->setPageTitle(MAIN_SUBTITLE);
$root->setRedirectWhen(SessionManager::userAvailable());
$root->setRedirectTo("/dashboard");
/** Push */

$_ROUTE_MANGER->addRoute($root->getRoute());

$not_found=new Route("404","404.php"); 
$_ROUTE_MANGER->addRoute($not_found->getRoute());

$login=new Route("login","login.php"); 
$login->setController("login.php");
$login->setRedirectWhen(SessionManager::userAvailable());
$login->setRedirectTo("/dashboard");
$_ROUTE_MANGER->addRoute($login->getRoute());

$password_reset=new Route("password_reset","password_reset.php"); 
$password_reset->setController("password_reset.php");
$_ROUTE_MANGER->addRoute($password_reset->getRoute());

$email_verification=new Route("email_verification","email_verification.php"); 
$email_verification->setController("email_verification.php");
$_ROUTE_MANGER->addRoute($email_verification->getRoute());

$new_password=new Route("new_password","new_password.php"); 
$new_password->setController("new_password.php");
$_ROUTE_MANGER->addRoute($new_password->getRoute());

$profile=new Route("profile","profile.php"); 
$profile->setController("profile.php");
$_ROUTE_MANGER->addRoute($profile->getRoute());

$logout=new Route("logout","dashboard.php"); 
$logout->setController("logout.php");
$_ROUTE_MANGER->addRoute($logout->getRoute());



$register=new Route("register","register.php"); 
$register->setController("register.php");
$_ROUTE_MANGER->addRoute($register->getRoute());


$dashboard=new Route("dashboard","dashboard.php"); 
$dashboard->setRedirectWhen(!SessionManager::userAvailable());
$dashboard->setRedirectTo("/login");
$_ROUTE_MANGER->addRoute($dashboard->getRoute());

?>