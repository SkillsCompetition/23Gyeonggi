const dd = console.log;

const App = {

  init(){
    if(location.pathname == "/") Map.init();
    if(location.pathname.includes("menual")) Query.init();
  },

  hook(){

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
        .val("*".repeat(Query.API_KEY.length))
        .prop("disabled", true);

      $(".modal .btn.toggle").toggle();
    }
  },

  setting(type){
    if(type){
      if($("#api_key").val().trim() == "") return alert("API 키를 입력해주세요.");
      Query.API_KEY = $("#api_key").val()

      $("#api_key")
        .val("*".repeat(Query.API_KEY.length))
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
    })

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