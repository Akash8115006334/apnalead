<?php
if (!isset($_GET['alert'])) {
    include __DIR__ . "/reminder-pop.php";
} else {
    $GetRemindertime = "";
}
include __DIR__ . "/birthday-pop-up.php";
include __DIR__ . "/visit-pop-window.php";
include __DIR__ . "/Daily-Quotes.php";
include __DIR__ . "/forms/Master-Search.php";
include __DIR__ . "/forms/UniversalMsg.php";
include __DIR__ . "/forms/Add-Customer.php";
?>
<!-- webhook by apnalead  -->
<!-- <div id='MainEnquiryForm'></div>
<script src='http://cdn.apnalead.com/apnalead.js?key=826r783ygfcherjebvcbvefvbjdbcfkjdbkj'></script> -->
<!-- webhook by apnalead  -->

<div id="footer" class="app-footer m-0">
    <div class="time-block" hidden="">
        <span><i class="fa fa-clock-o pl-1"></i> </span>
        <span id="clock">8:10:45</span>
        <span> | </span>
        <span class="date"><?php echo date("d D M, Y"); ?></span>
    </div>
    <script>
        let lastEntryIndex = 0; // Keep track of the last processed entry index
        let url = "https://script.google.com/macros/s/AKfycbzZ5-IOOzaTc7PwbtJlrz_P5G5W88TR8qv1i9s-R4qDZh5K-T6dsJGjPufIl1Zb7atQ3w/exec";

        // Fetch google sheets data into HTML and also save into the Database
        function FetchRecords() {
            fetch(url, {
                    method: "GET",
                })
                .then(res => res.json())
                .then(datas => {
                    // Check for new entries
                    const newEntries = datas.myalldata.slice(lastEntryIndex);
                    if (newEntries.length > 1) {
                        // Display new entries in HTML table
                        newEntries.forEach((data, index) => {
                            if (index !== 0) {
                                let FullName = data[0];
                                let PhoneNumber = data[1];
                                let EmailId = data[2];
                                let Requirement = data[3];
                                let Message = data[4];
                                let AuthenticationKey = data[5];

                                //ajax for GOOGLE SHEET TO APNA LEAD
                                $(document).ready(function() {
                                    $.ajax({
                                        url: '<?php echo DOMAIN; ?>/handler/AutoRunner/FetchingLeadsFromWebHooks.php',
                                        method: 'POST',
                                        data: {
                                            // Specify the data to be sent in the request
                                            FetchAndSaveLeadFromGoogleSheetToApnaLead: 'true',
                                            PersonFullName: FullName,
                                            PersonPhoneNumber: PhoneNumber,
                                            PersonEmailId: EmailId,
                                            PersonRequirement: Requirement,
                                            PersonMessage: Message,
                                            CompanyAuthenticationKey: AuthenticationKey
                                        },
                                    });
                                });
                            }
                        });

                        // Update the last entry index
                        lastEntryIndex = datas.myalldata.length;
                    }
                })
                .catch(error => console.error("Error fetching records:", error));
        }
        setInterval(FetchRecords, 2000); // Check for new entries every 500 milliseconds (half second)
    </script>
    <script>
        setInterval(showTime, 1000);

        function showTime() {
            let time = new Date();
            let hour = time.getHours();
            let min = time.getMinutes();
            let sec = time.getSeconds();
            am_pm = "PM";

            if (hour > 12) {
                hour -= 12;
                am_pm = "PM";
            }
            if (hour == 0) {
                hr = 12;
                am_pm = "AM";
            }

            hour = hour < 10 ? "0" + hour : hour;
            min = min < 10 ? "0" + min : min;
            sec = sec < 10 ? "0" + sec : sec;

            let currentTime = hour + ":" +
                min + ":" + sec + " " + am_pm + "";

            document.getElementById("clock").innerHTML = "&nbsp;" + currentTime + " ";

            //document.getElementById("clock2").innerHTML = "&nbsp;" + currentTime + " ";
            //show reminder at reminder time
            let RunningTime = hour + ":" + min + " " + am_pm;
            document.getElementsByClassName("showcurrenttimevalue").value = hour + ":" + min;
            document.getElementsByClassName("showcurrenttimehtml").innerHTML = hour + ":" + min;
            if (RunningTime == '<?php echo $GetRemindertime; ?>') {
                document.getElementById("alert_sound").play();
                document.getElementById("reminder_pop_up").style.display = "block";
            }
        }
        showTime();
    </script>
    <?php if (DEVICE_TYPE == "Computer") { ?>
        <footer class="main-footer">
            Copyrighted &copy; <?php echo date("Y"); ?> - <span class="text-primary"><?php echo APP_NAME; ?></span> | Managed By <a href="<?php echo DEVELOPER_URL; ?>" class="text-primary" target="_blank"><?php echo DEVELOPED_BY; ?></a>
        </footer>
    <?php } ?>
</div>
<div class="move">
    <a href="<?php echo APP_URL; ?>/leads/add.php" class="icon-container">
        <div class="icon">+</div>
        <div class="image" style="background-image: url(<?php echo APP_LOGO; ?>);"></div>
    </a>
</div>
<script>
    let move = document.querySelector(".move");
    let isDragging = false;
    let offset = {
        x: 0,
        y: 0
    };
    // Desktop and mobile events
    move.addEventListener('mousedown', startDrag);
    move.addEventListener('touchstart', startDrag);

    function startDrag(e) {
        // e.preventDefault(); // Try removing this line
        isDragging = true;

        if (e.type === 'mousedown') {
            offset.x = e.clientX - move.getBoundingClientRect().left;
            offset.y = e.clientY - move.getBoundingClientRect().top;
            document.addEventListener('mousemove', drag);
            document.addEventListener('mouseup', stopDrag);
        } else if (e.type === 'touchstart' && e.touches.length === 1) {
            let touch = e.touches[0];
            offset.x = touch.clientX - move.getBoundingClientRect().left;
            offset.y = touch.clientY - move.getBoundingClientRect().top;
            document.addEventListener('touchmove', drag);
            document.addEventListener('touchend', stopDrag);
        }
    }

    function drag(e) {
        if (!isDragging) return;

        if (e.type === 'mousemove') {
            move.style.left = e.clientX - offset.x + 'px';
            move.style.top = e.clientY - offset.y + 'px';
        } else if (e.type === 'touchmove' && e.touches.length === 1) {
            let touch = e.touches[0];
            move.style.left = touch.clientX - offset.x + 'px';
            move.style.top = touch.clientY - offset.y + 'px';
        }
    }

    function stopDrag() {
        isDragging = false;

        document.removeEventListener('mousemove', drag);
        document.removeEventListener('mouseup', stopDrag);
        document.removeEventListener('touchmove', drag);
        document.removeEventListener('touchend', stopDrag);
    }
</script>
<script>
    // Disable right-click
    // document.addEventListener('contextmenu', function(e) {
    //     e.preventDefault();
    // });
    // Disable screenshot
    document.addEventListener('keyup', function(e) {
        // Check for Print Screen key
        if (e.key === 'PrintScreen' || e.key === 'PrtSc') {
            e.preventDefault();
            console.log('Screenshot attempt detected.');
        }
    });
    // Disable text selection
    document.addEventListener('selectstart', function(e) {
        e.preventDefault();
    });
</script>