<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
    
    
    <?php
    
        // 【サンプル】
    	// ・データベース名：tb******db
    	// ・ユーザー名：tb-******
    	// ・パスワード：**********
    	// option, id, name, comment, date, password 
    
    	// DB接続設定
    	$dsn = 'mysql:dbname=tb******db;host=localhost';
    	$user = 'tb-******';
    	$password = '**********';
    	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
        #テーブルを新規作成
    	$sql = "CREATE TABLE IF NOT EXISTS mission5_1"
    	." ("
    	. "id INT AUTO_INCREMENT PRIMARY KEY," #自動でナンバリングされる。
    	#. "id INT,"
    	. "name char(32)," #名前を入力する。文字列、半角英数字で32文字
    	. "comment TEXT," #コメントを入力する。
    	. "date TEXT," #
    	. "pw TEXT"
    	.");";
    	$stmt = $pdo->query($sql);
    	
    	$sql ='SHOW TABLES';
    	$result = $pdo -> query($sql);
    	foreach ($result as $row){
    		echo $row[0];
    		echo '<br>';
    	}
    	echo "<hr>";
    	
    	$pw = $_POST["password"];
    	

        
    #「送信」ボタンが押されたとき
        if (isset($_POST["submit"])){
            #$option = $_POST["option"];
            $name = $_POST["name"]; #name : 入力された名前の値を取得
            $comment = $_POST["comment"]; #comment : 入力されたコメントの値を取得
            $date = date("Y年m月d日 H:i:s"); #date : 投稿日時を取得
            echo isset($_POST["option"]);
        #編集用の書き込みをするとき
            #if (isset($_POST["option"])){
            if ($_POST["option"] != ""){
                echo "編集書き込み完了";
            	$option = $_POST["option"];
            	$sql = 'UPDATE mission5_1 SET name=:name,comment=:comment,date=:date WHERE id=:id';
            	$stmt = $pdo->prepare($sql);
            	$stmt->bindParam(':id', $option, PDO::PARAM_INT);
            	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
            	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            	$stmt->bindParam(':date', $date, PDO::PARAM_STR);
            	$stmt->execute();
            }
        #通常の新規書き込みをするとき
            else{
                echo "新規書き込み完了";
                $sql = $pdo -> prepare("INSERT INTO mission5_1 (name, comment, date, pw) VALUES (:name, :comment, :date, :pw)");
        
            	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
            	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            	$sql -> bindParam(':date', $date, PDO::PARAM_STR);
            	$sql -> bindparam(':pw', $pw, PDO::PARAM_STR);
            	#今まで組み立てた$sqlの内容を実行する　
            	$sql -> execute();
            }
        }
        
    #削除ボタンが押されたとき
        else if (isset($_POST["delete"])){
            
            $delete_id = $_POST["delete_num"];
            $sql = 'SELECT * FROM mission5_1 WHERE id=:id ';
            
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
            $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
            $stmt->execute();                             // ←SQLを実行する。
            
            $results = $stmt->fetchAll();
            
            if ($results[0]['pw'] == $pw){
                echo "削除しました";
            	$sql = 'delete from mission5_1 where id=:id';
            	$stmt = $pdo->prepare($sql);
            	$stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
            	$stmt->execute();
            }
            else{
                echo "パスワードが違います<br>";
            }
        }
    
    #編集ボタンが押されたとき    
        else if (isset($_POST["edit"])){
            $num = $_POST["edit_num"];
            $sql = 'SELECT * FROM mission5_1 WHERE id=:id ';
            
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
            $stmt->bindParam(':id', $num, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
            $stmt->execute();                             // ←SQLを実行する。
            
            $results = $stmt->fetchAll(); 
            if ($results[0]['pw'] == $pw){
                echo "編集中";
                $edit_id = $results[0]['id'];
        		$edit_name = $results[0]['name'];
        		$edit_comment = $results[0]['comment'];
            }
        	else {
        	    echo "パスワードが違います<br>";
        	}
        }
        
    
        echo "ok<br>";
        $sql = 'SELECT * FROM mission5_1';
    	$stmt = $pdo->query($sql);
    	$results = $stmt->fetchAll();
    	foreach ($results as $row){
    		//$rowの中にはテーブルのカラム名が入る
    		echo $row['id'].' ';
    		echo $row['name'].' ';
    		echo $row['comment'].' ';
    		echo $row['date'].'<br>';
    	echo "<hr>";
    	}
        #}
    
    ?>
    
    
    <form action="" method="post">
        <input type="hidden" name="option" value="<?php echo $edit_id; ?>">
        <input type="text" name="name" value="<?php echo $edit_name; ?>" placeholder="名前"><br> <!--コメントフォームの作成-->
        <input type="text" name="comment" value="<?php echo $edit_comment; ?>" placeholder="コメント"><br>
        
        <input type="text" name="password" placeholder="パスワード"><br>
        <input type="submit" name="submit" value="送信"><br>
        
        <input type="number" name="delete_num" placeholder="削除したい番号を入力"> <!--削除フォームの作成-->
        <input type="submit" name="delete" value="削除"><br>
        
        <input type="number" name="edit_num" placeholder="編集したい番号を入力"> <!--編集フォームの作成-->
        <input type="submit" name="edit" value="編集">
        
        
        
    </form>
    
    
</body>
</html>