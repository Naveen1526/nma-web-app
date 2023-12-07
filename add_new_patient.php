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
                        <?php
                        // Include the database connection file
                        include('config.php');

                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_new_patient'])) {
                            // Retrieve form data
                            $firstname = $_POST['firstname'];
                            $lastname = $_POST['lastname'];
                            $email = $_POST['email'];
                            $phone = $_POST['phone'];
                            $gender = $_POST['gender'];
                            $dob = $_POST['dob'];
                            $address = $_POST['address'];

                            // Perform data validation and sanitation (implement as needed)

                            // Insert data into the 'patients' table
                            $insertPatientQuery = "INSERT INTO patients (first_name, last_name, email, phone_number, gender, dob, address) 
                           VALUES (:firstname, :lastname, :email, :phone, :gender, :dob, :address)";

                            $stmt = $conn->prepare($insertPatientQuery);

                            // Bind parameters
                            $stmt->bindParam(':firstname', $firstname);
                            $stmt->bindParam(':lastname', $lastname);
                            $stmt->bindParam(':email', $email);
                            $stmt->bindParam(':phone', $phone);
                            $stmt->bindParam(':gender', $gender);
                            $stmt->bindParam(':dob', $dob);
                            $stmt->bindParam(':address', $address);

                            // Execute the statement
                            try {
                                $stmt->execute();
                                echo '<div class="alert alert-success" role="alert">
                                Patient added successfully!</div>';
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }

                            // Close the statement and database connection
                            $stmt = null;
                            $conn = null;
                        }
                        ?>



                        <form class="user" action="add_new_patient.php" method="POST">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control" id="firstName" name="firstname" placeholder="First Name" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="lastName" name="lastname" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select name="gender" class="form-control rounded-lg" id="gender">
                                        <option value="" selected="selected">-Select Gender-</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of birth" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block" name="add_new_patient">
                                <b>Add New Patient</b>
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