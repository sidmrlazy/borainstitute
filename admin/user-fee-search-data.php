<?php include('includes/header.php') ?>
<?php include('components/navbar/user-navbar.php') ?>
<script>
function emptyField() {
    $(document).ready(function() {
        $("#emptyFieldModal").modal("show");
    });
}
</script>
<!-- ======================= SELECT CATEGORY MODAL ======================= -->
<div class="modal fade hide" id="emptyFieldModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Error!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <p>Please select category to search!</p>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <a href="user-past-payments.php" class="btn btn-primary">Go back</a>
            </div>
        </div>
    </div>
</div>
<div class="container user-form-container">
    <div class="page-marker">
        <a href="user-past-payments.php">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </a>
        <h5>Past Payments</h5>
    </div>
    <?php
    require('includes/connection.php');
    if (isset($_COOKIE['user_id'])) {
        $user_contact = $_COOKIE['user_id'];
        $fetch_data = "SELECT * FROM `bora_users` WHERE `user_contact` = '$user_contact'";
        $fetch_res = mysqli_query($connection, $fetch_data);
        $user_name = "";
        while ($row = mysqli_fetch_assoc($fetch_res)) {
            $user_name = $row['user_name'];
        }
    }
    ?>

    <div class="w-100">
        <form action="user-fee-search-data.php" method="POST" class="filter-row w-100 dashboard-tab p-3">
            <div class="w-100 m-1">
                <select name="search_type" class="form-select" aria-label="Default select example">
                    <option selected>Click here for options</option>
                    <option value="1">Name</option>
                    <option value="2">Mobile Number</option>
                    <option value="3">UID</option>
                    <option value="4">Receipt Number</option>
                </select>
            </div>
            <div class="w-100 m-1">
                <input type="text" name="student_search" class="form-control filter-input-box"
                    id="exampleFormControlInput1" placeholder="" required>
            </div>
            <button type="submit" name="search" class="btn btn-outline-success">Search</button>
        </form>
    </div>

    <div class="table-responsive user-table">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">RECEIPT NUMBER</th>
                    <th scope="col">RECEIPT DATE</th>
                    <th scope="col">STUDENT NAME</th>
                    <th scope="col">COURSE</th>
                    <th scope="col">PAID FOR</th>
                    <th scope="col">YEAR</th>
                    <th scope="col">AMOUNT</th>
                    <th scope="col">GENERATED BY</th>
                    <th scope="col">ACTION</th>
                    <!-- <th scope="col">EDIT</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                require('includes/connection.php');
                if (isset($_POST['search'])) {
                    $search_type = $_POST['search_type'];
                    $student_search = $_POST['student_search'];

                    if ($search_type == 'null') {
                        echo "<script>emptyField()</script>";
                    } else {

                        $query = "SELECT * FROM `bora_invoice` WHERE ";
                        if ($search_type == '1') {
                            $query .= "`bora_invoice_student` LIKE '%$student_search%'";
                        } else if ($search_type == '2') {
                            $query .= "`bora_invoice_student_contact` LIKE '%$student_search%'";
                        } else if ($search_type == '3') {
                            $query .= "`bora_invoice_student_en_no` LIKE '%$student_search%'";
                        } else if ($search_type == '4') {
                            $query .= "`bora_invoice_number` LIKE '%$student_search%'";
                        }

                        $res = mysqli_query($connection, $query);
                        if ($res) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $bora_invoice_number = $row['bora_invoice_number'];
                                $bora_invoice_date = $row['bora_invoice_date'];
                                $bora_invoice_student = $row['bora_invoice_student'];
                                $bora_invoice_student_course = $row['bora_invoice_student_course'];
                                $bora_invoice_tenure = $row['bora_invoice_tenure'];
                                $bora_invoice_for = $row['bora_invoice_for'];
                                $bora_invoice_grand_total = $row['bora_invoice_grand_total'];
                                $bora_invoice_by = $row['bora_invoice_by'];
                ?>
                <tr>
                    <th scope="row"><?php echo $bora_invoice_number ?></th>
                    <td><?php echo $bora_invoice_date ?></td>
                    <td><?php echo $bora_invoice_student ?></td>
                    <td><?php echo $bora_invoice_student_course ?></td>
                    <td><?php echo $bora_invoice_for ?></td>
                    <td><?php echo $bora_invoice_tenure ?></td>
                    <td><?php echo $bora_invoice_grand_total ?></td>
                    <td><?php echo $bora_invoice_by ?></td>
                    <td>
                        <form action="user-view-generated-fee.php" method="post" target="_blank">
                            <input type="text" value="<?php echo $bora_invoice_id ?>" name="bora_invoice_id" hidden>
                            <button type="submit" name="edit" class="btn btn-sm btn-outline-success">Details</button>
                        </form>
                    </td>
                </tr>
                <?php
                            }
                        } else {
                            echo "Data Not Found";
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php include('includes/footer.php') ?>