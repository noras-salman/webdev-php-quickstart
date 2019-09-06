<?php
class PrimaryKeyType extends Type{
    
    public $object;
 
    function __construct($object){
        $this->object=$object;
    }

    function getSql(){
        return $this->object->getSql();
    }
 
}
function PrimaryKey($object){
    return new PrimaryKeyType($object);
}
?>