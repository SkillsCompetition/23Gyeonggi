<?php

  function notUser(){
    err(@USER, "로그인한 회원은 접근할 수 없습니다.", "/");
  }

  function user(){
    err(!USER, "로그인 후 접근해주세요.", "/");
  }

?>