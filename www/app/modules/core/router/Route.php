<?php

class Route{
    public $path;
    public $page;
    public $controller;
    public $page_title;
    public $prevent_when;
    public $code;
    public $redirect_when;
    public $redirect_to;
    
    function __construct($path,$page){
        $this->path=$path;
        $this->page=$page;
        $this->controller=null;
        $this->page_title=$path;
        $this->prevent_when=false;
        $this->redirect_when=false;
        $this->redirect_to=$path;
        $this->code=403;
    }

    function setController($controller){
        $this->controller=$controller;
    }

    function setPageTitle($page_title){
        $this->page_title=$page_title;
    }

    function setPreventWhen($condition){
        $this->prevent_when=$condition;
    }

    function setRedirectWhen($condition){
        $this->redirect_when=$condition;
    }

    function setRedirectTo($redirect_to){
        $this->redirect_to=$redirect_to;
    }

    function checkRedirect(){
        if($this->redirect_when){
            header("Location: ".$this->redirect_to);
            exit();
        }
    }

    function checkPrevention(){
        if($this->prevent_when){
            http_response_code($this->code);
            exit();
        }
    }

    function getPath(){
        return $this->path;
    }

    function getPage(){
        return PAGES_DIR.$this->page;
    }

    function hasController(){
        return $this->controller!=null;
    }
    
    function getController(){
        return CONTROLLERS_DIR.$this->controller;
    }

    function getPageTitle(){
        return SITE_NAME." - ".$this->page_title;
    }

    function getRoute(){
        return array($this->path => $this);
    }


}

?>