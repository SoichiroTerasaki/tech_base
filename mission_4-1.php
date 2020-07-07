<?php	
	// 【サンプル】
	// ・データベース名：tb******db
	// ・ユーザー名：tb-******
	// ・パスワード：**********

	// DB接続設定
	$dsn = 'mysql:dbname=tb******db;host=localhost'; #左から順にデータベースの種類（MySQL）、名前(tb******db)、ホスト(localhost)を表す。今回はホストは気にしなくていいです。
	$user = 'tb-******'; #ポータルのログインIDと同じです。
	$password = '**********'; #ポータルのログインパスワードと同じです。

	#PDO(PHP Data Object)は、PHPからデータベースに接続して様々な処理をするための機能。
	#new PDOで、php手元のphpからデータベースに接続する。
	#$dsnはデータベースの情報、$userと$passwordは認証に使われる。
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    echo "ok"; #これでデータベースへの接続が完了。
?>
