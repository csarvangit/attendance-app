<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Spin Wheel App</title>
<style>
    @font-face { font-family: 'FontAwesome'; src: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.eot?#iefix') format('embedded-opentype'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.woff') format('woff'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.ttf') format('truetype'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.svg#FontAwesome') format('svg'); font-weight: normal; font-style: normal; }
    </style>
    </head>
    <body>
<div class="smart-wrap">
  <div class="smart-forms smart-container wrap-2">
    <div class="form-header header-primary">
      <h4><i class="fa fa-pencil-square"></i>Responsive Form</h4>
    </div><!-- end .form-header section -->
    <form method="post" id="new_post" name="new_post" action="" class="wpcf7-form" enctype="mu ltipart/form-data">
      <div class="form-body">
        <div class="spacer-b30">
          <div class="tagline"><span>Alta Clientes</span></div><!-- .tagline -->
        </div>
        <div class="frm-row">
          <div class="section colm colm6">
            <label for="firstname" class="field prepend-icon">
              <input type="text" name="_prospecto_nombre" id="firstname" class="gui-input" placeholder="Nombre">
              <label for="firstname" class="field-icon"><i class="fa fa-user"></i></label>
            </label>
          </div><!-- end section -->

          <div class="section colm colm6">
            <label for="lastname" class="field prepend-icon">
              <input type="text" name="_prospecto_apellido_paterno" id="lastname" class="gui-input" placeholder="Apellido Paterno">
              <label for="lastname" class="field-icon"><i class="fa fa-user"></i></label>
            </label>
          </div><!-- end section -->
          <div class="section colm colm6">
            <label for="lastname" class="field prepend-icon">
              <input type="text" name="lastname" id="lastname" class="gui-input" placeholder="Last name...">
              <label for="lastname" class="field-icon"><i class="fa fa-user"></i></label>
            </label>
          </div><!-- end section -->
        </div><!-- end .frm-row section -->

        <div class="section">
          <label for="useremail" class="field prepend-icon">
            <input type="email" name="useremail" id="useremail" class="gui-input" placeholder="Email address">
            <label for="useremail" class="field-icon"><i class="fa fa-envelope"></i></label>
          </label>
        </div><!-- end section -->

        <div class="section">
          <label for="website" class="field prepend-icon">
            <input type="url" name="website" id="website" class="gui-input" placeholder="Current website url">
            <label for="website" class="field-icon"><i class="fa fa-globe"></i></label>
          </label>
        </div><!-- end section -->

        <div class="section">
          <label class="field select">
            <select id="language" name="language">
              <option value="">Select language...</option>
              <option value="EN">English</option>
              <option value="FR">French</option>
              <option value="SP">Spanish</option>
              <option value="CH">Chinese</option>
              <option value="JP">Japanese</option>
            </select>
            <i class="arrow double"></i>
          </label>
        </div><!-- end section -->

        <div class="section">
          <label for="file1" class="field file">
            <span class="button btn-primary"> Choose File </span>
            <input type="file" class="gui-file" name="upload1" id="file1" onChange="document.getElementById('uploader1').value = this.value;">
            <input type="text" class="gui-input" id="uploader1" placeholder="no file selected" readonly>
          </label>
        </div><!-- end  section UPLOAD-->

        <div class="section">
          <label class="field select-multiple">
            <select name="mobileos" id="mobileos" multiple>
              <option value="0">Apple iOS </option>
              <option value="1">Windows Mobile </option>
              <option value="2">Google Android</option>
              <option value="3">Tizen mobile OS</option>
              <option value="5">Firefox OS</option>
              <option value="6">Blackberry OS</option>
              <option value="6">Symbian</option>
            </select>
          </label>
        </div><!-- end  section -->

        <div class="section">
          <label for="comment" class="field prepend-icon">
            <textarea class="gui-textarea" id="comment" name="comment" placeholder="Your comment"></textarea>
            <label for="comment" class="field-icon"><i class="fa fa-comments"></i></label>
            <span class="input-hint">
              <strong>DO NOT:</strong> Be negative or off topic, we expect a great comment...
            </span>
          </label>
        </div><!-- end section -->

        <div class="spacer-t40 spacer-b40">
          <div class="tagline"><span> Fill at least one </span></div><!-- .tagline -->
        </div>

        <div class="frm-row">

          <div class="section colm colm6">
            <label for="mobile_phone" class="field prepend-icon">
              <input type="tel" name="mobile_phone" id="mobile_phone" class="gui-input phone-group" placeholder="Mobile number">
              <label for="mobile_phone" class="field-icon"><i class="fa fa-mobile-phone"></i></label>
            </label>
          </div><!-- end section -->

          <div class="section colm colm6">
            <label for="home_phone" class="field prepend-icon">
              <input type="tel" name="home_phone" id="home_phone" class="gui-input phone-group" placeholder="Home number">
              <label for="home_phone" class="field-icon"><i class="fa fa-phone"></i></label>
            </label>
          </div><!-- end section -->

        </div><!-- end .frm-row section -->

        <div class="spacer-t20 spacer-b40">
          <div class="tagline"><span> Equal - Matching elements </span></div><!-- .tagline -->
        </div>

        <div class="section">
          <label for="password" class="field prepend-icon">
            <input type="password" name="password" id="password" class="gui-input" placeholder="Create a password">
            <label for="password" class="field-icon"><i class="fa fa-lock"></i></label>
          </label>
        </div><!-- end section -->

        <div class="section">
          <label for="repeatPassword" class="field prepend-icon">
            <input type="password" name="repeatPassword" id="repeatPassword" class="gui-input" placeholder="Repeat password">
            <label for="repeatPassword" class="field-icon"><i class="fa fa-unlock-alt"></i></label>
          </label>
        </div><!-- end section -->

        <div class="spacer-t40 spacer-b40">
          <div class="tagline"><span> Checkboxes + Radios Group </span></div><!-- .tagline -->
        </div>

        <div class="frm-row">

          <div class="section colm colm6 pad-r40 bdr">
            <div class="option-group field">
              <label for="female" class="option block">
                <input type="radio" name="gender" id="female" value="female">
                <span class="radio"></span> Female specie
              </label>

              <label for="male" class="option block spacer-t10">
                <input type="radio" name="gender" id="male" value="male">
                <span class="radio"></span> Male specie
              </label>

              <label for="other" class="option block spacer-t10">
                <input type="radio" name="gender" id="other" value="other">
                <span class="radio"></span> Other specie
              </label>

            </div>

          </div><!-- end .section section -->

          <div class="section colm colm6 pad-l40">
            <div class="option-group field">

              <label class="option block">
                <input type="checkbox" name="languages" value="FR">
                <span class="checkbox"></span> Fluent french
              </label>

              <label class="option block spacer-t10">
                <input type="checkbox" name="languages" value="EN">
                <span class="checkbox"></span> Fluent english
              </label>

              <label class="option block spacer-t10">
                <input type="checkbox" name="languages" value="CH">
                <span class="checkbox"></span> Fluent chinese
              </label>

            </div>
          </div><!-- end section -->

        </div> <!-- end .frm-row section -->

        <div class="spacer-t20 spacer-b30">
          <div class="tagline"><span> Custom Methods </span></div><!-- .tagline -->
        </div>

        <div class="section">
          <div class="smart-widget sm-left sml-120">
            <label for="verification" class="field prepend-icon">
              <input type="text" name="verification" id="verification" class="gui-input" placeholder="Solve verification">
              <label for="verification" class="field-icon"><i class="fa fa-shield"></i></label>
            </label>
            <label for="verification" class="button">15 + 4 = </label>
          </div><!-- end .smart-widget section -->
        </div><!-- end section -->

        <div class="spacer-t40 spacer-b30">
          <div class="tagline"><span> Conditional validation </span></div><!-- .tagline -->
        </div>

        <div class="section">
          <p class="small-text fine-grey"> 1 - The applicant age must be 16 years and above </p>
          <p class="small-text fine-grey"> 2 - For applicants above 19 years, a licence number will be required </p>
        </div><!-- end section -->

        <div class="frm-row">

          <div class="section colm colm6">
            <label for="applicant_age" class="field prepend-icon">
              <input type="text" name="applicant_age" id="applicant_age" class="gui-input" placeholder="Applicant age">
              <label for="applicant_age" class="field-icon"><i class="fa fa-male"></i></label>
            </label>
          </div><!-- end section -->

          <div class="section colm colm6">
            <label for="licence_no" class="field prepend-icon">
              <input type="text" name="licence_no" id="licence_no" class="gui-input" placeholder="Licence number">
              <label for="licence_no" class="field-icon"><i class="fa fa-credit-card"></i></label>
            </label>
          </div><!-- end section -->

        </div><!-- end .frm-row section -->

        <div class="spacer spacer-t10 spacer-b20"> </div>

        <div class="section">
          <p class="small-text fine-grey"> Child name will be required when you agree / tick / check that you are a parent </p>
        </div><!-- end section -->

        <div class="section">
          <div class="option-group field">

            <label class="option block">
              <input type="checkbox" name="parents" id="parents" value="parents">
              <span class="checkbox"></span> Yes i am a parent
            </label>

          </div><!-- end .option-group section -->
        </div><!-- end section -->

        <div class="section">
          <label for="child_name" class="field prepend-icon">
            <input type="text" name="child_name" id="child_name" class="gui-input" placeholder="Enter childs name">
            <label for="child_name" class="field-icon"><i class="fa fa-female"></i></label>
          </label>
        </div><!-- end section -->

      </div><!-- end .form-body section -->
      <div class="form-footer">
        <button type="submit" class="button btn-primary"> <a href="/spin">Submit</a> </button>
        <button type="reset" class="button"> Cancel </button>
      </div><!-- end .form-footer section -->
    </form>

  </div><!-- end .smart-forms section -->
</div><!-- end .smart-wrap section -->


</body>
</html>