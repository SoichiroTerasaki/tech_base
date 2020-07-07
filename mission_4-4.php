<?php	

	// DB接続設定
	$dsn = 'mysql:dbname=tb******db;host=localhost';
	$user = 'tb-******';
	$password = '**********';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

  $sql ='SHOW CREATE TABLE tbtest';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		#echo $row[1];
		print_r($row);
	}
	echo "<hr>";
?>
