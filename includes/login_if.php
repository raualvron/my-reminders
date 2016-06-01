<?php 

// Si el usuario esta logueado, redireccionar a home.php
if ($reg_user->is_logged_in() != "") {
  $reg_user->redirect('dashboard.php');
}

//Si existe las variables pasadas por el metodo post. Comprobar login y rediriguir
if (isset($_POST['login'])) {
	$email = trim($_POST['email']);
  	$password = trim($_POST['password']);
  	//Comprobando el inicio de sesion del usuario. Si es correcto rediriguir a home.
  	if ($reg_user->login($email, $password)) {
    	$reg_user->redirect('dashboard.php');
    }	
}
