<?php
class IntegerType extends Type{
    
    function  __construct(){
    }

    function getSql(){
        return "INT";
    }
}

function Integer(){
    return new IntegerType();
}
?>