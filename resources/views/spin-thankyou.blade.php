<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Thank You</title>
    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap"
      rel="stylesheet"
    />
    <!-- Stylesheet -->
    <link rel="stylesheet" href="style.css" />
    <style>
      * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
      }
      body {
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
      }
      .wrapper {
        text-align: center;
      }
      .thank-you {
        font-size: 2em;
        color: #28a745;
      }
      .prize {
        font-size: 1.5em;
        color: #343a40;
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <h1 class="thank-you">Thank You for Spinning!</h1>
      <p class="prize">You won: <strong>{{ $prize }}</strong></p>
      <p>We hope you enjoy your prize!</p>
    </div>
  </body>
</html>
