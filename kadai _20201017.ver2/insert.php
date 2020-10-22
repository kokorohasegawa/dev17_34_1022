<?php

// indexに入力したデータを受診
$book_name=$_POST['book_name'];
$book_URL=$_POST['book_URL'];
$comment=$_POST['book_comment'];

//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ

//2. DB接続します
try {
  //ID MAMP ='root'
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_bm_table;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO  gs_bm_table(code, 書籍名, 書籍URL, 書籍コメント, 登録日時)VALUES( NULL,:name,:URL,:comment,sysdate())");
$stmt->bindValue(':name', $book_name,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':URL',$book_URL,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment',$comment,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

// -- 実行分
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("記録ができません".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: index.php');
}
?>
