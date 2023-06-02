<div class="container mt-5 add-user-success">
    <?php
    require('includes/connection.php');

    if (isset($_POST['submit'])) {
        $course_name = mysqli_real_escape_string($connection, $_POST['course_name']);
        $course_tenure = mysqli_real_escape_string($connection, $_POST['course_tenure']);
        $course_semester = mysqli_real_escape_string($connection, $_POST['course_semester']);
        $course_fee = mysqli_real_escape_string($connection, $_POST['course_fee']);
        $course_status = '1';

        $query = "INSERT INTO `bora_course`(
        `course_name`,
        `course_tenure`,
        `course_semester`,
        `course_fee`,
        `course_status`
    )
    VALUES(
        '$course_name',
        '$course_tenure',
        '$course_semester',
        '$course_fee',
        '$course_status'
    )";
        $result = mysqli_query($connection, $query);

        if ($result) { ?>
            <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_lk80fpsm.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></lottie-player>
            <p>Course added</p>
            <a href="add-course.php" class="go-back-btn">Go Back</a>
    <?php }
    }
    ?>

</div>