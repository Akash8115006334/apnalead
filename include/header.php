<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
   <!-- Left navbar links -->
   <ul class="navbar-nav header">
      <li class="nav-item">
         <a class="nav-link h3" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars h1"></i></a>
      </li>
      <?php if (DEVICE_TYPE == "COMPUTER") { ?>
         <li class="navbar-item">
            <span class="nav-link h4"><i class="fa fa-clock"></i> <span id="clock"></span></span>
         </li>
      <?php } ?>
   </ul>
   <ul class="navbar-nav mobile-header">
      <?php
      $UserID = AuthAppUser("UserId");
      $MainCompanyId = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");
      $CompanyTableDetails = "SELECT * FROM config_companies WHERE company_id='$MainCompanyId'";
      $ImageEmpty = FETCH($CompanyTableDetails, "company_logo");
      if (empty($ImageEmpty)) {
         $ImageEmpty = "userlogo.jpg";
      }
      ?>
      <a href="<?php echo APP_URL; ?>" class="brand-link">
         <img src="<?php echo STORAGE_URL . '/companylogo/' . $ImageEmpty; ?>" alt="logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
         <span class="brand-text bold mt-0" style="font-size: 1.1rem !important;font-weight:600 !important;"><?php echo substr(FETCH($CompanyTableDetails, "company_name"), 0, 15); ?></span><br>
         <span class="brand-text brand-text-2 bold mt-0 " style="font-size: .7rem !important;font-weight:600 !important;"> by <img src="<?php echo STORAGE_URL . '/company/img/logo/logo.webp' ?>" alt="companylogo" class="company-logo"></span>
      </a>
   </ul>
   <!-- Right navbar links -->
   <ul class="navbar-nav ml-auto auth-header">
      <li class="nav-item">
         <a class=" h3 pt-2 " onclick="Databar('Master_Search')" href="#"><i class="fas fa-search h3 mr-3 mt-1"></i></a>
      </li>

      <li class="nav-item">
         <?php
         $UserId = AuthAppUser("UserId");
         $GetImg = FETCH("SELECT * FROM users where UserId='$UserId'", "UserProfileImage");
         if ($GetImg == null || $GetImg == 'default.png') {
            $Image = STORAGE_URL_D . "/default.png";
         } else {
            $Image = STORAGE_URL_U . "/$UserId/img/$GetImg";
         }
         ?>
         <a href="<?php echo APP_URL; ?>/profile/" class="nav-link UserPanelProfile shadow-sm rounded">

            <img src="<?PHP echo $Image; ?>" class="elevation-2 " alt="<?php echo AuthAppUser("UserFullName"); ?>" title="<?php echo AuthAppUser("UserFullName"); ?>" />
            <span class="UserProfileName"><b><?php echo AuthAppUser("UserFullName"); ?></b> </span>

         </a>
      </li>
   </ul>
</nav>
<!-- /.navbar -->

