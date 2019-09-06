<?php
class DateType extends Type{
    
    function  __construct(){
    }

    function getSql(){
        return "DATE";
    }
}

function Datetime(){
    return new DateType();
}
?>