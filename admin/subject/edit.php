<?php
include '../../functions.php'; // Include the functions
include '../partials/header.php';

$logoutPage = '../logout.php';
$dashboardPage = '../dashboard.php';
$subjectPage = './add.php';
include '../partials/side-bar.php';

?>
<div class="col-md-9 col-lg-10">

    <h3 class="text-left mb-5 mt-5">Edit Subject</h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
            </ol>
        </nav>
        <?php
        include '../partials/footer.php';

        ?>