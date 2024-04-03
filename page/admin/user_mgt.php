<?php
session_start();
$_SESSION['title'] = 'User MGT';
include '../dashboard/header.php';
?>
<?php
include '../dashboard/nav.php';
?>

<script>
    const API_URL = 'https://cyber-techo.000webhostapp.com/config/api.php';
    // Function to fetch data from the API
    function fetchData() {
        fetch(API_URL)
            .then(response => response.json())
            .then(data => {
                // Clear previous data
                document.getElementById('userInfo').innerHTML = '';

                // Loop through the data and create table rows
                data.forEach((item, index) => {
                    const employee = item.employee;
                    const employeeInfo = employee.employee_info;

                    const row = `<tr>
                                    <td>${index + 1}</td>
                                    <td>${employee.username}</td>
                                    <td>${employee.password}</td>
                                    <td>${employee.login_role}</td>
                                    <td>
                                        <!-- Add any action buttons here -->
                                    </td>
                                </tr>`;

                    // Append row to the table body
                    document.getElementById('userInfo').innerHTML += row;
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Call fetchData function when the page loads
    window.onload = fetchData;
</script>

<div class="container mt-5">
    <h2 class='text-white'>Users Management</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Password</th>
                <th>Login Role</th>
                <th>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fa-solid fa-user-plus"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody id='userInfo'>

        </tbody>
    </table>
</div>
<?php
include '../dashboard/footer.php';
?>