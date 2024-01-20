<?php
require "./../../acm/SysFileAutoLoader.php";
require "./../../handler/AuthController/AuthAccessController.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response | <?php echo APP_NAME; ?></title>
    <?php include "../../assets/HeaderFilesLoader.php"; ?>
</head>

<body>
    <center class="mt-5">
        <div class="custom-loader"></div>
    </center>

    <?php
    $random_number = rand(0000, 9999);
    $_SESSION["txn_ref_no"] = "TXNNO-" . date('dmy') . $random_number;
    ?>

    <form id="myForm" action="<?php echo CONTROLLER . "/ModuleHandler.php"; ?>" method="post">
        <?php FormPrimaryInputs(); ?>
        <input type="hidden" id="paymentId" name="paymentId" readonly value=""><br><br>
        <input type="hidden" id="bill_ref_no" name="bill_ref_no" readonly value=""><br><br>
        <input type="hidden" id="paymentAmount" name="FINAL_PRICE" readonly value=""><br><br>
        <input type="hidden" id="Total_user" name="total_user" readonly value=""><br><br>
        <input type="hidden" id="PlanPeriod" name=" PlanPeriod" readonly value=""><br><br>
        <input type="hidden" id="PlanAmount" name="PlanAmount" readonly value=""><br><br>
        <input type="hidden" id="adminPlanId" name="adminPlanId" readonly value=""><br><br>
        <input type="hidden" id="user_ID" name="user_ID" readonly value=""><br><br>
    </form>
    <script>
        document.getElementById("paymentId").value = sessionStorage.getItem("payment_id");
        document.getElementById("bill_ref_no").value = sessionStorage.getItem("bill_ref_no");
        document.getElementById("paymentAmount").value = sessionStorage.getItem("Final_Price");
        document.getElementById("Total_user").value = sessionStorage.getItem("total_user");
        document.getElementById("PlanPeriod").value = sessionStorage.getItem("PlanPeriod");
        document.getElementById("PlanAmount").value = sessionStorage.getItem("PlanAmount");
        document.getElementById("adminPlanId").value = sessionStorage.getItem("adminPlanId");
        document.getElementById("user_ID").value = sessionStorage.getItem("user_ID");
        window.addEventListener("load", function() {
     document.getElementById("myForm").submit();
        });
    </script>

</body>

</html>