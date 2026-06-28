<?php
session_start();
include("database.php");

if (!verifyAdmin($con)) {
    header("Location: index.php");
    return false;
}

// Defaults
$is_reset   = isset($_GET['reset']) && $_GET['reset'] == '1';
$start_date = (!$is_reset && isset($_GET['start_date'])) ? $_GET['start_date'] : '';
$end_date   = (!$is_reset && isset($_GET['end_date']))   ? $_GET['end_date']   : '';
$route      = (!$is_reset && isset($_GET['route']))      ? $_GET['route']      : '';
$status     = (!$is_reset && isset($_GET['status']))     ? $_GET['status']     : '';

// Query building
$where = "";
if ($start_date != '' && $end_date != '') {
    $where = " WHERE depart_date >= '$start_date' AND depart_date <= '$end_date' ";
}
if ($route != '') {
    $where .= ($where == '' ? ' WHERE ' : ' AND ') . " location = '$route' ";
}
if ($status != '') {
    $where .= ($where == '' ? ' WHERE ' : ' AND ') . " status = '$status' ";
}

// Summaries
$sql_sales  = "SELECT SUM(total) as sales, COUNT(*) as bookings, COUNT(DISTINCT username) as users FROM booking " . $where;
$res_sales  = mysqli_query($con, $sql_sales);
$data_sales = mysqli_fetch_array($res_sales);
$tot_sales    = $data_sales['sales'] + 0;
$tot_bookings = $data_sales['bookings'] + 0;
$tot_users    = $data_sales['users'] + 0;

// Pagination
$records_per_page = 10;
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

$sql_count   = "SELECT COUNT(*) as total FROM booking " . $where;
$res_count   = mysqli_query($con, $sql_count);
$row_count   = mysqli_fetch_array($res_count);
$total_records = $row_count['total'];
$total_pages   = ceil($total_records / $records_per_page);

// Data list
$sql_list = "SELECT * FROM booking " . $where . " ORDER BY depart_date DESC LIMIT $records_per_page OFFSET $offset";
$res_list = mysqli_query($con, $sql_list);
?>
<!DOCTYPE html>
<html>
<head>
    <title>BLUEHAUL RORO - Generate Report</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="w3.css">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body, h1, h2, h3, h4, h5, h6 { font-family: "Barlow", sans-serif; font-weight: 500; }
        body, html { height: 100%; line-height: 1.5; }
        .w3-bar .w3-button { padding: 16px; }
        a { text-decoration: none; }
    </style>
</head>
<body class="w3-pale-red">

<?php include("menu-admin.php"); ?>

<div class="w3-pale-red">
    <div class="w3-padding-64"></div>

    <!-- Page Container -->
    <div class="w3-container w3-content" style="max-width:1400px;">
        <!-- The Grid -->
        <div class="w3-row w3-white w3-card w3-padding">
            <div class="w3-xxlarge w3-center"><b>Generate Report</b></div>

            <!-- Filters Form -->
            <div class="w3-padding w3-margin-top">
                    <form method="get" action="a-report.php">
                    <div class="w3-row-padding">
                        <div class="w3-col m7 w3-margin-bottom">
                            <label>Date Range (Optional)</label>
                            <div class="w3-row">
                                <div class="w3-col s5">
                                    <input class="w3-input w3-border w3-round" type="date" name="start_date" value="<?php echo $start_date; ?>">
                                </div>
                                <div class="w3-col s2 w3-center" style="padding-top: 8px;">to</div>
                                <div class="w3-col s5">
                                    <input class="w3-input w3-border w3-round" type="date" name="end_date" value="<?php echo $end_date; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="w3-col m3 w3-margin-bottom">
                            <label>Route (Optional)</label>
                            <select class="w3-input w3-border w3-round" name="route">
                                <option value="">-- All Routes --</option>
                                <option value="LGK-KP" <?php if ($route == 'LGK-KP') echo 'selected'; ?>>Langkawi - Kuala Perlis</option>
                                <option value="KP-LGK" <?php if ($route == 'KP-LGK') echo 'selected'; ?>>Kuala Perlis - Langkawi</option>
                            </select>
                        </div>
                        <div class="w3-col m2 w3-margin-bottom">
                            <label>Status (Optional)</label>
                            <select class="w3-input w3-border w3-round" name="status">
                                <option value="">-- All Status --</option>
                                <option value="Paid"      <?php if ($status == 'Paid')      echo 'selected'; ?>>Paid</option>
                                <option value="Pending"   <?php if ($status == 'Pending')   echo 'selected'; ?>>Pending</option>
                                <option value="Cancelled" <?php if ($status == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="w3-row-padding w3-margin-top w3-center">
                        <button type="submit" class="w3-button w3-black w3-round"><i class="fa fa-file-text"></i> Generate Report</button>
                        <button type="button" onclick="resetAll()" class="w3-button w3-white w3-border w3-round"><i class="fa fa-refresh"></i> Reset</button>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="w3-row w3-padding-24 w3-light-gray w3-margin-top w3-round" style="padding-bottom: 24px;">
                <div class="w3-col m4 w3-container" style="margin-top: 20px;">
                    <div class="w3-card w3-white w3-round w3-padding-16">
                        <div class="w3-container w3-large">
                            Total Sales (Selected Period) <i class="fa fa-money fa-lg w3-right"></i>
                            <hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
                            <h2 class="w3-center">RM<?php echo number_format($tot_sales, 2); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="w3-col m4 w3-container" style="margin-top: 20px;">
                    <div class="w3-card w3-white w3-round w3-padding-16">
                        <div class="w3-container w3-large">
                            Bookings <i class="fa fa-ticket fa-lg w3-right"></i>
                            <hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
                            <h2 class="w3-center"><?php echo $tot_bookings; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="w3-col m4 w3-container" style="margin-top: 20px;">
                    <div class="w3-card w3-white w3-round w3-padding-16">
                        <div class="w3-container w3-large">
                            Users <i class="fa fa-users fa-lg w3-right"></i>
                            <hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
                            <h2 class="w3-center"><?php echo $tot_users; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Results -->
            <div class="w3-margin-top w3-padding">
                <div class="w3-row w3-margin-bottom w3-padding-small" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                    <div class="w3-large"><b>Report Result</b></div>
                    <div style="display:flex; align-items:center; gap:6px;">
                        <i class="fa fa-search" style="color:#888;"></i>
                        <input id="reportSearch" class="w3-input w3-border w3-round" type="text" placeholder="Search bookings..." style="width:240px;" oninput="filterTable()">
                    </div>
                </div>

                <div class="w3-responsive">
                    <table class="w3-table w3-table-all w3-hoverable w3-centered w3-bordered" id="reportTable">
                        <thead>
                            <tr class="w3-black">
                                <th>No.</th>
                                <th>Date</th>
                                <th>Booking ID</th>
                                <th>User</th>
                                <th>Route</th>
                                <th>Amount (RM)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $bil = $offset;
                        if (mysqli_num_rows($res_list) > 0) {
                            while ($row = mysqli_fetch_array($res_list)) {
                                $bil++;
                                $route_text = ($row['location'] == 'LGK-KP') ? 'Langkawi - Kuala Perlis' : 'Kuala Perlis - Langkawi';
                                echo "<tr>";
                                echo "<td>$bil</td>";
                                echo "<td>" . $row['depart_date'] . "</td>";
                                echo "<td>BK" . str_pad($row['booking_id'], 5, "0", STR_PAD_LEFT) . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>$route_text</td>";
                                echo "<td>" . number_format($row['total'], 2) . "</td>";
                                echo "<td>" . $row['status'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No records found.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="w3-center w3-padding-16">
                    <div style="display:inline-flex; align-items:center; gap:4px; flex-wrap:wrap; justify-content:center;">
                        <?php
                        $query_params = $_GET;
                        unset($query_params['page']);
                        $base_url = 'a-report.php?' . http_build_query($query_params);
                        $base_url .= ($query_params ? '&' : '');
                        ?>
                        <?php if ($page > 1): ?>
                        <a href="<?php echo $base_url; ?>page=<?php echo $page - 1; ?>"
                            class="w3-button w3-border w3-round w3-white w3-small"
                            style="padding:6px 12px;"><i class="fa fa-chevron-left"></i></a>
                        <?php else: ?>
                        <span class="w3-button w3-border w3-round w3-light-grey w3-small"
                            style="padding:6px 12px; cursor:not-allowed;"><i class="fa fa-chevron-left"></i></span>
                        <?php endif; ?>

                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page   = min($total_pages, $page + 2);
                        if ($start_page > 1) echo '<span style="padding:6px 4px;">...</span>';
                        for ($i = $start_page; $i <= $end_page; $i++):
                        ?>
                        <a href="<?php echo $base_url; ?>page=<?php echo $i; ?>"
                            class="w3-button w3-border w3-round w3-small <?php echo ($i == $page) ? 'w3-black' : 'w3-white'; ?>"
                            style="padding:6px 12px;"><?php echo $i; ?></a>
                        <?php endfor; ?>
                        <?php if ($end_page < $total_pages) echo '<span style="padding:6px 4px;">...</span>'; ?>

                        <?php if ($page < $total_pages): ?>
                        <a href="<?php echo $base_url; ?>page=<?php echo $page + 1; ?>"
                            class="w3-button w3-border w3-round w3-white w3-small"
                            style="padding:6px 12px;"><i class="fa fa-chevron-right"></i></a>
                        <?php else: ?>
                        <span class="w3-button w3-border w3-round w3-light-grey w3-small"
                            style="padding:6px 12px; cursor:not-allowed;"><i class="fa fa-chevron-right"></i></span>
                        <?php endif; ?>
                    </div>
                    <div class="w3-text-grey w3-small w3-padding-small">
                        Showing <?php echo min($offset + 1, $total_records); ?>–<?php echo min($offset + $records_per_page, $total_records); ?> of <?php echo $total_records; ?> records
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <div class="w3-padding-24"></div>
</div>

<script>
var mySidebar = document.getElementById("mySidebar");
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
    } else {
        mySidebar.style.display = 'block';
    }
}
function w3_close() {
    mySidebar.style.display = "none";
}

// Live search
function filterTable() {
    var input = document.getElementById("reportSearch").value.toLowerCase();
    var rows = document.querySelectorAll("#reportTable tbody tr");
    rows.forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().includes(input) ? "" : "none";
    });
}

// Reset all filters and search
function resetAll() {
    var searchBox = document.getElementById("reportSearch");
    if (searchBox) searchBox.value = "";
    window.location.href = "a-report.php?reset=1";
}
</script>

</body>
</html>