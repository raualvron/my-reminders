
<?php

// Si existe los valores ID y CODE por el metodo GET.
if(isset($_GET['id']) && isset($_GET['code'])) {
    
    $id = $encrypt->encrypt_decrypt('decrypt',  $_GET['id']);
    $code  = $encrypt->encrypt_decrypt('decrypt',  $_GET['code']);
    $status = "Y";
  
    // Obteniendo el ID y el STATUS del usuario solicitado.
    $stmt = $reg_user->queryDB("SELECT ID,status FROM myr_users WHERE ID=:id AND token=:code LIMIT 1");
    $stmt->execute(array(":id"=>$id,":code"=>$code));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
      // Si el resultado es mayor que uno.
      if($stmt->rowCount() > 0) {
          
          if($row['status']=="N")  {
              // El usuario no esta activado.
              $stmt = $reg_user->queryDB("UPDATE myr_users SET status=:status WHERE ID=:ID");
              $stmt->bindparam(":status",$status);
              $stmt->bindparam(":ID",$id);
              $stmt->execute(); 
              header("Location: login.php?activate");
          } else {
          	  // Y - El usuario esta activado
              header("Location: login.php?activated");
          }
      
      } else {
		// No encuentra el usuario con el ID y el TOKEN asociado.
      	header("Location: login.php?noaccount");
      } 
}
