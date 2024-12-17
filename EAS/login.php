<?php
session_start();
if (isset($_SESSION['login'])) {
    header('Location: siswa/dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="bg-primary">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <!-- Login Form Container -->
        <div class="col-6 border border-end rounded bg-light">
            <div class="card-body">
                <h3 class="text-center fw-bold mt-5">Login</h3>
                <form method="post" action="login_proccess.php">
                    <!-- Email Input -->
                    <div class="ms-5 me-5"> 
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>

                    <!-- Password Input -->
                    <div class="ms-5 me-5">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control mb-4" id="exampleInputPassword1" required>
                    </div>

                    <!-- Submit Button and Signup Link -->
                    <div class="mb-5 ms-5 me-5">
                        <button type="submit" class="btn btn-outline-primary w-100">Login</button>
                        <div id="Signup" class="form-text text-center mt-3 w-100">
                            Doesn't have an account? <a class="text-primary" href="register.php">Signup here</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
