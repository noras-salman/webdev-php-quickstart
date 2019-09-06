<?php
require(__DIR__."/core/Request.php");
require(__DIR__."/core/Template.php");
require(__DIR__."/core/router/Route.php");
require(__DIR__."/core/router/RouteManager.php");
require(__DIR__."/core/router/Router.php");
require(__DIR__."/core/access/AccessManager.php");
require(__DIR__."/firebase_authentication/firebase_functions.php");

/** Use access manager */
new AccessManager();

?>