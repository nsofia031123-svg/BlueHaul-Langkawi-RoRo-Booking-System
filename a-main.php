<?php
session_start();
include("database.php");

if (!verifyAdmin($con)) {
    header("Location: index.php");
    exit;
}

$tot_user = numRows($con, "SELECT * FROM `user`");
$tot_booking = numRows($con, "SELECT * FROM `booking`");
$tot_unresolved_messages = numRows($con, "SELECT * FROM `messages` WHERE `resolved` = FALSE");

$sales_result = mysqli_query($con, "SELECT SUM(total) AS sales FROM `booking`");
$sales_data = mysqli_fetch_assoc($sales_result);
$sales = $sales_data["sales"] + 0;

$today = date('Y-m-d');
$today_result = mysqli_query($con, "SELECT COUNT(*) AS total FROM `schedule` WHERE schedule_date = '$today'");
$today_data = mysqli_fetch_assoc($today_result);
$today_schedules = (int)$today_data['total'];

$upcoming_result = mysqli_query(
    $con,
    "SELECT location, schedule_date, depart_time, arrival_time, status
     FROM `schedule`
     WHERE schedule_date >= CURDATE()
     ORDER BY schedule_date ASC, depart_time ASC
     LIMIT 5"
);

function routeName($location) {
    return $location === 'LGK-KP' ? 'Langkawi to Kuala Perlis' : 'Kuala Perlis to Langkawi';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>BlueHaul Admin Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="admin-dashboard">
<?php include("menu-admin.php"); ?>

<main class="admin-dashboard-main">
    <section class="dashboard-heading">
        <div>
            <p class="section-kicker">Operations overview</p>
            <h1>Welcome back, Admin</h1>
            <p>Here is what is happening across BlueHaul today.</p>
        </div>
        <div class="dashboard-date">
            <i class="fa fa-calendar"></i>
            <span><?php echo date('l, d F Y'); ?></span>
        </div>
    </section>

    <section class="dashboard-metrics" aria-label="Dashboard summary">
        <a href="a-user.php" class="metric-card metric-users">
            <span class="metric-icon"><i class="fa fa-users"></i></span>
            <span class="metric-label">Registered users</span>
            <strong><?php echo $tot_user; ?></strong>
            <span class="metric-link">Manage users <i class="fa fa-arrow-right"></i></span>
        </a>

        <a href="a-history.php" class="metric-card metric-bookings">
            <span class="metric-icon"><i class="fa fa-ticket"></i></span>
            <span class="metric-label">Total bookings</span>
            <strong><?php echo $tot_booking; ?></strong>
            <span class="metric-link">View bookings <i class="fa fa-arrow-right"></i></span>
        </a>

        <a href="a-report.php" class="metric-card metric-sales">
            <span class="metric-icon"><i class="fa fa-money"></i></span>
            <span class="metric-label">Total sales (All Time)</span>
            <strong class="metric-money">RM <?php echo number_format($sales, 2); ?></strong>
            <span class="metric-link">View reports <i class="fa fa-arrow-right"></i></span>
        </a>

        <a href="a-message.php" class="metric-card metric-messages">
            <span class="metric-icon"><i class="fa fa-comment"></i></span>
            <span class="metric-label">Open messages</span>
            <strong><?php echo $tot_unresolved_messages; ?></strong>
            <span class="metric-link">Review messages <i class="fa fa-arrow-right"></i></span>
        </a>

        <a href="a-schedule.php" class="metric-card metric-schedules">
            <span class="metric-icon"><i class="fa fa-calendar-check-o"></i></span>
            <span class="metric-label">Departures today</span>
            <strong><?php echo $today_schedules; ?></strong>
            <span class="metric-link"><?php echo $today_schedules ? 'View today\'s trips' : 'No trips scheduled today'; ?> <i class="fa fa-arrow-right"></i></span>
        </a>
    </section>

    <section class="dashboard-panel">
        <div class="panel-heading">
            <div>
                <p class="section-kicker">Schedule</p>
                <h2>Next departures</h2>
            </div>
            <a href="a-schedule.php" class="panel-action">Manage schedules <i class="fa fa-arrow-right"></i></a>
        </div>

        <div class="departure-list">
            <?php if (mysqli_num_rows($upcoming_result) > 0) { ?>
                <?php while ($schedule = mysqli_fetch_assoc($upcoming_result)) { ?>
                    <div class="departure-row">
                        <div class="departure-date">
                            <strong><?php echo date('d', strtotime($schedule['schedule_date'])); ?></strong>
                            <span><?php echo date('M', strtotime($schedule['schedule_date'])); ?></span>
                        </div>
                        <div class="departure-route">
                            <strong><?php echo routeName($schedule['location']); ?></strong>
                            <span><?php echo date('l, d F Y', strtotime($schedule['schedule_date'])); ?></span>
                        </div>
                        <div class="departure-time">
                            <span><?php echo date('g:i A', strtotime($schedule['depart_time'])); ?></span>
                            <i class="fa fa-long-arrow-right"></i>
                            <span><?php echo date('g:i A', strtotime($schedule['arrival_time'])); ?></span>
                        </div>
                        <span class="status-badge"><?php echo htmlspecialchars($schedule['status']); ?></span>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="dashboard-empty">
                    <i class="fa fa-calendar-o"></i>
                    <h3>No upcoming departures</h3>
                    <p>Add a schedule to make future trips visible here.</p>
                </div>
            <?php } ?>
        </div>
    </section>
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
