<?php
require(__DIR__."/Database.php");
/** Build from init.sq */
$from_file=ture;

$db=new DatabaseConnection($from_file);
$db->rebuild();
$daos=array(
    new UserDao(),
    new ProfileDao()
);

if(!$from_file){
    foreach($daos as $dao){
        $dao->table->create();
    }
}
  

?>