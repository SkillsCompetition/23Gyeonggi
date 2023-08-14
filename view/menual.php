    <h1 class="page_title">API 메뉴얼 페이지</h1>
    
    <!-- 콘텐츠 -->
    <div class="content">

      <div class="menual_section">
        <div class="wrap">
          <div class="title">
            <h1>메뉴얼</h1>
            <div class="line"></div>
            <p>API 메뉴얼을 확인하세요.</p>
          </div>

          <div class="menual">
            <div class="left inputs">
              <div class="btn" onclick="Query.open()">인증키 설정</div>
              <div class="input_box">
                <label for="page">페이지 번호</label>
                <input type="text" id="page" name="page">
              </div>
              
              <div class="input_box">
                <label for="page">한 페이지 결과 수</label>
                <input type="text" id="per_page" name="per_page">
              </div>

              <div class="input_box textarea">
                <label for="sql">QUERY문</label>
                <textarea name="sql" id="sql"></textarea>
              </div>

              <div class="btn_box full">
                <div class="btn" onclick="Query.sort()">정렬</div>
                <div class="btn" onclick="Query.copy()">복사</div>
                <div class="btn" onclick="Query.request()">API호출</div>
              </div>
            </div>

            <div class="right col-flex">
              <div class="box">
                <p>요청 주소 : <br><span></span></p>
              </div>

              <div class="pre_box">
                <pre>
  
                </pre>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>

    <template>

      <div class="api_modal">
        <div class="main">
          <div class="top flex jcc aic">
            <h3>인증키 설정</h3>
          </div>
          <div class="inputs">
            <div class="input_box">
              <label for="api_key">API키</label>
              <input type="text" id="api_key">
            </div>
          </div>
        </div>
        <div class="btn_box full">
          <div class="btn toggle" onclick="Query.setting(true)">설정</div>
          <div class="btn toggle" onclick="Query.setting(false)" style="display: none;">설정해제</div>
          <div class="btn" onclick="Modal.close()">닫기</div>
        </div>
      </div>

    </template>