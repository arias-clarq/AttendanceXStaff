<?php
session_start();
$_SESSION['title'] = 'Employee Page';
include '../dashboard/header.php';
include '../../config/dbcon.php';
?>
<?php
include '../dashboard/nav.php';
?>
<div class="container mt-5 text-white">
    <h1 class="text-center mb-4">Dashboard</h1>
    <h4 id="system-time" class="text-center mb-4">System Time: </h4>
</div>
<script>
    // Function to update system time
    function updateSystemTime() {
        var systemTimeElement = document.getElementById('system-time');
        var now = new Date();
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
        var formattedTime = now.toLocaleDateString('en-US', options);
        systemTimeElement.textContent = 'System Time: ' + formattedTime;
    }

    // Update system time every second
    setInterval(updateSystemTime, 1000);

    // Initial call to update system time
    updateSystemTime();

    const API_URL = 'http://localhost/ims/api/employee/read.php?account_id=<?= $_SESSION['id'] ?>';
    function fetchData() {
        fetch(API_URL)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }
                return response.json();
            })
            .then(data => {
                const employeeNameCells = document.querySelectorAll('td#employeeName');
                const username = data.data[0].username; // Assuming only one username is returned
                employeeNameCells.forEach(cell => {
                    cell.textContent = username;
                });
            })
            .catch(error => console.error('Error fetching data:', error.message));
    }

    document.addEventListener('DOMContentLoaded', function () {
        fetchData();
    });
</script>

<!-- messages -->
<div class="row justify-content-center text-center">
    <?php
    if (isset($_SESSION["message"])) {
        ?>
        <div class="col-lg-3 alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>
                <?= $_SESSION["message"] ?>
            </strong>
        </div>
        <?php
    } else if (isset($_SESSION["e_message"])) { ?>
            <div class="col-lg-3 alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>
                <?= $_SESSION["e_message"] ?>
                </strong>
            </div>
    <?php }
    unset($_SESSION["message"]);
    unset($_SESSION["e_message"]);
    ?>
</div>
<?php
    date_default_timezone_set('Asia/Manila');
    $currentDate = date("Y-m-d");
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM `tbl_attendance` WHERE `employeeID` = '$id' AND `date` = '$currentDate' AND timeOut is not null";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['isTimein'] = true;
        $_SESSION['isTimeOut'] = true;
    }
?>
<div class="row justify-content-center">
    <div class="col-lg-1">
        <form action="../../config/attendance.php" method="post">
            <div class="card-body text-center">
                <input type="text" value="<?= $_SESSION['id'] ?>" name="EmployeeID" class="form-control" hidden>
                <button name="btn_timein" type="submit" class="btn btn-success btn-lg btn-block" <?= (isset($_SESSION['isTimein']) == true) ? 'disabled' : '' ?>>Time In</button>
            </div>
        </form>
    </div>

    <div class="col-lg-1">
        <form action="../../config/attendance.php" method="post">
            <div class="card-body text-center">
                <input type="text" value="<?= $_SESSION['id'] ?>" name="EmployeeID" class="form-control" hidden>
                <button name="btn_timeout" type="submit" class="btn btn-danger btn-lg btn-block" <?= (isset($_SESSION['isTimeOut']) == true) ? 'disabled' : '' ?>>Time Out</button>
            </div>
        </form>
    </div>
</div>

<div class="row justify-content-center mt-5 text-white">
    <div class="col-lg-6">
        <h2 class="text-center">Your Attendance</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Username</th>
                    <th>Time-In</th>
                    <th>Time-Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $id = $_SESSION['id'];
                $sql = "SELECT * FROM `tbl_attendance` 
                INNER JOIN tbl_status ON tbl_attendance.statusID = tbl_status.statusID
                WHERE tbl_attendance.employeeID = {$id};";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $timein = strtotime($row['timeIn']);
                    if ($row['timeOut'] != null) {
                        $timeout = strtotime($row['timeOut']);
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td>
                            <?= $row['date'] ?>
                        </td>
                        <td id="employeeName"></td>
                        <td>
                            <?= date('h:i A', $timein) ?>
                        </td>
                        <td>
                        <?= ($row['timeOut'] != null) ? date('h:i A', $timeout) : 'Pending..' ?>
                        </td>
                        <td>
                            <?= $row['status'] ?>
                        </td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>

</div>
<?php
include '../dashboard/footer.php';
?>