<?php
date_default_timezone_set("Asia/jakarta");
if (isset($_POST["submit"])){
    $data_form = date("d-m")." | ".$_POST["nama"]." | ".$_POST["info"]." | ".$_POST["bon"]." | ".$_POST["byr"]."\n";
    file_put_contents("data.txt", $data_form, FILE_APPEND);
    header("Location: index.php");
} else {
    header("Location: index.php");
}
?>