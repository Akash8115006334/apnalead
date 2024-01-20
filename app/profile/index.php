<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = "All Customers";
$PageDescription = "Manage all customers";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFilesLoader.php"; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("profile").classList.add("active");
      document.getElementById("profile_view").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
  <div class="wrapper">
    <?php include $Dir . "/include/loader.php"; ?>

    <?php
    include $Dir . "/include/header.php";
    include $Dir . "/include/sidebar.php"; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-12">
              <div class="card card-primary new-bg-color">
                <div class="card-body">

                  <div class="row">
                    <div class="col-md-8 col-lg-8 col-sm-7 col-12">
                      <form class="form" action="../../handler/ModuleHandler.php" method="POST">
                        <div class="row">
                          <div class="col-md-12 col-sm-12">
                            <h4 class="app-heading">Personal Details</h4>
                          </div>
                          <?php FormPrimaryInputs(true, [
                            "UserId" => AuthAppUser("UserId")
                          ]); ?>
                          <div class="form-group col-md-6 col-sm-6">
                            <label class="text-light">Full Name</label>
                            <input type="text" name="UserFullName" value="<?php echo AuthAppUser("UserFullName"); ?>" class="form-control form-control-sm" required="">
                          </div>
                          <div class="form-group col-md-6 col-sm-6">
                            <label class="text-light">Phone Number</label>
                            <input readonly type="text" name="UserPhoneNumber" value="<?php echo AuthAppUser("UserPhoneNumber"); ?>" class="form-control form-control-sm" required="">
                          </div>
                          <div class="form-group col-md-6 col-sm-6">
                            <label class="text-light">Email Id</label>
                            <input readonly type="email" name="UserEmailId" value="<?php echo AuthAppUser("UserEmailId"); ?>" class="form-control form-control-sm" required="">
                          </div>
                          <br>
                          <div class="col-md-12">
                            <br>
                            <button type="Submit" name="UpdateProfile" class="btn btn-md btn-success">Update Details</button>
                            <a href="<?php echo APP_URL; ?>/logout.php" class="btn btn-danger mt-3 ml-2">
                              <i class="nav-icon fas fa-lock text-danger"></i> Logout
                            </a>
                          </div>
                          <div class="col-md-12">

                          </div>
                        </div>
                      </form>
                      <hr>
                      <form class="form" action="../../handler/ModuleHandler.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "UserId" => AuthAppUser("UserId"),
                        ]); ?>
                        <div class="row">
                          <div class="col-md-12 col-sm-12">
                            <h4 class="app-heading">Update Password <span id="passmsg"></span></h4>
                          </div>
                          <div class="form-group col-md-6 col-sm-6">
                            <label class="text-light">Enter New Password</label>
                            <input type="password" name="UserPassword" placeholder="Enter New Password" oninput="checkpass()" id="pass1" class="form-control form-control-sm" required="">
                          </div>
                          <div class="form-group col-md-6 col-sm-6">
                            <label class="text-light">Re-Enter New Password</label>
                            <input type="password" name="UserPassword_2" placeholder="Re-Enter New Password" oninput="checkpass()" id="pass2" class="form-control form-control-sm" required="">
                          </div>
                          <br>
                          <div class="col-md-12">
                            <button type="Submit" id="passbtn" name="UpdatePassword" class="btn btn-md btn-success disabled">Update Password</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-12">
                      <div class="p-2 border-success">
                        <div class="br10 app-bg-light p-3 text-center">
                          <center>
                            <img src="<?php echo AuthAppUser("UserProfileImage"); ?>" class="w-25 mx-auto d-block rounded config-logo" style="border-radius:100% !important;">
                          </center>
                          <form class="form m-t-3" action="<?php echo CONTROLLER("ModuleHandler.php"); ?>" method="POST" enctype="multipart/form-data">
                            <input type="text" name="updateprofileimage" value="<?php echo AuthAppUser("UserId"); ?>" hidden="">
                            <?php FormPrimaryInputs(true); ?>
                            <label for="UploadProfileimg">
                              <img src="<?php echo STORAGE_URL_D; ?>/tool-img/img-upload.png" class="w-pr-10 upload-icon">
                            </label>
                            <input type="file" class="hidden" onchange="form.submit()" hidden="" name="UserProfileImage" id="UploadProfileimg" value="<?php echo APP_LOGO; ?>" accept="images/*">
                          </form>
                        </div>
                        <p class="m-t-10">
                          <span class="fs-20"> <?php echo AuthAppUser("UserFullName"); ?></span><br>
                          <span><i class="fa fa-phone text-info"></i> <?php echo AuthAppUser("UserPhoneNumber"); ?></span><br>
                          <span><i class="fa fa-envelope text-danger"></i> <?php echo AuthAppUser("UserEmailId"); ?></span><br>
                          <span><i class="fa fa-user text-warning"></i> <?php echo AuthAppUser("UserType"); ?></span><br>
                          <span><i class="fa fa-calendar text-primary"></i> CreatedAt: <?php echo AuthAppUser("UserCreatedAt"); ?></span><br>
                          <span><i class="fa fa-calendar text-primary"></i> UpdatedAt: <?php echo AuthAppUser("UserUpdatedAt"); ?></span><br>
                        </p>
                      </div>
                    </div>

                    <script>
                      function checkpass() {
                        var pass1 = document.getElementById("pass1");
                        var pass2 = document.getElementById("pass2");
                        if (pass1.value === pass2.value) {
                          document.getElementById("passbtn").classList.remove("disabled");
                          document.getElementById("passmsg").classList.add("text-success");
                          document.getElementById("passmsg").classList.remove("text-danger");
                          document.getElementById("passmsg").innerHTML = "<i class='fa fa-check-circle-o'></i> Password Matched!";
                        } else {
                          document.getElementById("passmsg").classList.remove("text-success");
                          document.getElementById("passmsg").classList.add("text-danger");
                          document.getElementById("passbtn").classList.add("disabled");
                          document.getElementById("passmsg").innerHTML = "<i class='fa fa-warning'></i> Password do not matched!";
                        }
                      }
                    </script>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>

</body>

</html>