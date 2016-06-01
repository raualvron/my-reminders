<?php

session_start();

require_once 'includes/config.php';
$user = new UserClass();

//Comprobando si el usuario esta logueado. Rediriguir a index.php si no esta logueado.
if(!$user->is_logged_in()) {
	$user->redirect('index.php');
}

//Comprobando si el usuario esta logueado. Rediriguir a index.php si esta logueado.
if($user->is_logged_in()!="") {
	$user->logout(); 
	$user->redirect('login.php');
}

?>