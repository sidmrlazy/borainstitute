<?php include('includes/header.php') ?>
<?php include('components/navbar/admin-navbar.php') ?>
<div class="container user-form-container">
    <div class="page-marker">
        <a href="dashboard.php">
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
        <form action="admin-fee-search-data.php" method="POST" class="filter-row w-100">
            <input type="text" name="student_search" class="form-control filter-input-box" id="exampleFormControlInput1"
                placeholder="Enter Invoice Number, Student Name, Student Contact Number or Course to search">
            <button type="submit" name="search" class="btn btn-outline-success">Search</button>
        </form>
    </div>

    <div class="table-responsive user-table">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">INVOICE NUMBER</th>
                    <th scope="col">INVOICE DATE</th>
                    <th scope="col">STUDENT NAME</th>
                    <th scope="col">COURSE</th>
                    <th scope="col">PAID FOR</th>
                    <th scope="col">INVOICE VALUE</th>
                    <th scope="col">GENERATED BY</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require('includes/connection.php');

                $results_per_page = 10;

                $fetch_students = "SELECT * FROM `bora_invoice` ORDER BY `bora_invoice_generation_date` DESC";
                $fetch_res = mysqli_query($connection, $fetch_students);
                $count = mysqli_num_rows($fetch_res);

                $number_of_page = ceil($count / $results_per_page);

                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }

                $page_first_result = ($page - 1) * $results_per_page;
                $page_query = "SELECT * FROM `bora_invoice` LIMIT "  . $page_first_result . ',' . $results_per_page;
                $page_result = mysqli_query($connection, $page_query);

                while ($row = mysqli_fetch_assoc($page_result)) {
                    $bora_invoice_id = $row['bora_invoice_id'];
                    $bora_invoice_number = $row['bora_invoice_number'];
                    $bora_invoice_date = $row['bora_invoice_date'];
                    $bora_invoice_student = $row['bora_invoice_student'];
                    $bora_invoice_student_course = $row['bora_invoice_student_course'];
                    $bora_invoice_tenure = $row['bora_invoice_tenure'];
                    $bora_invoice_grand_total = $row['bora_invoice_grand_total'];
                    $bora_invoice_by = $row['bora_invoice_by']; ?>
                <tr>
                    <th scope="row"><?php echo $bora_invoice_number ?></th>
                    <td><?php echo $bora_invoice_date ?></td>
                    <td><?php echo $bora_invoice_student ?></td>
                    <td><?php echo $bora_invoice_student_course ?></td>
                    <td><?php echo $bora_invoice_tenure ?></td>
                    <td><?php echo $bora_invoice_grand_total ?></td>
                    <td><?php echo $bora_invoice_by ?></td>
                    <td>
                        <form action="admin-view-generated-fee.php" method="post">
                            <input type="text" value="<?php echo $bora_invoice_id ?>" name="bora_invoice_id" hidden>
                            <button type="submit" name="edit" class="btn btn-sm btn-outline-success">View
                                Details</button>
                        </form>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example" class="w-100 mt-3">
            <ul class="pagination">
                <?php
                for ($page = 1; $page <= $number_of_page; $page++) {
                    echo '<li class="page-item"><a class="page-link" href="user-ppast-payments.php?page=' . $page . '">' . $page . ' </a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</div>

<?php include('includes/footer.php') ?>