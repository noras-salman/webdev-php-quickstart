<?php

class RouteManager{

    public $active_routes;

    function __construct(){
        $this->active_routes=array();
    }

    function addRoute($route){
        $this->active_routes+=$route;
    }

    function getRoutes(){
        return $this->active_routes;
    }

}
?>