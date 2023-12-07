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
    if ($stmt->execute()) {
        // Fetch patient details as an associative array
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if patient details are found
        if (!$patient) {
            echo "Patient not found.";
            // You might want to redirect or handle this case differently
        } else {
            // Fetch medical history for the patient
            $fetchMedicalHistoryQuery = "SELECT * FROM medical_history WHERE patient_id = :patientId";
            $stmtHistory = $conn->prepare($fetchMedicalHistoryQuery);
            $stmtHistory->bindParam(':patientId', $patientId, PDO::PARAM_INT);

            // Execute the statement
            $stmtHistory->execute();

            // Fetch medical history as an associative array
            $medicalHistory = $stmtHistory->fetchAll(PDO::FETCH_ASSOC);
        }
    } else {
        echo "Error fetching patient details.";
        // Handle the error, redirect, or display an appropriate message
    }
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
                        <h1 class="h3 mb-0 text-gray-800"> <?= $patient['first_name']; ?> Medical History</h1>
                        <a href="view_patients.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-users fa-sm text-white-50"></i> View All Patient</a>
                    </div>

                    <!-- Content Row -->
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"> <?= $patient['first_name'] . " " . $patient['last_name']; ?> Diagnosis and Illness History</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if ($medicalHistory) : ?>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Date Recorded</th>
                                                <th>Diagnosis</th>
                                                <th>Illness</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $serialNumber = 1; // Initialize serial number
                                            foreach ($medicalHistory as $record) : ?>
                                                <tr>
                                                    <td><?= $serialNumber++; ?></td>
                                                    <td><?= $record['date_recorded']; ?></td>
                                                    <td><?= $record['diagnosis']; ?></td>
                                                    <td><?= $record['illness']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Date Recorded</th>
                                                <th>Diagnosis</th>
                                                <th>Illness</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <?php else : ?>
                                    <p>No medical history available for this patient.</p>
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