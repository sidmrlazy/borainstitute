<?php include('includes/header.php') ?>
<?php include('components/navbar/admin-navbar.php') ?>


<div class="container user-form-container">
    <div class="page-marker">
        <a href="admin-past-payments.php">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </a>
        <h5>Edit Receipt</h5>
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

    if (isset($_POST['edit'])) {
        $bora_invoice_id = $_POST['bora_invoice_id'];
        $fetch_data = "SELECT * FROM `bora_invoice` WHERE `bora_invoice_id` = '$bora_invoice_id'";
        $fetch_data_res = mysqli_query($connection, $fetch_data);

        $bora_invoice_id = "";
        $bora_invoice_number = "";
        $bora_invoice_date = "";
        $bora_invoice_student = "";
        $bora_invoice_student_address = "";
        $bora_invoice_student_contact = "";
        $bora_invoice_student_course_id = "";
        $bora_invoice_student_course = "";
        $bora_invoice_for = "";
        $bora_invoice_tenure = "";
        $bora_invoice_payment_mode = "";
        $bora_invoice_cheque_number = "";
        $bora_invoice_bank_name = "";
        $bora_invoice_ifsc = "";
        $bora_invoice_payment_id = "";
        $bora_invoice_dd_number = "";
        $bora_invoice_value = "";
        $bora_invoice_disc = "";
        $bora_invoice_grand_total = "";
        $bora_invoice_by = "";

        while ($row = mysqli_fetch_assoc($fetch_data_res)) {
            $bora_invoice_id = $row['bora_invoice_id'];
            $bora_invoice_number = $row['bora_invoice_number'];
            $bora_invoice_date = $row['bora_invoice_date'];
            $bora_invoice_student = $row['bora_invoice_student'];
            $bora_invoice_student_address = $row['bora_invoice_student_address'];
            $bora_invoice_student_contact = $row['bora_invoice_student_contact'];
            $bora_invoice_student_course_id = $row['bora_invoice_student_course_id'];
            $bora_invoice_student_course = $row['bora_invoice_student_course'];

            $bora_invoice_for = $row['bora_invoice_for'];
            $bora_invoice_tenure = $row['bora_invoice_tenure'];
            $bora_invoice_payment_mode = $row['bora_invoice_payment_mode'];

            $bora_invoice_cheque_number = $row['bora_invoice_cheque_number'];
            $bora_invoice_bank_name = $row['bora_invoice_bank_name'];
            $bora_invoice_ifsc = $row['bora_invoice_ifsc'];
            $bora_invoice_payment_id = $row['bora_invoice_payment_id'];
            $bora_invoice_dd_number = $row['bora_invoice_dd_number'];

            $bora_invoice_value = $row['bora_invoice_value'];
            $bora_invoice_disc = $row['bora_invoice_disc'];
            $bora_invoice_grand_total = $row['bora_invoice_grand_total'];
            $bora_invoice_by = $row['bora_invoice_by'];
        }
    }

    ?>
    <form class="add-user-form" method="POST" action="generate-invoice.php">
        <input type="text" name="bora_invoice_student_id" value="<?php echo $bora_invoice_id ?>" hidden>
        <input type="text" name="bora_invoice_number" value="<?php echo $bora_invoice_number ?>" hidden>

        <div class="receipt-upper-section">
            <img src="../assets/images/logo/brand-logo.webp" alt="">
            <h5>Bora Institute of Allied Health Sciences</h5>
            <p>Sewa Nagar, NH-24, Sitapur Road. Lucknow - 226201.
                <strong>Contact:</strong> +91 9569863933 | +91 9305748634. <br><strong>Email:</strong>
                info@borainstitute.com.
                <strong>Website:</strong> borainstitute.com
            </p>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" colspan="4" class="table-active">RECEIPT NUMBER</th>
                        <th scope="col" class="table-active">RECEIPT DATE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" colspan="4"><strong><?php echo $bora_invoice_number; ?></strong></th>
                        <td>
                            <p><?php echo $bora_invoice_date; ?></p>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" colspan="4" class="table-active">BILL TO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" colspan="4">
                            <div class="recipient">
                                <h4><?php echo $bora_invoice_student ?></h4>
                                <p><?php echo $bora_invoice_student_address ?> |
                                    <?php echo $bora_invoice_student_contact ?></p>
                            </div>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-bordered ">
                <thead class="table-active">
                    <tr>
                        <th scope="col">FEE TYPE</th>
                        <th scope="col">COURSE</th>
                        <th scope="col">PAID FOR</th>
                        <th scope="col">AMOUNT</th>
                        <?php
                        if (!empty($bora_invoice_disc)) { ?>
                            <th scope="col">DISCOUNT</th>
                        <?php } ?>

                        <th scope="col">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">
                            <select name="bora_invoice_for" class="form-select w-100" aria-label="Default select example">
                                <?php
                                if ($bora_invoice_for == 'Examination') { ?>
                                    <option value="<?php echo $bora_invoice_for ?>"><?php echo $bora_invoice_for ?>
                                        (Selected)</option>
                                    <option value="Tution Fee">Tution Fee</option>
                                    <option value="Admission Fee">Admission Fee</option>
                                    <option value="Clinical Lab Fee">Clinical Lab Fee</option>
                                    <option value="Library Fee">Library Fee</option>
                                    <option value="Uniform Fee">Uniform Fee</option>
                                    <option value="SNA Charges">SNA Charges</option>
                                    <option value="Transport Fee">Transport Fee</option>
                                    <option value="Miscellaneous">Miscellaneous Fee</option>
                                    <option value="Security Deposit">Security Deposit</option>

                                <?php } else if ($bora_invoice_for == 'Tution Fee') { ?>
                                    <option value="<?php echo $bora_invoice_for ?>"><?php echo $bora_invoice_for ?>
                                        (Selected)</option>
                                    <option value="Examination">Examination Fee</option>
                                    <option value="Admission Fee">Admission Fee</option>
                                    <option value="Clinical Lab Fee">Clinical Lab Fee</option>
                                    <option value="Library Fee">Library Fee</option>
                                    <option value="Uniform Fee">Uniform Fee</option>
                                    <option value="SNA Charges">SNA Charges</option>
                                    <option value="Transport Fee">Transport Fee</option>
                                    <option value="Miscellaneous">Miscellaneous Fee</option>
                                    <option value="Security Deposit">Security Deposit</option>

                                <?php } else if ($bora_invoice_for == 'Admission Fee') { ?>
                                    <option value="<?php echo $bora_invoice_for ?>"><?php echo $bora_invoice_for ?>
                                        (Selected)</option>
                                    <option value="Examination">Examination Fee</option>
                                    <option value="Tution Fee">Tution Fee</option>
                                    <option value="Clinical Lab Fee">Clinical Lab Fee</option>
                                    <option value="Library Fee">Library Fee</option>
                                    <option value="Uniform Fee">Uniform Fee</option>
                                    <option value="SNA Charges">SNA Charges</option>
                                    <option value="Transport Fee">Transport Fee</option>
                                    <option value="Miscellaneous">Miscellaneous Fee</option>
                                    <option value="Security Deposit">Security Deposit</option>

                                <?php } else if ($bora_invoice_for == 'Clinical Lab Fee') { ?>
                                    <option value="<?php echo $bora_invoice_for ?>"><?php echo $bora_invoice_for ?>
                                        (Selected)</option>
                                    <option value="Examination">Examination Fee</option>
                                    <option value="Tution Fee">Tution Fee</option>
                                    <option value="Admission Fee">Admission Fee</option>
                                    <option value="Library Fee">Library Fee</option>
                                    <option value="Uniform Fee">Uniform Fee</option>
                                    <option value="SNA Charges">SNA Charges</option>
                                    <option value="Transport Fee">Transport Fee</option>
                                    <option value="Miscellaneous">Miscellaneous Fee</option>
                                    <option value="Security Deposit">Security Deposit</option>
                                <?php } else if ($bora_invoice_for == 'Library Fee') { ?>
                                    <option value="<?php echo $bora_invoice_for ?>"><?php echo $bora_invoice_for ?>
                                        (Selected)</option>
                                    <option value="Examination">Examination Fee</option>
                                    <option value="Tution Fee">Tution Fee</option>
                                    <option value="Admission Fee">Admission Fee</option>
                                    <option value="Clinical Lab Fee">Clinical Lab Fee</option>
                                    <option value="Uniform Fee">Uniform Fee</option>
                                    <option value="SNA Charges">SNA Charges</option>
                                    <option value="Transport Fee">Transport Fee</option>
                                    <option value="Miscellaneous">Miscellaneous Fee</option>
                                    <option value="Security Deposit">Security Deposit</option>
                                <?php } else if ($bora_invoice_for == 'Uniform Fee') { ?>
                                    <option value="<?php echo $bora_invoice_for ?>"><?php echo $bora_invoice_for ?>
                                        (Selected)</option>
                                    <option value="Examination">Examination Fee</option>
                                    <option value="Tution Fee">Tution Fee</option>
                                    <option value="Admission Fee">Admission Fee</option>
                                    <option value="Clinical Lab Fee">Clinical Lab Fee</option>
                                    <option value="Library Fee">Library Fee</option>
                                    <!-- <option value="Uniform Fee">Uniform Fee</option> -->
                                    <option value="SNA Charges">SNA Charges</option>
                                    <option value="Transport Fee">Transport Fee</option>
                                    <option value="Miscellaneous">Miscellaneous Fee</option>
                                    <option value="Security Deposit">Security Deposit</option>
                                <?php } else if ($bora_invoice_for == 'SNA Charges') { ?>
                                    <option value="<?php echo $bora_invoice_for ?>"><?php echo $bora_invoice_for ?>
                                        (Selected)</option>
                                    <option value="Examination">Examination Fee</option>
                                    <option value="Tution Fee">Tution Fee</option>
                                    <option value="Admission Fee">Admission Fee</option>
                                    <option value="Clinical Lab Fee">Clinical Lab Fee</option>
                                    <option value="Library Fee">Library Fee</option>
                                    <option value="Uniform Fee">Uniform Fee</option>
                                    <!-- <option value="SNA Charges">SNA Charges</option> -->
                                    <option value="Transport Fee">Transport Fee</option>
                                    <option value="Miscellaneous">Miscellaneous Fee</option>
                                    <option value="Security Deposit">Security Deposit</option>
                                <?php } else if ($bora_invoice_for == 'Transport Fee') { ?>
                                    <option value="<?php echo $bora_invoice_for ?>"><?php echo $bora_invoice_for ?>
                                        (Selected)</option>
                                    <option value="Examination">Examination Fee</option>
                                    <option value="Tution Fee">Tution Fee</option>
                                    <option value="Admission Fee">Admission Fee</option>
                                    <option value="Clinical Lab Fee">Clinical Lab Fee</option>
                                    <option value="Library Fee">Library Fee</option>
                                    <option value="Uniform Fee">Uniform Fee</option>
                                    <option value="SNA Charges">SNA Charges</option>
                                    <!-- <option value="Transport Fee">Transport Fee</option> -->
                                    <option value="Miscellaneous">Miscellaneous Fee</option>
                                    <option value="Security Deposit">Security Deposit</option>
                                <?php } else if ($bora_invoice_for == 'Miscellaneous') { ?>
                                    <option value="<?php echo $bora_invoice_for ?>"><?php echo $bora_invoice_for ?>
                                        (Selected)</option>
                                    <option value="Examination">Examination Fee</option>
                                    <option value="Tution Fee">Tution Fee</option>
                                    <option value="Admission Fee">Admission Fee</option>
                                    <option value="Clinical Lab Fee">Clinical Lab Fee</option>
                                    <option value="Library Fee">Library Fee</option>
                                    <option value="Uniform Fee">Uniform Fee</option>
                                    <option value="SNA Charges">SNA Charges</option>
                                    <option value="Transport Fee">Transport Fee</option>
                                    <!-- <option value="Miscellaneous">Miscellaneous Fee</option> -->
                                    <option value="Security Deposit">Security Deposit</option>
                                <?php } else if ($bora_invoice_for == 'Security Deposit') { ?>
                                    <option value="<?php echo $bora_invoice_for ?>"><?php echo $bora_invoice_for ?>
                                        (Selected)</option>
                                    <option value="Examination">Examination Fee</option>
                                    <option value="Tution Fee">Tution Fee</option>
                                    <option value="Admission Fee">Admission Fee</option>
                                    <option value="Clinical Lab Fee">Clinical Lab Fee</option>
                                    <option value="Library Fee">Library Fee</option>
                                    <option value="Uniform Fee">Uniform Fee</option>
                                    <option value="SNA Charges">SNA Charges</option>
                                    <option value="Transport Fee">Transport Fee</option>
                                    <option value="Miscellaneous">Miscellaneous Fee</option>
                                    <!-- <option value="Security Deposit">Security Deposit</option> -->
                                <?php } ?>
                            </select>
                        </th>
                        <!-- <th scope="row">
                            <p><?php echo $bora_invoice_for ?></p>
                        </th> -->
                        <td>
                            <p><?php echo $bora_invoice_student_course ?></p>
                        </td>
                        <!-- <td>
                            <p><?php echo $bora_invoice_tenure ?></p>
                        </td> -->
                        <td>
                            <select name="invoice_tenure" class="form-select w-100" aria-label="Default select example">
                                <option selected>Click here to open menu</option>
                                <?php
                                $fetch_course_name = "SELECT * FROM `bora_course` WHERE `course_id` = '$bora_invoice_student_course_id'";
                                $fetch_course_name_res = mysqli_query($connection, $fetch_course_name);

                                $course_id = "";
                                $course_name = "";
                                $course_tenure = "";
                                $course_year_1_fee = "";
                                $course_year_2_fee = "";
                                $course_year_3_fee = "";
                                $course_year_4_fee = "";

                                while ($row = mysqli_fetch_assoc($fetch_course_name_res)) {
                                    $course_id = $row['course_id'];
                                    $course_name = $row['course_name'];
                                    $course_tenure = $row['course_tenure'];
                                    $course_year_1_fee = $row['course_year_1_fee'];
                                    $course_year_2_fee = $row['course_year_2_fee'];
                                    $course_year_3_fee = $row['course_year_3_fee'];
                                    $course_year_4_fee = $row['course_year_4_fee'];
                                }
                                if ($course_tenure == '1') { ?>
                                    <option value="Year 1 Fee">Year 1 Fee</option>
                                <?php }
                                if ($course_tenure == '2') { ?>
                                    <option value="Year 1 Fee">Year 1 Fee</option>
                                    <option value="Year 2 Fee">Year 2 Fee</option>
                                <?php }
                                if ($course_tenure == '3') { ?>
                                    <option value="Year 1 Fee">Year 1 Fee</option>
                                    <option value="Year 2 Fee">Year 2 Fee</option>
                                    <option value="Year 3 Fee">Year 3 Fee</option>
                                <?php }
                                if ($course_tenure == '4') { ?>
                                    <option value="Year 1 Fee">Year 1 Fee</option>
                                    <option value="Year 2 Fee">Year 2 Fee</option>
                                    <option value="Year 3 Fee">Year 3 Fee</option>
                                    <option value="Year 4 Fee">Year 4 Fee</option>
                                <?php } ?>
                            </select>
                        </td>

                        <td>
                            <div>
                                <input type="number" name="bora_invoice_value" value="<?php echo $bora_invoice_value  ?>" id="collectingAmount" class="form-control" id="exampleFormControlInput1" placeholder="">
                            </div>
                        </td>
                        <?php if (!empty($bora_invoice_disc)) { ?>
                            <td>
                                <div>
                                    <input type="number" name="invoice_disc" id="discount" class="form-control" id="exampleFormControlInput1" placeholder="">
                                </div>
                            </td>
                        <?php } ?>

                        <!-- <td>
                            <p>₹<?php echo $bora_invoice_value ?></p>
                        </td>
                        <?php if (!empty($bora_invoice_disc)) { ?>
                        <td>
                            <p>₹<?php echo $bora_invoice_disc ?></p>
                        </td>
                        <?php } ?>
                        <td>
                            <p>₹<?php echo $bora_invoice_grand_total ?></p>
                        </td> -->
                    </tr>
                </tbody>
            </table>
        </div>



        <table style="margin-top: 5px; width: 100%; ">
            <?php
            if ($bora_invoice_payment_mode == 'cash') {
            ?>
                <thead>
                    <tr>
                        <th scope="col" colspan="4" style="border: 1px solid #e7e7e7e7; width: 100%; padding: 5px;">PAYMENT
                            MODE:<strong><?php echo strtoupper($bora_invoice_payment_mode) ?> </strong></th>
                    </tr>
                </thead>
            <?php } else if ($bora_invoice_payment_mode == 'cheque') { ?>
                <thead>
                    <th scope="col" colspan="4" style="border: 1px solid #e7e7e7e7; width: 100%; padding: 5px;">PAYMENT
                        MODE: <strong><?php echo strtoupper($bora_invoice_payment_mode) ?></th>
                </thead>
                <thead>
                    <th scope="col" colspan="4" style="border: 1px solid #e7e7e7e7; width: 100%; padding: 5px;">CHEQUE
                        NUMBER:
                        <?php echo strtoupper($bora_invoice_cheque_number) ?></th>
                </thead>
                <thead>
                    <th scope="col" colspan="4" style="border: 1px solid #e7e7e7e7; width: 100%; padding: 5px;">BANK NAME:
                        <?php echo strtoupper($bora_invoice_bank_name) ?></th>
                </thead>
                <thead>
                    <th scope="col" colspan="4" style="border: 1px solid #e7e7e7e7; width: 100%; padding: 5px;">BANK IFSC
                        CODE:
                        <?php echo strtoupper($bora_invoice_ifsc) ?></th>
                </thead>

            <?php } else if ($bora_invoice_payment_mode == 'online') { ?>
                <thead>
                    <tr>
                        <th scope="col" colspan="4" style="border: 1px solid #e7e7e7e7; width: 100%; padding: 5px;">PAYMENT
                            MODE: <strong><?php echo strtoupper($bora_invoice_payment_mode) ?> </th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="4" style="border: 1px solid #e7e7e7e7; width: 100%; padding: 5px;">PAYMENT
                            ID:
                            <?php echo $bora_invoice_payment_id ?>
                        </th>
                    </tr>
                </thead>

            <?php } else if ($bora_invoice_payment_mode == 'DemandDraft') { ?>
                <thead>
                    <tr>
                        <th scope="col" colspan="4" style="border: 1px solid #e7e7e7e7; width: 100%; padding: 5px;">PAYMENT
                            MODE: <strong><?php echo strtoupper($bora_invoice_payment_mode) ?> </th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="4" style="border: 1px solid #e7e7e7e7; width: 100%; padding: 5px;">DD
                            NUMBER:
                            <?php echo $bora_invoice_dd_number ?>
                        </th>
                    </tr>
                </thead>
            <?php } ?>
        </table>

        <div class="table-responsive mt-5">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="table-active">
                            <div class="receipt-calculation">
                                <h6>Collected By: <?php echo $bora_invoice_by; ?></h6>
                                <p id="difference"></p>
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>

        <button type="submit" name="update" class="btn btn-success mt-3">Update Receipt</button>
    </form>

</div>
<?php include('includes/footer.php') ?>