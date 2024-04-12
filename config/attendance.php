<?php
session_start();
include 'dbcon.php';
date_default_timezone_set('Asia/Manila');

$id = $_SESSION['id'];
$currentDate = date("Y-m-d");
$currentTime = date("H:i:s");

// Define the job start time (9:00 AM in this example)
$jobStartTime = strtotime("09:00:00");
// Define the job end time (5:00 PM in this example)
$jobEndTime = strtotime("17:00:00");

// Define the cutoff time for marking an employee as absent (e.g., midnight)
$cutoffTime = strtotime("23:59:59"); // Midnight

// Fetch employee data from the API

if (isset($_POST['btn_timein'])) {

    $sql = "INSERT INTO `tbl_attendance`(`employeeID`, `date`,`timeIn`,`workhoursID`,`statusID`) VALUES ('{$id}','{$currentDate}','{$currentTime}',1,";
    // Check if the current time is after the job start time
    if (strtotime($currentTime) > $jobStartTime) {
        // Late
        $sql .= "2)"; // StatusID = 2 for "late"
    } else {
        // On time
        $sql .= "1)"; // StatusID = 1 for "present"
    }
    $result = $conn->query($sql);
    $_SESSION['attendanceID'] = $conn->insert_id;

    // Fetch the employee's time in for the current date
    $sql = "SELECT `timeIn` FROM `tbl_attendance` WHERE `employeeID` = '$id' AND `date` = '$currentDate'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $timeIn = strtotime($row['timeIn']);

        // Calculate the work duration
        $workDuration = strtotime($currentTime) - $timeIn;

        // Check if it's normal work time, overtime, or undertime
        if ($workDuration >= ($jobEndTime - $jobStartTime)) {
            $worktime_statusID = 2; // Overtime
        } elseif ($workDuration < ($jobEndTime - $jobStartTime)) {
            $worktime_statusID = 3; // Undertime
        } else {
            $worktime_statusID = 1; // Normal work time
        }

        // Update the attendance record with the worktime_statusID
        $sql = "UPDATE `tbl_attendance` SET `worktime_statusID` = $worktime_statusID WHERE `employeeID` = '$id' AND `date` = '$currentDate'";
        $result2 = $conn->query($sql);
    }

    if ($result) {
        $_SESSION['message'] = "Time in successfully";
        $_SESSION['isTimein'] = true;
        header('location: ../page/employee/dashboard.php');
    }
}

if (isset($_POST['btn_timeout'])) {

    $attendanceID = $_SESSION['attendanceID'];

    $sql = "UPDATE `tbl_attendance` SET `timeOut`='{$currentTime}' WHERE `attendanceID` = $attendanceID";
    $result = $conn->query($sql);

    if ($result) {
        $_SESSION['message'] = "Time Out successfully";
        $_SESSION['isTimeOut'] = true;
        header('location: ../page/employee/dashboard.php');
    } else {
        $_SESSION['e_message'] = "Time In First";
        header('location: ../page/employee/dashboard.php');
    }
}

// $API_URL = 'http://localhost/ims/api/employee/read.php';
// $json = file_get_contents($API_URL);
// $data = json_decode($json, true);

// // Iterate over each employee data
// foreach ($data['data'] as $employee) {
//     $employeeID = $employee['account_id'];
//     $role = $employee['login_role'];

//     if ($role == 'Employee') {
//         // Check if the employee has already been marked as present for the current date
//         $sql = "SELECT * FROM `tbl_attendance` WHERE `employeeID` = '$employeeID' AND `date` = '$currentDate'";
//         $result = $conn->query($sql);

//         // If the employee has not been marked present for the current date, mark them as absent
//         if ($result->num_rows == 0) {
//             // Check if it's past the cutoff time (e.g., midnight)
//             if (strtotime($currentTime) > $cutoffTime) {
//                 $statusID = 3; // StatusID = 3 for "absent"
//             }else if(strtotime($currentTime) < $cutoffTime){
//                 $statusID = 2;
//             }
//             // Insert a new entry into tbl_attendance
//             $sql = "INSERT INTO `tbl_attendance`(`employeeID`, `date`, `statusID`) VALUES ('$employeeID', '$currentDate', $statusID)";
//             $conn->query($sql);
//         }
//     }
// }
?>