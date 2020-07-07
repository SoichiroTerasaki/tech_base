<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-3</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前"> <!--コメントフォームの作成-->
        <input type="text" name="comment" placeholder="コメント">
        <input type="submit" name="submit" value="送信">
        
        <input type="number" name="submit_num" placeholder="数字"> <!--削除フォームの作成-->
        <input type="submit" name="delete" value="削除">
    </form>
    
    <?php
        $filename = "mission_3-3.txt";
        
    #「送信」ボタンが押されたとき
        if (isset($_POST["submit"])){
            
        #すでにファイルがあるときは内容を表示
            if (file_exists($filename)){
            
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                foreach($lines as $line){
                    $contents = explode("<>",$line); #(**)
                    foreach($contents as $content){
                        echo $content." ";
                    }
                echo "<br>";
                }
            #最後の投稿番号+1の数字を取得(ほかにもやり方はあると思いますが...)
            #27行目のループ処理によって、現在$contentsには既存ファイルの最終行が格納されているから
            #ここで書く$contents[0]は最終行の投稿番号になっている。
            $num = $contents[0] + 1;
            }
        #ファイルがまだないときは投稿番号を1とする
            else{
                $num = 1;
            }
            
            
            
            $name = $_POST["name"]; #name : 入力された名前の値を取得
            $comment = $_POST["comment"]; #comment : 入力されたコメントの値を取得
            $date = date("Y年m月d日 H:i:s"); #date : 投稿日時を取得
            $fp = fopen($filename, "a"); #末尾への追記モードでファイルをオープンする
            #new_line : 新しく書き込みたい行
            $new_line = $num."<>".$name."<>".$comment."<>".$date.PHP_EOL;

            fwrite($fp, $new_line);
            fclose($fp);
            
            #新しく書き込んだ行を掲示板に表示
            echo $num." ".$name." ".$comment." ".$date.PHP_EOL;
            echo "<br>";
            echo "ok";
        }
        
    #削除ボタンが押されたとき
        else if (isset($_POST["delete"])){
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            $delete_num = $_POST["submit_num"]; #入力された数字の値を取得
            $delete_line = 0; #削除する投稿番号の存在を表すフラグ
            
            
            $fp = fopen($filename, "w"); #先頭への追記モードでファイルをオープンする
            
            foreach($lines as $line){ #削除番号と等しい投稿番号があるかどうか、1行ずつ確認します。
                $contents = explode("<>",$line); #取り出した行を<>で分割して
                if ($contents[0] != $delete_num){ #削除する投稿番号と違うときは
                    fwrite($fp, $line.PHP_EOL); #もとのまま書き込みます。
                    $new_line = $contents[0]." ".$contents[1]." ".$contents[2]." ".$contents[3]; #掲示板に表示するための変数を作り
                    echo $new_line. "<br>"; #掲示板に表示します
                }
                #削除する投稿番号と同じ投稿番号が見つかったとき
                else $delete_line = 1; #存在フラグを立てる(=0から1にする)
            }
            
            #該当する番号が見つからなかったら
            if ($delete_line == 1) echo "投稿番号".$delete_num."を削除しました<br>"; #このとおり表示します。
            #該当する番号が見つからなかったら
            else echo "投稿番号".$delete_num."は見つかりませんでした<br>"; #このとおり表示します。
            
            fclose($fp); #ファイルを閉じて終了します。
            echo "ok";
            
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
            }
        }
    ?>
</body>
</html>