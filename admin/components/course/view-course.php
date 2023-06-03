<div class="container user-form-container">
    <div class="page-marker">
        <a href="index.php">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </a>
        <h5>Course Settings</h5>
    </div>

    <div class="user-table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Course Name</th>
                    <th scope="col">Tenure</th>
                    <th scope="col">Semester</th>
                    <th scope="col">Annual Fee</th>
                    <th scope="col">Half-Yearly Fee</th>
                    <th scope="col">Quarterly Fee</th>
                    <th scope="col">Monthly Fee</th>
                    <th scope="col">Status</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require('includes/connection.php');
                $fetch_course = "SELECT * FROM `bora_course`";
                $fetch_result = mysqli_query($connection, $fetch_course);
                while ($row = mysqli_fetch_assoc($fetch_result)) {
                    $course_id = $row['course_id'];
                    $course_name = $row['course_name'];
                    $course_tenure = $row['course_tenure'];
                    $course_semester = $row['course_semester'];
                    $course_fee = $row['course_fee'];
                    $course_fee_six = $row['course_fee'] / 2;
                    $course_fee_qtr = $row['course_fee'] / 4;
                    $course_fee_monthly = $row['course_fee'] / 12;
                    $course_status = $row['course_status'];
                ?>
                <tr>
                    <th scope="row"><?php echo $course_name ?></th>
                    <td><?php echo $course_tenure ?></td>
                    <td><?php echo $course_semester ?></td>
                    <td><?php echo "₹" . $course_fee ?></td>
                    <td><?php echo "₹" . $course_fee_six ?></td>
                    <td><?php echo "₹" . $course_fee_qtr ?></td>
                    <td><?php echo "₹" . $course_fee_monthly ?></td>
                    <td><?php if ($course_status == "1") {
                                echo 'Active';
                            } else {
                                echo 'Disabled';
                            }
                            ?></td>
                    <td>
                        <form action="" method="POST">
                            <input type="text" name="course_id" value="<?php echo $course_id ?>" hidden>
                            <button class="btn btn-sm btn-outline-secondary">Edit</button>
                        </form>
                    </td>
                    <td>
                        <form action="" method="POST">
                            <input type="text" name="course_id" value="<?php echo $course_id ?>" hidden>
                            <button class="btn btn-sm btn-outline-danger">Del</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>