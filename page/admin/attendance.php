<?php
session_start();
$_SESSION['title'] = 'Monitoring Page';
include '../../config/dbcon.php';
include '../dashboard/header.php';
?>
<?php
include '../dashboard/nav.php';

// Initialize variables to store form inputs
$month = isset($_GET['month']) ? $_GET['month'] : '';
$usernameFilter = isset($_GET['username']) ? $_GET['username'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Fetch data from the API URL
$api_url = 'http://localhost/ims/api/employee/read.php';
$json = file_get_contents($api_url);
$data = json_decode($json, true);

?>

<div class="row mt-5 d-flex justify-content-center text-white fw-bold">
    <div class="col-lg-10 mb-3">
        <form action="" method="get">
            <div class="row">
                <div class="col">
                    <label for="">Sort By Month</label>
                    <input class="form-control" type="month" id="month" name="month">

                    <script>
                        // Get the input element
                        const monthInput = document.getElementById('month');

                        // Set the max and min attributes to the current month
                        const today = new Date();
                        const year = today.getFullYear();
                        const month = today.getMonth() + 1; // Months are 0-indexed
                        const formattedMonth = month < 10 ? `0${month}` : month; // Add leading zero if needed
                        const maxDate = `${year}-${formattedMonth}`;

                        monthInput.setAttribute('max', maxDate);
                    </script>
                </div>

                <div class="col">
                    <label for="">Sort By Username</label>
                    <input placeholder="Enter username" class="form-control" type="text" name="username" value="<?= $usernameFilter ?>">
                </div>

                <div class="col">
                    <label for="">Sort By Status</label>
                    <select name="status" class="form-select">
                        <option disabled selected>Select a Section</option>
                        <option value="1">PRESENT</option>
                        <option value="2">LATE</option>
                        <option value="3">ABSENT</option>
                    </select>
                </div>
                <div class="col align-self-end">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-10 mb-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Date</th>
                    <th>TimeIn</th>
                    <th>TimeOut</th>
                    <th>Status</th>
                    <th>Workhours</th>
                    <th>Start Shift</th>
                    <th>WorkTime_Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data['data'] as $employee) {
                    // Check if the employee matches the filter criteria
                    $id = $employee['account_id'];
                    $username = $employee['username'];
                    // Apply username filter
                    if (!empty($usernameFilter) && $username !== $usernameFilter) {
                        continue;
                    }
                    $sql = "SELECT * FROM `tbl_attendance`
                        INNER JOIN tbl_workhours ON tbl_attendance.workhoursID = tbl_workhours.workhoursID 
                        INNER JOIN tbl_status ON tbl_attendance.statusID = tbl_status.statusID
                        INNER JOIN tbl_worktime_status ON tbl_attendance.worktime_statusID = tbl_worktime_status.worktime_statusID
                        WHERE tbl_attendance.employeeID = {$id} ";

                    // Apply filters if provided
                    if (!empty($month)) {
                        // Extract month and year from the selected month
                        $selected_month = date('m', strtotime($month));
                        $selected_year = date('Y', strtotime($month));
                        // Compare month and year with the date in the database
                        $sql .= "AND MONTH(tbl_attendance.date) = $selected_month ";
                        $sql .= "AND YEAR(tbl_attendance.date) = $selected_year ";
                    }

                    if (!empty($status)) {
                        $sql .= "AND tbl_attendance.statusID = $status ";
                    }

                    $sql .= "ORDER BY tbl_attendance.date DESC"; // You can modify the sorting as per your requirement
                
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Display table rows based on filtered data
                            ?>
                            <tr>
                                <td></td>
                                <td>
                                    <?= $username ?>
                                </td>
                                <td>
                                    <?= date('F j, Y', strtotime($row['date'])) ?>
                                </td>
                                <td>
                                    <?= ($row['timeOut'] != null) ? date('h:i A', strtotime($row['timeIn'])) : 'No Data' ?>
                                </td>
                                <td>
                                    <?= ($row['timeOut'] != null) ? date('h:i A', strtotime($row['timeOut'])) : 'No Data' ?>
                                </td>
                                <td>
                                    <?= $row['status'] ?>
                                </td>
                                <td>
                                    <?= $row['workhours'] ?> Hours
                                </td>
                                <td>9 AM</td>
                                <td>
                                    <?= $row['worktime_status'] ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include '../dashboard/footer.php';
?>
