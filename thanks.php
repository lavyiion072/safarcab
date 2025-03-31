<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            padding: 50px;
            animation: fadeIn 1s ease-in-out;
        }
        .thank-you-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 255, 0, 0.3);
            max-width: 500px;
            margin: auto;
            animation: fadeInUp 1s ease-in-out;
            position: relative;
        }
        .checkmark {
            display: inline-block;
            width: 80px;
            height: 80px;
            background-color: #28a745;
            border-radius: 50%;
            position: relative;
            margin-bottom: 20px;
            animation: popIn 0.6s ease-out;
        }
        .checkmark::after {
            content: "✔";
            color: #fff;
            font-size: 50px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: scaleUp 0.6s ease-in-out;
        }
        h2 {
            color: #28a745;
            font-size: 28px;
            font-weight: bold;
        }
        p {
            color: #6c757d;
            font-size: 18px;
        }
        .btn-custom {
            background: #28a745;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            transition: 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 255, 0, 0.3);
        }
        .btn-custom:hover {
            background: #218838;
            color: #fff;
            box-shadow: 0 6px 15px rgba(0, 255, 0, 0.6);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes popIn {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        @keyframes scaleUp {
            from { transform: translate(-50%, -50%) scale(0); }
            to { transform: translate(-50%, -50%) scale(1); }
        }
    </style>
</head>
<body>

    <div class="thank-you-card">
        <div class="checkmark"></div>
        <h2>Booking Confirmed!</h2>
        <p>Your request has been received successfully. We will contact you soon.</p>
        <a href="index.php" class="btn btn-custom">Go Back to Home</a>
    </div>

</body>
</html>
