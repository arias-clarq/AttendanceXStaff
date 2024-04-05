<?php
    session_start();
    $_SESSION['title'] = 'Admin Page';
    include '../dashboard/header.php';
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
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric'};
        var formattedTime = now.toLocaleDateString('en-US', options);
        systemTimeElement.textContent = 'System Time: ' + formattedTime;
    }

    // Update system time every second
    setInterval(updateSystemTime, 1000);

    // Initial call to update system time
    updateSystemTime();
</script>
<?php 
    include '../dashboard/footer.php';
?>