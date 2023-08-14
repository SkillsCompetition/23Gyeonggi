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

  get("/application", function(){
    view("application");
  });

  get("/attraction", function(){
    view("attraction");
  });

  middleware("notUser", function(){

    get("/join", function(){
      view("join");
    });

    get("/login", function(){
      view("login");
    });
    
  });

?>