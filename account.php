<?php 

session_start();

require_once 'includes/config.php';

$reg_user = new UserClass();

// Comprobando si el usuario esta logueado
if(!$reg_user->is_logged_in()) {
  $reg_user->redirect('index.php');
  die();
}

$infouser = $reg_user->infoUser($id_session,$email_session);

$eventTitle = '';
$eventDescript = '';
$eventStartDate = '';
$eventEndDate = '';
$eventStarttime = '';
$eventEndtime = '';
$eventID = '';
$eventAction = '';


?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php' ?>
<body>
  <section id="container">
    <?php include 'menu-top.php' ?>
    <?php include 'menu-left.php' ?>
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12 main-chart">

           <div class="row mtbox block-reminders">
            <div class="col-md-12">
              <?php include 'includes/alert_message.php' ?>
            </div>
            <div class="col-md-6" style="text-align:center; color:#127D8C">
              <p><img class="img-circle" style="height: 200px" src="/assets/img/users/<?= $infouser['picture']; ?>"></p>
              <p><strong>Username:</strong> <?= $infouser['username']; ?></p>
              <p><strong>Email:</strong> <?= $infouser['email']; ?></p>
              <p><strong>Timezone:</strong> <?= $infouser['timezone']; ?></p>
            </div>

            <div class="col-md-6">
              <form class="formUser" action="" method="post" enctype="multipart/form-data">
                <p><strong>Timezone:</strong></p>
                <p><?php include 'includes/select.php'; ?></p>
                <p><strong>Picture:</strong></p>
                <div class="file-upload">
                  <span class="fileUpload btn btn-default">
                    <span class="glyphicon glyphicon-upload"></span> Upload file
                    <input type="file" name="upload" id="uploadfile" />
                  </span>
                </div>
                <div class="file-block">
                  <p class="filename"></p>
                  <div class="progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
                  </div>
                </div>
                <br/>
                <button type="submit" class="btn btn-default form-user-submit" data-dismiss="modal">Submit</button>
              </form>
            </div>

          </div>
        </div>
      </div>
    </section>
  </section>
</section>
<?php include 'footer.php'; ?>
</body>
</html>
