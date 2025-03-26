<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $_SESSION['booking'] = $_POST;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Confirm Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <header>
        <h1>Confirm Your Booking</h1>
    </header>

    <section class="checkout">
        <h2>Booking Details</h2>

        <?php if (isset($_SESSION['booking'])): ?>
            <p><strong>Pickup:</strong> <?= $_SESSION['booking']['pickup'] ?></p>
            <p><strong>Drop-off:</strong> <?= $_SESSION['booking']['dropoff'] ?></p>
            <p><strong>Date:</strong> <?= $_SESSION['booking']['date'] ?></p>
            <p><strong>Time:</strong> <?= $_SESSION['booking']['time'] ?></p>
            <p><strong>Name:</strong> <?= $_SESSION['booking']['name'] ?></p>
            <p><strong>Phone:</strong> <?= $_SESSION['booking']['phone'] ?></p>
            <p><strong>Email:</strong> <?= $_SESSION['booking']['email'] ?></p>
            
            <form action="booking.php" method="post">
                <input type="hidden" name="pickup" value="<?= $_SESSION['booking']['pickup'] ?>">
                <input type="hidden" name="dropoff" value="<?= $_SESSION['booking']['dropoff'] ?>">
                <input type="hidden" name="date" value="<?= $_SESSION['booking']['date'] ?>">
                <input type="hidden" name="time" value="<?= $_SESSION['booking']['time'] ?>">
                <input type="hidden" name="name" value="<?= $_SESSION['booking']['name'] ?>">
                <input type="hidden" name="phone" value="<?= $_SESSION['booking']['phone'] ?>">
                <input type="hidden" name="email" value="<?= $_SESSION['booking']['email'] ?>">

                <button type="submit">Confirm Booking</button>
            </form>
        <?php else: ?>
            <p>No booking details found. <a href="index.php">Go back</a></p>
        <?php endif; ?>
    </section>

</body>
</html>
