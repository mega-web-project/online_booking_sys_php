<?php
include 'init.php';
$pageTitle ="Reset |Password";
include('inc/formsheader.php');


?>

<div class="wrapper">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image" style="background-image:url('assets/img/key.png');">
                <!-------Image-------->
                <img src="assets/img/topp.png" height="50" alt="" class="rounded-circle">
                <div class="text" class="py-3">
                    
                </div>
            </div>
            <div class="col-md-6 right">
                <form action="user_action.php" method="post">
                    <div class="input-box">
                        <header>Password Reset</header>
                        <div class="input-field">
                            <input type="text" class="input" id="email" name="email" required autocomplete="off">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field">
                            <input type="password" class="input" id="password" name="Newpassword" required>
                            <label for="password">New Password</label>
                        </div>
                        <div class="input-field">
                            <input type="submit" class="submit" value="reset" name="Reset">

                        </div>
                       
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('inc/formsfooter.php'); ?>