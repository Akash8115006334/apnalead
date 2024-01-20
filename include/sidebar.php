<?php
if (AuthAppUser("UserType") == "Admin") {
  if (isset($_GET['view'])) {
    $AllViews = $_GET['view'];
    $_SESSION['AllViews'] = $AllViews;
  } else {
    if (isset($_SESSION['AllViews'])) {
      $AllViews = $_SESSION['AllViews'];
    } else {
      $AllViews = null;
    }
  }

  //LOAD SIDEBARS 
  if ($AllViews == null) {
    include __DIR__ . "/sidebar/admin-sidebar.php";
  } elseif ($AllViews == "Digital Dashboard") {
    include __DIR__ . "/sidebar/digital-sidebar.php";
  } else if ($AllViews == "Lead Dashboard") {
    include __DIR__ . "/sidebar/team-member-sidebar.php";
  } else {
    include __DIR__ . "/sidebar/admin-sidebar.php";
  }

  //else loading
} elseif (AuthAppUser("UserType") == "TeamMember") {
  include __DIR__ . "/sidebar/team-member-sidebar.php";
} elseif (AuthAppUser("UserType") == "Digital") {
  include __DIR__ . "/sidebar/digital-sidebar.php";
} else {
  include __DIR__ . "/sidebar/admin-sidebar.php";
}
