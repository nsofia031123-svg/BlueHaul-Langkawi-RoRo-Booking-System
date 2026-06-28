<?php
$currentPage = basename($_SERVER['PHP_SELF']);
function navActive($pages, $currentPage) {
    return in_array($currentPage, (array)$pages, true) ? ' active' : '';
}
?>
<link rel="stylesheet" href="css/design.css">

<header class="site-header">
  <div class="site-nav">
    <a href="index.php" class="site-brand" aria-label="BlueHaul RoRo home">
      <img src="images/logo.png" alt="BlueHaul RoRo">
    </a>

    <nav class="nav-links" aria-label="Main navigation">
      <a href="index.php" class="nav-link<?php echo navActive('index.php', $currentPage); ?>">Home</a>
      <div class="nav-dropdown">
        <button type="button" class="nav-trigger<?php echo navActive(['schedule.php','schedule2.php'], $currentPage); ?>">Schedule <i class="fa fa-chevron-down"></i></button>
        <div class="nav-menu">
          <a href="schedule.php">Kuala Perlis to Langkawi</a>
          <a href="schedule2.php">Langkawi to Kuala Perlis</a>
        </div>
      </div>
      <a href="fare.php" class="nav-link<?php echo navActive('fare.php', $currentPage); ?>">Fares</a>
      <a href="guide.php" class="nav-link<?php echo navActive('guide.php', $currentPage); ?>">Travel guide</a>

      <?php if (isset($_SESSION["username"])) { ?>
        <a href="history.php" class="nav-link<?php echo navActive(['history.php','booking-detail.php'], $currentPage); ?>">My bookings</a>
        <a href="book.php" class="nav-link nav-cta<?php echo navActive(['book.php','book2.php','book3.php'], $currentPage); ?>"><i class="fa fa-ticket"></i> Book a trip</a>
        <div class="nav-dropdown">
          <button type="button" class="nav-trigger"><i class="fa fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION["username"]); ?> <i class="fa fa-chevron-down"></i></button>
          <div class="nav-menu">
            <a href="profile.php">Profile settings</a>
            <a href="logout.php">Sign out</a>
          </div>
        </div>
      <?php } else { ?>
        <a href="contact.php" class="nav-link<?php echo navActive('contact.php', $currentPage); ?>">Contact</a>
        <div class="nav-dropdown">
          <button type="button" class="nav-trigger nav-cta<?php echo navActive(['login.php','register.php','admin.php'], $currentPage); ?>"><i class="fa fa-sign-in"></i> Sign in <i class="fa fa-chevron-down"></i></button>
          <div class="nav-menu sign-in-menu">
            <a href="login.php">
              <span class="sign-in-icon"><i class="fa fa-user"></i></span>
              <span><strong>User sign in</strong><small>Book and manage your trips</small></span>
            </a>
            <a href="admin.php">
              <span class="sign-in-icon"><i class="fa fa-lock"></i></span>
              <span><strong>Admin sign in</strong><small>Manage BlueHaul operations</small></span>
            </a>
          </div>
        </div>
      <?php } ?>
    </nav>

    <button type="button" class="mobile-toggle" onclick="w3_open()" aria-label="Open navigation"><i class="fa fa-bars"></i></button>
  </div>
</header>

<nav class="mobile-nav" id="mySidebar" aria-label="Mobile navigation">
  <div class="mobile-nav-head"><strong>Menu</strong><button type="button" class="mobile-close" onclick="w3_close()" aria-label="Close navigation"><i class="fa fa-times"></i></button></div>
  <a href="index.php" class="<?php echo navActive('index.php', $currentPage); ?>"><i class="fa fa-home"></i> Home</a>
  <a href="schedule.php" class="<?php echo navActive('schedule.php', $currentPage); ?>"><i class="fa fa-calendar"></i> KP to Langkawi schedule</a>
  <a href="schedule2.php" class="<?php echo navActive('schedule2.php', $currentPage); ?>"><i class="fa fa-calendar"></i> Langkawi to KP schedule</a>
  <a href="fare.php" class="<?php echo navActive('fare.php', $currentPage); ?>"><i class="fa fa-tags"></i> Fares</a>
  <a href="guide.php" class="<?php echo navActive('guide.php', $currentPage); ?>"><i class="fa fa-info-circle"></i> Travel guide</a>
  <?php if (isset($_SESSION["username"])) { ?>
    <div class="mobile-section">Your account</div>
    <a href="book.php"><i class="fa fa-ticket"></i> Book a trip</a>
    <a href="history.php"><i class="fa fa-list"></i> My bookings</a>
    <a href="profile.php"><i class="fa fa-user"></i> Profile settings</a>
    <a href="logout.php"><i class="fa fa-sign-out"></i> Sign out</a>
  <?php } else { ?>
    <a href="contact.php"><i class="fa fa-envelope"></i> Contact us</a>
    <div class="mobile-section">Sign in</div>
    <a href="login.php"><i class="fa fa-user"></i> User sign in</a>
    <a href="admin.php"><i class="fa fa-lock"></i> Admin sign in</a>
    <a href="register.php"><i class="fa fa-user-plus"></i> Create account</a>
  <?php } ?>
</nav>
