<?php include('includes/header.php'); ?>
<?php include('components/navbar/admin-navbar.php'); ?>
<div class="container user-form-container">
    <div class="page-marker">
        <a href="index.php">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </a>
        <h5>View Students</h5>
    </div>
    <?php
    require('includes/connection.php');
    $query = "SELECT * FROM `bora_student`";
    $res = mysqli_query($connection, $query);
    $student_count = mysqli_num_rows($res);
    $user_query = "SELECT * FROM `bora_users` WHERE `user_type` = 2";
    $user_res = mysqli_query($connection, $user_query);
    $count = mysqli_num_rows($user_res);
    ?>

    <div class="w-100 mb-3">
        <form action="search-student-data.php" method="POST" class="filter-row w-100 dashboard-tab p-3">
            <div class="w-100 m-1">
                <select name="search_type" class="form-select" aria-label="Default select example" required>
                    <option selected disabled>Click here for options</option>
                    <option value="1">Name</option>
                    <option value="2">Mobile Number</option>
                    <option value="3">UID</option>
                </select>
            </div>
            <div class="w-100 m-1">
                <input type="text" name="student_search" class="form-control filter-input-box" id="exampleFormControlInput1" placeholder="" required>
            </div>
            <button type="submit" name="search" class="btn btn-outline-success">Search</button>
        </form>
    </div>
    <script>
        function openModal(studentId) {
            $(document).ready(function() {
                $("#exampleModal").modal("show");
            });
        }

        function openEmptyModal() {
            $(document).ready(function() {
                $("#emptyModal").modal("show");
            });
        }

        function notFound() {
            $(document).ready(function() {
                $("#notFoundModal").modal("show");
            });
        }

        function deleteStudentModal(studentId) {
            $(document).ready(function() {
                $("#deleteStudent").modal("show");
            });
        }

        function hideDisplay() {
            const selectMenu = document.getElementById('studentStatus');
            const castCertificateDiv = document.getElementById('castCertificateDiv');

            selectMenu.addEventListener('change', function() {
                if (selectMenu.value === '1') {
                    castCertificateDiv.style.display = 'block';
                } else {
                    castCertificateDiv.style.display = 'none';
                }
            });
        }
    </script>
    <!-- ======================= MODAL ======================= -->
    <div class="modal fade hide" id="emptyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Error!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <p>Search category cannot be empty!</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <a href="view-students.php" class="btn btn-primary">Go back</a>
                </div>
            </div>
        </div>
    </div>



    <!-- ======================= NOT FOUND ======================= -->
    <div class="modal fade hide" id="notFoundModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Oops!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <p>No Student found!</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <a href="dashboard.php" class="btn btn-primary">Go back</a>
                </div>
            </div>
        </div>
    </div>



    <div class="table-responsive user-table">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">UID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Course</th>
                    <th scope="col">Batch</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                    <th scope="col">Delete</th>
                    <th scope="col">Admission Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require('includes/connection.php');

                if (isset($_POST['delete_success'])) {
                    $student_id = $_POST['student_id'];

                    $delete_query = "DELETE FROM `bora_student` WHERE `student_id` = '$student_id'";
                    $delete_res = mysqli_query($connection, $delete_query);

                    if ($delete_res) { ?>
                        <div class="w-100 alert alert-success mt-3 mb-3" role="alert">Student Deleted!</div>
                    <?php
                    }
                }

                if (isset($_POST['delete'])) {
                    $student_id = $_POST['student_id'];
                    echo '<script>deleteStudentModal(' . $student_id . ');</script>'; ?>
                    <div class="modal fade" id="deleteStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Student</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <div>
                                            <input type="text" name="student_id" value="<?php echo $student_id ?>" hidden>
                                            <p>Are you sure you want to delete this student?</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="delete_success" class="btn btn-success">Yes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                }
                if (isset($_POST['update_status'])) {
                    $student_id = $_POST['student_id'];
                    $student_status = $_POST['student_status'];

                    $change_status_query = "UPDATE
                    `bora_student`
                SET
                    `student_status` = '$student_status'
                WHERE
                    `student_id` = '$student_id'";
                    $change_status_query_r = mysqli_query($connection, $change_status_query);
                }

                if (isset($_POST['change'])) {
                    $student_id = $_POST['student_id'];
                    echo '<script>openModal(' . $student_id . ');</script>'; ?>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Change Admission Status</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="upload-grad-marksheet.php" method="POST" enctype="multipart/form-data">
                                    <input type="text" name="student_id" value="<?php echo $student_id ?>" hidden>
                                    <div class="modal-body">
                                        <div>
                                            <select onclick="hideDisplay()" name="student_status" id="studentStatus" class="form-select" aria-label="Default select example">
                                                <option selected>Open this select menu</option>
                                                <option value="1">Graduated</option>
                                                <option value="2">Active</option>
                                                <option value="3">Left</option>
                                            </select>
                                        </div>
                                        <div id="castCertificateDiv" class="mt-3 w-100" style="display: none;">
                                            <label for="formFile" class="form-label">Upload Marksheet</label>
                                            <input class="form-control" name="student_graduation_marksheet" type="file" id="formFile">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="update_marksheet" class="btn btn-primary">Save
                                            changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }



                if (isset($_POST['search'])) {
                    $search_type = $_POST['search_type'];
                    $student_search = $_POST['student_search'];

                    if ($search_type == 'null') {
                        echo "<script>openEmptyModal()</script>";
                    } else {
                        $page_query = "SELECT * FROM `bora_student` WHERE";
                        if ($search_type == "1") {
                            $page_query .= " `student_name` LIKE '%$student_search%'";
                        } elseif ($search_type == "2") {
                            $page_query .= " `student_contact` LIKE '%$student_search%'";
                        } elseif ($search_type == "3") {
                            $page_query .= " `student_roll` LIKE '%$student_search%'";
                        }

                        $page_result = mysqli_query($connection, $page_query);
                        $page_result_count = mysqli_num_rows($page_result);

                        if ($page_result_count > 0) {
                            while ($row = mysqli_fetch_assoc($page_result)) {
                                $student_id = $row['student_id'];
                                $student_img = "assets/student/" . $row['student_img'];
                                $student_name = $row['student_name'];
                                $student_batch = $row['student_batch'];
                                $student_contact = $row['student_contact'];
                                $student_course = $row['student_course'];
                                $student_roll = $row['student_roll'];
                                $student_admission_year = $row['student_admission_year'];
                                $student_added_by = $row['student_added_by'];
                                $student_status = $row['student_status'];
                    ?>
                                <tr>
                                    <td><?php echo $student_roll; ?></td>
                                    <td><?php echo $student_name; ?></td>
                                    <td><?php echo $student_contact; ?></td>
                                    <td>
                                        <?php
                                        $fetch_course_name = "SELECT * FROM `bora_course` WHERE `course_id` = '$student_course'";
                                        $fetch_course_name_res = mysqli_query($connection, $fetch_course_name);
                                        $course_name = "";
                                        while ($row = mysqli_fetch_assoc($fetch_course_name_res)) {
                                            $course_name = $row['course_name'];
                                        }
                                        echo $course_name;
                                        ?>
                                    </td>
                                    <td><?php echo $student_batch; ?></td>
                                    <td>
                                        <?php
                                        if ($student_status == '1') { ?>
                                            <p class="btn btn-sm btn-dark">Graduated</p>
                                        <?php } elseif ($student_status == '2') { ?>
                                            <p class="btn btn-sm btn-success">Active</p>
                                        <?php } elseif ($student_status == '3') { ?>
                                            <p class="btn btn-sm btn-primary">Left</p>
                                        <?php } elseif (empty($student_status)) { ?>
                                            <p class="btn btn-sm btn-info">Not Updated</p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <form action="student-details.php" method="post">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" hidden>
                                            <button type="submit" name="edit" class="btn btn-sm btn-outline-success">Edit
                                                Details</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="" method="POST">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" hidden>
                                            <button type="submit" name="delete" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="" method="POST">
                                            <input type="text" value="<?php echo $student_id ?>" name="student_id" hidden>
                                            <input type="text" value="<?php echo $search_type ?>" name="search_type" hidden>
                                            <input type="text" value="<?php echo $student_search ?>" name="student_search" hidden>
                                            <button type="submit" name="change" class="btn btn-sm btn-primary">Change Status</button>
                                        </form>
                                    </td>
                                </tr>
                <?php
                            }
                        } else if ($page_result_count == '0') {
                            echo "<script>notFound()</script>";
                        }
                    }
                }
                ?>
            </tbody>
        </table>


    </div>
</div>
<?php include('includes/footer.php'); ?>