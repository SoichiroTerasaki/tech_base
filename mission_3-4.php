<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-4</title>
</head>
<body>
    
    
    <?php
        $filename = "mission_3-4.txt";
        
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
                #削除する投稿番号と同じ番号を探す
                foreach($lines as $line){
                    $contents = explode("<>",$line);
                    #削除する投稿番号と違うとき
                    if ($contents[0] == $option){
                        $re_line = $option."<>".$name."<>".$comment."<>".$date;
                        fwrite($fp, $re_line.PHP_EOL);
                        $new_line = $option." ".$name." ".$comment." ".$date;
                        echo $new_line;
                        echo "<br>";
                    }
                    else{
                        fwrite($fp, $line.PHP_EOL);
                        $new_line = $contents[0]." ".$contents[1]." ".$contents[2]." ".$contents[3];
                        echo $new_line;
                        echo "<br>";
                    }
                }
            }
        #通常の新規書き込みだったとき
            else{
                #すでにファイルがあるときは内容を表示
                if (file_exists($filename)){
                
                    $lines = file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){
                        $contents = explode("<>",$line);
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
                #new_line : 書き込む行
                $new_line = $num."<>".$name."<>".$comment."<>".$date.PHP_EOL;
    
                fwrite($fp, $new_line);
                fclose($fp);
                
                $contents = explode("<>",$new_line);
                foreach($contents as $content){
                        echo $content." ";
                    }
                echo "<br>";
                echo "ok";
            }
        }
        
    #削除ボタンが押されたとき
        else if (isset($_POST["delete"])){
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            $delete_num = $_POST["submit_num"]; #入力された数字の値を取得
            $delete_line = 0; #削除する投稿番号の存在を表すフラグ
            
            
            $fp = fopen($filename, "w"); #先頭への追記モードでファイルをオープンする
            #削除する投稿番号と同じ番号を探す
            foreach($lines as $line){
                $contents = explode("<>",$line);
                #削除する投稿番号と違うとき
                if ($contents[0] != $delete_num){
                    fwrite($fp, $line.PHP_EOL);
                    $new_line = $contents[0]." ".$contents[1]." ".$contents[2]." ".$contents[3];
                    echo $new_line;
                    echo "<br>";
                }
                #削除する投稿番号と同じ投稿番号が見つかったとき
                else $delete_line = 1; #存在フラグを立てる(=0から1にする)
            }
            
            #該当する番号が見つからなかったら
            if ($delete_line == 1) echo "投稿番号".$delete_num."を削除しました<br>";
            #該当する番号が見つからなかったら
            else echo "投稿番号".$delete_num."は見つかりませんでした<br>";
            
            fclose($fp);
            echo "ok";
            
        }
        
        
    #編集ボタンが押されたとき
        else if (isset($_POST["edit"])){
            
            #すでにファイルがあるときは内容を表示
            if (file_exists($filename)){
            
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                foreach($lines as $line){
                    $contents = explode("<>",$line);
                    foreach($contents as $content){
                        echo $content." ";
                    }
                echo "<br>";
                }
            
                $edit_num = $_POST["submit_edit_num"]; #入力された数値を取得
                
                $fp = fopen($filename, "r"); #読取モードでファイルをオープンする
                #編集する投稿番号と同じ番号を探す
                foreach($lines as $line){
                    $contents = explode("<>",$line);
                    #編集する投稿番号と同じとき
                    if ($contents[0] == $edit_num){
                        $edit_name = $contents[1]; # 編集フォームに表示する名前の値を取得
                        $edit_comment = $contents[2]; # 編集フォームに表示するコメントの値を取得
                    }
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
                    foreach($contents as $content){
                        echo $content." ";
                    }
                    echo "<br>";
                }
                fclose($fp);
                echo ok;
            }
        }
    ?>
    
    <!-- フォームの位置をphpの下にお引越しする -->
    <!-- フォームの<input>タグ内にphpの処理結果を使うため、phpの処理より後に書く必要がある -->
    <form action="" method="post">
        <!--コメントフォームの作成-->
        <input type="num" name="option" value="<?php echo $edit_num; ?>"> <!-- php内の$edit_numを表示 -->
        <input type="text" name="name" value="<?php echo $edit_name; ?>" placeholder="名前"> <!--  php内の$edit_nameを表示-->
        <input type="text" name="comment" value="<?php echo $edit_comment; ?>" placeholder="コメント"> <!--  php内の$edit_commentを表示-->
        <input type="submit" name="submit" value="送信"><br>
        <!--削除フォームの作成-->
        <input type="number" name="submit_num" placeholder="削除したい番号を入力">
        <input type="submit" name="delete" value="削除"><br>
        <!--編集フォームの作成-->
        <input type="number" name="submit_edit_num" placeholder="編集したい番号を入力">
        <input type="submit" name="edit" value="編集">
    </form>
    
    
</body>
</html>