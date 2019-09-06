<?php
class TextType extends Type{
    
    function __construct(){
    }

    function getSql(){
        return "TEXT";
    }
}
function Text(){
    return new TextType();
}
?>