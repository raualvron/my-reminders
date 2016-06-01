<?php 
// Obteniendo los valores del formulario por el metodo POST.
if (isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $timezone = trim($_POST['timezone']);
    $pass = trim($_POST['password']);
    $pass_again = trim($_POST['password_again']);
    // Encriptando la password
    $password  = $encrypt->encrypt_decrypt('encrypt', $pass);
    $token = $random->randomkey();

    // Comprobando si el usuario existe en la base de datos.
    $stmt = $reg_user->queryDB("SELECT * FROM myr_users WHERE email=:email");
    $stmt->execute(array(
        ":email" => $email
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($pass == $pass_again) {
        // Si el resultado de la query es mayor que cero, existe el email en la base de datos.
        if ($stmt->rowCount() > 0) {
             // Es mayor que cero, por tanto el email existe.
        	header("Location: login.php?email");
            // Si es igual a cero. El email no existe.
            } else {
                    // Registrando al nuevo usuario en la base de datos.
            if ($reg_user->register($username, $email, $timezone,  $password, $token)) {
                // Encriptando el token
                $token  = $encrypt->encrypt_decrypt('encrypt', $token);
                $id  = $reg_user->lasdID();
                $key  = $encrypt->encrypt_decrypt('encrypt', $id);
                // Preparando el email para enviar.
                $message = "Hello $username,<br /><br />Welcome to Coding Cage!<br/>To complete your registration  please , just click following link<br/><br /><br /><a href='myreminders.io/login.php?id=$key&code=$token'>Click here to activate :)</a><br /><br />Thanks,";
                
                $subject = "Confirm Registration";
                // Enviando el correo.
                $qemail->insertEmail($email, $message, $subject);
                // El usuario ha sido registrado, enviado el correo y mostramos el mensaje en el index de la pagina.
                header("Location: login.php?create");
            
            } else {
                echo "sorry , Query could no execute...";
            }
        }
    } else  {

        header("Location: login.php?password");
        
    }
}