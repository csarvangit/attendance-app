<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Spin Wheel App</title>
    <link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/smart-forms.css" />
    <link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/font-awesome.min.css" />
<style>
    @font-face { font-family: 'FontAwesome'; src: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.eot?#iefix') format('embedded-opentype'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.woff') format('woff'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.ttf') format('truetype'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.svg#FontAwesome') format('svg'); font-weight: normal; font-style: normal; }
    .smart-forms .append-icon .field-icon, .smart-forms .prepend-icon .field-icon {
    top: 13px !important;
    }
    </style>
    </head>
    <body>
<div class="smart-wrap">
  <div class="smart-forms smart-container wrap-2">
    <div class="form-header header-primary">
      <h4 style="text-align: center;">Spin & Win</h4>
    </div><!-- end .form-header section -->
    <form method="post" id="new_post" name="new_post" action="" class="wpcf7-form" enctype="mu ltipart/form-data">
      <div class="form-body">
        <div class="spacer-b30">
            <div class="tagline"><span>Customer Details</span></div><!-- .tagline -->
        </div>
        <div class="frm-row">
          <div class="section colm colm12">
            <label for="firstname" class="field prepend-icon">
              <input type="text" name="_prospecto_nombre" id="firstname" class="gui-input" placeholder="Name">
              <label for="firstname" class="field-icon"><i class="fa fa-user"></i></label>
            </label>
          </div><!-- end section -->

        </div><!-- end .frm-row section -->

        <div class="section">
            <label for="useremail" class="field prepend-icon">
              <input type="email" name="useremail" id="useremail" class="gui-input" placeholder="Email address">
              <label for="useremail" class="field-icon"><i class="fa fa-envelope"></i></label>
            </label>
          </div><!-- end section -->
          <div class="section colm colm6">
            <label for="mobile_phone" class="field prepend-icon">
              <input type="tel" name="mobile_phone" id="mobile_phone" class="gui-input phone-group" placeholder="Mobile number">
              <label for="mobile_phone" class="field-icon"><i class="fa fa-mobile-phone"></i></label>
            </label>
          </div><!-- end section -->



        <div class="spacer-t40 spacer-b40">
          <div class="tagline"><span> ProductPurchased Details </span></div><!-- .tagline -->
        </div>

        <div class="section">
            <label class="field select">
              <select id="language" name="language">
                <option value="">Select branch...</option>
                <option value="EN">Alanganallur</option>
                <option value="FR">Valasai</option>
                <option value="SP">Iyerbagalow</option>
                <option value="CH">Palamedu</option>
              </select>
              <i class="arrow double"></i>
            </label>
          </div><!-- end section -->
  
          <div class="section">
            <label for="file1" class="field file">
              <span class="button btn-primary"> Choose invoice </span>
              <input type="file" class="gui-file" name="upload1" id="file1" onChange="document.getElementById('uploader1').value = this.value;">
              <input type="text" class="gui-input" id="uploader1" placeholder="No file selected" readonly>
            </label>
          </div><!-- end  section UPLOAD-->
  
          <div class="section colm colm6">
            <label for="licence_no" class="field prepend-icon">
              <input type="text" name="licence_no" id="licence_no" class="gui-input" placeholder="Invoice number">
              <label for="licence_no" class="field-icon"><i class="fa fa-credit-card"></i></label>
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