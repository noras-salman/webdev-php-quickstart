<?php
require(__DIR__."/Column.php");
require(__DIR__."/Index.php");


class Table{

    public $table_name;
    public $columns;

    function __construct($table_name,$columns=[]){
        $this->table_name=$table_name;
        $this->columns=$columns;
 
    }

    function getSql(){
        $column_sql=[];
        $column_sql_extral=[];
       
        foreach($this->columns as $column){
            if($column->getSql()!=false){
                array_push($column_sql, $column->getSql());
            }
            if($column->getExtraSql()!=false){
                array_push($column_sql_extral,$column->getExtraSql());
            }
        }
        $column_sql_final="";
        if(count($column_sql)>0){
            $column_sql_final.=join(",\n",$column_sql);
        }
        if(count($column_sql_extral)>0){
            $column_sql_final.=",\n".join(",\n",$column_sql_extral);
        }

        return "CREATE TABLE IF NOT EXISTS ".$this->table_name."(\n $column_sql_final \n);";
    }


    function getPrimaryKey(){
        foreach($this->columns as $column){
             if($column->isPrimaryKey()){
                 return $column->name;
             }
        }
        return false;
    }

    function create(){
        $db=new DatabaseConnection();
        $result=mysqli_query($db->getConnection(),$this->getSql());
        $db->close();
        return $result;
    }


}
?>