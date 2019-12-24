<?php

  //사용자가 게시글이나 덧글에 대한 좋아요를 눌렀을때의 프로세스를 처리한다.

  require_once('lib/DBConnector.php');

  $conn = $mysqli;

  $sql;
  //좋아요가 눌린 곡의 id를 받아온다.
  $id = mysqli_real_escape_string($conn, $_POST['songID']);

  //좋아요를 눌린 게 덧글이면 해당 덧글의 좋아요를 업데이트한다.
  if(isset($_POST['postID']))
  {
    $postID = mysqli_real_escape_string($conn, $_POST['postID']);
    $sql = "update post set recommend = recommend + 1 where id = {$postID}";
  }
  //덧글의 id가 넘어오지 않고, 곡의 id만 넘어왔으면(좋아요를 눌린게 게시글이면) 해당 곡의 좋아요를 업데이트한다.
  else if(isset($_POST['songID']))
  {
    $sql = "update song set recommend = recommend + 1 where id = {$id}";
  }
  else {
    echo "파라미터가 없습니다";
    exit();
  }


  $result = $conn->query($sql);

  //프로세스가 성공하면 원래 페이지로 돌아간다.
  if($result)
  {
    header("Location: ./songInfo.php?id={$id}");
  }
  else
    echo "Fail to run qury : (".$conn->errno.")".$conn->error;

    mysqli_close($conn);

 ?>

 <script>


 </script>
