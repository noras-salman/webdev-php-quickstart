<?php
class DoubleType extends Type{
    
    function  __construct(){
    }

    function getSql(){
        return "DOUBLE";
    }
}

function Double(){
    return new DoubleType();
}
?>