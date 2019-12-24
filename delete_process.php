<?php

  //덧글을 삭제하는 프로세스를 처리한다.

  require('lib/DBConnector.php');

  $conn = $mysqli;

//사용자의 입력정보를 받는다. (덧글에 걸린 패스워드, 덧글 id, 곡 id)
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $postID = mysqli_real_escape_string($conn, $_POST['postID']);
  $id = mysqli_real_escape_string($conn, $_POST['songID']);
//패스워드와 일치하는 덧글이 있다면 그 수를 센다.
  $sql_select = "select count(*) as pass_count from post where id='{$postID}' and password = UNHEX(MD5('{$password}'))";
//해당 덧글을 지운다.
  $sql_delete = "delete from post where id='{$postID}'";

//먼저 지워도 되는지 확인하는 쿼리를 한다.
  $result = $conn->query($sql_select);

  if($result) //result가 있으면 $result 는 true(1), 아니면 false(0) result는 select문이면 오브젝트타입. 그 외에는 0이나 1임.
  {
    $row = $result->fetch_assoc();

  }

//만약 쿼리 결과 일치하는 덧글이 있다면
  if($row['pass_count'] >0)
  {
    //덧글을 삭제한다.
    $conn->query($sql_delete);
    //프로세스가 성공하면 원래 페이지로 돌아간다.
    header("Location: ./songInfo.php?id={$id}");
  }
  else {
    //비밀번호가 틀립니다.
    header("Location: ./songInfo.php?ps=0&id={$id}");
  }

  mysqli_close($conn);



 ?>
