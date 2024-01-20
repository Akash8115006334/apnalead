<div class="row">
  <div class="col-md-12">
    <div class='flex-s-b'>
      <h3 class="app-heading w-pr-80 m-t-0"><i class="fa fa-home"></i> Digital Dashboard </h3>
      <?php if (AuthAppUser("UserType") == 'Admin') { ?>
        <form>
          <select name="view" onchange="form.submit()" class="form-control form-control-sm ">
            <?php InputOptions(["Admin Dashboard", 'Lead Dashboard', 'Digital Dashboard'], IfRequested('GET', 'view', 'Digital Dashboard', false)); ?>
          </select>
        </form>
      <?php } ?>
    </div>
  </div>
</div>