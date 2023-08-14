<?php

  function notUser(){
    err(@USER, "로그인한 회원은 접근할 수 없습니다.", "/");
  }
?>