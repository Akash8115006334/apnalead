<?php
require "./../../acm/SysFileAutoLoader.php";
require "./../../handler/AuthController/AuthAccessController.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminPlan | <?php echo APP_NAME; ?></title>
    <?php include "../../assets/HeaderFilesLoader.php"; ?>
</head>

<body>
    <section class="adminplan-section">
        <div class="container">
            <h1 class="text-center py-4">Welcome To Admin Section</h1>
            <form action="<?php echo CONTROLLER . "/ModuleHandler.php"; ?>" method="POST" class="form-group" enctype="multipart/form-data">
                <?php FormPrimaryInputs(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <label for="Plan-name">Plan Name</label>
                        <input type="text" placeholder="Plan Name.." required name="plan_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="Plan-amount">Plan Amount</label>
                        <input type="number" placeholder="Plan Name.." required name="plan_amount_per_user" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Plan Period</label>
                        <select class="form-select" name="plan_pay_period">
                            <option selected>Monthly</option>
                            <option>half-Yearly</option>
                            <option>Yearly</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Plan Status</label>
                        <select class="form-select" name="plan_status">
                            <option selected>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="Plan-name">Plan Image</label>
                        <input type="file" placeholder="Plan Name.." name="plan_feature_image" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="Plan-name">About the Plan</label>
                    <textarea name="plan_description" required cols="30" rows="5" class="form-control" placeholder="Description of the plan.."></textarea>
                </div>
                <div class="text-center my-4 ">
                    <input type="submit" name="AdminAddPlan" class="btn btn-primary">
                    <input type="reset" name="reset" class="btn btn-success mx-2">
                </div>

            </form>
        </div>
    </section>
    <?php include "../../assets/FooterFilesLoader.php"; ?>
</body>

</html>