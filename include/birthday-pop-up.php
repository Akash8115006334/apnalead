<?php
$TodayData = date("d-m");
$RequireDate = DATE_FORMATES("d-m", FETCH("SELECT * FROM users where UserId='" . AuthAppUser("UserId") . "'", "UserDateOfBirth"));
?>
<?php if (isset($_GET['birthday'])) {
  $birthday = $_GET['birthday'];
  $_SESSION['birthday'] = $birthday;
}
if (!isset($_SESSION['birthday'])) {
  if ($RequireDate == $TodayData) {
?>
    <section class="follow-up-reminder" style="display:none;" id="birthday_pop_up">
      <img src="<?php echo STORAGE_URL_D; ?>/tool-img/start-falling.gif" class="w-100" style="position:fixed;top:0px;">
      <div class="reminder-box w-50">
        <div class="container">
          <div class="card p-4" style="background-color: #fff5ed !important;">
            <img src="<?php echo STORAGE_URL_D; ?>/tool-img/ribbon.png" style="position: absolute;width: 25%;right: -3rem;top:-2rem;">
            <div class="row">
              <div class="col-md-12 text-center">
                <img src="<?php echo STORAGE_URL_D; ?>/tool-img/birthday.gif" class="w-50 p-2" style="border:none !important;">
                <h2 class="mt-4 birthday-dear">Dear, <b><?php echo AuthAppUser("UserFullName"); ?></b></h2>
                <p class="birthday-msg">
                  “Wishing you the best on your birthday and everything good in the year ahead.”
                  <br>
                  “Hope your day is filled with happiness.”
                  <br>
                  “Our whole team is wishing you the happiest of birthdays.”
                </p>
                <br>
                <a href="?birthday=false" class="btn btn-success btn-lg" style="border-radius:2rem !important;">Thanking You <i class="fa fa-thumbs-up"></i></a>
              </div>

              <div class='col-md-12'>
                <audio src="<?php echo STORAGE_URL_D; ?>/sys-tone/birthday.mp3" id="birthday_sound_for_birthday_wish" loop="loop"></audio>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php }
}
?>