<?php

//덧글을 수정하는 프로세스

  require_once('lib/DBConnector.php');

  $conn = $mysqli;


  if (isset($_POST['description']) && isset($_POST['postID']))
  {
    //사용자가 입력한 덧글 내용과 덧글의 id, 곡의 id를 가져온다.
      global $conn;
      $description = mysqli_real_escape_string($conn, $_POST['description']);
      $postID = mysqli_real_escape_string($conn, $_POST['postID']);
      $id = mysqli_real_escape_string($conn, $_POST['songID']);

      //해당 덧글 id와 일치하는 레코드를 찾아 갱신한다.
      $sql = "update post set description =\"{$description}\" where id = \"$postID\"";
      $result = $conn->query($sql);

  }
  else
  {
      echo "파라미터 부족";
  }


  mysqli_close($conn);

//프로세스가 끝나면 되돌아간다.
  header("Location: ./songInfo.php?id={$id}");
?>
