<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    
    
    <?php
        $filename = "mission_3-5.txt";
        $password = $_POST["password"]; #password : パスワードを取得
        $miss_password = 0; #passwordが間違っていたら1に変わる変数
        
    #「送信」ボタンが押されたとき
        if (isset($_POST["submit"])){
            
            $option = $_POST["option"]; #option : 入力された編集番号の値を取得
            $name = $_POST["name"]; #name : 入力された名前の値を取得
            $comment = $_POST["comment"]; #comment : 入力されたコメントの値を取得
            $date = date("Y年m月d日 H:i:s"); #date : 投稿日時を取得
            
        #編集用の書き込みだったとき
            if ($option != ""){
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                $fp = fopen($filename, "w"); #先頭への追記モードでファイルをオープンする
                #編集する投稿番号と同じ番号を探す
                foreach($lines as $line){
                    $contents = explode("<>",$line);
                    #編集する投稿番号と同じとき
                    if ($contents[0] == $option){
                        #パスワードが正しいとき
                        if ($contents[4] == $password){
                            $re_line = $option."<>".$name."<>".$comment."<>".$date."<>".$password."<>".PHP_EOL;
                            fwrite($fp, $re_line);
                            $new_line = $option." ".$name." ".$comment." ".$date;
                            echo $new_line."<br>";
                        }
                        #パスワードが間違っているとき
                        else{
                            fwrite($fp, $line.PHP_EOL);
                            $new_line = $contents[0]." ".$contents[1]." ".$contents[2]." ".$contents[3];
                            echo $new_line."<br>";
                            $miss_password = 1; #パスワードが間違っていた
                        }
                    }
                    else{
                        fwrite($fp, $line.PHP_EOL);
                        $new_line = $contents[0]." ".$contents[1]." ".$contents[2]." ".$contents[3];
                        echo $new_line."<br>";
                    }
                }
                #パスワードが間違っていたとき
                if ($miss_password){
                    echo "パスワードが違います<br>";
                }
            }
        #通常の新規書き込みだったとき
            else{
                #すでにファイルがあるときは内容を表示
                if (file_exists($filename)){
                
                    $lines = file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){
                        $contents = explode("<>",$line);
                        #contents[4]はパスワードなので表示されないようにしたい
                        #→$contentsを$contents[0]から[3]までにする。
                        $contents = array_slice($contents, 0, 4);
                        foreach($contents as $content){
                            echo $content." ";
                        }
                        echo "<br>";
                    }
                    #最後の投稿番号+1の数字を取得
                    $num = $contents[0] + 1;
                }
                #ファイルがまだないときは投稿番号を1とする
                else{
                    $num = 1;
                }
                
                $fp = fopen($filename, "a"); #末尾への追記モードでファイルをオープンする
                #new_line : 書き込む行(最後にパスワードも付いてる)
                $new_line = $num."<>".$name."<>".$comment."<>".$date."<>".$password."<>";
    
                fwrite($fp, $new_line.PHP_EOL);
                fclose($fp);
                
                $outputs = $num." ".$name." ".$comment." ".$date." ";
                echo $outputs."<br>";
                echo "ok";
            }
        }
        
    #削除ボタンが押されたとき
        else if (isset($_POST["delete"])){
            
            #すでにファイルがあるときは内容を表示
            if (file_exists($filename)){
            
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                $delete_num = $_POST["submit_num"]; #入力された数字の値を取得
                $exist_delete = 0; #削除番号を見つけたら1に変わる変数
                
                $fp = fopen($filename, "w"); #先頭への追記モードでファイルをオープンする
                #削除する投稿番号と同じ番号を探す
                foreach($lines as $line){
                    $contents = explode("<>",$line);
                    #削除する投稿番号と同じ投稿番号が見つかったとき
                    if ($contents[0] == $delete_num){
                        $exist_delete = 1; #削除対象をみつけた(=0から1にする)
                        #パスワードが間違っているとき
                        if ($contents[4] != $password){
                            echo $contents[4];
                            echo $password;
                            fwrite($fp, $line.PHP_EOL);
                            $new_line = $contents[0]." ".$contents[1]." ".$contents[2]." ".$contents[3];
                            echo $new_line;
                            echo "<br>";
                            $miss_password = 1;
                        }
                    }
                    #削除する投稿番号と違うとき
                    else {
                        fwrite($fp, $line.PHP_EOL);
                        $new_line = $contents[0]." ".$contents[1]." ".$contents[2]." ".$contents[3];
                        echo $new_line;
                        echo "<br>";
                    } 
                }
                
                #該当する番号が見つからなかったら
                if (!$exist_delete) echo "投稿番号".$delete_num."は見つかりませんでした<br>";
                #該当する番号が見つかったら
                else{
                    #パスワードが間違っているとき
                    if ($miss_password) echo "パスワードが違います";
                    #パスワードが正しいとき
                    else echo "投稿番号".$delete_num."を削除しました";
                } 
                fclose($fp);
                echo "ok";
            }
        }
        
        
    #編集ボタンが押されたとき
        else if (isset($_POST["edit"])){
            
            #すでにファイルがあるときは内容を表示
            if (file_exists($filename)){
            
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                $edit_num = $_POST["submit_edit_num"]; #入力された数値を取得
                $exist_edit = 0; #編集番号が正しいかどうか
                
                foreach($lines as $line){
                    $contents = explode("<>",$line);
                    #contents[4]はパスワードなので表示されないようにしたい
                    #→$contentsを$contents[0]から[3]までにする。
                    $contents = array_slice($contents, 0, 4);
                    foreach($contents as $content){
                        echo $content." ";
                    }
                    echo "<br>";
                }
                
                $fp = fopen($filename, "r"); #読取モードでファイルをオープンする
                #編集する投稿番号と同じ番号を探す
                foreach($lines as $line){
                    $contents = explode("<>",$line);
                    #編集する投稿番号と同じとき
                    if ($contents[0] == $edit_num){
                        $edit_name = $contents[1];
                        $edit_comment = $contents[2];
                        $exist_edit = 1;
                    }
                }
                if (!$exist_edit){
                    echo "該当する投稿番号が見つかりません<br>";
                }
            }
            else echo "該当する投稿番号が見つかりません<br>";
        }
        
    #どちらも押されていないとき（つまり開いてすぐの状態）
        else {
            #ファイルが存在するなら内容を表示
            if (file_exists($filename)){
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                fopen($filename, "r");
                foreach($lines as $line){
                    $contents = explode("<>",$line);
                    #contents[4]はパスワードなので表示されないようにしたい
                    #→$contentsを$contents[0]から[3]までにする。
                    $contents = array_slice($contents, 0, 4);
                    foreach($contents as $content){
                        echo $content." ";
                    }
                    echo "<br>";
                }
                fclose($fp);
                echo "ok";
            }
        }
    ?>
    
    
    <form action="" method="post">
        <input type="hidden" name="option" value="<?php echo $edit_num; ?>">
        <input type="text" name="name" value="<?php echo $edit_name; ?>" placeholder="名前"><br> <!--コメントフォームの作成-->
        <input type="text" name="comment" value="<?php echo $edit_comment; ?>" placeholder="コメント"><br>
        <input type="text" name="password" placeholder="パスワード">
        <input type="submit" name="submit" value="送信"><br>
        
        <input type="number" name="submit_num" placeholder="削除したい番号を入力"> <!--削除フォームの作成-->
        <input type="submit" name="delete" value="削除"><br>
        
        <input type="number" name="submit_edit_num" placeholder="編集したい番号を入力"> <!--編集フォームの作成-->
        <input type="submit" name="edit" value="編集">
    </form>
    
    
</body>
</html>