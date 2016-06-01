<?php 

// Si se recibe el metodo forgot por post.
if (isset($_POST['forgot'])) {
    
    $email = $_POST['email'];
    $stmt  = $user->queryDB("SELECT ID FROM myr_users WHERE email=:email LIMIT 1");
    $stmt->execute(array(":email" => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // Si encuentra algun resultado en la query.
    if ($stmt->rowCount() == 1) {
        
        // Codificar el ID para pasar por URL.
        $id = $encrypt->encrypt_decrypt('encrypt', $row['ID']);
        // Generar un code aleatorio.
        $code = $random->randomkey();
        $code_encrypt = $encrypt->encrypt_decrypt('encrypt', $code);
        
        // Modificando el usuario con el nuevo valores.
        $stmt = $user->queryDB("UPDATE myr_users SET token=:token WHERE email=:email");
        $stmt->execute(array(":token" => $code,":email" => $email));
        
        $message = "Hello , $email<br /><br />We got requested to reset your password, if you do this then just click the following link to reset your password,
        if not just ignore this email,<br /><br />Click Following Link To Reset Your Password <br /><br />
        <a href='myreminders.io/reset.php?id=$id&code=$code_encrypt'>click here to reset your password</a><br /><br />thank you :)";
        
        $subject = "Password Reset";
        
        // Enviando email a los usuarios.
        $qemail->insertEmail($email, $message, $subject);
        
        $msg = "<div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button>We've sent an email to $email.
        Please click on the password reset link in the email to generate new password. </div>";
    }
    
    // No existe el email buscado.
    else {
        
        $msg = "<div class='alert alert-danger'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry!</strong>  this email not found. </div>";
    
    }
}