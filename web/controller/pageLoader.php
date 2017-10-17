<?php
session_start();
require_once "route.php";
require_once "UserController.php";

if(XPost("username") && XPost("password")){
    UserController::login(XPost("username"),XPost("password"));
}

if(XGet("logout")){
    UserController::logout();
}

$pageRequest = XGet("page");
if(!empty($pageRequest)) {
    if(pageNeedsConnection($pageRequest) && empty($_SESSION["connectedUser"])){
        $theLink = getLink("login");
    }
    else{
        try {
            $theLink = getLink($pageRequest);
        }
        catch (Exception $e){
            generateErrorPost($e);
        }
    }
    buildPage($theLink);
}
else{
    header("location: ../index.php");
}

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

/**
 * @param Exception $_exception
 */
function generateErrorPost($_exception){
    ?>
    <form id="errorForm" action="pageLoader.php?page=error" method="post">
        <input type="hidden" name="errorMessage" value="<?= $_exception->getMessage() ?>">
    </form>
    <script type="text/javascript">
        document.getElementById('errorForm').submit();
    </script>
    <?php
}