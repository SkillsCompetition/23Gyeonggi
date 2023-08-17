    <h1 class="page_title">명물 페이지</h1>
    
    <!-- 콘텐츠 -->
    <div class="content">
      
      <div class="special_section">
        <div class="wrap">
          <div class="title">
            <h1>명물</h1>
            <div class="line"></div>
            <p>천안의 맛있는 명물들입니다.</p>
          </div>

          <div class="special">
            <div class="top">
              <div class="btn_box">
                <div class="input_box">
                  <label for="filter">검색필터</label>
                  <select name="filter" id="filter">
                    <option value="name">이름</option>
                    <option value="addr">주소</option>
                  </select>
                </div>

                <div class="input_box">
                  <label for="search">검색어</label>
                  <input type="text" id="search">
                </div>
                
                <div class="btn" onclick="search()">검색</div>
              </div>
            </div>

            <div class="container">

            </div>
          </div>
        </div>
      </div>

    </div>

    <script>

      const initData = <?= json_encode($data)?>;

      setContainer(initData);
      function setContainer(data){
        $(".special .container").html(data.map(v => {
          return `
            <div class="item">
              <img src="${v.image}" alt="#" title="#">
              <div class="text_box">
                <div class="top flex jcsb aic">
                  <h2>${v.name}</h2>
                  <p><i class="fa fa-star"></i> ${v.score}</p>
                </div>

                <div class="bottom flex jcsb aic">
                  <p>${v.addr}</p>
                  <p>${v.phone}</p>
                </div>
              </div>
            </div>
          `
        }))
      }

      function search(){
        const key = $("#filter").val();
        const keyword = $("#search").val();

        const data = initData.filter(v => v[key].includes(keyword));
        setContainer(data);
      }

    </script>