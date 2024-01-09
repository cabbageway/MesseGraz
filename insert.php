<?php
     /*$servername = 'localhost';
     $username = "root";
     $password = '';
     $dbname = "messe_db";*/
     $servername = 'db5012227694.hosting-data.io';
     $username = "dbu2915191";
     $password = 'Ionos2023#';
     $dbname = "dbs10288941";
     $conn = mysqli_connect($servername, $username, $password,$dbname);

    $id=$_POST['id'];
	$sql = "INSERT INTO `aufrufe`(`gutschein_id`) VALUES (".$id.");";
	$conn->query($sql);
	mysqli_close($conn);
?>