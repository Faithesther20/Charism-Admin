<?php
include "connection.php";
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
  // Redirect to the dashboard page
  header("Location: dashboard.php");
  exit;
}

// Check if the login form is submitted
if (isset($_POST['login'])) {
  // Perform your login validation here
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Prepare and execute the SQL statement
  $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND isAdmin = 'true' ");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if the user exists and is an admin
  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Simulating a successful login
    $_SESSION['user_id'] = $row['id'];

    // Redirect to the dashboard page
    header("Location: dashboard.php");
    exit;
  }

  // Invalid login credentials
  $error = "Invalid email or password";

  // Close the database connection
  $stmt->close();
  $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Soft UI Dashboard by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
          <div class="container-fluid pe-0">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="../pages/dashboard.html">
              Charism Admin Dashboard
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto ms-xl-auto me-xl-7">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="../pages/dashboard.html">
                    <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                    Dashboard
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="../pages/profile.html">
                    <i class="fa fa-user opacity-6 text-dark me-1"></i>
                    Profile
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="../pages/sign-up.html">
                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                    Sign Up
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="../pages/sign-in.html">
                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                    Sign In
                  </a>
                </li>
              </ul>
              <li class="nav-item d-flex align-items-center">
                <a class="btn btn-round btn-sm mb-0 btn-outline-primary me-2" target="_blank" href="https://www.creative-tim.com/builder?ref=navbar-soft-ui-dashboard">get in touch</a>
              </li>
              <ul class="navbar-nav d-lg-block d-none">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/product/soft-ui-dashboard" class="btn btn-sm btn-round mb-0 me-1 bg-gradient-dark">Download app</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
                  <p class="mb-0">Enter your email and password to sign in</p>
                </div>
                <div class="card-body">
                    <form role="form" method="POST">
                      <label>Email</label>
                      <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                      </div>
                      <label>Password</label>
                      <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                      <div class="text-center">
                        <button type="submit" name="login" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
                      </div>
                    </form>
                  </div>
                  <div class="card-footer text-center pt-0 px-lg-2 px-1">
                    <p class="mb-4 text-sm mx-auto">
                      Don't have an account?
                      <a href="javascript:;" class="text-info text-gradient font-weight-bold">Sign up</a>
                    </p>
                    <?php if (isset($error)): ?>
                    <p class="mb-4 text-sm mx-auto text-danger">
                      <?php echo $error; ?>
                    </p>
                    <?php endif; ?>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/curved-images/curved6.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <footer class="footer py-5">
    <div class="container">
      
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> Digisoft IT
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>