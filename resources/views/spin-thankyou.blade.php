<!-- resources/views/thankYou.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Thank You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #FFDE59;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .wrapper {
            background-color: #e91414; 
            padding: 2em;
            border-radius: 1em;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        h2 {
            color: white;
        }
        p {
            color: white;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Thank You!</h2>
        <p>Your spin has been completed.</p>
        <p>Invoice Number: <strong>{{ $invoice_number }}</strong></p>
        <p>Discount: <strong>{{ $discount }}</strong></p>
    </div>
</body>
</html>
