<aside>
  <div id="sidebar"  class="nav-collapse ">
    <ul class="sidebar-menu" id="nav-accordion">

     <p class="centered"><a href="profile.html"><img src="assets/img/users/<?= $infouser['picture']; ?>" class="img-circle" width="60"></a></p>
     <h5 class="centered"><?= $infouser['username']; ?></h5>

     <li class="sub-menu">
      <a href="dashboard.php">
        <i class="fa fa-dashboard"></i>
        <span>My Dashboard</span>
      </a>
    </li>

    <li class="sub-menu">
      <a href="event.php">
        <i class="fa fa-calendar" aria-hidden="true"></i>
        <span>My events</span>
      </a>


      <ul class="sub sub-menu-il" style="overflow: hidden; display: block;">
        <li><a class="add_event"><i class="fa fa-plus" aria-hidden="true"></i>Add reminders</a></li>
        <li><a href="event.php"><i class="fa fa-eye" aria-hidden="true"></i>View reminders</a></li>
      </ul>
    </li>


    <li class="sub-menu">
      <a href="account.php">
        <i class="fa fa-user"></i>
        <span>My account</span>
      </a>
    </li>

  </ul>
</div>
</aside>