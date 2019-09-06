<?php
class VarcharType extends Type{
    
    public $length;
 
    function __construct($length){
        $this->length=$length;
    }

    function getSql(){
        return "VARCHAR(".$this->length.")";
    }
}

function Varchar($length){
    return new VarcharType($length);
}
?>