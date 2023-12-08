<?php require_once "includes/header.php"; ?>
<?php
// Fetch available rooms and beds
$fetchRoomsQuery = "SELECT * FROM rooms";
$stmtRooms = $conn->prepare($fetchRoomsQuery);
$stmtRooms->execute();
$rooms = $stmtRooms->fetchAll(PDO::FETCH_ASSOC);
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once "includes/sidebar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require_once "includes/navbar.php"; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Check Available Rooms</h1>
                        <a href="assign_patient_to_room.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-user fa-sm text-white-50"></i> Assign Patient to Room
                        </a>
                    </div>

                    <!-- Content Row -->
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Check room availability</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if ($rooms) : ?>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Room Number</th>
                                                <th>Total Beds</th>
                                                <th>Available Beds</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($rooms as $room) : ?>
                                                <tr>
                                                    <td><?= $room['room_number']; ?></td>
                                                    <td><?= $room['bed_count']; ?></td>
                                                    <td><?= $room['available_beds']; ?></td>
                                                    <td class="<?= ($room['status'] === 'Available') ? 'text-success' : 'text-danger'; ?>">
                                                        <?= $room['status']; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Room Number</th>
                                                <th>Total Beds</th>
                                                <th>Available Beds</th>
                                                <th>Status</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <?php else : ?>
                                    <p>No available rooms and beds.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once "includes/footernote.php"; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php require_once "includes/footer.php"; ?>

</body>

</html>