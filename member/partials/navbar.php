<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="index.php">
      <h1>Member Panel</h1>
    </a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    <ul class="navbar-nav navbar-nav-right">

      <li class="nav-item d-none d-lg-block full-screen-link">
        <a class="nav-link">
          <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link count-indicator" href="view-notifications.php">
          <?php
          include_once "classes/db.php";
          include_once "classes/notification.php";

          $id  = $_SESSION["member_id"];
          $db = new Db();
          $notification = new Notification($db->getConnection());
          $res = $notification->display($id);
          ?>
          <i class="mdi mdi-bell-outline menu-icon>"></i>
          <?php
          if ($res->num_rows > 0) {
            echo '<span class="count-symbol bg-danger"></span>';
          }
          ?>
        </a>
      </li>

      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-text">
            <p class="mb-1 text-black"><?php echo $_SESSION["member_username"] ?></p>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="handlers/logout.php">
            <i class="mdi mdi-logout me-2 text-primary"></i> Logout </a>
        </div>
      </li>

    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>