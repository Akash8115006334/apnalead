<div class="row">
    <div class="col-md-12">
        <h6 class="app-sub-heading mt-0">Leaves Details</h6>
    </div>
    <div class="col-md-3">
        <div class="card card-body rounded-3 p-4">
            <div class="flex-s-b">
                <h2 class="count mb-0 m-t-5 h1 text-primary">
                    0
                </h2>
            </div>
            <p class="mb-0 fs-14 text-grey">Total Leaves</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-body rounded-3 p-4">
            <div class="flex-s-b">
                <h2 class="count mb-0 m-t-5 h1 text-info">
                    0
                </h2>
            </div>
            <p class="mb-0 fs-14 text-grey">Leave Taken</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-body rounded-3 p-4">
            <div class="flex-s-b">
                <h2 class="count mb-0 m-t-5 h1 text-success">
                    0
                </h2>
            </div>
            <p class="mb-0 fs-14 text-grey">Balance</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-body rounded-3 p-4">
            <div class="flex-s-b">
                <h2 class="count mb-0 m-t-5 h1 text-warning">
                    0
                </h2>
            </div>
            <p class="mb-0 fs-14 text-grey">OD Leaves</p>
        </div>
    </div>
</div>

<form action="<?php echo CONTROLLER; ?>/EmployeeController.php" method="POST">
    <?php FormPrimaryInputs(true, [
        "UserAttandanceMainUserId" => $REQ_UserId
    ]); ?>
    <div class="row">
        <div class="col-md-12">
            <h6 class="app-sub-heading">Add Attandance</h6>
        </div>
        <div class="col-md-2 form-group">
            <label>Check-in Date</label>
            <input type="date" readonly="" name="UserAttandanceStartDate" class="form-control form-control-sm " value="<?php echo date("Y-m-d"); ?>">
        </div>
        <div class="col-md-2 form-group">
            <label>Check-in Time</label>
            <input type="time" readonly="" id="at_times" name="UserAttandanceStartTime" class="form-control form-control-sm " value="<?php echo date('h:i'); ?>">
            <script>
                window.setInterval(function() {
                    var todays = new Date();
                    var times = todays.getHours() + ":" + todays.getMinutes();
                    document.getElementById("at_times").value = times;
                }, 1000);
            </script>
        </div>
        <div class="col-md-2 form-group">
            <label>Status</label>
            <select name="UserAttandanceStatus" id="at_status" onchange="CheckLeaves()" class="form-control form-control-sm " required="">
                <option value="PRESENT">PRESENT</option>
                <option value="ABSANT">ABSANT</option>
                <option value="WORK_FROM_HOME">WORK FROM HOME</option>
                <option value="LEAVE">LEAVE</option>
            </select>
        </div>
        <div class="col-md-4 form-group hidden" id="leavenote">
            <label>Enter Reason</label>
            <textarea name="UserAttandanceNotes" class="form-control form-control-sm " rows="3"></textarea>
        </div>
        <div class="col-md-2">
            <button type="submit" name="AttandanceRecords" class="btn btn-sm btn-success m-t-18">Save Records</button>
        </div>
    </div>
</form>

<div class="row mb-5px">
    <div class="col-md-12">
        <h5 class="app-sub-heading">Open/Pending/Un-Check-out Attandances</h5>
        <?php
        $sql = "SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceEndTime='null' and UserAttandanceEndDate='null' GROUP BY UserAttandanceMonth ORDER BY DATE('UserAttandanceStartDate') DESC";
        $FetchAttandances = _DB_COMMAND_("$sql", true);
        if ($FetchAttandances != null) {
            foreach ($FetchAttandances as $Record) {
                $MonthGroup = $date = $Record->UserAttandanceMonth; ?>
                <form action="<?php echo CONTROLLER; ?>/EmployeeController.php" method="POST">
                    <?php FormPrimaryInputs(true, [
                        "UserAttandanceId" => $Record->UserAttandanceId,
                    ]) ?>
                    <div class="row">
                        <div class="col-md-5">
                            <p class="flex-s-b" style="line-height:18px;">
                                <span>
                                    <span class="text-grey">Check-in Date</span><br>
                                    <span class="text-black fs-17px"><b><?php echo DATE_FORMATES("d M, Y", $Record->UserAttandanceStartDate); ?></b></span>
                                </span>
                                <span>
                                    <span class="text-grey">Check-in Time</span><br>
                                    <span class="text-black fs-17px"><b><?php echo DATE_FORMATES("h:m A", $Record->UserAttandanceStartTime); ?></b></span>
                                </span>
                                <span>
                                    <span class="text-grey">Status</span><br>
                                    <span class="text-black fs-17px"><?php echo $Record->UserAttandanceStatus; ?></span>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-7 flex-s-b shadow-sm rounded-1">
                            <div class="form-group">
                                <label>Check-out Date</label>
                                <input type="date" readonly="" name="UserAttandanceEndDate" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-sm ">
                            </div>
                            <div class="form-group">
                                <label>Check-out Time</label>
                                <input type="time" readonly="" name="UserAttandanceEndTime" id="<?php echo $Record->UserAttandanceId; ?>_times" value="" class="form-control form-control-sm ">
                            </div>
                            <script>
                                window.setInterval(function() {
                                    var today_<?php echo $Record->UserAttandanceId; ?> = new Date();
                                    var times_<?php echo $Record->UserAttandanceId; ?> = today_<?php echo $Record->UserAttandanceId; ?>.getHours() + ":" + today_<?php echo $Record->UserAttandanceId; ?>.getMinutes();
                                    document.getElementById("<?php echo $Record->UserAttandanceId; ?>_times").value = times_<?php echo $Record->UserAttandanceId; ?>;
                                }, 1000);
                            </script>
                            <div>
                                <button class="btn btn-warning btn-sm mt-4 text-white" name="CheckOutRecord">Check-out <i class="fa fa-angle-right"></i></button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                    </div>
                </form>
        <?php }
        } else {
            NoData("No Pending Record Found!");
        } ?>
        <h5 class="app-sub-heading">Monthly Attandance History</h5>
        <?php if (isset($_GET['month-group']) && isset($_GET['monthview'])) {
            $ReqMonthGroup = $_GET['month-group']; ?>
            <div class="flex-s-b mb-5px">
                <h4>Attandance Record for : <b><?php echo $_GET['month-group']; ?></b></h4>
                <a href="?get=<?php echo IfRequested("GET", "get", "", false); ?>" class="btn btn-sm btn-primary">Hide Record</a>
            </div>
            <table class="table table-striped">
                <tr>
                    <th>Date</th>
                    <th>Month</th>
                    <th>Check-in/IP</th>
                    <th>Check-Out/IP</th>
                    <th>Work Hours</th>
                    <th>WorkDayCount</th>
                    <th>Status/Note</th>
                </tr>
                <?php
                $sql2 = "SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceMonth='$ReqMonthGroup' ORDER BY DATE('UserAttandanceStartDate') DESC";
                $FetchAttandances = _DB_COMMAND_("$sql2", true);
                if ($FetchAttandances != null) {
                    $TotalHours = 0;
                    $TotalDays = 0;
                    foreach ($FetchAttandances as $Record) {
                        $MonthGroup = $date = $Record->UserAttandanceMonth;
                        $CheckIN = $Record->UserAttandanceStartDate . " " . $Record->UserAttandanceStartTime;
                        $CheckOUT = $Record->UserAttandanceEndDate . " " . $Record->UserAttandanceEndTime;
                        $WorkingHoursTotal = GetHours($CheckIN, $CheckOUT);
                        $WorkDaysTotal = round($WorkingHoursTotal / REQUIRED_WORK_HOURS_PER_DAY, 1);
                        $TotalHours += $WorkingHoursTotal;
                        $TotalDays += $WorkDaysTotal; ?>
                        <tr>
                            <td><span class="bold text-primary"><?php echo DATE_FORMATES("d M, Y", strtoupper($Record->UserAttandanceStartDate)); ?></span></td>
                            <td><?php echo strtoupper($MonthGroup); ?></td>
                            <td><?php echo $Record->UserAttandanceStartIP; ?></td>
                            <td><?php echo $Record->UserAttandanceEndIP; ?></td>
                            <td>
                                <?php echo $WorkingHoursTotal; ?> Hrs.
                            </td>
                            <td>
                                <?php echo $WorkDaysTotal; ?> Days
                            </td>
                            <td><?php echo $Record->UserAttandanceStatus; ?></td>
                        </tr>
                    <?php
                    } ?>
                    <tr>
                        <td colspan="4" align="right"><b>Total Work Hours : </b><?php echo $TotalHours; ?> Hrs.</td>
                        <td colspan="3" class="text-center"><b>Total Work Days: </b><?php echo $TotalDays; ?> Days</td>
                    </tr>
                <?php
                } ?>
            </table>
        <?php } ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Month-Year</th>
                    <th>Presents</th>
                    <th>Absants</th>
                    <th>WFH</th>
                    <th>Leaves</th>
                    <th>WorkHours</th>
                    <th>WorkDays</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' GROUP BY UserAttandanceMonth ORDER BY DATE('UserAttandanceStartDate') DESC";
                $FetchAttandances = _DB_COMMAND_("$sql", true);

                if ($FetchAttandances != null) {
                    $TotalHours = 0;
                    $TotalDays = 0;
                    foreach ($FetchAttandances as $Record) {
                        $MonthGroup = $date = $Record->UserAttandanceMonth;
                        $CheckIN = $Record->UserAttandanceStartDate . " " . $Record->UserAttandanceStartTime;
                        $CheckOUT = $Record->UserAttandanceEndDate . " " . $Record->UserAttandanceEndTime;
                        $WorkingHours = GetHours($CheckIN, $CheckOUT);
                        $WorkDays = round($WorkingHours / REQUIRED_WORK_HOURS_PER_DAY, 1);

                        //count total work hours and days
                        $sql2 = "SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceMonth='$MonthGroup' ORDER BY DATE('UserAttandanceStartDate') DESC";
                        $FetchAttandances = _DB_COMMAND_("$sql2", true);
                        if ($FetchAttandances != null) {
                            foreach ($FetchAttandances as $Record) {
                                $MonthGroup = $date = $Record->UserAttandanceMonth;
                                $CheckIN = $Record->UserAttandanceStartDate . " " . $Record->UserAttandanceStartTime;
                                $CheckOUT = $Record->UserAttandanceEndDate . " " . $Record->UserAttandanceEndTime;
                                $WorkingHoursTotal = GetHours($CheckIN, $CheckOUT);
                                $WorkDaysTotal = round($WorkingHoursTotal / REQUIRED_WORK_HOURS_PER_DAY, 1);
                                $TotalHours += $WorkingHoursTotal;
                                $TotalDays += $WorkDaysTotal;
                            }
                        }

                ?>
                        <tr>
                            <td><span class="bold text-primary"><?php echo strtoupper($MonthGroup); ?></span></td>
                            <td class="bold"><?php echo TOTAL("SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceMonth='" . $date . "' and UserAttandanceStatus='PRESENT'"); ?></td>
                            <td class="bold"><?php echo TOTAL("SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceMonth='" . $date . "' and UserAttandanceStatus='ABSANT'"); ?></td>
                            <td class="bold"><?php echo TOTAL("SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceMonth='" . $date . "' and UserAttandanceStatus='WORK_FROM_HOME'"); ?></td>
                            <td class="bold"><?php echo TOTAL("SELECT * FROM user_attandances where UserAttandanceMainUserId='$REQ_UserId' and UserAttandanceMonth='" . $date . "' and UserAttandanceStatus='LEAVE'"); ?></td>
                            <td>
                                <?php echo $TotalHours; ?> Hrs.
                            </td>
                            <td>
                                <?php echo $TotalDays; ?> Days
                            </td>
                            <td>
                                <a href="?get=<?php echo IfRequested("GET", "get", "", false); ?>&monthview=true&month-group=<?php echo $MonthGroup; ?>" class="text-primary bold">View Day Chart</a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    function CheckLeaves() {
        var at_status = document.getElementById("at_status");

        if (at_status.value == "LEAVE" || at_status.value == "WORK_FROM_HOME") {
            document.getElementById("leavenote").style.display = "block";
        } else {
            document.getElementById("leavenote").style.display = "none";
        }
    }
</script>