<?php
session_start();
include("database.php");

if (!verifyUser($con)) {
    header("Location: login.php");
    exit;
}

$username = mysqli_real_escape_string($con, $_SESSION['username']);
$result = mysqli_query(
    $con,
    "SELECT * FROM `booking`
     WHERE `username` = '$username'
     ORDER BY `depart_date` DESC, `booking_id` DESC"
);

function bookingRouteName($location) {
    return $location === 'LGK-KP' ? 'Langkawi to Kuala Perlis' : 'Kuala Perlis to Langkawi';
}

function bookingDisplayDate($date) {
    return (!$date || $date === '0000-00-00') ? 'Not applicable' : date('d M Y', strtotime($date));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Bookings | BlueHaul RoRo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="my-bookings-page">
<?php include("menu.php"); ?>

<main class="my-bookings-main">
    <section class="my-bookings-heading">
        <div>
            <p class="section-kicker">Your journeys</p>
            <h1>My bookings</h1>
            <p>View your upcoming and previous ferry bookings, details, and tickets.</p>
        </div>
        <a href="book.php" class="my-bookings-cta"><i class="fa fa-plus"></i> Book another trip</a>
    </section>

    <?php if (mysqli_num_rows($result) > 0) { ?>
        <section class="booking-list">
            <?php while ($booking = mysqli_fetch_assoc($result)) {
                $booking_id = (int)$booking['booking_id'];
                $amount = $booking['final_total'] > 0 ? $booking['final_total'] : $booking['total'];
                $ferry_status = trim((string)$booking['ferry_status']);
            ?>
                <article class="booking-card">
                    <div class="booking-card-top">
                        <div>
                            <span class="booking-number-label">Booking number</span>
                            <strong class="booking-number">#<?php echo htmlspecialchars($booking['booking_no']); ?></strong>
                        </div>
                        <div class="booking-badges">
                            <span class="booking-status"><?php echo htmlspecialchars($booking['status']); ?></span>
                            <?php if ($ferry_status !== '') { ?>
                                <span class="ferry-status"><?php echo htmlspecialchars($ferry_status); ?></span>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="booking-route">
                        <span class="route-icon"><i class="fa fa-ship"></i></span>
                        <div>
                            <strong><?php echo bookingRouteName($booking['location']); ?></strong>
                            <span><?php echo ucfirst(htmlspecialchars($booking['trip'])); ?> trip</span>
                        </div>
                    </div>

                    <div class="booking-facts">
                        <div><span>Departure</span><strong><?php echo bookingDisplayDate($booking['depart_date']); ?></strong></div>
                        <div><span>Return</span><strong><?php echo bookingDisplayDate($booking['return_date']); ?></strong></div>
                        <div><span>Vehicle</span><strong><?php echo htmlspecialchars(GetVehicle($con, $booking['vehicle'])); ?></strong></div>
                        <div><span>Total paid</span><strong>RM <?php echo number_format((float)$amount, 2); ?></strong></div>
                    </div>

                    <div class="booking-card-actions">
                        <a href="booking-detail.php?booking_id=<?php echo $booking_id; ?>" target="_blank" class="booking-secondary-action"><i class="fa fa-file-text-o"></i> View details</a>
                        <a href="slip.php?booking_id=<?php echo $booking_id; ?>" target="_blank" class="booking-primary-action"><i class="fa fa-qrcode"></i> View ticket</a>
                    </div>
                </article>
            <?php } ?>
        </section>
    <?php } else { ?>
        <section class="bookings-empty">
            <span><i class="fa fa-ticket"></i></span>
            <h2>No bookings yet</h2>
            <p>Your ferry bookings will appear here after you complete your first trip booking.</p>
            <a href="book.php" class="my-bookings-cta">Book your first trip</a>
        </section>
    <?php } ?>
</main>

<?php include("footer.php"); ?>
<script>
var mySidebar = document.getElementById("mySidebar");
function w3_open() {
    mySidebar.style.display = mySidebar.style.display === 'block' ? 'none' : 'block';
}
function w3_close() {
    mySidebar.style.display = 'none';
}
</script>
</body>
</html>
