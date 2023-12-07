<?php
require_once "includes/header.php"
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        require_once "includes/sidebar.php"
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                require_once "includes/navbar.php"
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="container">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Add New Patient</h1>
                        </div>

                        <!-- Content Row -->


                        <form class="user" action="" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="fullName" name="name" placeholder="Full Name" required>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="address" name="address" placeholder="Address" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" id="phone" name="phone" placeholder="Phone number" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Email" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control form-control-user" id="dob" name="dob" placeholder="Date of birth" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block" name="add_new_patient">
                                Add New Patient
                            </button>
                        </form>
                    </div>



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
            require_once "includes/footernote.php"
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php
    require_once "includes/footer.php"
    ?>

</body>

</html>