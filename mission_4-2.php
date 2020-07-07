<?php	

	// DB接続設定
	$dsn = 'mysql:dbname=tb******db;host=localhost';
	$user = 'tb-******';
	$password = '**********';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    echo "ok";

	
	$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY," #自動でナンバリングされる。
	. "name char(32)," #名前を入力する。文字列、半角英数字で32文字
	. "comment TEXT" #コメントを入力する。
	.");";

	$stmt = $pdo->query($sql);
	#この例ではドット(.)を沢山使っていますが、見やすさのために改行しているだけです。なので、下のように書いても同じです。
	#"CREATE TABLE IF NOT EXISTS tbtest (id INT AUTO_INCREMENT PRIMARY KEY, name char(32), comment TEXT);"
    echo "okok";

?>
