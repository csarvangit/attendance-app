<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Spin Wheel App</title>
    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap"
      rel="stylesheet"
    />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <!-- Stylesheet -->   
    <style>
        * {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body {
  height: 100vh;
  background: #FFDE59;
  max-width: 400px;
    margin: 0 auto;
}
.wrapper {
  width: 90%;
  max-width: 400px; 
  background-color: #e91414; 
  padding: 3em;
  border-radius: 1em;
  box-shadow: 0;
  margin-top: 50px;
}
.container {
  position: relative;
  width: 100%;
}
.strech {    
    flex-direction: column;
    box-sizing: border-box;
    display: flex;
    place-content: stretch flex-start;
    align-items: stretch;
    max-width: 100%;}
    .logo {
        width: 100%;
        text-align: center;
        margin-top: 30px;
    }
    .logo img{
        max-width: 80%;
        margin: 0 auto;
    }
        </style>
  </head>
  <body>
    <div class="strech">
        <div class="logo">
            <img src="{{ asset('resources/images/logo-1.png') }}" />
        </div>
        <div class="logo">
            <img src="{{ asset('resources/images/spin-logo.png') }}" height="200px" />
        </div>
    </div>
    <div class="wrapper">
      <div class="container">
			<h2 class="text-white text-center">Thank You</h2>
      </div>      
    </div>
  </body>
</html>