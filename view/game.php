<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="/resources/js/jquery.js"></script>
  <script src="/resources/js/script.js"></script>
  <link rel="stylesheet" href="resources/icons/fontawesome-free-6.4.0-web/css/all.css">
  <link rel="stylesheet" href="style.css">
  <title>Document</title>
</head>
<body>                    

  <input type="checkbox" name="menu" id="menu" hidden>
  <label for="menu" class="menu_btn"><i class="fa fa-bars"></i></label>
  <div class="menu_nav">
    <label for="menu"></label>
    <div class="side_box col-flex jcsb">
      <div class="top col-flex aife">
        <label for="menu" class="close"><i class="fa fa-times"></i></label>
        <div class="menu">
          <a href="/" class="depth1">천안명물명소</a>
          <a href="ranking.html" class="depth1">랭킹</a>
          <div class="depth_box">
            <a href="#" class="depth1">정보</a>
            <div class="submenu">
              <a href="special.html" class="depth2">명물</a>
              <a href="attraction.html" class="depth2">명소</a>
            </div>
          </div>
          <div class="depth_box">
            <a href="#" class="depth1">API</a>
            <div class="submenu">
              <a href="menual.html" class="depth2">매뉴얼</a>
              <a href="application.html" class="depth2">발급</a>
              <a href="#" class="depth2">관리자</a>
            </div>
          </div>
          <a href="#" class="depth1">로그인</a>
          <a href="#" class="depth1">회원가입</a>
        </div>
      </div>

      <div class="bottom col-flex">
        <div class="sns_box flex">
          <i class="fab fa-facebook"></i>
          <i class="fab fa-instagram"></i>
          <i class="fab fa-twitter"></i>
        </div>
        <div class="flex jcsb aic">
          <p>(31162) 충남 천안시 서북구 번영로 156</p>
          <p>031-1234-4321</p>
        </div>
      </div>
    </div>
  </div>

  <div id="root">
    
    <!-- 콘텐츠 -->
    <div class="game_section">
      <div class="guide_line"></div>
      <div class="container">
      </div>
    </div>
  
  </div>

  <template>

    <div class="game_modal">
      <div class="main">
        <div class="top flex jcc aic">
          <h3>이상형 월드컵 게임</h3>
        </div>
        <div class="inputs">
          <div class="input_box">

            <label for="round">총 라운드</label>
            <select name="round" id="round">
              <option value="4">4강</option>
              <option value="8">8강</option>
              <option value="16">16강</option>
              <option value="32">32강</option>
            </select>

          </div>

        </div>
      </div>
      <div class="btn_box full">
        <div class="btn" onclick="Game.start()">시작하기</div>
      </div>
    </div>

    <div class="changeRound_modal">
      <div class="main">
        <div class="top flex jcc aic">
          <h3>이상형 월드컵 게임</h3>
        </div>
        <div class="flex jcc aic">
          <small>
            <span class="round">32</span>강
          </small>
        </div>
      </div>
    </div>

    <div class="result_modal">
      <div class="main">
        <div class="top flex jcc aic">
          <h3>이상형 월드컵 게임</h3>
        </div>
        <div class="result col-flex jcc aic">
        </div>
      </div>
      <div class="btn_box full">
        <div class="btn" onclick="location.href='/ranking'">전체 결과보기</div>
        <div class="btn" onclick="Modal.open('game')">다시하기</div>
      </div>
    </div>

  </template>

  <div class="modal"></div>
  
</body>
</html>