<?php
session_start();

include("database.php");
if (!verifyAdmin($con)) {
    header("Location: index.php");
    return false;
}

$message_id = (isset($_REQUEST['message_id'])) ? trim($_REQUEST['message_id']) : '0';
$act = (isset($_POST['act'])) ? trim($_POST['act']) : '';

$success = "";

// Resolve action handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['act']) && $_POST['act'] == "resolve") {
    $message_id = mysqli_real_escape_string($con, $_POST['message_id']);
    $admin_solution = mysqli_real_escape_string($con, $_POST['admin_solution']);

    // Update the database with the admin solution and set resolved to true
    $SQL_update = "UPDATE messages SET resolved = TRUE, admin_solution = '$admin_solution' WHERE message_id = '$message_id' ";
    $result = mysqli_query($con, $SQL_update);

    if (!$result) {
        die("Error updating message: " . mysqli_error($con));
    }

    $success = "Message resolved!";
}

?>

<!DOCTYPE html>
<html>
<title>BLUEHAUL RORO</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="css/table.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

<style>
    a {
        text-decoration: none;
    }

    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: "Barlow", sans-serif
    }

    body,
    html {
        height: 100%;
        line-height: 1.5;
    }

    /* Full height image header */
    .bgimg-1 {
        background-position: top;
        background-attachment: fixed;
        background-size: cover;
        background-image: url("images/banner.jpg");
        min-height: 100%;
    }

    .w3-bar .w3-button {
        padding: 16px;
    }

    input[name="admin_solution"] {
        width: 300px; /* Adjust the width as needed */
        padding: 10px;
        margin: 5px 0;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
    }

    /* Style for the Resolve button */
    button[type="submit"] {
        background-color: #4CAF50; /* Green */
        color: white;
        padding: 10px 15px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<body class="w3-pale-red">

    <?php include("menu-admin.php"); ?>

    <!--- Toast Notification -->
    <?php if ($success) {
        Notify("success", $success, "a-message.php");
    } ?>

    <div>

        <div class="w3-padding-64"></div>

        <!-- Page Container -->
        <div class="w3-container w3-content" style="max-width:1400px;">
            <!-- The Grid -->
            <div class="w3-row w3-white w3-card w3-padding">

                <div class="w3-xxlarge w3-center"><b>Resolved Messages</b></div>
                <div class="w3-row w3-margin ">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="w3-black">
                                    <th>Bil</th>
                                    <th>Name</th>
                                    <th>Plate Number</th>
                                    <th>Phone Number</th>
                                    <th>Message</th>
                                    <th>Timestamp</th>
                                    <th>Admin Solution</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $bil = 0;
                                $SQL_list = "SELECT * FROM messages WHERE resolved = TRUE";
                                $result = mysqli_query($con, $SQL_list);
                                while ($data = mysqli_fetch_array($result)) {
                                    $bil++;
                                    $message_id = $data["message_id"];
                                ?>
                                    <tr>
                                        <td><?php echo $bil; ?></td>
                                        <td><?php echo $data["name"]; ?></td>
                                        <td><?php echo $data["plate_number"]; ?></td>
                                        <td><?php echo $data["phone_number"]; ?></td>
                                        <td><?php echo $data["message_text"]; ?></td>
                                        <td><?php echo $data["submission_date"]; ?></td>
                                        <td><?php echo $data["admin_solution"]; ?></td>
                                        
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- End Grid -->
            </div>

            <!-- End Page Container -->
        </div>

        <div class="w3-padding-24"></div>

    </div>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                paging: true,
                searching: true
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

    <script>
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