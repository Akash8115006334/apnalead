 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-light-primary">
   <!-- Brand Logo -->
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
     <span class="brand-text bold mt-0" style="font-size: 1.1rem !important;font-weight:600 !important;"><?php echo substr(FETCH($CompanyTableDetails, "company_name"), 0, 20); ?></span><br>
     <span class="brand-text brand-text-2 bold mt-0 " style="font-size: .7rem !important;font-weight:600 !important;"> by <img src="<?php echo STORAGE_URL . '/company/img/logo/logo.webp' ?>" alt="companylogo" class="company-logo"></span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
     <!-- Sidebar Menu -->
     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <li class="nav-item">
           <a href="<?php echo APP_URL; ?>" class="nav-link">
             <i class="nav-icon fas fa-tachometer-alt text-dark"></i>
             <p>
               Dashboard
             </p>
           </a>
         </li>

         <li class="nav-item">
           <a href="<?php echo APP_URL; ?>/leads/" class="nav-link" id="teams">
             <i class=" nav-icon fas fa-star text-dark"></i>
             <p>
               All Leads
             </p>
           </a>
         </li>

         <li class="nav-item">
           <a href="<?php echo APP_URL; ?>/leads/transfer/" class="nav-link" id="teams">
             <i class="nav-icon fa fa-exchange text-dark"></i>
             <p>
               Move Leads
             </p>
           </a>
         </li>

         <li class="nav-item">
           <a href="<?php echo APP_URL; ?>/leads/uploads/" class="nav-link" id="teams">
             <i class="nav-icon fas fa-upload text-dark"></i>
             <p>
               Upload Leads
             </p>
           </a>
         </li>

         <li class="nav-item">
           <a href="<?php echo APP_URL; ?>/leads/uploaded/" class="nav-link" id="teams">
             <i class=" nav-icon fas fa-list text-dark"></i>
             <p>
               Uploaded Leads
             </p>
           </a>
         </li>

         <li class="nav-item">
           <a href="<?php echo APP_URL; ?>/projects/" class="nav-link" id="teams">
             <i class=" nav-icon fas fa-table text-dark"></i>
             <p>
               All Projects
             </p>
           </a>
         </li>

         <li class="nav-item">
           <a href="<?php echo APP_URL; ?>/teams/" class="nav-link" id="teams">
             <i class=" nav-icon fas fa-users text-dark"></i>
             <p>
               All Team
             </p>
           </a>
         </li>

         <li class="nav-item">
           <a href="<?php echo APP_URL; ?>/profile/" class="nav-link">
             <i class="nav-icon fas fa-user text-dark"></i>
             <p>
               Profile
             </p>
           </a>
         </li>



         <li class="nav-item">
           <a href="<?php echo APP_URL; ?>/logout.php" class="nav-link">
             <i class="nav-icon fas fa-lock text-danger"></i>
             <p>
               Logout
             </p>
           </a>
         </li>

       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>
 <div class="container">
   <div class="mobile-sidebar">
     <div class="mobile-view">
       <a href="<?php echo APP_URL; ?>" class=" mobile-links">
         <img src="<?PHP echo STORAGE_URL_D; ?>/menu-icons/HOME.png" alt="Home">
         <p> Home </p>
       </a>
     </div>
     <div class="mobile-view">
       <a href="<?php echo APP_URL; ?>/leads/?TotalItems=1" class=" mobile-links">
         <img src="<?PHP echo STORAGE_URL_D; ?>/menu-icons/lead.png" alt="leads">
         <p>Leads </p>
       </a>
     </div>
     <div class="mobile-view">
       <a href="<?php echo APP_URL; ?>/leads/?TotalItems=1" class=" mobile-links">
         <img src="<?PHP echo STORAGE_URL_D; ?>/menu-icons/call.png" alt="call" class="call-image">
         <p> Call </p>
       </a>
     </div>
     <div class="mobile-view">
       <a href="<?php echo APP_URL; ?>/configs/" class=" mobile-links">
         <img src="<?PHP echo STORAGE_URL_D; ?>/menu-icons/followup.png" alt="follow">
         <p> FollowUps </p>
       </a>
     </div>
     <div class="mobile-view">
       <a href="<?php echo APP_URL; ?>/profile/" class=" mobile-links">
         <img src="<?PHP echo STORAGE_URL_D; ?>/menu-icons/account.png" alt="profile">
         <p> My Account </p>
       </a>
     </div>
   </div>
 </div>