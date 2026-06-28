<?php
session_start();

include("database.php");
if (!verifyAdmin($con)) {
    header("Location: index.php");
    return false;
}
?>
<?php
$schedule_id = (isset($_REQUEST['schedule_id'])) ? trim($_REQUEST['schedule_id']) : '0';
$act = (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';

$schedule_date = (isset($_POST['schedule_date'])) ? trim($_POST['schedule_date']) : '';
$depart_time = (isset($_POST['depart_time'])) ? trim($_POST['depart_time']) : '';
$arrival_time = (isset($_POST['arrival_time'])) ? trim($_POST['arrival_time']) : '';
$location = (isset($_POST['location'])) ? trim($_POST['location']) : '';
$status = (isset($_POST['status'])) ? trim($_POST['status']) : 'On Time';

$success = "";

if ($act == "add") {
    $SQL_insert = "INSERT INTO Schedule (schedule_date, depart_time, arrival_time, location, status) VALUES ('$schedule_date', '$depart_time', '$arrival_time', '$location', '$status')";
    $result = mysqli_query($con, $SQL_insert);
    $success = "Schedule added successfully";
}

if ($act == "edit") {
    $SQL_update = "UPDATE `schedule` SET `schedule_date` = '$schedule_date', `depart_time` = '$depart_time', `arrival_time` = '$arrival_time', `location` = '$location', `status` = '$status' WHERE `schedule_id` =  '$schedule_id'";
    $result = mysqli_query($con, $SQL_update) or die("Error in query: " . $SQL_update . "<br />" . mysqli_error($con));
    $success = "Successfully Update";
}

if ($act == "del") {
    $SQL_delete = "DELETE FROM `schedule` WHERE `schedule_id` =  '$schedule_id' ";
    $result = mysqli_query($con, $SQL_delete);
    $success = "Successfully Delete";
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
</style>

<body class="w3-pale-red">

    <?php include("menu-admin.php"); ?>

    <!--- Toast Notification -->
    <?php
    if ($success) {
        Notify("success", $success, "a-schedule.php");
    }
    ?>

    <div class="w3-pale-red">
        <div class="w3-padding-64"></div>

        <!-- Page Container -->
        <div class="w3-container w3-content" style="max-width:1400px;">
            <!-- The Grid -->
            <div class="w3-row w3-white w3-card w3-padding">

                <a onclick="document.getElementById('add01').style.display='block'; "
                    class="w3-margin-bottom w3-right w3-button w3-black w3-round "><i class="fa fa-fw fa-lg fa-plus"></i>
                    Add</a>
                <div class="w3-xxlarge w3-center"><b>Schedules</b></div>
                <div class="w3-row w3-margin ">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="w3-black">
                                    <th>Bil</th>
                                    <th>Schedule Date</th>
                                    <th>Departure Time</th>
                                    <th>Arrival Time</th>
                                    <th>Location</th>
                                    <th>Status</th> <!-- Add this line for the new column -->
                                    <th class="w3-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $bil = 0;
                                $current_date = date("Y-m-d");
                                $delete_query = "DELETE FROM schedule WHERE schedule_date < '$current_date'";
                                mysqli_query($con, $delete_query);
                                $SQL_list = "SELECT * FROM schedule ORDER BY schedule_date ASC";
                                $result = mysqli_query($con, $SQL_list);
                                while ($data = mysqli_fetch_array($result)) {
                                    $bil++;
                                    $schedule_id = $data["schedule_id"];
                                ?>
                                    <tr>
                                        <td><?php echo $bil; ?></td>
                                        <td><?php echo $data["schedule_date"]; ?></td>
                                        <td><?php echo $data["depart_time"]; ?></td>
                                        <td><?php echo $data["arrival_time"]; ?></td>
                                        <td><?php echo $data["location"]; ?></td>
                                        <td><?php echo $data["status"]; ?></td>
                                        <td class="w3-center">
                                            <a href="#"
                                                onclick="document.getElementById('idEdit<?php echo $bil; ?>').style.display='block'"
                                                class=""><i class="fa fa-fw fa-edit fa-lg"></i></a>

                                            <a title="Delete"
                                                onclick="document.getElementById('idDelete<?php echo $bil; ?>').style.display='block'"
                                                class="w3-text-red"><i class="fa fa-fw fa-trash fa-lg"></i></a>
                                        </td>
                                    </tr>

                                    <div id="idEdit<?php echo $bil; ?>" class="w3-modal" style="z-index:10;">
                                        <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom"
                                            style="max-width:500px">
                                            <header class="w3-container ">
                                                <span
                                                    onclick="document.getElementById('idEdit<?php echo $bil; ?>').style.display='none'"
                                                    class="w3-button w3-large w3-circle w3-display-topright "><i
                                                        class="fa fa-fw fa-times"></i></span>
                                            </header>

                                            <div class="w3-container w3-padding">

                                                <form action="" method="post">
                                                    <div class="w3-padding">
                                                        <b class="w3-large">Update Schedule</b>
                                                        <div class="w3-section">
                                                            <label>Schedule Date *</label>
                                                            <input class="w3-input w3-border w3-round" type="date"
                                                                name="schedule_date"
                                                                value="<?php echo $data["schedule_date"]; ?>"
                                                                min="<?php echo date('Y-m-d'); ?>" required>
                                                        </div>

                                                        <div class="w3-section">
                                                            <label>Departure Time *</label>
                                                            <input class="w3-input w3-border w3-round" type="time"
                                                                name="depart_time"
                                                                value="<?php echo $data["depart_time"]; ?>" required>
                                                        </div>

                                                        <div class="w3-section">
                                                            <label>Arrival Time *</label>
                                                            <input class="w3-input w3-border w3-round" type="time"
                                                                name="arrival_time"
                                                                value="<?php echo $data["arrival_time"]; ?>" required>
                                                        </div>

                                                        <div class="w3-section">
                                                            <label>Location *</label>
                                                            <select class="w3-input w3-border w3-round" type="text"
                                                                name="location" required>
                                                                <option value="LGK-KP" <?php if ($data["location"] == "LGK-KP")
                                                                    echo "selected"; ?>>Langkawi - Kuala Perlis</option>
                                                                <option value="KP-LGK" <?php if ($data["location"] == "KP-LGK")
                                                                    echo "selected"; ?>>Kuala Perlis - Langkawi</option>
                                                            </select>
                                                        </div>

                                                        <div class="w3-section">
                                                            <label>Status *</label>
                                                            <select class="w3-input w3-border w3-round" type="text"
                                                                name="status" required>
                                                                <?php
                                                                foreach (["On Time", "Delayed", "No Status"] as $option) {
                                                                    $selected = ($data["status"] == $option) ? "selected" : "";
                                                                    echo "<option value=\"$option\" $selected>$option</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <hr class="w3-clear">
                                                        <input type="hidden" name="schedule_id"
                                                            value="<?php echo $data["schedule_id"]; ?>">
                                                        <input type="hidden" name="act" value="edit">
                                                        <button type="submit"
                                                            class="w3-button w3-black w3-text-white w3-margin-bottom w3-round">SAVE
                                                            CHANGES</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="w3-padding-24"></div>
                                    </div>

                                    <div id="idDelete<?php echo $bil; ?>" class="w3-modal" style="z-index:10;">
                                        <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom"
                                            style="max-width:500px">
                                            <header class="w3-container ">
                                                <span
                                                    onclick="document.getElementById('idDelete<?php echo $bil; ?>').style.display='none'"
                                                    class="w3-button w3-large w3-circle w3-display-topright "><i
                                                        class="fa fa-fw fa-times"></i></span>
                                            </header>

                                            <div class="w3-container w3-padding">
                                                <form action="" method="post">
                                                    <div class="w3-padding"></div>
                                                    <b class="w3-large">Confirmation</b>
                                                    <hr class="w3-clear">
                                                    Are you sure to delete this record ?
                                                    <div class="w3-padding-16"></div>
                                                    <input type="hidden" name="schedule_id"
                                                        value="<?php echo $data["schedule_id"]; ?>">
                                                    <input type="hidden" name="act" value="del">
                                                    <button type="button"
                                                        onclick="document.getElementById('idDelete<?php echo $bil; ?>').style.display='none'"
                                                        class="w3-button w3-gray w3-text-white w3-margin-bottom w3-round">CANCEL</button>
                                                    <button type="submit"
                                                        class="w3-right w3-button w3-red w3-text-white w3-margin-bottom w3-round">YES,
                                                        CONFIRM</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Grid -->
        </div>
        <!-- End Page Container -->
    </div>
    <div class="w3-padding-24"></div>
</div>
<div id="add01" class="w3-modal">
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
        <header class="w3-container ">
            <span onclick="document.getElementById('add01').style.display='none'"
                class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
        </header>
        <div class="w3-container w3-padding">
            <form action="" method="post">
                <div class="w3-padding"></div>
                <b class="w3-large">Add Schedule</b>
                <hr>
                <div class="w3-section">
                    <label>Schedule Date *</label>
                    <input class="w3-input w3-border w3-round" type="date" name="schedule_date" value=""
                        min="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="w3-section">
                    <label>Departure Time *</label>
                    <input class="w3-input w3-border w3-round" type="time" name="depart_time" value="" required>
                </div>
                <div class="w3-section">
                    <label>Arrival Time *</label>
                    <input class="w3-input w3-border w3-round" type="time" name="arrival_time" value="" required>
                </div>
                <div class="w3-section">
                    <label>Location *</label>
                    <select class="w3-select w3-padding w3-padding-16 w3-border w3-round" type="text"
                        name="location" required>
                        <option value="" disabled selected hidden>Select Location</option>
                        <option value="LGK-KP">Langkawi - Kuala Perlis</option>
                        <option value="KP-LGK">Kuala Perlis - Langkawi</option>
                    </select>
                </div>
                <div class="w3-section">
                    <label>Status *</label>
                    <select class="w3-select w3-padding w3-padding-16 w3-border w3-round" type="text" name="status" required>
                        <?php
                        foreach (["On Time", "Delayed", "No Status"] as $option) {
                            echo "<option value=\"$option\">$option</option>";
                        }
                        ?>
                    </select>
                </div>
                <hr class="w3-clear">
                <div class="w3-section">
                    <input name="act" type="hidden" value="add">
                    <button type="submit"
                        class="w3-button w3-black w3-text-white w3-margin-bottom w3-round">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
    <div class="w3-padding-24"></div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            paging: false,
            searching: true
        });
    });

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
</script>

</body>
</html>
