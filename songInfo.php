
<style>

/*모든 컨텐츠를 감싸는 div*/
  #content{

    position: relative;
    margin-top: 50px;
    margin-left: 50px;
    margin-right: 50px;


  }

/*상단의 곡정보를 보여주는 박스. 테두리를 표시한다.*/
  #infoBox{
    width: inherit;
    height: 250px;
    border: 1px black solid;
  }

/*infoBox에서 그림에 해당하는 부분. 테두리를 표시한다.*/
  #thumbnail{
    height: inherit;
    width: 300px;
    border: 1px black solid;
  }

/*infoBox에서 곡정보에 해당하는 부분*/
  #infoPanel{
      display: inline-block;
      position: absolute;
      width: inherit;
      height: inherit;
      padding: 30px;
  }

/*infoBox에서 좋아요버튼에 해당하는 부분*/
  #songLike{
    height: 100px;
    width: 100px;
  }

/*가사를 보여주는 부분을 감싸는 패널*/
  #lyricPanel{
    text-align: center;
    padding: 50px;
    padding-top: 100px;
    padding-bottom: 100px;
  }

/*가사를 보여주는 부분*/
  #lyric{
    width: inherit;
    height: inherit;
  }
</style>
<?php
//모든 페이지에서 중복되는 최상단 부분을 표시한다.
  require_once("./view/top.html");

//해당 곡의 id를 GET으로 받아 DB에 곡에 대한 정보를 쿼리한다.
  if(isset($_GET['id']))
  {
    $id = htmlspecialchars($_GET['id']);
    require_once('lib/DBConnector.php');
    $conn = $mysqli;

    $sql = "select * from song where id= '{$id}'";

    $result = $conn->query($sql);

//받아온 정보를 파싱후 캐싱한다.
    if($result)
    {
      $row = $result->fetch_assoc();
      $name = htmlspecialchars($row['name']);
      $singer = htmlspecialchars($row['singer']);
      $link = htmlspecialchars($row['link']);
      $like = htmlspecialchars($row['recommend']);
      $thumbnail = htmlspecialchars($row['thumbnail']);
    }
  }
?>
<div id="content">
<h1>곡정보</h1>
<div id="infoBox">
  <?php
  //캐싱한 곡 정보를 적절한 화면에 뿌려준다.
  echo "<image id='thumbnail' src='src/{$thumbnail}'>";
   ?>
    <div id="infoPanel">
      <?php
      //곡의 정보를 보여주는 패널에 정보를 뿌려준다.
          echo "
          제목: <span id='title'>{$name}</span><br>
          가수: <span id='singer'>{$singer}</span><br>
          <a href='{$link}' target='_blank'> 듣기 </a><br><br>
          ";
          //좋아요 프로세스 폼
          echo "<form action='like_process.php' method='POST' style='display: inline;'>";
          //해당 곡의 id를 넘긴다.
          echo "<input type='hidden' name = 'songID' value='{$id}'>";
          echo "<input type='image' src='./src/heart.png' width='18px' height='18px' style='position: relative; top: 4px;'>";
          echo "</form>";
          echo "&nbsp;&nbsp;".$like;
          echo "<hr>";



  ?>
  </div>
</div>

<!--가사를 표시하는 패널-->
<div id='lyricPanel'>
  <!-- 제목 나타내기 -->
  <h3><?php echo $name;?></h3><br>
  <div id='lyric'>
    <!-- 가사 나타내기-->
  <?php
  //DB에서 곡 id에 해당하는 가사를 가져온다.
  $sql = "select lyric from lyric where song_id = {$id}";
  $result = $conn->query($sql);

  if($result)
  {
    $row = $result->fetch_assoc();
    $lyric = $row['lyric'];
    //가사를 표시한다.
    echo $lyric;
  }

   ?>

  </div>


</div>
</div>
<?php
//덧글을 표시한다.
  require("view/general_forum.php");
  //하단부분을 표시한다.
  require("view/bottom.html");
 ?>
