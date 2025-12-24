<?php

include '../model/User.php';
include '../controllers/AuthController.php';

$authController = new AuthController();


if(isset($_GET['action']) && method_exists($authController, $_GET['action'])){
    $action = $_GET['action'];
    $authController->$action();
}else{
    echo 'invalide a method ';
}

?>