<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-2</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前">
        <input type="text" name="str" placeholder="コメント">
        <input type="submit" name="submit">
    </form>
    <?php
        $filename = "mission_3-2.txt";
        #num : 投稿番号
        $num = 1;
        if (file_exists($filename)){
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            $num = count($lines) + 1; #ファイルの行数を数え、行数+1を投稿番号にします。
            foreach($lines as $line){ 
                $elems = explode("<>",$line);
                foreach($elems as $elem){
                    echo $elem." ";
                }
                echo "<br>";
            }
        }
        
        if (empty($_POST) == false){ #もし送信されたものがあれば
            $date = date("Y年m月d日 H:i:s"); #date : 投稿日時
            $fp = fopen($filename, "a"); #追記モードでファイルを開き
            $new_line = $num."<>".$_POST["name"]."<>".$_POST["str"]."<>".$date.PHP_EOL;
            #new_line : 新しく書き込む内容

            fwrite($fp, $new_line); #ファイルに書き込みます
            fclose($fp);
            
            #$elems = explode("<>",$new_line);
            #foreach($elems as $elem){
            #        echo $elem." ";
            #    }
            
            echo $num." ".$_POST["name"]." ".$_POST["str"]." ".$date."<br>"; #書き込んだ行を掲示板に表示させます。
            echo "ok";
        }
    ?>
</body>
</html>