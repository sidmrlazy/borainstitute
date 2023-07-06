<?php include('includes/header.php') ?>
<?php include('components/navbar/user-navbar.php') ?>

<?php
require('includes/connection.php');
if (isset($_POST['view'])) {
    $student_id = $_POST['student_id'];

    $query = "SELECT * FROM `bora_student` WHERE `student_id` = '$student_id'";
    $res = mysqli_query($connection, $query);
    $student_id = "";
    $student_graduation_marksheet = "";
    while ($row = mysqli_fetch_assoc($res)) {
        $student_id = $row['student_id'];
        $student_graduation_marksheet = "assets/grad_marksheet/" . $row['student_graduation_marksheet'];
    }
}

?>
<div class="container user-form-container">

    <form action="user-student-details.php" method="POST" class="page-marker">
        <input type="text" name="student_id" value="<?php echo $student_id ?>" hidden>
        <button type="submit" name="edit_back" class="page-marker no-btn">
            <a href="#">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </a>
            <h5>Graduation Marksheet</h5>
        </button>
    </form>
    <div class="doc-row w-100">
        <div class="col-md-6 doc-img">
            <form action="alot-update-success.php" method="POST" enctype="multipart/form-data" class="">
                <input type="text" name="student_id" value="<?php echo $student_id ?>" hidden>
                <img src="<?php echo $student_graduation_marksheet ?>" alt="">
                <!-- <div class="mb-3">
                    <input class="form-control" name="student_graduation_marksheet" type="file" id="formFile">
                </div>
                <button type="submit" name="front" class="w-100 btn btn-outline-success">Change/Upload Image</button> -->
            </form>
        </div>
    </div>
</div>
<?php include('includes/footer.php') ?>