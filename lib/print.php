<?php
require_once('lib/DBConnector.php');
//db커넥터와 print사이의 의존관계 제거. db커넥터의 mysqli 변수 이름을 바꿔도 print.php에는 영향없다.
$conn = $mysqli;

//DB에 접속해 정보를 띄워줄 필요가 있는 html에 대해서는 여기서 처리한다.

//index.php의 songBox를 표시한다.
function printSongBoxes()
{
    global $conn;


    $sql = "select id, name, singer, thumbnail from song limit 30";
    $result = $conn->query($sql);

    //디비에서 가져온 정보를 파싱해서 뿌려준다.
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $name = htmlspecialchars($row['name']);
            $singer = htmlspecialchars($row['singer']);
            $thumbnail= htmlspecialchars($row['thumbnail']);
            $id = htmlspecialchars($row['id']);

            //곡에 대한 게시글로 이동하는 form이다. 해당 곡의 id를 넘겨준다.
            echo
            "<form action='songInfo.php' method='GET' style='display:inline-block;'>
             <input type='hidden' value='{$id}' name='id'>
            ";
            //DB에서 가져온 정보로 songBox를 구성한다.
            echo
            '<div class="songBox" onmouseover="showMusicInfo(this)" onmouseout="clearMusicInfo(this)">
            <input type="image" src="./src/'."{$thumbnail}".'" style="width:200px; height:200px;">
            <div id="songInfo">
            제목: <span id="songTitle">'."{$name}".'</span><br>
            가수: <span id="singer">'."{$singer}".'</span>
            </div>
            </div>
            </form>
            ';

        }
    }
}



//songInfo.php에서 표시되는 덧글을 출력하는 함수
function printPostList()
{
    global $conn;

    if(isset($_GET['id']))
    {
      $songID = htmlspecialchars($_GET['id']);

    }

    //출력할 덧글 리스트를 DB에 요청한다. 곡 id에 해당하는 덧글만 가져온다.
    if ($stmt = $conn->prepare("select * from post where song_id = ? limit ?")) {
        $limit = 100;
        $stmt->bind_param("ii", $songID, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        //post는 덧글이다. div_trash는 글을 삭제할때 사용하는 쓰레기통 아이콘이다.
        echo "<style>
      #post {
        width: inherit; height: inherit;
        position: absolute;


      }

      .div_trash{
        width: 200px; height: 50px;
        position: absolute;
        right:0px;
      }


    </style>";

        //덧글 전체를 묶는 div
        echo "<div id='post'>";

        //DB에서 가져온 정보를 파싱한다.
        while ($row = $result->fetch_assoc()) {
            $nickname = htmlspecialchars($row['nickname']);
            $description = htmlspecialchars($row['description']);
            $date = htmlspecialchars($row['updated_date']);
            $postID = htmlspecialchars($row['id']);
            $like = htmlspecialchars($row['recommend']);


            //덧글 작성자와 작성일을 표시한다. 또한 갱신 아이콘을 표시한다.
            echo "<hr>";
            echo "{$nickname}&nbsp;&nbsp;&nbsp;{$date}";
            echo "<image src=\"./src/pen.png\" width='20px' height='20px' align='right' onclick='clickPen($postID)'>";

            //삭제 프로세스 폼
            echo "<form action='delete_process.php' method='POST' style='display: inline;'>";
            //삭제 프로세스에 덧글 ID와 해당 곡 ID를 넘겨준다.
            echo "<input type='hidden' name='postID' value='{$postID}'>";
            if(isset($songID))
            {
              echo "<input type='hidden' name='songID' value='{$songID}'>";

            }
            //삭제 버튼을 눌렀을 때 비밀번호를 입력하게 하는 창인 div_trash를 표시한다.
            echo "<image src=\"./src/bin.png\" width='20px' height='20px' align='right' style='float: right;' onclick='clickBin($postID)'>";
            echo "<div class = 'div_trash' id='div_trash_$postID' style='display: none;'>";
            echo "<input type='password' style='float: right;' name='password'/>";
            echo "<input type='submit' value='삭제' style='float: right;'/>";
            echo "</div>";
            echo "</form>";

            //갱신 프로세스 폼
            echo "<div id='description_form_$postID' style='display: none;'>";
            echo "<form action='update_process.php' method='POST'>";
            echo "<input type='hidden' name='postID' value='{$postID}'>";
            if(isset($songID))
              echo "<input type='hidden' name='songID' value='{$songID}'>";
            echo "<input type='text' id='discription_text_$postID' name = 'description' row='10' col='50'>";
            echo "<input type='submit' value='완료'>";
            echo "</form>";
            echo "</div>";

            //덧글 내용을 표시한다.
            echo "<div id='description_div_$postID' >$description</div>";
            echo "<br>";

            //좋아요 프로세스 폼
            echo "<form action='like_process.php' method='POST' style='display: inline;'>";
            echo "<input type='hidden' name='postID' value='{$postID}'>";
            if(isset($songID))
              echo "<input type='hidden' name='songID' value='{$songID}'>";
            echo "<input type='image' src='./src/heart.png' width='18px' height='18px' style='position: relative; top: 4px;'>";
            echo "</form>";
            //좋아요 수를 표시한다.
            echo "&nbsp;&nbsp;".$like;
            echo "<hr>";
        }

        echo "</div>";
        //닫아줘야 커넥션이 쌓이지 않음(쌓이면 DB에 무리가감.)
        mysqli_close($conn);
    }
}
