<html>
  <head>
    <meta charset="UTF-8">
    <title>Evergreen Form</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kulim+Park:ital,wght@0,200;0,300;0,400;0,600;0,700;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <style>
      /* General */
      * {
        font-family: "Inter";
        color: #003631;
      }

      body {
        margin: 40px;
        background-image: url(contents/bg-image.png);
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
      }

      h1, h2, h3, h4, h5, h6, p {
        margin: 0;
      }

      /* NAVIGATION BAR */
      nav {
        display: flex;
        gap: 5px;
        margin: 20px;
      }

      .logo {
        width: 45px;
        height: 45px;
        align-self: center;
      }

      #title-page, .motto {
        font-family: "Kulim Park";
      }

      #title-page {
        font-size: 20px;
      }

      .motto {
        font-size: 15px;
      }

      /* FORM - General */
      main {
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .main-form-body {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.5);
        padding: 60 40;
        width: 70%;
        display: flex;
        flex-direction: column;
        gap: 25px;
      }

      /* FORM - Uppermost */

      .uppermost-form {
        text-align: center;
        display: flex;
        flex-direction: column;
        gap: 10px;
      }

      .form-sub-text {
        color: #3A3A3A;
        font-size: 15px;
      }

      /* FORM - progress line */
      .upper-form {
        display: flex;
      }

      .wrap {
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 15px;
      }

      .form-part {
        /* background-color: #003631; for progress track */
        color: white;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 20px;
      }

      .form-part-label {
        font-size: 10px;
      }

      #form-part-I {
        background-color: #003631;
      }

      .form-line {
        /* background-color: #003631; for progress track */
        width: 80%;
        height: 2px;
        align-self: center;
        margin: 0 20px;
      }

      /* FORM - Personal Info Panel */
      .personal-info-panel {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-template-areas:
        "upper upper"
        "lower lower"
        "date date"
        "street street"
        "city city";
        gap: 15px;
        flex-direction: column;
      }

      .upper-input-wrap, .lower-input-wrap, .city-input-wrap{
        display: flex;
        gap: 20px;
      }

      .input-wrap {
        width: 100%;
      }

      .upper-input-wrap {
        grid-area: upper;
      }

      .lower-input-wrap {
        grid-area: lower;
      }

      .date-input-wrap {
        grid-area: date;
     }

     .street-input-wrap {
        grid-area: street;
      }

      .city-input-wrap {
        grid-area: city;
      }

      .inp-credentials {
        width: 100%;
        height: 35px;
        border: 1px solid #C4C4C4;
        border-radius: 5px;
        padding: 5px 10px;
        font-size: 14px;
      }

      /* Verification section (Identity & Employment) */
      .verification-part {
        display: flex;
        flex-direction: column;
        gap: 18px;
        padding-top: 18px;
        border-top: 1px solid #E6E6E6;
      }

      .verification-part .section-title {
        color: #003631;
        font-size: 16px;
        margin: 6px 0 0 0;
        font-weight: 600;
      }

      .ssn-wrap {
        display: flex;
        flex-direction: column;
        gap: 15px;
      }

      .helper-text {
        font-size: 12px;
        color: #8C8C8C;
      }

      .two-col-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        align-items: center;
      }

      .full-width {
        width: 100%;
      }

      .emp-wrap {
        display: flex;
        flex-direction: column;
        gap: 15px;
      }

      /* FORM - Button */
      .btn-container {
        display: flex;
        justify-content: flex-start;
      }

      .button-action {
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
      }

      #button-next {
        background-color: #003631;
        color: white;
      }

      #button-prev {
        background-color: #E6E6E6;
        color: #003631;
      }

      /* REVIEW / Account Preferences */
      .review-part {
        display: flex;
        flex-direction: column;
        gap: 18px;
        padding-top: 18px;
        border-top: 1px solid #E6E6E6;
      }

      .account-type-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
      }

      .acct-card {
        border: 1px solid #E6E6E6;
        border-radius: 8px;
        padding: 14px;
        background: #FFFFFF;
        cursor: pointer;
        text-align: left;
        transition: 0.2s;
      }

      .acct-card h4 {
        margin: 0 0 6px 0;
        font-size: 14px;
      }

      .acct-card p {
        margin: 0;
        font-size: 12px;
        color: #8C8C8C;
      }

      /* if an acct-card is selected (FOR JAVASCRIPT) */
      .selected {
        background-color: #003631;
        color: white;
        border-color: #003631;
        transition: 0.2s;
      }

      .selected h4 {
        color: white;
      }

      .services-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        align-items: start;
      }

      .terms-box {
        border: 1px solid #E6E6E6;
        border-radius: 6px;
        padding: 12px;
        background: #FBFBFB;
      }

      /* Error Text */
      .error-text {
        color: #D43F3A;
        font-size: 13px;
        margin-top: 6px;
        display: none; /* hidden until validation triggers */
      }

      .field-error {
        color: #D43F3A;
        font-size: 12px;
        margin-top: 6px;
        display: none;
      }

      .input-error {
        border-color: #D43F3A;
      }

      /* Review Modal */
      .modal-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .details-review {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        width: 50%;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        flex-direction: column;
      }

      .details-contains {
        display: flex;
        gap: 40px;
        padding: 20px;
      }

      .content-group {
        display: flex;
        gap: 15px;
      }

      .left, .right {
        display: flex;
        flex-direction: column;
        gap: 20px;
      }

      .btn-container {
        display: flex;
        justify-content: space-between;
      }

      #ok {
        background-color: #003631;
        color: white;
        padding: 10px;
        border-radius: 15px;
        width: 80px;
        border: none;
      }

      #cancel {
        color: black;
        padding: 10px;
        border-radius: 15px;
        width: 80px;
        border: none;
      }

      /* Success modal */
      .successful-modal {
        background-color: white;
        border-radius: 10px;
        padding: 30px;
        width: 40%;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        gap: 15px;
      }

      .s-wrap {
        display: flex;
        flex-direction: column;
        gap: 6px;
        align-items: center;
      }

      #confirm-btn {
        background-color: #003631;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
      }

    </style>
  </head>
  <body>
    <nav>
      <img src="contents/evrgrn-logo.png" alt="logo" class="logo">
      <div class="wrap-nav">
        <h1 id="title-page">Evergreen</h1>
        <P class="motto">Secure, Invest, Achieve</P>
      </div>
    </nav>

    <!-- main body -->
    <main>
      <div class="main-form-body">
        <!-- form title -->
        <div class="uppermost-form">
          <h2 class="form-title">Account Application</h2>
          <p class="form-sub-text">Complete this application to open your Evergreen Bank account</p>
        </div>
        <!-- form progress -->
        <!-- make it like a breadcrumb logic --> 
        <!-- the form part 2 & 3 should be grey at first -->
        <div class="upper-form">
          <div class="wrap">
            <h4 class="form-part" id="form-part-I">1</h4>
            <p class="form-part-label" id="label-I">Personal Info</p>
          </div>
          <hr class="form-line" id="line-I">
          <div class="wrap">
            <h4 class="form-part" id="form-part-II">2</h4>
            <p class="form-part-label" id="label-II">Verification</p>
          </div>
          <hr class="form-line" id="line-II">
          <div class="wrap">
            <h4 class="form-part" id="form-part-III">3</h4>
            <p class="form-part-label" id="label-III">Review</p>
          </div>
        </div>

        <!-- this will be the replaceable panel -->
        <div class="fillup-change">
          
          <!-- Personal info part -->
          <div class="personal-info-panel">
            <div class="upper-input-wrap">
              <div class="input-wrap">
                <label for="f-name">First Name<span style="color: red;">*</span></label>
                <input type="text" class="inp-credentials" id="f-name">
              </div>
              <div class="input-wrap">
                <label for="l-name">Last Name<span style="color: red;">*</span></label>
                <input type="text" class="inp-credentials" id="l-name">
              </div>
            </div>

            <div class="lower-input-wrap">
              <div class="input-wrap">
                <label for="e-mail">Email Address<span style="color: red;">*</span></label>
                <input type="email" class="inp-credentials" id="e-mail">
              </div>
              <div class="input-wrap">
                <label for="phone-number">Phone Number<span style="color: red;">*</span></label>
                <input type="tel" class="inp-credentials" id="phone-number" placeholder="(123) 456-7890">
            </div>
          </div>

          <div class="date-input-wrap">
              <div class="input-wrap">
                <label for="date-of-birth">Date of Birth<span style="color: red;">*</span></label>
                <input type="date" class="inp-credentials" id="date-of-birth">
              </div>
            </div>

            <div class="street-input-wrap">
              <div class="input-wrap">
                <label for="street-address">Street Address<span style="color: red;">*</span></label>
                <input type="text" class="inp-credentials" id="street-address">
              </div>
            </div>

            <div class="city-input-wrap">
              <div class="input-wrap">
                <label for="city">City<span style="color: red;">*</span></label>
                <input type="text" class="inp-credentials" id="city">
              </div>
              <div class="input-wrap">
                <label for="state">State<span style="color: red;">*</span></label>
                <input type="text" class="inp-credentials" id="state">
              </div>
              <div class="input-wrap">
                <label for="zip-code">Zip Code<span style="color: red;">*</span></label>
                <input type="text" class="inp-credentials" id="zip-code">
              </div>
            </div>
          </div>
          <!-- Verification Part -->
           <div class="verification-part" style="display: none;">
             <div class="ssn-wrap">
               <h3 class="section-title">Identity Verification</h3>
               <div>
                 <label for="ssn">Social Security Number<span style="color: red;">*</span></label>
                 <input type="text" id="ssn" class="inp-credentials full-width" placeholder="123-45-6789">
               </div>
               <div class="helper-text">Your SSN is securely encrypted and never shared with third parties.</div>
             </div>

             <div class="two-col-row">
               <div>
                 <label for="id-type">ID Type<span style="color: red;">*</span></label>
                 <select id="id-type" class="inp-credentials">
                   <option>Driver's License</option>
                   <option>Passport</option>
                   <option>State ID</option>
                 </select>
               </div>
               <div>
                 <label for="id-number">ID Number<span style="color: red;">*</span></label>
                 <input type="text" id="id-number" class="inp-credentials">
               </div>
             </div>

             <div class="emp-wrap">
               <h3 class="section-title">Employment Information</h3>
               <div>
                 <label for="employment-status">Employment Status<span style="color: red;">*</span></label>
                 <select id="employment-status" class="inp-credentials full-width">
                   <option>Employed</option>
                   <option>Unemployed</option>
                   <option>Self-Employed</option>
                   <option>Student</option>
                   <option>Retired</option>
                 </select>
               </div>
             </div>

             <div class="two-col-row">
               <div>
                 <label for="employer-name">Employer Name<span style="color: red;">*</span></label>
                 <input type="text" id="employer-name" class="inp-credentials">
               </div>
               <div>
                 <label for="job-title">Job Title<span style="color: red;">*</span></label>
                 <input type="text" id="job-title" class="inp-credentials">
               </div>
             </div>

             <div>
               <label for="annual-income">Annual Income (USD)<span style="color: red;">*</span></label>
               <input type="text" id="annual-income" class="inp-credentials full-width" placeholder="50000">
             </div>
           </div>
           <!-- Review Part -->
            <div class="review-part" style="display: none;">
              <h3 class="section-title">Account Preferences</h3>

              <div class="account-type-cards">
                <div class="acct-card" id="acct-checking">
                  <h4>Checking</h4>
                  <p>Everyday banking</p>
                </div>
                <div class="acct-card" id="acct-savings">
                  <h4>Savings</h4>
                  <p>Earn interest</p>
                </div>
                <div class="acct-card" id="acct-both">
                  <h4>Both</h4>
                  <p>Complete package</p>
                </div>
              </div>

              <div>
                <p style="margin:8px 0 6px 0; font-size:13px; color:#003631;">Additional Services (Optional)</p>
                <div class="services-grid">
                  <label><input type="checkbox" value="debit"> Debit Card</label>
                  <label><input type="checkbox" value="online"> Online Banking</label>
                  <label><input type="checkbox" value="mobile">Mobile Banking</label>
                  <label><input type="checkbox" value="overdraft"> Overdraft Protection</label>
                </div>
              </div>

              <div>
                <h3 class="section-title">Terms and Agreements</h3>
                <div class="terms-box">
                  <label style="display:flex; gap:8px; align-items:flex-start;"><input type="checkbox" value="I agree" id="term-tnc"> I agree to the <strong>Terms and Conditions</strong> of Evergreen Bank.</label>
                  <p style="color: red;" id="error-tnc">agree to terms and condition</p>
                  <label style="display:flex; gap:8px; align-items:flex-start; margin-top:8px;"><input type="checkbox" id="term-privacy" value="I acknowledge"> I acknowledge that I have received and read the <strong>Privacy Policy</strong>.</label>
                  <p style="color: red;" id="error-privacy">agree to privacy</p>
                  <label style="display:flex; gap:8px; align-items:flex-start; margin-top:8px;"><input type="checkbox" value="consent"> I consent to receive marketing communications from Evergreen Bank about products and services that may interest me.</label>
                </div>
              </div>
            </div>

        </div>
          <div class="btn-container">
            <button class="button-action" id="button-prev" style="display: none;">Previous</button>
            <button class="button-action" id="button-next">Next</button>
          </div>
      </div>
    </main>

    <!-- Review Modal -->
    <div class="modal-container" style="display: none;">
      <div class="details-review">
        <h2 class="confirm-title">Please confirm the details below</h2>
        <div class="details-contains">
          <div class="left">
            <div class="content-wrap">
              <label for="rev-f-name">First Name</label>
              <h4 class="rev-f-name">None</h4>          <!-- Content will be dynamically injected here -->
            </div>
            <div class="content-wrap">
              <label for="rev-l-name">Last Name</label>
              <h4 class="rev-l-name">None</h4>           <!-- Content will be dynamically injected here -->
            </div>
            <div class="content-wrap">
              <label for="rev-birth">Birthday</label>
              <h4 class="rev-birth">0/00/0000</h4>           <!-- Content will be dynamically injected here -->
            </div>
            <div class="content-wrap">
              <label for="rev-street">Street Address</label>
              <h4 class="rev-street">None</h4>           <!-- Content will be dynamically injected here -->
            </div>

            <div class="content-group">
              <div class="content-wrap">
                <label for="rev-city">City</label>
                <h4 class="rev-street">None</h4>           <!-- Content will be dynamically injected here -->
              </div>
              <div class="content-wrap">
                <label for="rev-state">State</label>
                <h4 class="rev-state">None</h4>           <!-- Content will be dynamically injected here -->
              </div>
              <div class="content-wrap">
                <label for="rev-zip">Zip Code</label>
                <h4 class="rev-street">None</h4>           <!-- Content will be dynamically injected here -->
              </div>
          </div>       
          </div>
          <div class="right">
          <div class="content-wrap">
            <label for="rev-ssn">Social Security Number</label>
            <h4 class="rev-ssn">000-00-0000</h4>           <!-- Content will be dynamically injected here -->
          </div>
          <div class="content-wrap">
            <label for="rev-id-type">ID Type</label>
            <h4 class="rev-id-type">None</h4>           <!-- Content will be dynamically injected here -->
          </div>
          <div class="content-wrap">
            <label for="rev-id-number">ID Number</label>
            <h4 class="rev-id-number">0000</h4>           <!-- Content will be dynamically injected here -->
          </div>
          <div class="content-wrap">
            <label for="rev-employment-status">Employment Status</label>
            <h4 class="rev-employment-status">None</h4> <!-- Content will be dynamically injected here -->
          </div>
          <div class="content-wrap">
            <label for="rev-employer-name">Employer Name</label>
            <h4 class="rev-employer-name">None</h4><!-- Content will be dynamically injected here -->
          </div>
          <div class="content-wrap">
            <label for="rev-job-title">Job Title</label>
            <h4 class="rev-job-title">None</h4>  <!-- Content will be dynamically injected here -->
          </div>
          <div class="content-wrap">
            <label for="rev-annual-income">Annual Income</label>
            <h4 class="rev-annual-income">$00,000</h4> <!-- Content will be dynamically injected here -->
        </div>
      
          </div>
        </div>
        <div class="btn-container">
          <button id="cancel" class="action-button">Cancel</button>
          <button id="ok" class="action-button">Ok</button>
        </div>
      </div>
    </div>

    <!-- Successful Modal -->
     <div class="modal-container" id="success-modal=container" style="display: none;">
      <div class="successful-modal">
        <img src="contents/circle-check-filled.png" alt="success" class="check">
        <h2 class="head-text">Success!</h2>
        <h3 class="sub-text">Your application has been successfully submitted.</h3>
        <div class="s-wrap">
          <p class="grey-text" id="ref-id">0000</p><!-- make this dynamic/random -->
          <p class="grey-text" id="date-submitted">0/00/0000</p>
        </div>
        <button class="action-button" id="confirm-btn">CONFIRM</button>
      </div>
     </div>
  </body>
    <script>
    // panels
    let personalInfoPanel = document.querySelector(".personal-info-panel");
    let verificationPanel = document.querySelector(".verification-part");
    let reviewPanel = document.querySelector(".review-part");

    // buttons
    let prevBtn = document.getElementById("button-prev");
    let nextBtn = document.getElementById("button-next");

    // progress elements
    let formPartI = document.getElementById("form-part-I");
    let formPartII = document.getElementById("form-part-II");
    let formPartIII = document.getElementById("form-part-III");
    let lineI = document.getElementById("line-I");
    let lineII = document.getElementById("line-II");

    // modal elements
    let modalContainer = document.querySelector(".modal-container");
    let okBtn = document.getElementById("ok");
    let cancelBtn = document.getElementById("cancel");
    let successModal = document.getElementById("success-modal=container");
    let confirmBtn = document.getElementById("confirm-btn");

    // state
    let infoData = [];
    let step = 1;
    let acctType = null;

    // helper: show/hide field errors
    function showFieldError(inputEl, message) {
      inputEl.classList.add('input-error');
      let next = inputEl.nextElementSibling;
      if (!next || !next.classList || !next.classList.contains('field-error')) {
        let err = document.createElement('div');
        err.className = 'field-error';
        err.textContent = message;
        inputEl.insertAdjacentElement('afterend', err);
        err.style.display = 'block';
      } else {
        next.textContent = message;
        next.style.display = 'block';
      }
    }

    function clearFieldError(inputEl) {
      inputEl.classList.remove('input-error');
      let next = inputEl.nextElementSibling;
      if (next && next.classList && next.classList.contains('field-error')) {
        next.style.display = 'none';
      }
    }

    // Basic validators
    function isNotEmpty(val) { return val !== null && String(val).trim() !== ''; }
    function isEmail(val) { return /^\S+@\S+\.\S+$/.test(val); }
    function isNumeric(val) { return /^\d+(?:\.\d+)?$/.test(String(val).trim()); }
    function isSSN(val) { return /^(\d{3}-?\d{2}-?\d{4})$/.test(String(val).trim()); }

    // Per-step validation
    function validatePersonal() {
      let valid = true;
      const required = ['f-name','l-name','e-mail','phone-number','date-of-birth','street-address','city','state','zip-code'];
      required.forEach(id => {
        const el = document.getElementById(id);
        if (!isNotEmpty(el.value)) {
          showFieldError(el, 'This field is required');
          valid = false;
        } else {
          clearFieldError(el);
        }
      });

      const emailEl = document.getElementById('e-mail');
      if (isNotEmpty(emailEl.value) && !isEmail(emailEl.value)) {
        showFieldError(emailEl, 'Enter a valid email address');
        valid = false;
      }

      return valid;
    }

    function validateVerification() {
      let valid = true;
      const ssnEl = document.getElementById('ssn');
      if (!isNotEmpty(ssnEl.value) || !isSSN(ssnEl.value)) {
        showFieldError(ssnEl, 'Enter a valid SSN (e.g. 123-45-6789)');
        valid = false;
      } else { clearFieldError(ssnEl); }

      const idNum = document.getElementById('id-number');
      if (!isNotEmpty(idNum.value)) { showFieldError(idNum, 'ID number required'); valid = false; } else { clearFieldError(idNum); }

      const employer = document.getElementById('employer-name');
      const job = document.getElementById('job-title');
      const income = document.getElementById('annual-income');
      const employment = document.getElementById('employment-status');

      if (!isNotEmpty(employment.value)) { showFieldError(employment, 'Select employment status'); valid = false; } else { clearFieldError(employment); }
      if (!isNotEmpty(employer.value)) { showFieldError(employer, 'Employer is required'); valid = false; } else { clearFieldError(employer); }
      if (!isNotEmpty(job.value)) { showFieldError(job, 'Job title required'); valid = false; } else { clearFieldError(job); }
      if (!isNotEmpty(income.value) || !isNumeric(income.value)) { showFieldError(income, 'Enter numeric income'); valid = false; } else { clearFieldError(income); }

      return valid;
    }

    function validateReview() {
      let valid = true;
      const tnc = document.getElementById('term-tnc');
      const privacy = document.getElementById('term-privacy');
      const errTnc = document.getElementById('error-tnc');
      const errPrivacy = document.getElementById('error-privacy');

      if (!tnc.checked) { errTnc.style.display = 'block'; valid = false; } else { errTnc.style.display = 'none'; }
      if (!privacy.checked) { errPrivacy.style.display = 'block'; valid = false; } else { errPrivacy.style.display = 'none'; }

      return valid;
    }

    // account type selection (toggle single selection)
    document.querySelector('.account-type-cards').addEventListener('click', function(e) {
      let card = e.target.closest('.acct-card');
      if (!card) return;
      document.querySelectorAll('.acct-card').forEach(c => c.classList.remove('selected'));
      card.classList.add('selected');
      acctType = card.id; // store selected id
    });

    // Next/Prev handlers with validation
    prevBtn.addEventListener('click', function() {
      if (step > 1) step--;
      updateStepUI();
    });

    nextBtn.addEventListener('click', function(e) {
      e.preventDefault();
      if (step === 1) {
        if (!validatePersonal()) return;
        step++;
        updateStepUI();
        return;
      }
      if (step === 2) {
        if (!validateVerification()) return;
        step++;
        updateStepUI();
        return;
      }
      if (step === 3) {
        if (!validateReview()) return;
        // All good — gather data and show review modal
        let injector = {
          firstName: document.getElementById('f-name').value,
          lastName: document.getElementById('l-name').value,
          email: document.getElementById('e-mail').value,
          phoneNumber: document.getElementById('phone-number').value,
          dateOfBirth: document.getElementById('date-of-birth').value,
          streetAddress: document.getElementById('street-address').value,
          city: document.getElementById('city').value,
          state: document.getElementById('state').value,
          zipCode: document.getElementById('zip-code').value,
          socialSecurityNumber: document.getElementById('ssn').value,
          idType: document.getElementById('id-type').value,
          idNumber: document.getElementById('id-number').value,
          employmentStatus: document.getElementById('employment-status').value,
          employerName: document.getElementById('employer-name').value,
          jobTitle: document.getElementById('job-title').value,
          annualIncome: document.getElementById('annual-income').value,
          accountType: acctType,
        };
        infoData = [injector];
        // populate review modal
        displayCred('rev-f-name', injector.firstName);
        displayCred('rev-l-name', injector.lastName);
        displayCred('rev-birth', injector.dateOfBirth);
        displayCred('rev-street', injector.streetAddress);
        displayCred('rev-city', injector.city);
        displayCred('rev-state', injector.state);
        displayCred('rev-zip', injector.zipCode);
        displayCred('rev-ssn', injector.socialSecurityNumber);
        displayCred('rev-id-type', injector.idType);
        displayCred('rev-id-number', injector.idNumber);
        displayCred('rev-employment-status', injector.employmentStatus);
        displayCred('rev-employer-name', injector.employerName);
        displayCred('rev-job-title', injector.jobTitle);
        displayCred('rev-annual-income', '$' + injector.annualIncome);

        modalContainer.style.display = 'flex';
      }
    });

    okBtn.addEventListener('click', function() {
      modalContainer.style.display = 'none';
      successModal.style.display = 'flex';
    });

    cancelBtn.addEventListener('click', function() { modalContainer.style.display = 'none'; });

    confirmBtn.addEventListener('click', function() { successModal.style.display = 'none'; location.reload(); });

    // display a ref id and date submitted dynamically (Success modal)
    let refId = Math.floor(1000 + Math.random() * 9000);
    document.getElementById('ref-id').textContent = 'Reference ID: ' + refId;
    let currentDate = new Date();
    let formattedDate = (currentDate.getMonth() + 1) + '/' + currentDate.getDate() + '/' + currentDate.getFullYear();
    document.getElementById('date-submitted').textContent = 'Date Submitted: ' + formattedDate;

    // display credentials in review modal
    function displayCred(name, value) {
      let elements = document.getElementsByClassName(name);
      for (let i = 0; i < elements.length; i++) { elements[i].textContent = value; }
    }

    function updateStepUI() {
      personalInfoPanel.style.display = (step === 1) ? 'flex' : 'none';
      verificationPanel.style.display = (step === 2) ? 'flex' : 'none';
      reviewPanel.style.display = (step === 3) ? 'flex' : 'none';
      prevBtn.style.display = (step === 2 || step === 3) ? 'flex' : 'none';
      nextBtn.textContent = (step === 3) ? 'Submit' : 'Next';
      // progress
      formPartI.style.backgroundColor = (step >= 1) ? '#003631' : 'white';
      formPartII.style.backgroundColor = (step >= 2) ? '#003631' : 'white';
      lineI.style.backgroundColor = (step >= 2) ? '#003631' : 'white';
      lineII.style.backgroundColor = (step >= 3) ? '#003631' : 'white';
      formPartIII.style.backgroundColor = (step >= 3) ? '#003631' : 'white';
    }

    // initialize UI
    updateStepUI();

  </script>
</html>