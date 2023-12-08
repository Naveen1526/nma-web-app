<?php
require_once "includes/header.php"
?>
<?php
// Fetch distinct doctor names
$fetchDoctorsQuery = "SELECT DISTINCT staff_id, first_name, last_name FROM medical_staff WHERE job_type = 'Doctor'";
$stmtDoctors = $conn->prepare($fetchDoctorsQuery);
$stmtDoctors->execute();
$doctors = $stmtDoctors->fetchAll(PDO::FETCH_ASSOC);

// Get selected doctor and date from the form submission
if (isset($_POST['submitDoctor'])) {
    $selectedDoctorId = $_POST['doctor'];

    // Fetch and display scheduled appointments per doctor
    $fetchAppointmentsQuery = "SELECT 
                                    a.appointment_date,
                                    p.first_name AS patient_first_name,
                                    p.last_name AS patient_last_name,
                                    d.first_name AS doctor_first_name,
                                    d.last_name AS doctor_last_name
                               FROM appointments a
                               INNER JOIN patients p ON a.patient_id = p.patient_id
                               INNER JOIN medical_staff d ON a.doctor_id = d.staff_id
                               WHERE a.doctor_id = :selectedDoctorId
                               ORDER BY a.appointment_date";

    $stmtAppointments = $conn->prepare($fetchAppointmentsQuery);
    $stmtAppointments->bindParam(':selectedDoctorId', $selectedDoctorId, PDO::PARAM_INT);
    $stmtAppointments->execute();
    $scheduledAppointments = $stmtAppointments->fetchAll(PDO::FETCH_ASSOC);
}

// Get selected date from the form submission
if (isset($_POST['submitDate'])) {
    $selectedDate = $_POST['selected_date'];

    // Fetch and display scheduled appointments per date
    $fetchAppointmentsQuery = "SELECT 
                                    a.appointment_date,
                                    p.first_name AS patient_first_name,
                                    p.last_name AS patient_last_name,
                                    d.first_name AS doctor_first_name,
                                    d.last_name AS doctor_last_name
                               FROM appointments a
                               INNER JOIN patients p ON a.patient_id = p.patient_id
                               INNER JOIN medical_staff d ON a.doctor_id = d.staff_id
                               WHERE DATE_FORMAT(a.appointment_date, '%Y-%m-%d') = :selectedDate
                               ORDER BY a.appointment_date";

    $stmtAppointments = $conn->prepare($fetchAppointmentsQuery);
    $stmtAppointments->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);
    $stmtAppointments->execute();
    $scheduledAppointments = $stmtAppointments->fetchAll(PDO::FETCH_ASSOC);
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
                        <h1 class="h3 mb-0 text-gray-800">View Scheduled Appointments</h1>
                        <a href="add_new_patient.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user fa-sm text-white-50"></i> Add New Patient</a>
                    </div>

                    <!-- Content Row -->
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Scheduled Appointments</h6>
                        </div>
                        <div class="card-body">
                            <!-- Form to view appointments by doctor -->
                            <form method="POST" action="" class="mb-5">
                                <div class="form-group">
                                    <label for="doctor">Select Doctor:</label>
                                    <select name="doctor" class="form-control">
                                        <?php foreach ($doctors as $doctor) : ?>
                                            <option value="<?= $doctor['staff_id']; ?>"><?= $doctor['first_name'] . ' ' . $doctor['last_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" name="submitDoctor" class="btn btn-primary">View Appointments</button>
                            </form>

                            <!-- OR -->

                            <!-- Form to view appointments by date -->
                            <form method="POST" action="" class="mb-5">
                                <div class="form-group">
                                    <label for="selected_date">Select Date:</label>
                                    <input type="date" name="selected_date" class="form-control" required>
                                </div>
                                <button type="submit" name="submitDate" class="btn btn-primary">View Appointments</button>
                            </form>


                            <div class="table-responsive">
                                <?php if (isset($scheduledAppointments)) : ?>
                                    <!-- Display scheduled appointments -->
                                    <?php if ($scheduledAppointments) : ?>

                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Date and Time</th>
                                                    <th>Patient</th>
                                                    <th>Doctor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($scheduledAppointments as $appointment) : ?>
                                                    <tr>
                                                        <td><?= date('Y-m-d H:i', strtotime($appointment['appointment_date'])); ?></td>
                                                        <td><?= $appointment['patient_first_name'] . ' ' . $appointment['patient_last_name']; ?></td>
                                                        <td><?= $appointment['doctor_first_name'] . ' ' . $appointment['doctor_last_name']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Date and Time</th>
                                                    <th>Patient</th>
                                                    <th>Doctor</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    <?php else : ?>
                                        <p>No appointments scheduled for the selected criteria.</p>
                                    <?php endif; ?>
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