    <h1 class="page_title">명소 페이지</h1>
    
    <!-- 콘텐츠 -->
    <div class="content">
      
      <div class="attraction2_section">
        <div class="wrap">
          <div class="title">
            <h1>명소</h1>
            <div class="line"></div>
            <p>천안의 아름다운 명소들입니다.</p>
          </div>

          <div class="attraction2">
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

              <div class="item">
                <img src="resources/img/attraction/sub/6.jpg" alt="#" title="#">
                <div class="text_box">
                  <div class="top flex jcsb aic">
                    <h2>유관순열사기념관</h2>
                    <p><i class="fa fa-star"></i> 3.3</p>
                  </div>

                  <div class="bottom flex jcsb aic">
                    <p>충청남도 천안 동남구 병천면 유관순길 38</p>
                    <p>041-552-6463</p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>


    <script>

      const initData = <?= json_encode($data)?>;

      setContainer(initData);
      function setContainer(data){
        $(".attraction2 .container").html(data.map(v => {
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