<?php
include '../../functions.php'; // Include the functions
include '../partials/header.php';

$logoutPage = '../logout.php';
$dashboardPage = '../dashboard.php';
$subjectPage = './add.php';
include '../partials/side-bar.php';

// Fetch subject data based on subject_code passed in the URL
$subject_data = getSubjectCode($_GET['subject_code']);
if (!$subject_data) {
    echo "<p class='text-danger'>Subject not found.</p>";
    exit;
}

$errors = []; // Initialize an empty array for errors
$subject_name = $subject_data['subject_name']; // Default value

if (isPost()) {
    $subject_code = $subject_data['subject_code']; // Use existing subject_code
    $subject_name = trim(postData('subject_name')); // Get the new subject name from the form

    // Validate the input
    if (empty($subject_name)) {
        $errors['subject_name'] = "Please fill out this field.";
    }

    // Proceed if no validation errors
    if (empty($errors)) {
        $result = EditSubject($subject_code, $subject_name, "./add.php");
        if ($result !== true) {
            $errors[] = $result; // Add any database error to the error array
        } else {
            // Redirect handled in EditSubject function
            exit;
        }
    }
}
?>

<div class="col-md-9 col-lg-10">
    <h3 class="text-left mb-5 mt-5">Edit Subject</h3>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
        </ol>
    </nav>

    <!-- Display System Errors -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <h5 class="alert-heading">System Errors</h5>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form to edit subject -->
    <div class="card p-4 mb-5">
        <form method="POST" action="">
            <div class="form-group">
                <label for="subject_code">Subject Code</label>
                <input type="text" class="form-control" id="subject_code" name="subject_code"
                    value="<?= htmlspecialchars($subject_data['subject_code']) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="subject_name">Subject Name</label>
                <input type="text"
                    class="form-control <?= isset($errors['subject_name']) ? 'is-invalid' : '' ?>"
                    id="subject_name" name="subject_name"
                    value="<?= htmlspecialchars($subject_name) ?>"
                    required>
                <?php if (isset($errors['subject_name'])): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($errors['subject_name']) ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Update Subject</button>
        </form>
    </div>
</div>

<?php include '../partials/footer.php'; ?>