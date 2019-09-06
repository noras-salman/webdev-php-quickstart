<?php
class IndexType extends Type{
   public  $name;

function __construct($name){
    $this->name=$name;
}

function getSql(){
    return false;
}

function getExtraSql(){
    return "INDEX(".$this->name.")";
}

}

function Index($name){
    return new IndexType($name);
}
?>