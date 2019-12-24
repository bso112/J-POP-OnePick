<?php
//여기에서는 덧글을 생성하는 프로세스를 처리한다.

  require_once('lib/DBConnector.php');

  $conn = $mysqli;

  //포스트 형식으로 사용자의 입력정보를 받는다.
  $nickname = mysqli_real_escape_string($conn, $_POST['nickname']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $id = mysqli_real_escape_string($conn, $_POST['songID']);


    //덧글 테이블에 사용자의 입력정보를 삽입한다.
  $sql = "insert into post(nickname, `password`, `description`, updated_date,
  song_id) values(\"{$nickname}\", UNHEX(MD5(\"{$password}\")), \"{$description}\", NOW(), \"{$id}\")";


  $res = $conn->query($sql);
  if(!$res)
    echo "Fail to run qury : (".$conn->errno.")".$conn->error;

  mysqli_close($conn);

//프로세스가 성공하면 원래 페이지로 돌아간다.
  header("Location: ./songInfo.php?id={$id}");






 ?>
