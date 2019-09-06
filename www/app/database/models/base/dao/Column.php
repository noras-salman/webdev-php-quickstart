<?php
require(__DIR__."/types/Type.php");
require(__DIR__."/types/Integer.php");
require(__DIR__."/types/Double.php");
require(__DIR__."/types/Varchar.php");
require(__DIR__."/types/Text.php");
require(__DIR__."/types/Timestamp.php");
require(__DIR__."/types/Datetime.php");
require(__DIR__."/types/PrimaryKey.php");
require(__DIR__."/types/ForeignKey.php");

class ColumnType{
    public $name;
    public $type;
    public $props;

    function  __construct($name,$type,$props=""){
        $this->name=$name;
        $this->type=$type;
        $this->props=$props;
    }

    function getSql(){
        return $this->name." ".$this->type->getSql()." ".$this->props;
    }

    function getExtraSql(){
        $extra=false;
        if($this->isPrimaryKey()){
            $extra="PRIMARY KEY (".$this->name.")";
        }else if($this->isForeignKey()){
            $extra="FOREIGN KEY (".$this->name.") REFERENCES ".$this->type->getTable()."(".$this->type->getColumn().")";
        }
        return $extra;
    }

    function isPrimaryKey(){
        return get_class($this->type)=="PrimaryKeyType";
    }

    function isForeignKey(){
        return get_class($this->type)=="ForeignKeyType";
    }
}
function Column($name,$type,$props=""){
    return new ColumnType($name,$type,$props);
}
?>