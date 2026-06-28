<?php
$currentPage = basename($_SERVER['PHP_SELF']);
if (!function_exists('navActive')) {
    function navActive($pages, $currentPage) {
        return in_array($currentPage, (array)$pages, true) ? ' active' : '';
    }
}
?>
<link rel="stylesheet" href="css/design.css">

<header class="site-header admin-header">
  <div class="site-nav">
    <a href="a-main.php" class="site-brand" aria-label="BlueHaul admin dashboard"><img src="images/logo.png" alt="BlueHaul RoRo"></a>
    <nav class="nav-links" aria-label="Admin navigation">
      <a href="a-main.php" class="nav-link<?php echo navActive('a-main.php', $currentPage); ?>">Dashboard</a>
      <a href="a-history.php" class="nav-link<?php echo navActive('a-history.php', $currentPage); ?>">Bookings</a>
      <a href="a-schedule.php" class="nav-link<?php echo navActive('a-schedule.php', $currentPage); ?>">Schedules</a>
      <a href="a-fare.php" class="nav-link<?php echo navActive('a-fare.php', $currentPage); ?>">Fares</a>
      <a href="a-promotion.php" class="nav-link<?php echo navActive('a-promotion.php', $currentPage); ?>">Promotions</a>
      <div class="nav-dropdown">
        <button type="button" class="nav-trigger<?php echo navActive(['a-message.php','a-message2.php'], $currentPage); ?>">Messages <i class="fa fa-chevron-down"></i></button>
        <div class="nav-menu"><a href="a-message.php">Open messages</a><a href="a-message2.php">Resolved messages</a></div>
      </div>
      <a href="a-user.php" class="nav-link<?php echo navActive('a-user.php', $currentPage); ?>">Users</a>
      <a href="a-report.php" class="nav-link<?php echo navActive('a-report.php', $currentPage); ?>">Reports</a>
      <div class="nav-dropdown">
        <button type="button" class="nav-trigger"><i class="fa fa-user-circle"></i> Admin <i class="fa fa-chevron-down"></i></button>
        <div class="nav-menu"><a href="a-profile.php">Profile settings</a><a href="logout.php">Sign out</a></div>
      </div>
    </nav>
    <button type="button" class="mobile-toggle" onclick="w3_open()" aria-label="Open navigation"><i class="fa fa-bars"></i></button>
  </div>
</header>

<nav class="mobile-nav" id="mySidebar" aria-label="Admin mobile navigation">
  <div class="mobile-nav-head"><strong>Admin menu</strong><button type="button" class="mobile-close" onclick="w3_close()" aria-label="Close navigation"><i class="fa fa-times"></i></button></div>
  <a href="a-main.php"><i class="fa fa-dashboard"></i> Dashboard</a>
  <a href="a-history.php"><i class="fa fa-ticket"></i> Bookings</a>
  <a href="a-schedule.php"><i class="fa fa-calendar"></i> Schedules</a>
  <a href="a-fare.php"><i class="fa fa-money"></i> Fares</a>
  <a href="a-promotion.php"><i class="fa fa-bullhorn"></i> Promotions</a>
  <a href="a-message.php"><i class="fa fa-envelope"></i> Open messages</a>
  <a href="a-message2.php"><i class="fa fa-check-circle"></i> Resolved messages</a>
  <a href="a-user.php"><i class="fa fa-users"></i> Users</a>
  <a href="a-report.php"><i class="fa fa-bar-chart"></i> Reports</a>
  <div class="mobile-section">Account</div>
  <a href="a-profile.php"><i class="fa fa-user"></i> Profile settings</a>
  <a href="logout.php"><i class="fa fa-sign-out"></i> Sign out</a>
</nav>
