<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//echo getcwd();


echo '<div>
    <div class="dashboard">
        <div class="member-dashboard">Welcome <b>' . $_SESSION['userDisplayName'] . '</b> 
        . You have successfully logged in!<br>
            <a href="../views/ViewTimesheetNew.php?action=newtimesheet" class="logout-button">New timesheet    |    </a>
            <a href="../views/ViewTimesheetsSummary.php" class="logout-button">All timesheets    |    </a>
            <a href="../../action/ActionLogout.php" class="logout-button">Logout</a><br>

        </div>
    </div>
</div>';

?>