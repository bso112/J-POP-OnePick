
<?php
  require_once("./lib/print.php");

 ?>

  <style>

  /*화면에 표시되는 모든 컨텐츠의 부모 컨테이너에 대한 스타일*/
    #content {
      position: relative;
    }

/*곡정보 카드를 보여주는 영역에 대한 스타일. 중앙정렬한다.*/
    #songPanel {
      position: relative;
      width: 910px;
      height: 614px;
      margin: auto;
      top: 20px;

    }

/*곡정보 카드 하나에 대한 스타일. 그리드 형식으로 배치되고, 그림이 들어간다.*/
    .songBox {
      width: 200px;
      height: 200px;
      border: 1px black solid;
      border-radius: 30px;
      margin: 50px;
      display: inline-flex;
      position: relative;
      overflow: hidden;
      align-items: stretch;
      justify-content: center;
    }

/*songBox에 마우스를 hover헸을때 나오는 카드로, 곡명, 가수명을 표시한다.*/
    #songInfo {
      position: absolute;
      bottom: 0px;
      width: inherit;
      height: 50px;
      background-color: #ecf0f1;
      visibility: hidden;
      text-align: center;
    }

  </style>
  <script>

  //sonBox에 마우스 hover시 수행할 동작. songInfo를 나타낸다.
    function showMusicInfo(songBox) {
      var songInfo = songBox.children[1];
      songInfo.style.visibility = 'inherit';

    }
//songBox에 마우스 hover에서 벗어날때 수행할 동작. songInfo를 숨긴다.
    function clearMusicInfo(songBox) {
      var songInfo = songBox.children[1];
      songInfo.style.visibility = 'hidden';
    }


  </script>


<?php
//모든 페이지에서 중복되는 윗부분은 재사용을 위해 따로 뺌.
  require("view/top.html");
  ?>
    <div id="content">
      <div id="songPanel">
        <?php
        //DB에 접속해 가져온 정보를 활용해 SongBox를 띄우기 때문에 따로 뺌.
          printSongBoxes();
         ?>
      </div>
    </div>
<?php
//마찬가지로 중복되는 아랫부분은 따로 뺌.
  require("view/bottom.html");
?>
