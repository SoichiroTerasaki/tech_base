<?php	
	// 【サンプル】
	// ・データベース名：tb******db
	// ・ユーザー名：tb-******
	// ・パスワード：**********

	// DB接続設定
	$dsn = 'mysql:dbname=tb******db;host=localhost';
	$user = 'tb-******';
	$password = '**********';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    echo "ok";
?>
