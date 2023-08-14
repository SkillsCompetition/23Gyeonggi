<?php
  session_start();
  date_default_timezone_set("Asia/Seoul");

  define("USER", @$_SESSION["user_101"]);
  define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
  define("G", $_GET);
  define("P", $_POST);
  define("F", $_FILES);
  define("U", explode("?", $_SERVER["REQUEST_URI"])[0]);

  function move($msg = false, $url = "back"){
    $url = $url == "back" ? "history.back()" : "location.href='$url'";

    if($msg){
      echo "<script>alert('$msg')</script>";
    }

    if($url){
      echo "<script>$url</script>";
    }

    exit;
  }

  function dd(){
    echo "<pre>";
    var_dump(...func_get_args());
    echo "</pre>";
  }

  function err($err, $msg = false, $url = "back"){
    if($err) move($msg, $url);
  }

  function emp_vali($chk){
    foreach($chk as $v){
      if(trim($v) == "") return true;
    }
    return false;
  }

  function view($loc, $data = [], $h = true, $f = true){
    extract($data);

    if($h) require ROOT."/view/header.php";
    require ROOT."/view/$loc.php";
    if($f) require ROOT."/view/footer.php";
  }
?>