<?php	

	// DB接続設定
	$dsn = 'mysql:dbname=tb******db;host=localhost';
	$user = 'tb-******';
	$password = '**********';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    echo "ok";

	$sql = "CREATE TABLE IF NOT EXISTS mission5_1test"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY," #自動でナンバリングされる。
	. "name char(32)," #名前を入力する。文字列、半角英数字で32文字
	. "comment TEXT" #コメントを入力する。
	.");";
	$stmt = $pdo->query($sql);
    echo "okok";
?>
