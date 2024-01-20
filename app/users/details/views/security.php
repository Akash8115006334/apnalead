<div class="row">
    <div class="col-md-12">
        <h6 class="app-sub-heading">Login & Security</h6>
    </div>
</div>
<form class="form mt-3" action="../../../controller/UserController.php" method="POST">
    <?php FormPrimaryInputs(true); ?>
    <div class="row">
        <div class="form-group col-md-6 col-sm-6">
            <label>Enter New Password <small class="text-grey">Current <code><?php echo FETCH($PageSqls, "UserPassword"); ?></code></small></label>
            <input type="password" name="UserPassword" oninput="checkpass()" id="pass1" class="form-control form-control-sm" required="">
        </div>
        <div class="form-group col-md-6 col-sm-6">
            <label>Re-Enter New Password</label>
            <input type="password" name="UserPassword_2" oninput="checkpass()" id="pass2" class="form-control form-control-sm" required="">
        </div>
        <div class="col-md-12">
            <button type="Submit" id="passbtn" name="UpdatePassword" class="btn btn-md btn-success disabled">Update Password</button>
            <span style="font-size:1.5rem;padding:1rem;"><span id="passmsg"></span></span>
        </div>
    </div>
</form>
<script>
    function checkpass() {
        var pass1 = document.getElementById("pass1");
        var pass2 = document.getElementById("pass2");
        if (pass1.value === pass2.value) {
            document.getElementById("passbtn").classList.remove("disabled");
            document.getElementById("passmsg").classList.add("text-success");
            document.getElementById("passmsg").classList.remove("text-danger");
            document.getElementById("passmsg").innerHTML = "<i class='fa fa-check-circle'></i> Password Matched!";
        } else {
            document.getElementById("passmsg").classList.remove("text-success");
            document.getElementById("passmsg").classList.add("text-danger");
            document.getElementById("passbtn").classList.add("disabled");
            document.getElementById("passmsg").innerHTML = "<i class='fa fa-warning'></i> Password do not matched!";
        }
    }
</script>