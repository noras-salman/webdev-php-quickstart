<?php
/** Global configuration */
require(__DIR__.'/config.php');
require(__DIR__.'/locale/Locale.php');
require(__DIR__.'/database/Database.php');
require(__DIR__.'/modules/Modules.php');
require(__DIR__.'/Routes.php');


$_ROUTER=new Router($_ROUTE_MANGER->getRoutes());
if(!array_key_exists($_ROUTER->current_path,$_ROUTER->active_routes)){
    http_response_code(404);
    header("Location: /404");
}


$_ROUTER->getCurrentRoute()->checkPrevention();
$_ROUTER->getCurrentRoute()->checkRedirect();

if($_ROUTER->getCurrentRoute()->hasController()){
     require($_ROUTER->getCurrentRoute()->getController());
}

 
require(CONTENT_FILE);
?>