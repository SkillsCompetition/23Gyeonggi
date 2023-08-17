<?php

  get("/", function(){
    view("index", [], true, false);
  });

  get("/ranking", function(){
    $place = array_slice(place::all("ORDER BY score DESC"), 0, 10);
    $food = array_slice(food::all("ORDER BY score DESC"), 0, 10);

    view("ranking", get_defined_vars());
  });

  get("/game_data/$", function($type){
    if($type == "place") echo json_encode(place::all());
    if($type == "food") echo json_encode(food::all());
  });

  post("/rank", function(){
    $table = P["table"];
    dd($table);
    DB::mq("UPDATE $table SET score = score + 1 WHERE idx = ?", P["idx"]);
  });

  get("/game", function(){
    view("game", [], false, false);
  });

  get("/special", function(){
    $data = food::all();

    view("special", get_defined_vars());
  });

  get("/attraction", function(){
    $data = place::all();

    view("attraction", get_defined_vars());
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

    get("/logout", function(){
      session_destroy();

      move("로그아웃 되었습니다.", "/");
    });

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

    get("/menual", function(){
      view("menual");
    });

    get("/api/place/$/$/$/$", function($sql, $page, $perPage, $api_key){
      $chkKey = application::find("api_key = ?", $api_key);
  
      if(!$chkKey) echo json_encode([
        "message" => "API키가 올바르지 않습니다."
      ]);
  
      try{
        $sql = urldecode($sql);
        $lower = strtolower($sql);
        if(!strpos($lower, "from place") && !strpos($lower, "from food"))
          throw new Exception("테이블은 place 또는 food만 접근 가능합니다.", '123123123');

        if(preg_match_all("/\(.*select.*\)/iU", $sql) > 1)
          throw new Exception("서브 쿼리는 1개만 사용 가능합니다.", '123123123');

        if(!preg_match("/select (.*idx.*|\*) from/i", $sql)){
          $sql = preg_replace("/select/i", "select idx,", $sql);
        }

        $table = strpos($lower, "from place") ? "place" : "food";
        $data = DB::mq($sql)->fetchAll();

        $permission = permission::find("userid = ? && target_table = ?", [USER["userid"], $table]);
        $permission = @$permission ? json_decode($permission["list"], true) : [];

        $data = array_map(function($v) use ($permission){
          unset($v["image"]);

          foreach($permission as $key){
            if(!@$v[$key]) continue;

            $v[$key] = "허용되지 않은 컬럼";
          };

          return $v;
        }, $data);
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
      }catch(Exception $err){
        if($err->getCode() == 123123123){
          echo json_encode([
            "message" => $err->getMessage()
          ], JSON_UNESCAPED_UNICODE);
        }else{
          echo json_encode([
            "message" => "올바른 QUERY문을 작성해주세요."
          ], JSON_UNESCAPED_UNICODE);
        }
        
      };
    });

  });

  middleware("admin", function(){

    get("/api_admin", function(){
      view("api_admin");
    });

    get("/permission/$/$", function($userid, $table){
      $user = user::find("userid = ?", $userid);
      $permission = permission::find("userid = ? && target_table = ?", [$userid, $table]);

      echo json_encode([
        "user" => boolval($user),
        "permission" => !$permission ? [] : $permission["list"]
      ]);
    });

    post("/permission/$/$", function($userid, $table){
      $permission = permission::find("userid = ? && target_table = ?", [$userid, $table]);

      if(!$permission){
        permission::insert([
          "list" => json_encode(P["list"]),
          "target_table" => $table,
          "userid" => $userid
        ]);
      }else{
        permission::update("userid = ? && target_table = ?", [$userid, $table], [
          "list" => json_encode(P["list"])
        ]);
      }

      http_response_code(200);
    });

    get("/permission_list", function(){
      $data = DB::mq("SELECT permission.*, application.api_key FROM permission LEFT JOIN application ON application.userid = permission.userid")->fetchAll();

      echo json_encode($data);
    });

  });

?>