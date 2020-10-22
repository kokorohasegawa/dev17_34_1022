<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">ブックマークデータ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->

<!-- 検索エリア[start] -->
<div>
  <form method="post" action="select.php">
    <div class="jumbotron">
      <fieldset>
        <label>検索する内容：<input type="text" name="search_value"></label><br>
        <input type="submit" value="送信">
      </fieldset>
    </div>
  </form>
</div>

<!-- 検索エリア[end] -->



<!-- Main[End] -->



<?php
// 検索フォームに入力したデータを受診
$search_value=$_POST['search_value'];
$search_value='%'.$search_value.'%';
print($search_value);

//1. DB接続します
try {
  //ID MAMP ='root'
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_bm_table;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE 書籍名 LIKE '$search_value'OR 書籍コメント LIKE '$search_value'");
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // fecthでデータを抽出
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .="<p>";
    $view .= $result['code'].' '.$result['書籍名'].'<br>'.'　'.$result['書籍コメント'].'<br>';
    $view .=' '.'<a href="';
    $view .=$result['書籍URL'];
    $view .='">　リンク先</a>';
    $view .="</p>";
  }
}
?>

<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>
<div>
<a href="index.php">入力画面へ</a>
</div>

</body>
</html>
