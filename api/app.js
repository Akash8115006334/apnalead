function ApnaLeadEnquiryForm(AuthenticationKey) {
  const enquiryFormHTML = `
<style>
.rounded {
  -o-border-radius: 1rem;
  -ms-border-radius: 1rem;
  -webkit-border-radius: 1rem;
  -moz-border-radius: 1rem;
  border-radius: 1rem !important;
} 
.apna-lead-enquiry-btn {
  border-radius: 1rem;
  color: white;
  text-decoration: none;
  font-size: 1.4rem !important;
  position: fixed;
  right: 0px;
  top: 35%;
  transform: rotate(180deg);
  cursor: pointer;
  z-index:999;
}
.apna-lead-enquiry-btn img {
  width: 30%;
}
.apna-lead-enquiry-btn:hover {
  color: white;
  text-decoration: underline;
}
#apna-lead-enquiry-form {
  position: fixed;
  width: 100%;
  top: 0px;
  right: 0px;
  background-color: #0000008f;
  height: 100%;
  overflow-y: scroll;
  z-index:9999;
  padding:1rem !important;
}

#apna-lead-enquiry-form .div {
  min-width: 240px;
  max-width: 360px;
  background-color: white;
  border-radius: 1rem;
  padding: 1rem;
  margin: 2% auto;
}

.apnalead-enq-heading {
      font-family: math;
    font-size: 2rem;
    text-shadow: 0px 0px 1px grey !important;
    margin-bottom:0.5rem !important;
    margin-top:1.5rem !important;
}
.apnalead-p-text {
  margin-top: 0px !important;
    color: darkslategrey !important;
    font-size:0.9rem !important;
}
.apna-lead-form-group {
      margin-bottom: 1rem !important;
    display: flex;
    flex-direction: column;
}
.apna-lead-form-group label {
  font-family: math;
  font-size: 0.7rem;
  text-shadow: 0px 0px 1px grey!important;
  margin-bottom:0.2rem!important;
}
.apna-lead-form-group .apna-form-control {
    font-size: 0.8rem;
    border-style: none;
    box-shadow: 0px 0px 1px black;
    padding: 0.25rem;
    border-radius: 0.25rem;
    font-family:math !important;
}
.apna-lead-btn {
    font-size: 1rem;
    border-style: none !important;
    box-shadow: 0px 0px 1px green;
    background-color: #349f34;
    font-family: math;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    color: white;
    text-transform: uppercase;
    margin-right: 0.5rem !important;
}
.apna-lead-cls-btn {
      box-shadow: 0px 0px 1px grey;
    background-color: lightgrey;
    font-size: 1rem;
    font-family: math;
    padding: 0.5rem 1rem;
    border-radius: 0.4rem;
    border-style:none !important;
    margin-right: 0.5rem !important;
}

</style>
  <a id='EnquiryBtn' class="apna-lead-enquiry-btn">
    <img src="https://www.pngkey.com/png/full/255-2555375_stg-travel-special-offers-quick-enquiry-vertical-button.png">
  </a>
  <section id='apna-lead-enquiry-form' style='display:none;'>
    <div class="div">
      <div id='FormArea'>
        <form method="POST" id="LeadForm">
        <input type='text' hidden id='AuthKey' name='AuthenticationKey'>
          <div class="apna-lead-form-group text-center" style='margin-bottom:0.5rem !important;'>
            <h2 class='apnalead-enq-heading'>Have an eqnuiry?</h2>
            <p class='apnalead-p-text'>Feel free to share your enquiry...</p>
          </div>
          <div class="apna-lead-form-group" style='margin-bottom:1rem !important;'>
            <label>Enter Full Name</label>
            <input type="text" name='FullName' required class="apna-form-control">
          </div>
          <div class="apna-lead-form-group" style='margin-bottom:1rem !important;'>
            <label>Enter Phone Number</label>
            <input type="text" minlength="10" maxlength="12" name='PhoneNumber' required class="apna-form-control" placeholder="without +91">
          </div>
          <div class="apna-lead-form-group" style='margin-bottom:1rem !important;'>
            <label>Enter EmailId</label>
            <input type="email" name='EmailId' required class="apna-form-control">
          </div>
          <div class="apna-lead-form-group" style='margin-bottom:1rem !important;'>
            <label>Requirement For</label>
            <select name='Requirement' required='' id='ProjectList' class="apna-form-control">
             
            </select>
          </div>
          <div class="apna-lead-form-group" style='margin-bottom:1rem !important;'>
            <label>Enter Query Details</label>
            <textarea class="apna-form-control" required rows="3" name="Message"></textarea>
          </div>
          <div class="apna-lead-form-group" style='display:flex !important;flex-direction:row;'>
            <button name="btn" class="apna-lead-btn">Save Details</button>
            <button id='CloseEnquiryBtn'  type='button' class="apna-lead-cls-btn">Cancel</button>
          </div>
        </form>
      </div>
      <div id='ThankMsg' style='display:none;'>
        <div class="text-center p-3">
          <h1 class="text-success">Thanking you!</h1>
          <p style='margin-bottom:1rem !important;'>We have received your enquiry and will contact you as soon as possible.</p>
          <a href="" class="btn btn-sm btn-info" style='color:white !important;'>Back to Home</a>
        </div>
      </div>
    </div>
  </section>
`;

  //initiate enquiry form
  document.getElementById("MainEnquiryForm").innerHTML = enquiryFormHTML;
  document.getElementById("AuthKey").value = AuthenticationKey;

  //ajax request
  //ajax for GOOGLE SHEET TO APNA LEAD
  let ProjectList = document.getElementById("ProjectList");
  document.addEventListener("DOMContentLoaded", function () {
    // Make the GET request
    fetch(
      "https://app.apnalead.com/api/GenerateProjectResponse.php?GetProjectOptions=true&ProjectFroAuthenticationKey=" +
        AuthenticationKey
    )
      .then((response) => response.text())
      .then(function (response) {
        // Handle the response
        document.getElementById("ProjectList").innerHTML = response;
      })
      .catch(function (error) {
        // Handle errors
        document.getElementById("ProjectList").innerHTML =
          "<option value='0'>No Project Found</option>";
      });
  });

  //variables
  let url =
    "https://script.google.com/macros/s/AKfycbzZ5-IOOzaTc7PwbtJlrz_P5G5W88TR8qv1i9s-R4qDZh5K-T6dsJGjPufIl1Zb7atQ3w/exec";
  let LeadForm = document.getElementById("LeadForm");
  let FormArea = document.getElementById("FormArea");
  let ThankMsg = document.getElementById("ThankMsg");

  //show html from js
  // You can now use the "enquiryFormHTML" variable wherever needed in your JavaScript code.

  // JavaScript to show/hide the div on click
  document.getElementById("EnquiryBtn").addEventListener("click", function () {
    var EnquiryForm = document.getElementById("apna-lead-enquiry-form");
    if (EnquiryForm.style.display === "none") {
      EnquiryForm.style.display = "block";
    } else {
      EnquiryForm.style.display = "none";
    }
  });

  // JavaScript to show/hide the div on click
  document
    .getElementById("CloseEnquiryBtn")
    .addEventListener("click", function () {
      var EnquiryForm = document.getElementById("apna-lead-enquiry-form");
      if (EnquiryForm.style.display === "none") {
        EnquiryForm.style.display = "block";
      } else {
        EnquiryForm.style.display = "none";
      }
    });

  //save HTML form data into Google Sheets
  LeadForm.addEventListener("submit", (e) => {
    e.target.btn.innerHTML = "Sending. Please wait...";
    let LeadFormData = new FormData(LeadForm);
    fetch(url, {
      method: "POST",
      body: LeadFormData,
    })
      .then((res) => res.text())
      .then((finalRes) => {
        e.target.btn.innerHTML = "Submit";
        FormArea.style.display = "none";
        ThankMsg.style.display = "Block";
      });
    e.preventDefault();
  });
}
