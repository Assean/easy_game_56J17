<?php
include_once("./pdo.php");
$sql = "INSERT INTO `results` (`game`, `user`, `result`, `time`) 
        VALUES ('{$_POST["game"]}',
                '{$_POST["user"]}',
                '{$_POST["result"]}',
                '{$_POST["time"]}');";
$pdo->exec($sql);
?>