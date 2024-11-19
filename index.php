<?php
// Include database connection and validation functions
include('functions.php');

$loginMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $errors = [];

    // Check for empty fields and collect errors
    if (empty($email) && !empty($password)) {
        $errors[] = "Email is required";
        $errors[] = "Invalid password";
    } else if (!empty($email) && empty($password)) {
        $errors[] = "Invalid Email";
        $errors[] = "Password is required";
    } else {
        if (empty($email)) {
            $errors[] = "Email is required";
        }
        if (empty($password)) {
            $errors[] = "Password is required";
        }
    }


    // If there are errors, display them
    if (!empty($errors)) {
        $errorList = "";
        foreach ($errors as $error) {
            $errorList .= "<li>" . htmlspecialchars($error) . "</li>";
        }
        $loginMessage = "<div class='alert alert-danger'>
                            <strong>System Errors</strong>
                            <ul class='mb-0'>$errorList</ul>
                         </div>";
    } else {
        // Check if the entered credentials match the default admin
        if (validateAdmin($email, $password)) {
            $loginMessage = "<div class='alert alert-success'>Login successful! Welcome Admin.</div>";
            // Redirect to admin dashboard
            header("Location: ../admin/dashboard.php");
            exit();
        } else {
            // Query to check user credentials for regular users
            $result = validateUser($email, $password);

            if ($result->num_rows > 0) {
                // Login successful for regular user
                $loginMessage = "<div class='alert alert-success'>Login successful! Welcome.</div>";
            } else {
                // Login failed for regular user
                $loginMessage = "<div class='alert alert-danger'>Invalid email or password.</div>";
            }
        }
    }
}

// Close the database connection
closeDbConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
</head>

<body class="bg-secondary-subtle">
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="col-3">
            <!-- Server-Side Validation Messages -->
            <?php echo $loginMessage; ?>
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-4 fw-normal">Login</h1>
                    <form method="post" action="">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="email" name="email" placeholder="user1@example.com">
                            <label for="email">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            <label for="password">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>