<div class="row">
  <div class="col-md-12">
    <?php
    if (AuthAppUser("UserType") == "Admin") {
      $AllCustomers = _DB_COMMAND_("SELECT * FROM users where (UserEmailId like '%$search%' OR UserPhoneNumber like '%$search%' OR UserFullName like '%$search%') ORDER BY UserFullName ASC", true);
      if ($AllCustomers != null) { ?>
        <div class="shadow-sm p-1">
          <?php echo "<h2 class='app-sub-heading'><i class='fa fa-search'></i> User Search Results</h2>"; ?>
          <div class="row">
            <?php
            foreach ($AllCustomers as $Customers) {
              $UserMainUserId = $Customers->UserId;
              $REQ_UserId = $Customers->UserId;
              $isCompanyUser = FETCH("SELECT COUNT(*) FROM company_users WHERE company_alloted_user_id='$UserMainUserId' AND company_main_id='$companyid'", "COUNT(*)");

              if ($isCompanyUser > 0) {
                // Retrieve the user details from company_users table
                $UserId = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserMainUserId' AND company_main_id='$companyid'", "company_alloted_user_id");
            ?>
                <div class="data-list col-md-2 ml-4 m-1">
                  <a href="<?= APP_URL ?>/users/details/?uid=<?= SECURE($UserId, "e") ?>" class="text-primary bold">
                    <b class="h6">
                      <?= FETCH("SELECT UserSalutation FROM users WHERE UserId='$UserMainUserId'", "UserSalutation") ?>
                      <?= FETCH("SELECT UserFullName FROM users WHERE UserId='$UserMainUserId'", "UserFullName") ?>
                    </b><br>
                    <?= FETCH("SELECT UserPhoneNumber FROM users WHERE UserId='$UserMainUserId'", "UserPhoneNumber") ?><br>
                    <?= FETCH("SELECT UserEmailId FROM users WHERE UserId='$UserMainUserId'", "UserEmailId") ?>
                  </a>
                </div>
            <?php
              }
            }
            ?>
          </div>
        </div>
    <?php
      }
    }
    ?>
  </div>
</div>