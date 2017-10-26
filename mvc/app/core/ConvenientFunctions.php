<?php

/**
 * @param string $_key
 * @return string
 */
function XGet($_key){
    return isset($_GET[$_key]) ? htmlentities($_GET[$_key]) : "" ;
}

/**
 * @param string $_key
 * @return string
 */
function XPost($_key){
    return isset($_POST[$_key]) ? htmlentities($_POST[$_key]) : "" ;
}

function XSession($_key){
    return isset($_SESSION[$_key]) ? htmlentities($_SESSION[$_key]) : "" ;
}

function removeXSession($_key){
    if(isset($_SESSION[$_key])){
        unset($_SESSION[$_key]);
        return true;
    }
    return false;
}

function setXSession($_key,$_value){
    $_SESSION[$_key] = htmlentities($_value);
}

function resource($_resource){
    $resourcePath = "/public/resources/$_resource";
    return $resourcePath;
}

function ClassToRoute($_class){
    $_class = strtolower($_class);
    return substr($_class,0,strpos($_class,"controller"));
}

function RouteToClass($_route){
    $_route = ucwords($_route);
    return "{$_route}Controller";
}

function MethodToRoute($_method){
    return substr($_method,0,strpos($_method,"Action"));
}

function RouteToMethod($_route){
    return "{$_route}Action";
}