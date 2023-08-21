<?php
include 'init.php';
$pageTitle ="Reset Account|Verify";
include('inc/formsheader.php');
?>



<div class="wrapper">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image" style="background-image:url('assets/img/key.png');">
                <!-------Image-------->
                <img src="assets/img/topp.png" height="50" alt="" class="rounded-circle">
                <div class="text">
                    
                </div>
            </div>
            <div class="col-md-6 right">
                <form action="user_action.php" method="post">
                    <?php if (isset($message)) { ?>
                        <p>
                            <?php echo $message; ?>
                        </p>
                    <?php } ?>

                    <div class="input-box">
                        <header>
                            <p>Enter your email to reset your account</p>
                        </header>

                        <div class="input-field">
                            <input type="email" class="input" id="email" name=" email" required autocomplete="off">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field">
                            <input type="submit" class="submit" name="reset_password" value="Verify">

                        </div>
                        <div class="signin">
                            <span>Return back to <a href="login.php">Login</a></span>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>





<?php include('inc/formsfooter.php'); ?>