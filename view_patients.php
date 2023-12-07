<?php
require_once "includes/header.php"
?>
<?php
// Fetch all patients
$fetchPatientsQuery = "SELECT * FROM patients ORDER BY patient_id";
$stmt = $conn->prepare($fetchPatientsQuery);

// Execute the statement
$stmt->execute();

// Fetch all patients as an associative array
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the statement and database connection
$stmt = null;
$conn = null;
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
                        <h1 class="h3 mb-0 text-gray-800">View Patients Information</h1>
                        <a href="add_new_patient.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user fa-sm text-white-50"></i> Add New Patient</a>
                    </div>

                    <!-- Content Row -->
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">All Registered Patients</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Registered Date</th>
                                            <th>View Patient</th>
                                            <th>Schedule Appointment</th>
                                            <th>Medical History</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $serialNumber = 1; // Initialize serial number
                                        foreach ($patients as $patient) :
                                        ?>
                                            <tr>
                                                <td><?= $serialNumber++; ?></td>
                                                <td><?= $patient['first_name']; ?></td>
                                                <td><?= $patient['last_name']; ?></td>
                                                <td><?= calculateAge($patient['dob']); ?></td>
                                                <td><?= $patient['gender']; ?></td>
                                                <td><?= $patient['email']; ?></td>
                                                <td><?= $patient['phone_number']; ?></td>
                                                <td><?= $patient['address']; ?></td>
                                                <td><?= $patient['registration_date']; ?></td>
                                                <td><a href="view_patient.php?id=<?= $patient['patient_id']; ?>">View</a></td>
                                                <td><a href="schedule_appointment.php?id=<?= $patient['patient_id']; ?>">Schedule</a></td>
                                                <td><a href="medical_history.php?id=<?= $patient['patient_id']; ?>">View History</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Registered Date</th>
                                            <th>View Patient</th>
                                            <th>Schedule Appointment</th>
                                            <th>Medical History</th>
                                        </tr>
                                    </tfoot>
                                </table>
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