<?php
session_start();
$_SESSION['title'] = 'User MGT';
include '../dashboard/header.php';
?>
<?php
include '../dashboard/nav.php';
?>

<script>

    const API_URL = 'http://localhost/ims/api/employee/read.php';

    function fetchData() {
        fetch(API_URL)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }
                return response.json();
            })
            .then(data => {
                // Clear previous data
                const userInfoTable = document.getElementById('userInfo');
                userInfoTable.innerHTML = ''; // Clearing the table

                // Loop through the data and create table rows
                let tableRows = '';
                data.data.forEach((employee, index) => {
                    const employeeInfo = employee.employee_info;

                    // Formatting data for display
                    const formattedData = {
                        account_id: employee.account_id,
                        username: employee.username,
                        password: employee.password,
                        loginRole: employee.login_role,
                        // You can format other fields similarly
                    };

                    const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${formattedData.username}</td>
                        <td>${formattedData.password}</td>
                        <td>${formattedData.loginRole}</td>
                        <td>                                               
                            <div class="d-flex">
                                <!-- Edit Button -->
                                <button class="btn btn-warning me-2 form-control fw-bold" data-bs-toggle="modal" data-bs-target="#editModal${formattedData.account_id}">
                                    Edit
                                </button>
                                <?php include 'modals/edit.php'; ?>

                                <!-- Delete Form -->
                                <form id="deleteEmployee${formattedData.account_id}">
                                    <button class="btn btn-danger">Delete</button>
                                    <input type="hidden" value="${formattedData.account_id}" name="id">
                                </form>
                            </div>
                        </td>
                    </tr>
                `;
                    tableRows += row;
                });

                // Append all rows to the table body at once
                userInfoTable.innerHTML = tableRows;

                // Select correct option in edit modal
                data.data.forEach(employee => {
                    const formattedData = {
                        account_id: employee.account_id,
                        loginRole: employee.login_role
                    };
                    const editModal = document.getElementById(`editModal${formattedData.account_id}`);
                    if (editModal) {
                        const selectElement = editModal.querySelector('select[name="login_role"]');
                        if (selectElement) {
                            // Set the selected attribute based on the login role
                            const options = selectElement.options;
                            for (let i = 0; i < options.length; i++) {
                                if (options[i].value === formattedData.loginRole) {
                                    options[i].selected = true;
                                }
                            }
                        }
                    }
                });

                // Add this script after the existing JavaScript code
                data.data.forEach(employee => {
                    const formattedData = {
                        account_id: employee.account_id,
                        loginRole: employee.login_role
                    };

                    const editModal = document.getElementById(`editModal${formattedData.account_id}`);
                    if (editModal) {
                        const editForm = editModal.querySelector('form#editEmployee');
                        if (editForm) {
                            editForm.addEventListener('submit', function (event) {
                                event.preventDefault(); // Prevent form submission

                                // Collect form data
                                const formData = new FormData(this);

                                // Convert FormData to JSON object
                                const jsonData = {};
                                formData.forEach((value, key) => {
                                    jsonData[key] = value;
                                });

                                // Get the account_id from the form data
                                const account_id = formData.get('account_id');

                                // Send data to the API endpoint using Fetch API
                                fetch(`http://localhost/ims/api/employee/update.php?account_id=${account_id}`, {
                                    method: 'PUT', // Use the PUT method
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify(jsonData)
                                })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Failed to update employee');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        console.log('Employee updated successfully:', data);
                                        window.location.reload();
                                    })
                                    .catch(error => console.error('Error updating employee:', error.message));
                            });
                        }
                    }
                });

                data.data.forEach(employee => {
                    const formattedData = {
                        account_id: employee.account_id
                    };

                    const deleteForm = document.getElementById(`deleteEmployee${formattedData.account_id}`);
                    if (deleteForm) {
                        deleteForm.addEventListener('submit', function (event) {
                            event.preventDefault(); // Prevent form submission

                            const formData = new FormData(this);
                            const account_id = formData.get('id');

                            // Send request to delete the employee
                            fetch(`http://localhost/ims/api/employee/delete.php?account_id=${account_id}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Failed to delete employee');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Employee deleted successfully:', data);
                                    showSuccessMessage('Employee deleted successfully');
                                    window.location.reload();
                                })
                                .catch(error => {
                                    console.error('Error deleting employee:', error.message);
                                    showErrorMessage('Error deleting employee');
                                });
                        });
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error.message));
    }
    // Call fetchData function when the page loads
    window.onload = fetchData;
</script>

<div class="container mt-5">
    <h2 class='text-white'>Users Management</h2>
    <div id="message"></div>
    <table class="table table-hover">
        <thead>
            <tr>
                <form id="addNewEmployee">
                    <th></th>
                    <th><input class="form-control" placeholder="Enter username" type="text" name="username" required>
                    </th>
                    <th><input class="form-control" placeholder="Enter password" type="text" name="password" required>
                    </th>
                    <th>
                        <select name="login_role" class="form-select">
                            <option value="Admin">Admin</option>
                            <option value="Employee">Employee</option>
                        </select>
                    </th>
                    <th>
                        <button class="btn btn-success" type="submit">Add</button>
                    </th>
                </form>

                <script>
                    const API_URL_CREATE = 'http://localhost/ims/api/employee/create.php';

                    document.getElementById('addNewEmployee').addEventListener('submit', function (event) {
                        event.preventDefault(); // Prevent form submission

                        // Collect form data
                        const formData = new FormData(this);

                        // Convert FormData to JSON object
                        const jsonData = {};
                        formData.forEach((value, key) => {
                            jsonData[key] = value;
                        });

                        // Send data to the API endpoint using Fetch API
                        fetch(API_URL_CREATE, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(jsonData)
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Failed to add employee');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Employee added successfully:', data);
                                window.location.reload();
                            })
                            .catch(error => console.error('Error adding employee:', error.message));
                    });
                </script>
            </tr>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Password</th>
                <th>Login Role</th>
                <th></th>
            </tr>
        </thead>
        <tbody id='userInfo'>

        </tbody>
    </table>
</div>
<?php
include '../dashboard/footer.php';
?>