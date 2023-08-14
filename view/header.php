<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="/resources/js/jquery.js"></script>
  <script src="/resources/js/script.js"></script>
  <link rel="stylesheet" href="/resources/icons/fontawesome-free-6.4.0-web/css/all.css">
  <link rel="stylesheet" href="/style.css">
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
          <a href="/ranking" class="depth1">랭킹</a>
          <div class="depth_box">
            <a href="#" class="depth1">정보</a>
            <div class="submenu">
              <a href="/special" class="depth2">명물</a>
              <a href="/attraction" class="depth2">명소</a>
            </div>
          </div>
          <div class="depth_box">
            <a href="#" class="depth1">API</a>
            <div class="submenu">
              <a href="/menual" class="depth2">매뉴얼</a>
              <a href="/application" class="depth2">발급</a>
              <a href="#" class="depth2">관리자</a>
            </div>
          </div>

          <?php if(@USER): ?>
            <p class="depth1"><?= USER["username"] ?>님</p>
            <a href="/logout" class="depth1">로그아웃</a>
          <?php else: ?>
            <a href="/login" class="depth1">로그인</a>
            <a href="/join" class="depth1">회원가입</a>
          <?php endif ?>
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
