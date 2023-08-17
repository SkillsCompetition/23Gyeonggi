
    <h1 class="page_title">API키 발급 페이지</h1>
    
    <!-- 콘텐츠 -->
    <div class="content">

      <div class="application_section">
        <div class="wrap">
          <div class="title">
            <h1>발급</h1>
            <div class="line"></div>
            <p>API키를 발급 받으세요.</p>
          </div>

          <form action="/application" method="POST" class="application">
            <div class="inputs">
              <div class="input_box apikey_input">
                <label for="application_key">발급된 API키</label>
                <input type="text" name="application_key" id="application_key" placeholder="발급 후 확인해주세요." value="<?= @$key["api_key"] ?>" readonly disabled>
              </div>
              
              <div class="input_box">
                <label for="name">어플이름</label>
                <input type="text" name="name" id="name">
              </div>
              <div class="input_box">
                <label for="url">어플URL</label>
                <input type="text" name="url" id="url">
              </div>
              <div class="input_box textarea">
                <label for="description">어플개요</label>
                <textarea name="description" id="description"></textarea>
              </div>
              <button class="btn">API키 발급</button>
            </div>
          </form>
        </div>
      </div>

    </div>
