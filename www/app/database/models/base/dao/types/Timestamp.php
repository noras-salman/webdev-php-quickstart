<?php
class TimestampType extends Type{
    
    function __construct(){
    }

    function getSql(){
        return "TIMESTAMP";
    }
}

function Timestamp(){
    return new TimestampType();
}
?>