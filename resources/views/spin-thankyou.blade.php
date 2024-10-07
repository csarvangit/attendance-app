<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Spin Wheel App - Thank You</title>
    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap"
      rel="stylesheet"
    />
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
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
        margin-top: 50px;
        margin: 0 auto;
      }
      .container {
        position: relative;
        width: 100%;
      }
      .strech {
        display: flex;
        flex-direction: column;
        place-content: stretch flex-start;
        align-items: stretch;
        max-width: 100%;
      }
      .logo {
        width: 100%;
        text-align: center;
        margin-top: 30px;
      }
      .logo img {
        max-width: 80%;
        margin: 0 auto;
      }
      h2 {
        margin-top: 20px;
        color: white;
        text-align: center;
      }
      .result-message {
        color: white;
        font-size: 1.5em;
        text-align: center;
        margin-top: 20px;
      }
      .result-image {
        display: block;
        margin: 20px auto;
        max-width: 100%;
      }
    </style>
  </head>
  <body>
    <div class="strech">
      <div class="logo">
        <img src="{{ asset('resources/images/logo-2.png') }}" />
      </div>
      <div class="logo">
        <img src="{{ asset('resources/images/spin-logo.png') }}" height="200px" />
      </div>
    </div>
    <div class="wrapper">
      <div class="container">
        <h2>Thank You</h2>
        <!-- Dynamic result message -->
        <div class="result-message" id="result-message">
          <!-- The result will be injected here -->
        </div>
        <!-- Dynamic result image -->
        <img id="result-image" class="result-image" src="" alt="Result Image" />
      </div>
    </div>

    <script>
      // Get the query parameters from the URL (e.g., ?result=20&image=discount-20.png)
      const urlParams = new URLSearchParams(window.location.search);
      const result = urlParams.get('result'); // Get the 'result' parameter
      const image = urlParams.get('image');   // Get the 'image' parameter

      // Update the result message dynamically
      const resultMessage = document.getElementById('result-message');
      resultMessage.innerHTML = `Congrats! You received a ${result}% discount!`;

      // Update the image source dynamically
      const resultImage = document.getElementById('result-image');
      resultImage.src = `{{ asset('resources/images/') }}/${image}`;

      // Example URL: http://yourdomain.com/thankyou?result=20&image=discount-20.png
    </script>
  </body>
</html>
