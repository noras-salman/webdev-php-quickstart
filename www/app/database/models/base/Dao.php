<?php
require(__DIR__."/dao/Table.php");
class Dao{
    public $table_name;
    public $indexes=[];
    public $columns=[];
    public $table;

    function __construct(){
        $this->table=$this->getTable();
    }

    //override to append more than standards
    function appendOnQuery($binded,$row){
        return $binded;
    }

    function getProperties(){
        $properties=[];
        foreach(get_object_vars($this) as $key=>$value){
            if(is_object($value) && get_class($value)=="ColumnType")  
                array_push($properties,$value->name);
        }
        return $properties;
     }


 function getTable(){
        foreach(get_object_vars($this) as $key=>$value){
            if(is_object($value) && get_class($value)=="ColumnType")            
                array_push($this->columns,$value);
        }

        foreach($this->indexes as $value){
            if(get_class($value)=="IndexType")
            array_push($this->columns,$value); 
          
        }

        return new Table($this->table_name,$this->columns);
    }

    function addIndex($index){
        array_push($this->indexes,$index);
    }

    function object_to_array($data){
        if (is_array($data) || is_object($data)){
            $result = array();
            foreach ($data as $key => $value)
            {
                $result[$key] = $this->object_to_array($value);
            }
            return $result;
        }
        return $data;
        }

    function insert($object){
        $db=new DatabaseConnection();
        $preped_values=array();
        $variables=array();

        if(is_object($object)){
            $object=$this->object_to_array($object);
        }

        foreach(get_object_vars($this) as $key => $value){
           

            if(isset($object[$key])){
                $prepared_value=$db->escape_for_insert($object[$key]);
                if(!is_numeric($prepared_value)){
                    $prepared_value="'".$prepared_value."'";
                }

                array_push($variables,$key);
                array_push($preped_values,$prepared_value);
            }

        }

        $variables=join(",",$variables);
        $values=join(",",$preped_values);
        
        $sql="INSERT INTO ".$this->table_name." ($variables) VALUES ($values)";
        $result=mysqli_query($db->getConnection(),$sql);
        $inserted_id=mysqli_insert_id($db->getConnection());
        $db->close();

        $status=new stdClass();
        $status->success=$result;
        $status->id=$inserted_id;
        return $status;
    }

    function update($object){
        $id_key=$this->getTable()->getPrimaryKey();
       

        $db=new DatabaseConnection();
        $variables=array();

        if(is_object($object)){
            $object=$this->object_to_array($object);
        }

        foreach(get_object_vars($this) as $key => $value){
           

            if(isset($object[$key])){
                $prepared_value=$db->escape_for_insert($object[$key]);
                if(!is_numeric($prepared_value)){
                    $prepared_value="'".$prepared_value."'";
                }

                array_push($variables,$key."=".$prepared_value);
           
            }

        }

        if(!isset($object[$id_key])){
            throw new Exception("No primary key found for ".$this->table_name);
        }

        $object_id=$object[$id_key];

        $variables=join(",",$variables);
        $object_id=$db->escape_for_insert($object_id);
        
        $sql="UPDATE ".$this->table_name." SET $variables WHERE $id_key=$object_id" ;
        $result=mysqli_query($db->getConnection(),$sql);
        $inserted_id=mysqli_insert_id($db->getConnection());
        $db->close();

        $status=new stdClass();
        $status->success=$result;
        $status->id=$inserted_id;
        return $status;
    }
    
    function bind($row){
       
        foreach(get_object_vars($this) as $key => $value){             
            if(is_numeric($value)){
                settype($row[$key], gettype($value));

            }
        }
        return (object)$row;
    }

    function insertManual($variables,$values){
        $db=new DatabaseConnection();
        $preped_values=array();
        foreach($values as $value){
            $value=$db->escape_for_insert($value);
            if(!is_numeric($value)){
                $value="'".$value."'";
            }
            array_push($preped_values,$value);
        }

        $variables=join(",",$variables);
        $values=join(",",$preped_values);

        $sql="INSERT INTO ".$this->table_name." ($variables) VALUES ($values)";
        $result=mysqli_query($db->getConnection(),$sql);
        $inserted_id=mysqli_insert_id($db->getConnection());
        $db->close();

        $status=new stdClass();
        $status->success=$result;
        $status->id=$inserted_id;

    
        return $status;
    }

    function updateManual($object,$object_id,$id_key="id"){
        $db=new DatabaseConnection();
        $variables=array();

        if(is_object($object)){
            $object=$this->object_to_array($object);
        }

        foreach(get_object_vars($this) as $key => $value){
           

            if(isset($object[$key])){
                $prepared_value=$db->escape_for_insert($object[$key]);
                if(!is_numeric($prepared_value)){
                    $prepared_value="'".$prepared_value."'";
                }

                array_push($variables,$key."=".$prepared_value);
           
            }

        }

        $variables=join(",",$variables);
        $object_id=$db->escape_for_insert($object_id);
        
        $sql="UPDATE ".$this->table_name." SET $variables WHERE $id_key=$object_id" ;
        $result=mysqli_query($db->getConnection(),$sql);
        $inserted_id=mysqli_insert_id($db->getConnection());
        $db->close();

        $status=new stdClass();
        $status->success=$result;
        $status->id=$inserted_id;
        return $status;
    }

    function queryExtended($postfix="",$fetch=true){

        $sql="SELECT ". join(",",$this->getProperties())." FROM ".$this->table_name;
        $sql_exec=$sql." ".$postfix;

        $obj_results=array();

        $db=new DatabaseConnection();
        $mysql_result=mysqli_query($db->getConnection(),$sql_exec);
        $row_count=0;
        $executed=false;
        if($mysql_result){
            $executed=true;
            $row_count=mysqli_num_rows($mysql_result) ;
            if ($row_count > 0) {
                if($fetch){
                    while($row = mysqli_fetch_assoc($mysql_result)) {
                        $binded=$this->bind($row);
                        $extended=$this->appendOnQuery($binded,$row);
                        array_push($obj_results,$extended);
                    }
                 }
            }
        }
           
       
        $db->close();
        $query_result=new stdClass();
        $query_result->executed=$executed;
        $query_result->row_count=$row_count;
        $query_result->sql=$sql;
        $query_result->sql_exec=$sql_exec;
        $query_result->results=$obj_results;
        $query_result->fetch=$fetch;

       return $query_result;
    }


    function getAll(){
        return $this->queryExtended()->results;
    }

    function getPage($postfix="",$page=1,$page_size=10){
        $offset=(int)($page_size*($page-1));
        $query=$this->queryExtended($postfix." LIMIT $page_size OFFSET $offset");
        $query_for_total=$this->queryExtended($postfix,false);
        $total_pages=ceil($query_for_total->row_count/$page_size);
        $pagination=new stdClass();
        $pagination->size=$query->row_count;
        $pagination->page=$page;
        $pagination->total_pages=$total_pages;
        $pagination->total=$query_for_total->row_count;
        $pagination->has_next=$page<$total_pages;
        $pagination->has_previous=$page>1;
        $pagination->items=$query->results;
        return $pagination;
    }


}



?>