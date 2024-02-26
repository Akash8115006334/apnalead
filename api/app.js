function ApnaLeadEnquiryForm(AuthenticationKey) {
  const enquiryFormHTML = `
<style>
.apnalead_rounded {
  -o-border-radius: 1rem;
  -ms-border-radius: 1rem;
  -webkit-border-radius: 1rem;
  -moz-border-radius: 1rem;
  border-radius: 1rem !important;
} 
.apnalead_form-heading h2{
    font-size:2rem !important;
    text-align:center !important;
    margin-bottom:0 !important;
}
.apnalead_form-heading p{
   font-size:1.1rem !important;
    text-align:center !important;
}
.apnalead_enquiry-btn {
  border-radius: 1rem;
  color: white;
  text-decoration: none;
  font-size: 1.4rem !important;
  position: fixed;
  right: 0px;
  top: 35%;
  transform: rotate(180deg);
  cursor: pointer;
}
.apnalead_enquiry-btn img {
  width: 30%;
}
.apnalead_enquiry-btn:hover {
  color: white;
  text-decoration: underline;
}
#enquiry-form {
  position: fixed;
  width: 100%;
  top: 0px;
  right: 0px;
  background-color: #0000008f;
  height: 100%;
  overflow-y: scroll;
  z-index:9999;
}
#enquiry-form .apnalead_div {
  position:fixed;
  right:20px;
  min-width: 300px;
  max-width: 450px;
  background-color:white;
  background-image: repeating-linear-gradient(45deg, #5ca2d830, transparent 1px);
  border-radius: 1rem;
  padding: 1rem;
  margin: 2% auto;
}
#CloseEnquiryBtn{
  padding:.3rem !important;
  color:white !important;
  background-color:gray !important;
  border: none !important;
  border-radius:.2rem !important;
  cursor:pointer !important;
}
#submit-btn{
  padding:.3rem !important;
  color:white !important;
  background-color:green !important;
  border: none !important;
  border-radius:.2rem !important;
  cursor:pointer !important;
}
.apnalead_footer{
  
  text-align:center !important;
}
#GoToHome{
  padding:.3rem !important;
  color:white !important;
  background-color:sky-blue !important;
  border: none !important;
  border-radius:.2rem !important;
  cursor:pointer !important;
  text-decoration:none !important;
}
</style>
  <a id='EnquiryBtn' class="apnalead_enquiry-btn">
    <img src="https://www.pngkey.com/png/full/255-2555375_stg-travel-special-offers-quick-enquiry-vertical-button.png">
  </a>
  <section id='enquiry-form' style='display:block;'>
    <div class="apnalead_div">
      <div id='FormArea'>
        <form method="POST" id="LeadForm">
          <input type='text' hidden id='AuthKey' name='AuthenticationKey'>
          <div class="apnalead_form-heading " style='margin-bottom:0.5rem !important; margin-top:1rem !important;'>
            <h2>Have an eqnuiry?</h2>
            <p>Feel free to share your enquiry...</p>
          </div>
            <div class="" style='margin-bottom:1rem !important; width:90%;'>
              <label>Enter Full Name</label><br>
              <input type="text" name='FullName' required  placeholder='Name' style='width:100% !important; margin-top:.1rem !important; padding:.3rem !important;'>
            </div>
            <div class="" style='margin-bottom:1rem !important; width:90%;'>
              <label>Enter Phone Number</label><br>
              <input type="text" minlength="10" maxlength="12" name='PhoneNumber' required  placeholder="without +91" style='width:100% !important; margin-top:.1rem !important; padding:.3rem !important;'>
            </div>
        
          <div class="" style='margin-bottom:1rem !important;  width:90%;'>
            <label>Enter Email-Id</label><br>
            <input type="email" name='EmailId' placeholder='Email' required  style='width:100% !important; margin-top:.1rem !important; padding:.3rem !important;'>
          </div>
          <div class="" style='margin-bottom:1rem !important; width:95%;'>
            <label>Requirement For</label><br>
            <select name='Requirement' required='' id='ProjectList'  style='width:100% !important; margin-top:.1rem !important; padding:.3rem !important;'>
            </select>
          </div>
        
          <div class="" style='margin-bottom:1rem !important; width:100% !important;'>
            <label>Enter Query Details</label><br>
            <textarea  required rows="3" name="Message" placeholder='Message'  style='width:95% !important; margin-top:.1rem !important; padding:.3rem !important;'></textarea>
          </div>
          <div class="form-group" style='display:flex !important;justify-content:end !important;align-items:center !important;'>
            <button name="btn" class="" id="submit-btn" style='margin:0.5rem;'>Save Details</button>
            <a id='CloseEnquiryBtn' type='button'>Cancel</a>
          </div>
        </form>
        <hr>
         <div class="apnalead_footer" style="margin:auto !important;">
           <p style="color:gray; font-size:0.8rem !important">Powered By : <a href="https://apnalead.com/" target="_blank" style="text-decoration:none;"> <img src="https://apnalead.com/assets/img/logo.png" alt="apnalead logo" style="width:15% !important;"></a></p>
         </div>
      </div>
      <div id='ThankMsg' style='display:none;'>
        <div class="" style='text-align:center !important;'>
          <h1 style='color:green !important;'>Thanking you!</h1>
          <p style='margin-bottom:1rem !important;'>We have received your enquiry and will contact you as soon as possible.</p>
          <a href="" id="GoToHome" style='text-align:center !important; background-color:blue !important; color:white !important; border:none !important;'>Back to Home</a>
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
  fetch("https://app.apnalead.com/api/GenerateProjectResponse.php?GetProjectOptions=true&ProjectFroAuthenticationKey=" + AuthenticationKey)
    .then(response => response.text())
    .then(function (response) {
      // Handle the response
      document.getElementById("ProjectList").innerHTML = response;
    })
    .catch(function (error) {
      // Handle errors
      document.getElementById("ProjectList").innerHTML = "<option value='0'>No Project Found</option>";
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
    var EnquiryForm = document.getElementById("enquiry-form");
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
      var EnquiryForm = document.getElementById("enquiry-form");
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

