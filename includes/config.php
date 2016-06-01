<?php

function __autoload($class_name) {
	// No se encuentra en la misma ubicacion, si no da error de clases
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
}

if (isset($_SESSION) && !empty($_SESSION)) {

	$code_session = $_SESSION['codeSession'];
	$email_session = $_SESSION['emailSession'];
	$id_session = $_SESSION['userSession'];
	
}


error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);