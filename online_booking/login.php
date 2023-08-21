<?php
include 'init.php';
$pageTitle ="Login |Page";
include('inc/formsheader.php');


?>
<style>
    .password-container {
      position: relative;
    }

    .password-container .eye-icon {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #606f7d;
    }

    @media only screen and (max-width: 480px) {
      .password-container .eye-icon {
        font-size: 16px;
        position: absolute;
      top: 50%;
      right: 70px;
      transform: translateY(-50%);
      cursor: pointer;
      }
    }
  </style>
<div class="wrapper">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image" style="background-image:url('assets/img/twiftopp_logo.png'); background-color:rgb(200 209 204) !important;">
                <!-------Image-------->
                <img src="assets/img/topp.png" height="50" alt="logo" class="rounded-circle">
                <div class="text" class="py-3">
                   
                </div>
            </div>
            <div class="col-md-6 right">
                <form action="user_action.php" method="post">
                    <?php if (isset($_SESSION['error'])) { ?>
                        <div class="alert alert-danger" role="alert">
                               <?php echo $_SESSION['error']; ?>
                        </div>
                        
                    <?php } ?>
                    <div class="input-box">
                        <header>Login account</header>
                        <div class="input-field">
                            <input type="text" class="input" id="email" name="email" required autocomplete="off">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field password-container">
                            <input type="password" class="input" id="password" name="password" required>
                            <i id="eye-icon" class="fa fa-eye eye-icon" onclick="togglePasswordVisibility()"></i>
                            <label for="password">Password</label>
                        </div>
                        <div  style="margin-left:10px" class="p-1">
                        
                    </div>
                        <div class="input-field">
                            <input type="submit" class="submit" value="Sign in" name="login">

                        </div>
                        <div class="signin">
                            <span>Forgotten an account? <a href="reset_acc.php">Click here to Reset.</a></span>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
      var passwordInput = document.getElementById("password");
      var eyeIcon = document.getElementById("eye-icon");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
      } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
      }
    }
  </script>
<?php include('inc/formsfooter.php'); ?>