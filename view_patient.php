<?php
require_once "includes/header.php"
?>
<?php
if (isset($_GET['id'])) {
    // Retrieve patient ID from the URL
    $patientId = $_GET['id'];

    // Fetch patient details
    $fetchPatientQuery = "SELECT * FROM patients WHERE patient_id = :patientId";
    $stmt = $conn->prepare($fetchPatientQuery);
    $stmt->bindParam(':patientId', $patientId, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

    // Fetch patient details as an associative array
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the statement and database connection
    $stmt = null;
    $conn = null;
} else {
    // Redirect to a page indicating that the patient ID is missing
    header("Location: index.php");
    exit();
}
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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">View Patient Details</h1>
                        <a href="add_new_patient.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user fa-sm text-white-50"></i> Add New Patient</a>
                    </div>

                    <!-- Content Row -->

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><?= $patient['first_name']; ?>'s information</h6>
                        </div>
                        <div class="card-body">
                            <div>
                                <?php if ($patient) : ?>
                                    <p><strong>First Name:</strong> <?= $patient['first_name']; ?></p>
                                    <p><strong>Last Name:</strong> <?= $patient['last_name']; ?></p>
                                    <p><strong>Age:</strong> <?= calculateAge($patient['dob']); ?></p>
                                    <p><strong>Gender:</strong> <?= $patient['gender']; ?></p>
                                    <p><strong>Email:</strong> <?= $patient['email']; ?></p>
                                    <p><strong>Phone:</strong> <?= $patient['phone_number']; ?></p>
                                    <p><strong>Address:</strong> <?= $patient['address']; ?></p>
                                    <p><strong>Registered Date:</strong> <?= $patient['registration_date']; ?></p>
                                <?php else : ?>
                                    <p>Patient not found.</p>
                                <?php endif; ?>
                            </div>

                        </div>
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