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
                    <div class="container">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Schedule Appointment</h1>
                            <a href="view_patients.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-users fa-sm text-white-50"></i> View All Patient</a>

                        </div>

                        <!-- Content Row -->
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['schedule_appointment'])) {
                            // Retrieve form data
                            $patient_id = $_POST['patient_id'];
                            $doctor_id = $_POST['doctor_id'];
                            $appointment_date = $_POST['appointment_date'];

                            // Perform data validation and sanitation (implement as needed)

                            // Insert data into the 'appointments' table
                            $insertAppointmentQuery = "INSERT INTO appointments (patient_id, doctor_id, appointment_date) 
                                                   VALUES (:patient_id, :doctor_id, :appointment_date)";

                            $stmt = $conn->prepare($insertAppointmentQuery);

                            // Bind parameters
                            $stmt->bindParam(':patient_id', $patient_id);
                            $stmt->bindParam(':doctor_id', $doctor_id);
                            $stmt->bindParam(':appointment_date', $appointment_date);

                            // Execute the statement
                            try {
                                $stmt->execute();
                                echo '<div class="alert alert-success" role="alert">
                                Appointment scheduled successfully!</div>';
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                        }
                        ?>


                        <?php
                        if ($patient) {

                        ?>


                            <form class="user" action="schedule_appointment.php" method="POST">
                                <input type="hidden" name="patient_id" value="<?= $patient['patient_id']; ?>">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="appointment_date">Patient First Name:</label>
                                        <input type="text" class="form-control" id="firstName" name="firstname" value="<?= $patient['first_name']; ?>" placeholder="First Name" readonly required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="appointment_date">Patient Last Name:</label>
                                        <input type="text" class="form-control" id="lastName" name="lastname" value="<?= $patient['last_name']; ?>" placeholder="Last Name" readonly required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="appointment_date">Patient Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= $patient['email']; ?>" placeholder="Email" readonly required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="appointment_date">Patient Phone Number:</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $patient['phone_number']; ?>" placeholder="Phone number" readonly required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="appointment_date">Select Doctor:</label>
                                        <select name="doctor_id" class="form-control rounded-lg" id="doctor">
                                            <!-- Fetch and display the list of available doctors from the database -->
                                            <?php
                                            $fetchDoctorsQuery = "SELECT * FROM medical_staff WHERE job_type = 'Doctor'";
                                            $stmt = $conn->prepare($fetchDoctorsQuery);
                                            $stmt->execute();
                                            $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($doctors as $doctor) {
                                                echo "<option value='{$doctor['staff_id']}'>{$doctor['first_name']} {$doctor['last_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="appointment_date">Select Appointment Date:</label>
                                        <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" placeholder="Date of birth" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block" name="schedule_appointment">
                                    <b>Schedule Appointment</b>
                                </button>
                            </form>
                        <?php
                        } else {
                        ?>
                            <form class="user" action="schedule_appointment.php" method="POST">
                                <div class="form-group">
                                    <label for="patient">Select Patient:</label>
                                    <select name="patient_id" id="patient" class="form-control rounded-lg" required>
                                        <!-- Fetch and display the list of patients from the database -->
                                        <?php
                                        $fetchPatientsQuery = "SELECT * FROM patients";
                                        $stmt = $conn->prepare($fetchPatientsQuery);
                                        $stmt->execute();
                                        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($patients as $patient) {
                                            echo "<option value='{$patient['patient_id']}'>{$patient['first_name']} {$patient['last_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="appointment_date">Select Doctor:</label>
                                        <select name="doctor_id" class="form-control rounded-lg" id="doctor" required>
                                            <!-- Fetch and display the list of available doctors from the database -->
                                            <?php
                                            $fetchDoctorsQuery = "SELECT * FROM medical_staff WHERE job_type = 'Doctor'";
                                            $stmt = $conn->prepare($fetchDoctorsQuery);
                                            $stmt->execute();
                                            $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($doctors as $doctor) {
                                                echo "<option value='{$doctor['staff_id']}'>{$doctor['first_name']} {$doctor['last_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="appointment_date">Select Appointment Date:</label>
                                        <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" placeholder="Date of birth" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block" name="schedule_appointment">
                                    <b>Schedule Appointment</b>
                                </button>
                            </form>
                        <?php
                        } ?>
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