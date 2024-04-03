<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Attendance x Employee System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav ms-auto">
                <?php
                if ($_SESSION['user_role'] == 'Admin') {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link me-3" href="user_mgt.php"><i class="fa-solid fa-users fa-xl"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Users Management"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-3" href="attendance_monitoring.php"><i
                                class="fa-solid fa-clipboard-user fa-2xl" data-bs-toggle="tooltip" data-bs-placement="left"
                                title="Attendance Monitoring"></i></a>
                    </li>
                    <?php
                } else { ?>
                    <li class="nav-item">
                        <button class="btn nav-link" data-bs-toggle="modal" data-bs-target="#profileModal">
                            <i class="fa-solid fa-user fa-xl" data-bs-toggle="tooltip" data-bs-placement="left"
                                title="Profile"></i>
                        </button>
                    </li>
                    <?php
                }
                ?>
            </ul>

            <button class="btn bottom-icon" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fa-solid fa-lg fa-right-from-bracket text-danger" data-bs-toggle="tooltip"
                    data-bs-placement="left" title="Logout"></i>
            </button>

            <!-- Logout Modal -->
            <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true"
                data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="loginModalLabel">Logout</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5>Are you sure you want to logout?</h5>
                        </div>
                        <div class="modal-footer">

                            <a href="../../index.php" type="submit" class="btn btn-success">Confirm</a>

                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>