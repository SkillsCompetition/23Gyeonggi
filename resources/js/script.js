const dd = console.log;

const ls = localStorage;

const App = {

  init(){
    if(location.pathname == "/") {
      Map.init();
      Parallax.init();
    };
    if(location.pathname.includes("menual")) Query.init();
    if(location.pathname.includes("game")) Game.init();
    if(location.pathname.includes("ranking")) Rank.init();
  },

}

const Parallax = {

  init(){
    Parallax.hook();
  },

  hook(){
    $(document)
      .on("scroll", Parallax.scroll)
  },

  scroll(){
    const nowY =  window.scrollY + window.innerHeight/2;
    
    Parallax.showText(nowY);
    Parallax.playVideo(nowY);

    Parallax.other(".page_top div:nth-child(1) img", "left");
    Parallax.other(".page_top div:nth-child(2) img", "right");
    Parallax.other(".page_top .scroll_down", "left");
  },

  showText(y){
    const offsetY = $(".parallax_text").offset().top;
    const height = $(".parallax_text").innerHeight();

    const count = $(".parallax_text span").length;
    const per = (y - offsetY)/height

    if(y > offsetY - 100 && y < offsetY + height + 200){
      let idx = Math.floor(count * per);
      idx = idx > 27 ? 27 : idx < 0 ? 0 : idx;

      $(".parallax_text span").css({
        color : "#0b0b08"
      })

      $(".parallax_text span").eq(idx).css({
        color : "#fff"
      })
    }
  },

  playVideo(y){
    const offsetY = $(".parallax_video").offset().top;
    const height = $(".parallax_video").innerHeight();

    const target = $(".parallax_video video");
    const duration = target[0].duration;
    const changeY = y - offsetY
    const per = changeY/height

    if(y > offsetY && y < offsetY + height){
      $(".parallax_video video").css({
        position : "fixed",
        top : `50%`
      });

      target[0].currentTime = duration * per;
    }else{
      $(".parallax_video video").css({
        position : "absolute",
        top : `${changeY > height ? height : changeY < 0 ? 0 : changeY}px`
      });
    }
  },

  other(target, targetType){
    const scale =  window.scrollY * 2;
    const type = {
      top : `translateY(-${scale}px)`,
      left : `translateX(-${scale}px)`,
      right : `translateX(${scale}px)`
    }

    $(target).css({
      "transform" : type[targetType]
    });
  }
}

const Map = {
  data : [],
  pos : [
    {
      rank : 1,
      x : 400,
      y : 450,
      scale : 1
    },
    {
      rank : 2,
      x : 200,
      y : 100,
      scale : .8
    },
    {
      rank : 1,
      x : 400,
      y : 140,
      scale : .6
    },
    {
      rank : 1,
      x : 100,
      y : 500,
      scale : .5
    },
    {
      rank : 1,
      x : 300,
      y : 300,
      scale : .4
    },
  ],

  async init(){
    await Map.loadData()
    Map.drawBackground().then(() => {
      Map.drawAttraction();
    });
  },

  drawBackground(){
    const canvas = $("#map")[0];
    const ctx = canvas.getContext("2d");

    return new Promise(res => {
      $("<img>", { src : "/resources/img/attraction/map.png" })[0]
        .onload = (e) => {
          ctx.drawImage(e.target, 0, 0, 640, 640);
          res();
        }
    })
  },

  drawAttraction(){
    const canvas = $("#map")[0];
    const ctx = canvas.getContext("2d");

    ctx.textAlign = "center";

    Map.data.sort((a, b) => b.count - a.count);
    const data = Map.data.slice(0, 5);

    data.forEach((v, i) => {
      const { x, y, scale } = Map.pos[i];
      
      ctx.fillStyle = "#ffb700bf"
      ctx.beginPath();
        ctx.arc(x, y, 100 * scale, 0, Math.PI*2);
      ctx.closePath();
      ctx.fill();

      ctx.fillStyle = "#000";
      ctx.font = `bold ${22 * scale}px sans`;

      ctx.fillText(`${i + 1}위`, x, y - (50 * scale));
      ctx.fillText(v.name, x, y + 2);
      ctx.fillText(v.count, x, y + (50 * scale));
    });
  },

  loadData(){
    return $.getJSON("/resources/json/place.json")
      .then(res => {
        Map.data = res;
      })
  }

}

const Query = {
  API_KEY : null,
  keys : [],

  init(){
    Query.loadKeys();
  },

  open(){
    Modal.open("api");

    if(Query.API_KEY){
      $("#api_key")
        .val("*****")
        .prop("disabled", true);

      $(".modal .btn.toggle").toggle();
    }
  },

  setting(type){
    if(type){
      if($("#api_key").val().trim() == "") return alert("API 키를 입력해주세요.");
      Query.API_KEY = $("#api_key").val()

      $("#api_key")
        .val("*****")
        .prop("disabled", true)

        $(".modal .btn.toggle").toggle();
    }else{
      Query.API_KEY = null;

      $("#api_key")
        .val("")
        .prop("disabled", false)

        $(".modal .btn.toggle").toggle();
    }
  },
  
  sort(){
    const sql = $("#sql").val().replaceAll(/[\n\s\t]{1,}/g, " ");
    const subQeury = sql.match(/\(.*\)/g);
    const mainQuery = sql.replaceAll(/\(.*\)/g, "(sub)").split(/(?=FROM|WHERE|GROUP BY|ORDER BY)/)

    const changeMainQuery = Query.sortingQuery(mainQuery);

    const changeSubQuery = subQeury?.map(query => {
      const splitQuery = query.split(/(?=FROM|WHERE|GROUP BY|ORDER BY)/);
      return Query.sortingQuery(splitQuery, 1, "\n ");
    }) || [];

    const complete = changeSubQuery.reduce((acc, v) => {
      const len = acc.match(/.*(?=\(sub\))/)[0].length;
      return acc.replace("(sub)", v.replaceAll(`\n`, "\n".padEnd(len + 1, " ")));
    }, changeMainQuery);

    $("#sql").val(complete)
  },

  sortingQuery(query, count = 0, join = "\n"){
    return query.map((v) => {
      let str = v;

      if(v.includes("SELECT")) {
        str = str.replaceAll(/\s,\s|,\s|\s,|,/g, ",\n".padEnd(9 + count, " "))
      };

      if(v.includes("FROM")) {
        str = str.replaceAll(/\s,\s|,\s|\s,|,/g, ",\n".padEnd(8 + count, " "))
      };

      if(v.includes("AND") || v.includes("OR")){
        str = str.replaceAll(/(?=AND\s|OR\s)/g, "\n".padEnd(8 + count, " "))
      }

      if(v.includes("WHERE")){
        str = str.replaceAll(/\s,\s|,\s|\s,|,/g, ",\n".padEnd(9 + count, " "))
      }

      if(v.includes("ORDER BY") || v.includes("GROUP BY")) {
        str = str.replaceAll(/\s,\s|,\s|\s,|,/g, ",\n".padEnd(12 + count, " "))
      }

      return str;
    }).join(join);
  },

  copy(){
    navigator.clipboard.writeText($("#sql").val()).then(() => {
      alert("클립보드에 복사되었습니다.");
    })
  },

  request(){
    if(!Query.API_KEY) return alert("API키를 설정해주세요.");
    if($(".menual input, .menual textarea").toArray().some(v => v.value.trim() == "")) return alert("모든 값을 입력해주세요.");

    const data = {
      sql : $("#sql").val(),
      page : $("#page").val(),
      perPage : $("#per_page").val()
    }

    $(".menual .right span")
      .html(`/api/place/${data.sql}/${data.page}/${data.perPage}/${Query.API_KEY}`)

    if(!Query.keys.includes(Query.API_KEY)){
      $(".menual pre").html(`{\n\t"message" : "API키가 올바르지 않습니다."\n}`);
    }else{
      $.getJSON("/resources/json/place.json")
        .then(res => {
          $(".menual pre").html(JSON.stringify(res, null, 4));
        })
    }
  },

  loadKeys(){
    $.getJSON("/resources/json/key.json")
      .then(res => {
        Query.keys = res;
      })
  }

}

const Game = {
  data : [],
  totalRound : Infinity,
  nowRound : Infinity,
  gameType : null,

  async init(){
    Game.gameType = location.hash.replace("#", "");
    await Game.loadData();

    if(ls["game"] && confirm("이어하시겠습니까?")){
      Game.load();
    }else{
      ls["game"] = "";
      Modal.open("game");
    }
  },

  start(){
    const round = Number($("#round").val());
    Game.nowRound = round;

    Game.prevData = [...Game.data].map((v, i) => i).sort(() => Math.random() - 0.5).slice(0, round);
    Game.nextData = [];

    Modal.close();
    Game.next();
  },

  next(){
    const now = Game.prevData.splice(0, 2)

    Game.setItem(now);
  },

  setItem(data){
    $(".game_section .container").html(data.map(v => {
      return `
        <div class="item" onclick="Game.select(this, ${v})">
          <img src="${Game.data[v].image}" alt="">
          <h1>${Game.data[v].name}</h1>
        </div>
      `
    }));
  },

  select(target, idx){
    Game.nextData.push(idx);

    $(".game_section .item").css({
      "pointer-events" : "none"
    }).animate({
      "opacity" : 0
    }, 500);

    Game.save();

    $(target).stop();
    if(Game.prevData.length <= 0){
      setTimeout(Game.changeRound, 1000);
    }else{
      setTimeout(Game.next, 1000);
    }
  },

  changeRound(){
    Game.prevData = [...Game.nextData];
    Game.nextData = [];

    Game.nowRound /= 2;

    if(Game.nowRound == 1){ 
      Game.showResult();
    }else{  
      Modal.open("changeRound");
      $(".modal .round").html(Game.nowRound == 2 ? "결승" : Game.nowRound);

      setTimeout(() => {
        Modal.close();
        Game.next();
      }, 1500);
    }

  },

  showResult(){
    Modal.open("result");

    const data = JSON.parse(ls[Game.gameType]);
    data[Game.prevData[0]].count++;

    ls[Game.gameType] = JSON.stringify(data);
    ls["game"] = "";

    $(".result_modal .result").html(`
      <img src="${Game.data[Game.prevData[0]].image}" alt="">
      <h1>${Game.data[Game.prevData[0]].name}</h1>
    `)
  },

  loadData(){
    if(!ls["place"]){
      $.getJSON(`/resources/json/place.json`)
        .then(v => {
          ls["place"] = JSON.stringify(v);
        });
    }

    if(!ls["food"]){
      $.getJSON(`/resources/json/food.json`)
        .then(v => {
          ls["food"] = JSON.stringify(v);
        });
    }

    return $.getJSON(`/resources/json/${Game.gameType}.json`)
      .then(v => {
        Game.data = v;
      });
  },

  save(){
    const saveData = {
      type : Game.type,
      nowRound : Game.nowRound,
      prevData : Game.prevData,
      nextData : Game.nextData
    }

    ls["game"] = JSON.stringify(saveData);
  },

  load(){
    const { type, nowRound, prevData, nextData } = JSON.parse(ls["game"]);

    Game.type = type;
    Game.nowRound = nowRound;
    Game.prevData = prevData;
    Game.nextData = nextData;

    if(prevData.length <= 0) Game.changeRound();
    else Game.next();
  }

}

const Rank = {
  place : [],
  food : [],

  async init(){
    await Rank.loadData();

    Rank.settingData();
  },

  settingData(){
    Rank.place.sort((a, b) => b.count - a.count);
    $(".placerank .container").html(Rank.place.slice(0, 10).map((v, i) => {
      return `
        <div class="item">
          <h2><span>${i + 1}위</span>${v.name}</h2>
          <p>별점 ${v.count}</p>
        </div>
      `
    }))

    Rank.food.sort((a, b) => b.count - a.count);
    $(".foodrank .container").html(Rank.food.slice(0, 10).map((v, i) => {
      return `
        <div class="item">
          <h2><span>${i + 1}위</span>${v.name}</h2>
          <p>별점 ${v.count}</p>
        </div>
      `
    }))
  },

  loadData(){
    const promise = [];

    if(!ls["place"]){
      promise.push($.getJSON(`/resources/json/place.json`)
        .then(v => {
          ls["place"] = JSON.stringify(v);
          Rank.place = v;
        }));
    }else{
      Rank.place = JSON.parse(ls["place"]);
    }

    if(!ls["food"]){
      promise.push($.getJSON(`/resources/json/food.json`)
        .then(v => {
          ls["food"] = JSON.stringify(v);
          Rank.food = v;
        }));
    }else{
      Rank.food = JSON.parse(ls["food"]);
    }

    return Promise.all(promise)
  }

}

const Modal = {
  template : (t) => $($("template")[0].content).find(`.${t}_modal`).clone(),

  open(t){
    $("body").css("overflow", "hidden");

    $(".modal")
      .addClass("open")
      .html(Modal.template(t));
  },

  close(){
    $("body").css("overflow", "");

    $(".modal")
      .removeClass("open")
      .html("");
  }
}

$(() => App.init());