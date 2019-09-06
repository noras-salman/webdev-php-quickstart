<?php

require(__DIR__."/languages/_default.php");
if(file_exists(__DIR__."/languages/".project_locale.".php")){
    require(__DIR__."/languages/".project_locale.".php");
}

define ("_TEXT_", serialize($_TEXT));
function getText($key){
    return unserialize (_TEXT_)[$key];
}
?>