<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance X Staff</title>
    <?php
        include 'assets/bootstrap.php';
        include 'assets/fontawesome.php';
    ?>
</head>

<body>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('loginForm').addEventListener('submit', async function (event) {
                event.preventDefault();
                const formData = new FormData(this);

                try {
                    const response = await fetch('config/login.php', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        if (data.role === 'Admin') {
                            window.location.href = 'page/admin/dashboard.php';
                        } else if (data.role === 'Employee') {
                            window.location.href = 'page/employee/dashboard.php';
                        }
                    } else {
                        const errorMessage = document.getElementById('errorMessage');
                        errorMessage.textContent = 'Incorrect Username or Password';
                        errorMessage.style.display = 'block';
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>

    <style>
        .gradient-custom {
            background: #6a11cb;
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
    </style>

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">Attendance X Employee System</h2>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>

                                <!-- login error messages -->
                                <div class="container">
                                    <div id="errorMessage" class="alert alert-danger" style="display: none;">
                                        <strong>Incorrect Username or Password</strong>
                                    </div>
                                </div>

                                <form id="loginForm" method="post">
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" class="form-control form-control-lg"
                                            placeholder="Enter Username" name="username" />
                                        <label class="form-label">Username</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" placeholder="Enter Password"
                                            class="form-control form-control-lg" name="password" />
                                        <label class="form-label">Password</label>
                                    </div>
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    session_unset();
    include ("assets/template/footer.php");
    ?>
</body>

</html>
