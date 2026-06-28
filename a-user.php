<?php
session_start();

include("database.php");
if (!verifyAdmin($con)) {
    header("Location: index.php");
    return false;
}
?>
<?php
$user_id = (isset($_REQUEST['user_id'])) ? trim($_REQUEST['user_id']) : '0';
$act = (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';

$success = "";

if ($act == "del") {
    $SQL_delete = " DELETE FROM `user` WHERE `user_id` =  '$user_id' ";
    $result = mysqli_query($con, $SQL_delete);

    $success = "Deleted!";
    //print "<script>self.location='a-user.php';</script>";
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
    a { text-decoration: none; }

    body, h1, h2, h3, h4, h5, h6 { font-family: "Barlow", sans-serif }

    body, html {
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
</style>

<body class="w3-pale-red">

    <?php include("menu-admin.php"); ?>

    <!--- Toast Notification -->
    <?php
    if ($success) { Notify("success", $success, "a-user.php"); }
    ?>

    <div>

        <div class="w3-padding-64"></div>


        <!-- Page Container -->
        <div class="w3-container w3-content" style="max-width:1000px;">
            <!-- The Grid -->
            <div class="w3-row w3-white w3-card w3-padding">

                <div class="w3-xxlarge w3-center"><b>user</b></div>
                <div class="w3-row w3-margin ">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="w3-black">
                                    <th>Bil</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th class="w3-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $bil = 0;
                                $SQL_list = "SELECT * FROM `user` ";
                                $result = mysqli_query($con, $SQL_list);
                                while ($data = mysqli_fetch_array($result)) {
                                    $bil++;
                                    $user_id = $data["user_id"];
                                ?>
                                    <tr>
                                        <td><?php echo $bil; ?></td>
                                        <td><?php echo $data["email"]; ?></td>
                                        <td><?php echo $data["username"]; ?></td>
                                        <td class="w3-center">
                                            <a href="#" onclick="confirmDelete('<?php echo $user_id; ?>')" class="w3-text-red"><i class="fa fa-fw fa-trash fa-lg"></i></a>
                                        </td>
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
        $(document).ready(function () {


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
    <!--<script src="assets/demo/datatables-demo.js"></script>-->

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

        function confirmDelete(userId) {
            var confirmDelete = confirm("Are you sure you want to delete this user?");

            if (confirmDelete) {
                window.location.href = '?act=del&user_id=' + userId;
            }
        }
    </script>

</body>

</html>
