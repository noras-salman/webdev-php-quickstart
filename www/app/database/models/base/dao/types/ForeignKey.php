<?php
class ForeignKeyType extends Type{
    
    public $object;
    public $ref_table;
    public $ref_column;
 
    function  __construct($object,$ref_table,$ref_column){
        $this->object=$object;
        $this->ref_table=$ref_table;
        $this->ref_column=$ref_column;
    }

    function getSql(){
        return $this->object->getSql();
    }

    function getTable(){
        return $this->ref_table;
    }

    function getColumn(){
        return $this->ref_column;
    }
}

function ForeignKey($object,$ref_table,$ref_column){
    return new ForeignKeyType($object,$ref_table,$ref_column);
}
?>