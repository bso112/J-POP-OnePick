<?php
  require_once('lib/print.php');

  //곡에 대한 덧글을 표시하는 뷰
 ?>

  <?php
  //delete_process 수행시 비밀번호가 틀렸다면 경고창 띄움
    if(isset($_GET['ps']) && $_GET['ps'] == 0)
    {
      ?>
      <script> alert("비밀번호가 틀립니다!");</script>
      <?php
    }
   ?>

  <style>

/*전체 덧글을 감싸는 div*/
  #comentPanel{
    width: inherit; height: inherit;
    position: relative;
    background-color: lightgray;
  }

/*덧글을 작성하는 부분. 사용자 이름, 비밀번호, 덧글내용, 확인버튼, 글자수 카운트 텍스트가 들어가 있다.*/
  #entry{
    height: 200px;
  }

/*덧글의 내용을 작성하는 부분*/
  #description{
    position: absolute;
    left: 200px; width: 750px;
    overflow: auto;
    height: 130px;
  }

/*덧글 작성을 완료하는 버튼*/
  #submitBtn{
    position: absolute;
    margin-top: 85px; margin-left: 850px;
    width: 80px; height: 30px; text-align: center;
    color: white;
    line-height: 30px;
    background-color: #4a57a8;
    }

/*사용자 이름, 비밀번호를 입력하는 부분*/
    .user_info{
      height: 25px;
      margin: 5px;
    }

/*덧글 내용의 글자수를 세는 텍스트*/
    #charCountText{
      position: absolute;
      right: 150px;
      bottom: 10px;
    }


  </style>
  <script>

  //덧글 삭제하기 눌렀을 때. 덧글에 대한 패스워드를 입력하는 텍스트필드와 서밋버튼을 묶는 div를 표시한다. 한번 더 누르면 감춤.
    function clickBin(index) {
      var con = document.getElementById("div_trash_" + index);
        if(con.style.display=='none'){
            con.style.display = 'block';
        }else{
            con.style.display = 'none';
        }
    }

    //글 수정하기 눌렀을 때. 해당 덧글의 내용을 value로 하는 텍스트 필드를 감췄다가 보였다가한다.
    function clickPen(index){
      var description_form = document.getElementById("description_form_" + index);
      var description_div = document.getElementById("description_div_" + index);
      var description_text = document.getElementById("discription_text_" + index);
      if(description_form.style.display == 'none'){
        description_form.style.display = 'block';
        description_text.value = description_div.innerText;
        description_div.style.display = 'none';
      }else {
        description_form.style.display = 'none';
        description_div.style.display = 'block';
      }
    }

    //덧글쓰기에서 글자수 체크하기
    function countChar(obj)
    {
      var submitBtn = document.getElementById("submitBtn");
      var charCountText = document.getElementById("charCountText");
      var maxByte = 800;
      var description = obj.innerText;
      var currentLength = description.length;

      charCountText.innerText = currentLength + "/" + maxByte;

      if(currentLength> maxByte && submitBtn.disabled)
      {
        //아무것도 안함(800자 넘었을때 한 글자 지울 때마다 경고창 떠서 이렇게함)
      }
      else if(currentLength > maxByte)
      {
        alert("최대 허용 글자수를 초과하였습니다.");
        submitBtn.disabled = true;
        submitBtn.style.backgroundColor = 'lightgray';
      }
      else
      {
        submitBtn.disabled = false;
        submitBtn.style.backgroundColor = '#4a57a8';
      }
    }



  </script>


  <div style="border : 1px solid; padding:10px;" id='entry'>
    <!--덧글을 생성하는 폼-->
    <form action="create_process.php" method="post">
      <textarea name="description" value='this.innerText;' id='description' rows="10" cols="10" onkeyup="countChar(this)"></textarea>
      <div><input type="text" name="nickname" style="width:180px;" class = 'user_info' placeholder="닉네임"></div>
      <?php
      //해당 덧글이 표시된 곡의 id를 넘겨주는 필드를 추가한다.
        $songID = htmlspecialchars($_GET['id']);
        echo "<input type='hidden' name='songID' value='{$songID}'>";
       ?>
      <div><input type="password" name="password" style="width:180px;" class = 'user_info'placeholder="비밀번호"></div>
      <input type="submit" value="작성" id='submitBtn'>
      <span id='charCountText'>0/800</span>

    </form>
  </div>

  <div id='comentPanel'>
  <?php
  //게시글에 해당하는 덧글 나타내기
  printPostList();
  ?>
  </div>
