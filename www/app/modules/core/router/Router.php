<?php
class Router{

    public $current_path;
    public $current_route;
    public $active_routes;
    
    function __construct($active_routes){

       
        $this->active_routes=$active_routes;
        if(!isset($_GET['route'])){
            $this->current_path='root';
    
        }else{
            $this->current_path=$_GET['route'];
           
        }

        $this->current_route=$active_routes[$this->current_path];
       
        $query_string_post=strpos($_SERVER["REQUEST_URI"],"?");
        if($query_string_post!==false){
            if(isset($_GET['route'])){
                $query_string=substr($_SERVER["REQUEST_URI"],$query_string_post+1);
                $get=array();
                if(strlen($query_string)>0){
                    $get=explode("&",$query_string);
                    foreach($get as $var){
                        $var=explode("=",$var);
                        $_GET[$var[0]]=$var[1];
                      
                    }
                }
            }
        }
    }

    function getCurrentRoute(){
        return  $this->current_route;
    }

    function getCurrentPage(){
        return $this->getCurrentRoute()->getPage();
    }

}
?>