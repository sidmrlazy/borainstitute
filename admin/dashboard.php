<?php include('includes/header.php') ?>
<?php
require('includes/connection.php');
if (isset($_SESSION['user_id'])) {
    $user_contact = $_SESSION['user_id'];

    $query = "SELECT * FROM `bora_users` WHERE `user_contact` = '$user_contact'";
    $res = mysqli_query($connection, $query);

    $user_type = "";

    while ($row = mysqli_fetch_assoc($res)) {
        $user_type = $row['user_type'];
    }

    if ($user_type == 1) {
        include('components/navbar/admin-navbar.php');
        include('includes/footer.php');
    } else if ($user_type == 2) {
        include('components/navbar/user-navbar.php');
        include('includes/footer.php');
    }
}
?>