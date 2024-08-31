<?php
if (isset($_POST["submit"])){
    $data_form = $_POST["namaadd"].",";
    file_put_contents("nama.txt", $data_form, FILE_APPEND);
    header("Location: index.php");
} else {
    header("Location: index.php");
}
?>