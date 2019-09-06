<?php
require(__DIR__."/config.php");
require(__DIR__."/models/core/DatabaseConnection.php");
require(__DIR__."/models/base/Dao.php");
foreach(glob(__DIR__."/models/*.php") as $file){
        require($file);
}
?>