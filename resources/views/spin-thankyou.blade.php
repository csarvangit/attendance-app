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
    <link rel="stylesheet" href="style.css" />
    <style>
      body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #FFDE59;
        font-family: "Poppins", sans-serif;
      }
      .thankyou-container {
        text-align: center;
      }
      .thankyou-container h1 {
        color: #2e3192;
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
      }
      .thankyou-container p {
        font-size: 1.2rem;
        color: #333;
      }
    </style>
  </head>
  <body>
    <div class="thankyou-container">
      <h1>Thank You!</h1>
      <p>Your Spin is Complete</p>
      <p>Your prize is: <span id="prize-name"></span></p>
    </div>

    <script>
      // Get the prize from the query parameter
      const urlParams = new URLSearchParams(window.location.search);
      const prize = urlParams.get('prize');

      // Display the prize
      document.getElementById('prize-name').textContent = prize ? prize : 'Unknown Prize';
    </script>
  </body>
</html>
