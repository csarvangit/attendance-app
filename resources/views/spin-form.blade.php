<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Spin Wheel App</title>
    <link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/smart-forms.css" />
    <link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    
    
<style>
    @font-face { font-family: 'FontAwesome'; src: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.eot?#iefix') format('embedded-opentype'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.woff') format('woff'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.ttf') format('truetype'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/172203/fontawesome-webfontba72.svg#FontAwesome') format('svg'); font-weight: normal; font-style: normal; }
    .smart-forms .append-icon .field-icon, .smart-forms .prepend-icon .field-icon {
    top: 13px !important;
    }
    .help-block {
      margin-top: 5px;
    }
    .spin-logo-div {
	width: 100%;
	text-align: center;
}
.spin-logo {
	margin: 0 auto;
}
.smart-container {
    margin: 0px auto;
    box-shadow: none;
    background: transparent;
}
.smart-forms .form-body {
    padding: 0px 30px;
    padding-bottom: 0px;
}
.smart-forms .form-footer {
    background: none;
    padding: 0px 25px;
    padding-top: 10px;
}
.smart-forms .tagline span {
    color: #000;
}
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #111;
  overflow: hidden;
}

.diwali-background {
  position: relative;
  width: 100%;
  height: 100%;
  background: linear-gradient(180deg, #111, #222);
}

/* Fireworks */
.firework {
  position: absolute;
  width: 4px;
  height: 4px;
  background-color: #ffcc00;
  border-radius: 50%;
  animation: explode 3s ease-in-out infinite;
  box-shadow: 0 0 10px #ffcc00, 0 0 20px #ffcc00, 0 0 40px #ff6600;
}

.firework1 {
  top: 20%;
  left: 30%;
}

.firework2 {
  top: 50%;
  left: 70%;
}

.firework3 {
  top: 80%;
  left: 50%;
}

.firework4 {
  top: 40%;
  left: 60%;
  animation-delay: 1s;
}

@keyframes explode {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(4);
    opacity: 0.5;
  }
  100% {
    transform: scale(0);
    opacity: 0;
  }
}

/* Sparkles */
.sparkles::before, .sparkles::after {
  content: '';
  position: absolute;
  width: 2px;
  height: 2px;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
  border-radius: 50%;
  animation: sparkle 2s linear infinite;
}

.sparkles::before {
  top: 20%;
  left: 40%;
}

.sparkles::after {
  top: 60%;
  left: 80%;
}

@keyframes sparkle {
  0%, 100% {
    opacity: 0;
    transform: scale(0);
  }
  50% {
    opacity: 1;
    transform: scale(1.5);
  }
}

/* Floating Diyas */
.floating-diya-container {
  position: absolute;
  bottom: 10%;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 50px;
}

.floating-diya {
  width: 20px;
  height: 20px;
  background-color: #ff6600;
  border-radius: 50%;
  animation: float-diya 5s ease-in-out infinite;
  box-shadow: 0 0 20px rgba(255, 102, 0, 0.7), 0 0 40px rgba(255, 165, 0, 0.9);
}

@keyframes float-diya {
  0% {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
  50% {
    transform: translateY(-100px) scale(1.2);
    opacity: 0.8;
  }
  100% {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
}

/* Diya Lights */
.diya-container {
  position: absolute;
  bottom: 5%;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 20px;
}

.diya {
  width: 30px;
  height: 30px;
  background-color: #ff6600;
  border-radius: 50%;
  animation: flicker 1s infinite alternate;
  box-shadow: 0 0 20px rgba(255, 102, 0, 0.7), 0 0 40px rgba(255, 165, 0, 0.9);
}

@keyframes flicker {
  0% {
    opacity: 1;
    transform: scale(1);
  }
  50% {
    opacity: 0.8;
    transform: scale(1.2);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

    </style>
    </head>
    <body>
    <div class="diwali-background">
    <div class="firework firework1"></div>
    <div class="firework firework2"></div>
    <div class="firework firework3"></div>
    <div class="firework firework4"></div>
    <div class="sparkles"></div>
    <div class="floating-diya-container">
      <div class="floating-diya"></div>
      <div class="floating-diya"></div>
      <div class="floating-diya"></div>
    </div>
    <div class="diya-container">
      <div class="diya"></div>
      <div class="diya"></div>
      <div class="diya"></div>
    </div>
<div class="pt-3">
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

    <div class="spin-logo-div">
      <!-- <h4 style="text-align: center;">Spin & Win</h4> -->
      <img class="spin-logo" src="{{ asset('resources/images/spin-logo.png') }}" height="200" alt="spinner arrow" />

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

        <!--<div class="section {{ $errors->has('email') ? 'has-error' : ''}}">
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
                <option value="Iyerbungalow">Iyer Bungalow</option>
                <option value="Palamedu">Palamedu</option>
              </select>
              <i class="arrow double"></i>
            </label>
            {!! $errors->first('branch', '<p class="help-block">:message</p>') !!}
          </div><!-- end section -->
  
          <!--<div class="section {{ $errors->has('invoice_copy') ? 'has-error' : ''}}">
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

</div>

</body>
</html>