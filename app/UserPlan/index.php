<?php
require "./../../acm/SysFileAutoLoader.php";
require "./../../handler/AuthController/AuthAccessController.php";
//some hidden  input value 
$username = AuthAppUser("UserFullName");
$userID = AuthAppUser("UserId");
$userphone = AuthAppUser("UserPhoneNumber");
$useremail = AuthAppUser("UserEmailId");
$random_number = rand(0000, 9999);
$_SESSION["bill_ref_no"] = "#REFNO-" . date('dmy') . $random_number;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UserPlan | <?php echo APP_NAME; ?></title>
    <?php include "../../assets/HeaderFilesLoader.php"; ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <?php
    $userId = AuthAppUser("UserId");
    $CheckPlanExist = CHECK("SELECT * FROM user_billings WHERE user_main_id='$userId'");
    if ($CheckPlanExist != null) {
        $_SESSION['exist_plan'] = true;
        echo ' <script>
            swal({
            title: "Plan Already Purchased!",
            text: "Please Upgrade Your PLan To Pro",
            icon: "info",
            });
        </script>
        ';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                
                 document.getElementById("FreePlan").classList.remove("text");
                document.getElementById("FreePlan").classList.add("hidden");
                document.getElementById("PayNow").classList.remove("text");
                document.getElementById("PayNow").classList.add("hidden");
                document.getElementById("UpgradePlan").classList.remove("hidden");
                document.getElementById("UpgradePlan").classList.add("text");
            });
        </script>';
    } else {
        unset($_SESSION['exist_plan']);
    }
    ?>
    <div class="container mb-2">
        <a href="./../index.php?skip_plan=true" class="skip-button"> X </a>
    </div>
    <section class="Userplan-section">
        <div class="container">
            <div class="d-flex align-items-center justify-content-center mt-3">
                <img src="<?PHP echo APP_LOGO; ?>" alt="LOGO">
                <h2 class="text-center  ml-2">WELCOME TO <span>APNALEAD-SUBSCRIPTION</span></h2>
            </div>
            <hr>
            <form action="./../Payment/index.php" method="POST" class="form-group" id="UserPlanForm" enctype="multipart/form-data">
                <?php FormPrimaryInputs(); ?>
                <div class="row mt-4 d-flex justify-content-between">
                    <div class="col-md-5 col-sm-12 details-area">
                        <div class="choose-plan">
                            <h3>"Discover Your Ideal Plan"</h3>
                            <p>Explore and Pick the Perfect Plan for You..</p>
                        </div>
                        <?php
                        $GetAPlans = _DB_COMMAND_("SELECT * FROM config_plans ORDER BY plan_id ASC", true);
                        if ($GetAPlans != null) {
                            $isFirst = true;
                            $totalPlans = count($GetAPlans);
                            foreach ($GetAPlans as $index => $Plan) {
                                $premiumTag = $isFirst ? '<span class="premium-tag">Best Choice</span>' : '';
                                $isLast = ($index === $totalPlans - 1); // Check if it's the last item
                                $premiumTag2 = $isLast ? '<span class="premium-tag">Free Trial Plan Claim Now</span>' : '';
                                echo '
                                    <label class="custom-radio plan-radio" style="background-image:url(' . STORAGE_URL . '/image/' . $Plan->plan_feature_image . ');"
                                        data-plan-amount="' . $Plan->plan_amount_per_user . '" data-plan-period="' . $Plan->plan_pay_period . '" data-plan-name="' . $Plan->plan_name . '">
                                        ' . $premiumTag . $premiumTag2 . ' 
                                        <input type="radio" name="admin_plan_id" required value="' . $Plan->plan_id . '" onchange="updateSelectedPlan(this);" />
                                        <span class="radio-btn">
                                            <div class="text_details">
                                                <h2>' . $Plan->plan_pay_period . ' <span> per user</span></h2>
                                                <h1>₹' . $Plan->plan_amount_per_user . '/-</h1>
                                                <p>' . $Plan->plan_description . '</p>
                                            </div>
                                        </span>
                                    </label>';
                                $isFirst = false;
                            }
                        } else {
                            NoData("No Plans found!", "Please create some plans!");
                        }
                        ?>
                    </div>
                    <div class="col-md-6 col-sm-12 basic-details mt-4">
                        <div class="details">
                            <h2>Billing Details :</h2>
                            <hr>
                            <input type="hidden" name="user_name" id="" value="<?php echo $username; ?>">
                            <input type="hidden" name="user_ID" id="" value="<?php echo $userID; ?>">
                            <input type="hidden" name="user_mobile" id="" value="<?php echo $userphone; ?>">
                            <input type="hidden" name="user_email" id="" value="<?php echo $useremail; ?>">
                            <input type="hidden" name="total_user" id="total-user" value="5">
                            <!-- for single user  -->
                            <input type="hidden" name="min-user" value="1">
                            <input type="hidden" name="adminPlanId" id="adminPlanId" value="">
                            <input type="hidden" name="selectedPlanName" id="selectedPlanName" value="">
                            <input type="hidden" name="bill_ref_no" id="" value="<?php echo $_SESSION["bill_ref_no"]; ?>">
                            <div class="row billing-area">
                                <div class="col-md-12 col-sm-12 d-flex justify-content-between">
                                    <p>Plan Name :</p>
                                    <input type="text" readonly id="" name="PlanName" value="ApnaLead">
                                </div>
                                <hr>
                                <div class="col-md-12 col-sm-12 d-flex justify-content-between">
                                    <p>Billing Duration :</p>
                                    <input type="text" readonly id="selectedPlanPeriod" name="PlanPeriod" value="">
                                </div>
                                <hr>
                                <div class="col-md-12 col-sm-12 d-flex justify-content-between">
                                    <p>Plan Amount per User :</p>
                                    <input type="text" readonly id="selectedPlanAmount" oninput="updateSpan()" name="PlanAmount" value="">
                                </div>
                                <hr>
                                <div class="col-md-12 col-sm-12 d-flex justify-content-between">
                                    <p>Minimum User :</p>
                                    <p id="min-user">5</p>
                                </div>
                                <hr>
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <p>Get More User</p>
                                    <div class="quantity" id="hide">
                                        <button class="btn btn-primary minus-btn disabled" type="button">-</button>
                                        <span id="quantity">5</span>
                                        <button class="btn btn-primary plus-btn" type="button">+</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12 d-flex justify-content-between align-items-center ">
                                    <div>
                                        <p>Plan Duration :</p>
                                    </div>
                                    <div class="d-flex align-items-center p-2">
                                        <p id="totalmonth">0</p>
                                        <p class="pl-1">Month</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12 d-flex justify-content-between">
                                    <p>Net User Cost :</p>
                                    <p id="outputSpan"></p>
                                </div>
                                <hr>
                                <div class="col-md-12 d-flex justify-content-between">
                                    <p>Applicable Tax</p>
                                    <p>18%</p>
                                </div>
                                <hr>
                                <div class="col-md-12 d-flex justify-content-between">
                                    <p class="total">Net Payable</p>
                                    <input type="text" id="FinalAmount" class="total" readonly name="FINAL_PRICE" value="">
                                </div>
                                <hr>
                                <span id="payment-error"> <?php echo "" . isset($_SESSION["Payment_Failed"]) ? $_SESSION["Payment_Failed"] : '' . ""; ?></span>
                            </div>
                            <div class="col text-center mt-4">
                                <input type="submit" name="UserPlanSubmit" value="Pay Now" id="PayNow" class="btn btn-primary">
                                <input type="submit" name="FreePlan" value="Claim Now" id="FreePlan" class="btn btn-primary">
                                <input type="button" name="UpgradePlan" onclick="popup()" value="Upgrade Your Plan" id="UpgradePlan" class="btn btn-success hidden">
                            </div>
                            <div class="col mt-5">
                                <p><strong>Notice:</strong> "Kindly take a moment to review the payment details and ensure they align with your chosen plan."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php include "../../assets/FooterFilesLoader.php";
    unset($_SESSION["Payment_Failed"]); ?>


    <script>
        function popup() {

            swal({
                title: "Coming Soon!!!",
                icon: "warning",
            });
        }

        function updateSelectedPlan(planRadio) {
            let adminPlanId = planRadio.value;
            let planAmount = parseFloat(planRadio.parentElement.getAttribute("data-plan-amount"));
            let planPeriod = planRadio.parentElement.getAttribute("data-plan-period");
            let planName = planRadio.parentElement.getAttribute("data-plan-name");

            document.getElementById("adminPlanId").value = adminPlanId;
            document.getElementById("selectedPlanAmount").value = planAmount;
            document.getElementById("selectedPlanPeriod").value = planPeriod;
            document.getElementById("selectedPlanName").value = planName;

            updateTotalAmount();



        }

        function updateTotalAmount() {
            let quantity = parseInt(document.getElementById('quantity').innerText);
            let planAmount = parseFloat(document.getElementById('selectedPlanAmount').value);
            let planPeriod = document.getElementById('selectedPlanPeriod').value;
            let myForm = document.getElementById("UserPlanForm");

            if (planAmount != 0) {
                document.getElementById('hide').style.display = "block";
                document.getElementById('min-user').innerText = 5;
                myForm.action = "./../Payment/index.php";
                document.getElementById('FreePlan').classList.remove("text");
                document.getElementById('FreePlan').classList.add("hidden");
                document.getElementById('PayNow').classList.remove("hidden");
                document.getElementById('PayNow').classList.add("text");
            } else {
                document.getElementById('hide').style.display = "none";
                quantity = 1;
                document.getElementById('min-user').innerText = quantity;
                myForm.action = "<?php echo CONTROLLER . "/ModuleHandler.php"; ?>";
                document.getElementById('PayNow').classList.remove("text");
                document.getElementById('FreePlan').classList.remove("hidden");
                document.getElementById('PayNow').classList.add("hidden");
                document.getElementById('FreePlan').classList.add("text");
            }
            if (!isNaN(planAmount) && planPeriod) {
                let multiplier = 1;
                if (planPeriod === "Half-Yearly") {
                    multiplier = 6;
                } else if (planPeriod === "Yearly") {
                    multiplier = 12;
                }
                document.getElementById('totalmonth').innerText = multiplier;
                let totalAmount = quantity * planAmount * multiplier;
                let spanElement = document.getElementById('outputSpan');

                if (spanElement) {
                    spanElement.textContent = totalAmount.toFixed(2);
                }

                let taxAmount = (totalAmount * 18) / 100;
                let finalAmount = totalAmount + taxAmount;

                document.getElementById('FinalAmount').value = finalAmount.toFixed(2);
                document.getElementById('totalCount').value = quantity;
            } else {
                var spanElement = document.getElementById('outputSpan');

                if (spanElement) {
                    spanElement.textContent = "Please select the plan";
                }
            }
        }

        document.querySelector(".plus-btn").addEventListener("click", function() {
            var valueCount = parseInt(document.getElementById("quantity").innerText);
            valueCount++;
            document.getElementById("quantity").innerText = valueCount;
            document.getElementById("total-user").value = valueCount;

            if (valueCount > 5) {
                document.querySelector(".minus-btn").removeAttribute("disabled");
                document.querySelector(".minus-btn").classList.remove("disabled");
            }

            updateTotalAmount();
        });

        document.querySelector(".minus-btn").addEventListener("click", function() {
            var valueCount = parseInt(document.getElementById("quantity").innerText);

            if (valueCount > 1) {
                valueCount--;
                document.getElementById("quantity").innerText = valueCount;
                document.getElementById("total-user").value = valueCount;
            }

            if (valueCount === 5) {
                document.querySelector(".minus-btn").setAttribute("disabled", "disabled");
            }

            updateTotalAmount();
        });

        // Initial call to updateTotalAmount to ensure it's called when the page loads
        updateTotalAmount();
    </script>

</body>

</html>