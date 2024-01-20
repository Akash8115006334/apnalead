<?php
require "./../../acm/SysFileAutoLoader.php";
require "./../../handler/AuthController/AuthAccessController.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | <?php echo APP_NAME; ?></title>
    <?php include "../../assets/HeaderFilesLoader.php"; ?>
</head>

<body>
    <center class="mt-5">
        <div class="custom-loader mt-5"></div>
        <h1>
            Processing...
        </h1>
        <p>Please wait while processing your request...</p>
        <br>
        <p>or go back to plan page </p>
        <a href="../UserPlan/" class="btn btn-default btn-md mt-3"> <i class="fa fa-angle-left"></i> back</a>
    </center>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            // "key": "rzp_live_p6fcTUeIeqKrkL",
            "key": "rzp_test_YvZBVTF4psSm8c",
            "amount": <?php echo $_POST["FINAL_PRICE"] * 100; ?>,
            "currency": "INR",
            "name": "<?php echo $_POST["selectedPlanName"]; ?>",
            "image": "https://demo.apnalead.com/storage/company/img/logo…a_Lead_Logo_04_Aug_2023_01_08_24_14196890590_.png",
            "handler": function(response) {
                sessionStorage.setItem("payment_id", response.razorpay_payment_id);
                sessionStorage.setItem("bill_ref_no", "<?php echo $_POST["bill_ref_no"]; ?>");
                sessionStorage.setItem("total_user", "<?php echo $_POST["total_user"]; ?>");
                sessionStorage.setItem("Final_Price", "<?php echo $_POST["FINAL_PRICE"]; ?>");
                sessionStorage.setItem("PlanPeriod", "<?php echo $_POST["PlanPeriod"]; ?>");
                sessionStorage.setItem("PlanAmount", "<?php echo $_POST["PlanAmount"]; ?>");
                sessionStorage.setItem("adminPlanId", "<?php echo $_POST["adminPlanId"]; ?>");
                sessionStorage.setItem("user_ID", "<?php echo $_POST["user_ID"]; ?>");
                // Redirect to your success page
                window.location.href = "http://localhost/apnalead/app/response/index.php";
            },
            "prefill": {
                "name": "<?php echo $_POST["user_name"]; ?>",
                "email": "<?php echo $_POST["user_email"]; ?>",
                "contact": "<?php echo $_POST["user_mobile"]; ?>"
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function(response) {
            alert("Payment failed with error code: " + response.error.code);
            // Redirect to a failure page
            window.location.href = "http://localhost/apnalead/app/UserPlan/";
            <?php $_SESSION["Payment_Failed"] = "Payment Failed! Please Try Again"; ?>
        });
        // Trigger the Razorpay checkout when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            rzp1.open();
        });
    </script>
   


    <?php include "../../assets/FooterFilesLoader.php"; ?>
</body>

</html>