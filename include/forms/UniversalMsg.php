<?php
if (isset($_GET["UpdateWindow"])) {
    $_SESSION['UniversalMsg'] = "true";
    $UniversalHiddenValue = "hidden";
} else {
    if (isset($_SESSION['UniversalMsg'])) {
        $UniversalHiddenValue = "hidden";
    } else {
        $UniversalHiddenValue = "hidden";
    }
}
?>
<section class="pop-section <?php echo $UniversalHiddenValue;
                            ?>" id="Universal">
    <div class="action-window w-75">
        <div class='container w-pr-50 mt-5 mb-5 '>
            <div class=" col-md-12 text-center">
                <center>
                    <span>
                        <img src="<?php echo STORAGE_URL . '/company/img/logo/logo.webp' ?>" style="box-shadow:none !important" alt="companylogo" class=" w-25 mb-3">
                        <h2>New Update Arrived !!</h2>
                    </span>
                    <br>
                </center>
                <div class="row">
                    <div class="col-md-12 text-justify fs-18">
                        <p>ApnaLead CRM brings a sleek new UI, detailed user call history, advanced date filters, and real-time counters for Facebook and website leads."</p><br>
                        <p>"<i>"Thanks for staying with ApnaLead! Your ongoing support is priceless as we enhance our CRM platform. Let's reach new heights of success together. We value your partnership!"</i>"</p>
                    </div>
                </div>
            </div>
            <div class="text-center col-md-12"><a href="index.php?UpdateWindow=true;" class="btn btn-outline-success">Close</a></div>
        </div>
    </div>
</section>