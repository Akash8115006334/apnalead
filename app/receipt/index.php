<?php
require "./../../acm/SysFileAutoLoader.php";
require "./../../handler/AuthController/AuthAccessController.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Receipt</title>
    <?php include "../../assets/HeaderFilesLoader.php"; ?>
</head>

<body>
    <?php
    $id = $_GET['billingId'];
    $GetBillingDetails = _DB_COMMAND_("SELECT * FROM user_billings INNER JOIN config_plans ON user_billings.user_billing_plan_main_id = config_plans.plan_id 
                            INNER JOIN users ON user_billings.user_main_id = users.UserId  WHERE user_billing_id='$id'", true);
    $txnDetails = _DB_COMMAND_("SELECT * FROM user_transactions WHERE user_billing_main_id='$id'", true);
    foreach ($txnDetails as $txn) {
        $paymode = $txn->user_txn_pay_mode;
        $amount = $txn->user_txn_amount;
        $gst = $txn->user_txn_tax;
    }
    if ($GetBillingDetails != null) {
        foreach ($GetBillingDetails as $BillDetails) {

            if ($BillDetails->plan_pay_period == "Monthly") {
                $month = 1;
            } else if ($BillDetails->plan_pay_period == "Half-Yearly") {
                $month = 6;
            } else if ($BillDetails->plan_pay_period == "Yearly") {
                $month = 12;
            }
    ?>
            <a href="./../Setup/1/" class="skip btn btn-dark">Close</a>
            <section class="bill-receipt-section mt-4">

                <div class="receipt-area">

                    <div class="compony-details">
                        <img src="<?PHP echo APP_LOGO; ?>" alt="LOGO">
                        <div class="compony-description">
                            <h2>NAVIX CONSULTANCY</h2>
                            <p class="text-gray">Navix Consultancy is your trusted partner in business growth and success. Our dedicated team is here to
                                empower you with the tools, strategies, and insights needed to thrive in today's competitive landscape. Discover the
                                Navix advantage and unlock your business's full potential.</p>
                        </div>

                    </div>

                    <div class="pay-receipt">
                        <h2>PAY RECEIPT</h2>
                        <hr>
                        <div class="user-details">
                            <div class="user-description">
                                <p><?php echo $BillDetails->UserFullName; ?> <br>
                                    <?php echo $BillDetails->UserPhoneNumber; ?> <br>
                                    <?php echo $BillDetails->UserEmailId; ?><br>
                                </p>
                            </div>
                            <img src="<?PHP echo STORAGE_URL; ?>/default/default.png" alt="UserLOGO">

                        </div>


                    </div>
                    <div class="bill-details">
                        <h2>BILL DETAILS</h2>
                        <hr>
                        <table>
                            <thead>
                                <tr>
                                    <th>Ref No:</th>
                                    <th>Payment Month:</th>
                                    <th>Plan Started From:</th>
                                    <th>Plan End To:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $BillDetails->user_billing_ref_no; ?></td>
                                    <td><?php echo $BillDetails->user_billing_month; ?></td>
                                    <td><?php echo $BillDetails->user_billing_from_date; ?></td>
                                    <td><?php echo $BillDetails->user_billing_to_date; ?></td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th>Plan Name:</th>
                                    <th>Payment Mode:</th>
                                    <th>Plan Updated At:</th>
                                    <th>Plan Period:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $BillDetails->plan_name; ?></td>
                                    <td><?php echo $paymode; ?></td>
                                    <td><?php echo $BillDetails->user_billing_created_at; ?></td>
                                    <td><?php echo $BillDetails->plan_pay_period; ?></td>
                                </tr>

                            </tbody>
                        </table>
                        <hr>
                    </div>

                    <div class="payment-details">

                        <div class="plan">
                            <h3>Plan Amount</h3>
                            <p>Rs.<?php echo $BillDetails->plan_amount_per_user; ?></p>
                        </div>
                        <div class="plan">
                            <h3>Plan User</h3>
                            <p><?php echo $BillDetails->user_billing_net_users; ?> User</p>
                        </div>
                        <div class="plan">
                            <h3>Plan Duration</h3>
                            <p class=""><?php echo $month; ?> Month</p>
                        </div>
                        <div class="plan">
                            <h3>Plan Amount Per User</h3>
                            <p>Rs.<?php echo $BillDetails->plan_amount_per_user * $BillDetails->user_billing_net_users ?></p>
                        </div>
                        <div class="plan">
                            <h3>GST</h3>
                            <p><?php echo $gst; ?>%</p>
                        </div>
                        <hr>
                        <div class="plan">

                            <h3>TOTAL :</h3>
                            <h2>Rs.<?php echo $amount; ?></h2>

                        </div>
                        <hr>
                <?php }
        }
                ?>
                    </div>
                    <div class="signature">
                        Authorised Signature

                    </div>

                    <div class="footer my-2">
                        <hr>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellendus, maiores?</p>
                    </div>
                </div>
            </section>
            <div class="text-center">
                <a href="" class="btn btn-primary mt-4">Print</a>
            </div>
            <?php include "../../assets/FooterFilesLoader.php"; ?>
</body>

</html>