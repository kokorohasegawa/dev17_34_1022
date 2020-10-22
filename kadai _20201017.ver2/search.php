<?php

// indexに入力したデータを受診
$search_value=$_POST['search_value'];
$search_value='%'.$search_value.'%';
print($search_value);

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

//３．データベースで検索
$stmt2 = $pdo->prepare("SELECT * FROM gs_bm_table WHERE 書籍名 LIKE '$search_value'");
$status = $stmt2->execute();


// -- 実行分
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("記録ができません".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: select.php');
}
?>
