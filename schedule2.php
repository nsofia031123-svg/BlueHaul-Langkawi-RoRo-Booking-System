<?php
session_start();
include("database.php");
?>

<!DOCTYPE html>
<html>
<title>BLUEHAUL RORO</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- DataTables CSS and Bootstrap CSS -->
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

<style>
body, h1, h2, h3, h4, h5, h6 {
    font-family: "Barlow", sans-serif;
    font-weight: 500;
}

body, html {
    height: 100%;
    line-height: 1.5;
}

/* Full height image header */
.bgimg-1 {
    background-position: top;
    background-size: cover;
    min-height: 100%;
    background-attachment: fixed;
    background-image: url(images/banner.jpg);
}

.w3-bar .w3-button {
    padding: 16px;
}
</style>

<body class="w3-pale-red">

    <?php include("menu.php"); ?>

    <div class="bgimg-1">
        <div class="w3-padding-64"></div>

        <div class="w3-container w3-padding-16" id="contact">
            <div class="w3-content w3-container w3-white w3-round-large w3-card" style="max-width:1200px">
                <div class="w3-padding">

                    <h3><b>Langkawi - Kuala Perlis</b></h3>

                    <table id="myTable" class="w3-table w3-table-all" width="100%" cellspacing="0">
                        <thead>
                            <tr class="w3-black">
                                <th>BIL</th>
                                <th>Schedule Date</th>
                                <th>Departure Time</th>
                                <th>Arrival Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $bil = 0;
                            $SQL_list = "SELECT * FROM `schedule` WHERE location = 'LGK-KP' ORDER BY `schedule_date` ASC";
                            $result = mysqli_query($con, $SQL_list);

                            while ($data = mysqli_fetch_array($result)) {
                                $bil++;
                            ?>
                                <tr>
                                    <td><?php echo $bil; ?></td>
                                    <td><?php echo $data["schedule_date"]; ?></td>
                                    <td><?php echo $data["depart_time"]; ?></td>
                                    <td><?php echo $data["arrival_time"]; ?></td>
                                    <td><?php echo $data["status"]; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
                <div class="w3-padding-24"></div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTable without pagination
			//SEARCH FUNCTION
			//PAGING FUNCTION
            $('#myTable').DataTable({
                paging: false
            });
        });

        // Toggle between showing and hiding the sidebar when clicking the menu icon
        var mySidebar = document.getElementById("mySidebar");

        function w3_open() {
            if (mySidebar.style.display === 'block') {
                mySidebar.style.display = 'none';
            } else {
                mySidebar.style.display = 'block';
            }
        }

        // Close the sidebar with the close button
        function w3_close() {
            mySidebar.style.display = "none";
        }
    </script>

</body>
</html>
