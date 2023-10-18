<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Spin Wheel App</title>
    <link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/smart-forms.css" />
    <link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    
    
<style>
    @font-face { font-family: 'FontAwesome'; src: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.eot?#iefix') format('embedded-opentype'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.woff') format('woff'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.ttf') format('truetype'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.svg#FontAwesome') format('svg'); font-weight: normal; font-style: normal; }
    .smart-forms .append-icon .field-icon, .smart-forms .prepend-icon .field-icon {
    top: 13px !important;
    }
    .help-block {
      margin-top: 5px;
    }
    </style>
    </head>
    <body>
<div class="smart-wrap">

@if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        @foreach($errors->all() as $error)
            {{ $error }} <br/>
        @endforeach
    </div>
@endif

@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ session()->get('success') }}
    </div>
@endif
  <div class="smart-forms smart-container wrap-2">

    <div class="form-header header-primary">
      <h4 style="text-align: center;">Spin & Win</h4>
    </div><!-- end .form-header section -->
    <form method="post" id="new_post" name="new_post" action="{{ route('saveInvoiceForm') }}" class="wpcf7-form" enctype="multipart/form-data">
      @csrf
      <div class="form-body">
        <div class="spacer-b30">
            <div class="tagline"><span>Customer Details</span></div><!-- .tagline -->
        </div>
        <div class="frm-row">
          <div class="section colm colm12 {{ $errors->has('username') ? 'has-error' : ''}}">
            <label for="username" class="field prepend-icon">
              <input type="text" name="username" id="username" class="gui-input form-control @error('username') is-invalid @enderror" placeholder="Name" value="{{ old('username') }}">
              <label for="username" class="field-icon"><i class="fa fa-user"></i></label>
            </label>
            {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
          </div><!-- end section -->

        </div><!-- end .frm-row section -->

        <div class="section {{ $errors->has('email') ? 'has-error' : ''}}">
            <label for="email" class="field prepend-icon">
              <input type="email" name="email" id="email" class="gui-input @error('email') is-invalid @enderror" placeholder="Email address" value="{{ old('email') }}">
              <label for="email" class="field-icon"><i class="fa fa-envelope"></i></label>
            </label>
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
          </div><!-- end section -->
          <div class="section colm colm6 {{ $errors->has('mobile') ? 'has-error' : ''}}">
            <label for="mobile" class="field prepend-icon">
              <input type="tel" name="mobile" id="mobile" class="gui-input phone-group @error('mobile') is-invalid @enderror" placeholder="Mobile number" value="{{ old('mobile') }}">
              <label for="mobile" class="field-icon"><i class="fa fa-mobile-phone"></i></label>
            </label>
            {!! $errors->first('mobile', '<p class="help-block">:message</p>') !!}
          </div><!-- end section -->



        <div class="spacer-t40 spacer-b40">
          <div class="tagline"><span> ProductPurchased Details </span></div><!-- .tagline -->
        </div>

        <div class="section {{ $errors->has('branch') ? 'has-error' : ''}}">
            <label class="field select">
              <select id="branch" name="branch" class="@error('branch') is-invalid @enderror">
                <option value="">Select branch...</option>
                <option value="Alanganallur">Alanganallur</option>
                <option value="Valasai">Valasai</option>
                <option value="Iyerbagalow">Iyerbagalow</option>
                <option value="Palamedu">Palamedu</option>
              </select>
              <i class="arrow double"></i>
            </label>
            {!! $errors->first('branch', '<p class="help-block">:message</p>') !!}
          </div><!-- end section -->
  
          <div class="section {{ $errors->has('invoice_copy') ? 'has-error' : ''}}">
            <label for="file1" class="field file">
              <span class="button btn-primary"> Choose invoice </span>
              <input type="file" class="gui-file @error('invoice_copy') is-invalid @enderror" name="invoice_copy" id="invoice_copy" onChange="document.getElementById('invoice_copy_name').value = this.value;">
              <input type="text" class="gui-input" id="invoice_copy_name" placeholder="No file selected" readonly>
            </label>
            {!! $errors->first('invoice_copy', '<p class="help-block">:message</p>') !!}
          </div><!-- end  section UPLOAD-->
  
          <div class="section colm colm6 {{ $errors->has('invoice_number') ? 'has-error' : ''}}">
            <label for="invoice_number" class="field prepend-icon">
              <input type="text" name="invoice_number" id="invoice_number" class="gui-input @error('invoice_number') is-invalid @enderror" placeholder="Invoice number" value="{{ old('invoice_number') }}">
              <label for="invoice_number" class="field-icon"><i class="fa fa-credit-card"></i></label>
            </label>
            {!! $errors->first('invoice_number', '<p class="help-block">:message</p>') !!}
          </div><!-- end section -->

      </div><!-- end .form-body section -->
      <div class="form-footer">
        <button type="submit" class="button btn-primary"> Submit </button>
        <button type="reset" class="button"> Cancel </button>
      </div><!-- end .form-footer section -->
    </form>

  </div><!-- end .smart-forms section -->
</div><!-- end .smart-wrap section -->


</body>
</html>