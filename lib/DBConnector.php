<?php
//DB에 접속하는 코드. 마지막에는 항상 커넥션을 닫아줘야한다.

  include(dirname(__FILE__).'/../../../password.php');
  $mysqli = mysqli_connect('localhost', 'root', getPassword(), 'when_feel_blue');
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

 ?>
