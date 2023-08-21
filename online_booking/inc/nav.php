<div class="main-container d-flex">
    <!-- sidbar menu -->
    <div class="sidebar" id="side_nav">
        <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between">
            <h1 class="fs-4">
                <span class="bg-white text-dark rounded shadow px-2 me-2">Club </span><span
                    class="text-white">House</span>
            </h1>

            <!-- close btn -->
            <button class="btn d-md-none d-block close-btn px-1 py-0 text-white ">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
        </div>

        <ul class="list-unstyled px-2">
            <li class="active"><a href="index.php" class="text-decoration-none px-3 py-2 d-block"><i
                        class="fa-solid fa-house"></i> Dashboard</a></li>
            <li class="">
                <a href="request.php" class="text-decoration-none px-3 py-2 d-block">
                    <i class="fa-solid fa-code-pull-request"></i> Request</a>
            </li>
            <li class=""><a href="view_request.php" class="text-decoration-none px-3 py-2 d-block"><i
                        class="fa-solid fa-bookmark"></i> All Requests
                </a></li>
            <?php if ($_SESSION['user_type'] == 'admin'): ?>
                <li class=""><a href="menu.php" class="text-decoration-none px-3 py-2 d-block">
                        <i class="fa fa-cutlery" aria-hidden="true"></i> Manage Menu
                    </a></li>
                <li class=""><a href="users.php" class="text-decoration-none px-3 py-2 d-block"><i
                            class="fa-solid fa-user"></i>
                        Users</a></li>

                <li class=""><a href="department.php" class="text-decoration-none px-3 py-2 d-block"><i
                            class="fa-solid fa-restroom"></i> Department</a></li>

            </ul>
             <hr class="line text-white">


            <ul class="list-unstyled px-2 ">
                <li class="">
                    <a href="people.php" class="text-decoration-none px-3 py-2 d-block">
                        <i class="fa fa-database" aria-hidden="true"></i>
                        Manage People
                    </a>
                </li>


                <li class="">
                    <?php
                    // Assuming you have created an instance of the Request class named $request
                    $totalWhilelistRequests = $request->countWhilelistRequests();
                    ?>
                    <a href="todo.php" class="text-decoration-none px-3 py-2 d-block">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        Todo <button class="btn btn-secondary">
                            <span class="badge badge-light rounded-pill bg-dark"><?php echo $totalWhilelistRequests; ?></span>
                        </button>
                    </a>
                </li>
            <?php endif; ?>
            <li class="">
                <a href="message.php" class="text-decoration-none px-3 py-2 d-block "><i class="fa-solid fa-bell"></i>
                    Notification

                    <button type="button" class="btn btn-info position-relative">
                        Inbox
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <p class="card-text ">
                                <?php if ($_SESSION['user_type'] == 'user'): ?>
                                    <?php

                                    $requesterId = $_SESSION['user_id'];
                                    $numRejectedRequests = $request->countRejectedRequests($requesterId);
                                    ?>
                                    <?= $numRejectedRequests ?>
                                <?php else: ?>
                                    <?php
                                    $numPendingRequests = $request->countAllPendingRequests();
                                    ?>
                                    <?= $numPendingRequests ?>
                                <?php endif; ?>
                                <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                </a>
            </li>
            <li class="">
                <a href="logout.php" class="text-decoration-none px-3 py-2 d-block" name="logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </li>
        </ul>
        <div class="clas p-3">
            <hr class="line text-white">
            <p class="lead text-white" style="font-size:12px">ORS-TOPP &copy; 2023. V1.0.0</p>
            <hr class="line text-white">
        </div>

    </div>
    <!-- main content -->
    <div class="content">
        <!-- top nav bar -->
        <nav class="navbar navbar-expand-md bg-body-tertiary">
            <div class="container-fluid">
                <div class="d-flex justify-content-between d-md-none d-block">

                    <button class="btn py-1 py-0 open-btn me-2">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                    <a class="navbar-brand fs-4" href="#"><span
                            class="bg-dark rounded px-2 py-0 text-white">CH</span></a>

                </div>
                <button class="navbar-toggler shadow-none p-0 border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-list"></i>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="profile.php">
                                <span class="mx-3">
                                    <?php echo $_SESSION['user_details']['name']; ?>
                                </span>
                                <i class="fa-solid fa-user"></i>
                                Profile</a>
                        </li>

                    </ul>

                </div>
            </div>
        </nav>

        <!-- top nav ends -->