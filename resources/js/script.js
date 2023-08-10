const dd = console.log;

const App = {

  init(){
    if(location.pathname == "/") Map.init();
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

  init(){

  },
  
}

$(() => App.init());