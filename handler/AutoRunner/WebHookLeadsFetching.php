<?php
require __DIR__ . "/../../acm/SysFileAutoLoader.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FETCH API GOOGLE SHEET -> APNA LEAD APP | GLEADS (PHP)</title>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
  <div id='Google_Sheet_Records_Viewer'></div>
  <script>
    let lastEntryIndex = 0; // Keep track of the last processed entry index
    const Records = document.getElementById("Google_Sheet_Records_Viewer");
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
                    success: function(response) {
                      Records.innerHTML += response;
                    },
                    error: function(xhr, status, error) {
                      Records.innerHTML += response + " @" + status + ": " + error + "<br>";
                    }
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
</body>

</html>