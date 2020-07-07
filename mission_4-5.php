<?php	
	// DB接続設定
	$dsn = 'mysql:dbname=tb******db;host=localhost';
	$user = 'tb-******';
	$password = '**********';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
#データ入力
    #prepareは、SQL文のテンプレートを先に準備(prepare)して
    #値とSQL部分を明確に分ける音で安全を確保する。
    #外部の値とSQL文の値(VALUES)を区別するために、プレースホルダ(「:変数名」または「?」)と呼ばれる識別子をおく。
    
    #外部から届く値をプレースホルダ(:name, :comment)で置き換えている。
    #prepareはSQL文を実行する準備を整える。
    $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
    
  #bindParamはSQL文実行前に値を入れる場所を確保しておき、その場所と確定した外部の値を結びつける。
  
	#:nameは値を入れる場所、$nameは外部の値
	#ここでは、SQL文の:nameという場所に$nameを結びつけますよ、という宣言をしている
	#(注意)この段階では宣言しているだけで、実際にどんな$nameの値を結びつけるかは決まってない
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
  
	#:commentは値を入れる場所、$commentは外部の値
	#ここでは、SQL文の:commentという場所に$commentを結びつけますよ、という宣言をしている
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
  
	#$nameの値を確定させる
	$name = 'そういちろう';
  
	#$commentの値を確定させる
	$comment = 'テスト3回目';
  
	#今まで組み立てた$sqlの内容を実行する　
	$sql -> execute();
	echo "ok";

	//bindParamの引数名（:name など）はテーブルのカラム名に併せるとミスが少なくなります。最適なものを適宜決めよう。
?>
