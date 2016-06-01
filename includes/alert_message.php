<?php if (isset($_GET['inactive'])) { ?>

        <div class='alert alert-warning'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry!</strong> This account is not activated go to your inbox and activate it. </div>
    
    <?php } else if (isset($_GET['error'])) { ?>

        <div class='alert alert-danger'><button class='close' data-dismiss='alert'>&times;</button><center><strong>Wrong Details!</strong></center></div>
    
    <?php } else if (isset($_GET['create'])) { ?>

        <div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><strong>Success!</strong>  We've sent an email in your inbox email.Please click on the confirmation link in the email to create your account. </div>

    <?php } else if (isset($_GET['email'])) { ?>

        <div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><center><strong>Sorry !</strong>  email allready exists , Please Try another one</center></div>

    <?php } else if (isset($_GET['password'])) { ?>
        
        <div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><center><strong>Sorry</strong> the passwords dont match</center></div>

    <?php } else if (isset($_GET['activate'])) { ?>

        <div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><strong>WoW !</strong>  Your Account is now activated</div>

    <?php } else if (isset($_GET['activated'])) { ?>

        <div class='alert alert-warning'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry !</strong>  Your account is allready activated</div>

    <?php } else if (isset($_GET['noaccount'])) { ?>

        <div class='alert alert-warning'><button class='close' data-dismiss='alert'>&times;</button><strong>sorry !</strong>  No account found</div>
   
    <?php } else if (isset($_GET['adde'])) { ?>

        <div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><center><strong>Great !</strong>  Your event have been added in your calendar</center></div>

    <?php } else if (isset($_GET['mdy'])) { ?>

        <div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><center><strong>Great !</strong>  Your event have been modified with the information's event</center></div>

    <?php } else if (isset($_GET['del'])) { ?>

        <div class='alert alert-warning'><button class='close' data-dismiss='alert'>&times;</button><center><strong>Ohhh !</strong>  Your event have been deleted from you dashboard event</center></div>

    <?php } else if (isset($_GET['uupdt'])) { ?>

        <div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><center><strong>Great !</strong>  Your account have been update with the new information</center></div>

    <?php } ?>
