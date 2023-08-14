<?php

  get("/", function(){
    view("index", [], true, false);
  });

  get("/menual", function(){
    view("menual");
  });

  get("/ranking", function(){
    view("ranking");
  });

  get("/game", function(){
    view("game", [], false, false);
  });

  get("/special", function(){
    view("special");
  });

  get("/attraction", function(){
    view("attraction");
  });

  middleware("notUser", function(){

    get("/join", function(){
      view("join");
    });

    post("/join", function(){
      err(emp_vali(P), "모든 값을 입력해주세요.");

      $find = user::find("userid = ?", P["userid"]);
      err($find, "중복된 아이디가 존재합니다.");

      user::insert(P);
      move("회원가입이 완료되었습니다.", "/login");
    });

    get("/login", function(){
      view("login");
    });

    post("/login", function(){
      $find = user::find("userid = ? && password = ?", array_values(P));
      err(!$find, "아이디 혹은 비밀번호가 옳지 않습니다.");

      $_SESSION["user_101"] = $find;

      move("로그인 되었습니다.", "/");
    });

  });

  middleware("user", function(){

    get("/application", function(){
      $key = application::find("userid = ?", USER["userid"]);
  
      view("application", get_defined_vars());
    });

    post("/application", function(){
      err(emp_vali(P), "모든 값을 입력해주세요.");

      $find = application::find("userid = ?", USER["userid"]);
      err($find, "이미 발급되었습니다.");

      $idx = application::insert(array_merge(P, [
        "userid" => USER["userid"],
        "api_key" => substr(bin2hex(random_bytes(40)), 20, 15)
      ]));

      move("발급되었습니다.", "/application");
    });

  });

?>