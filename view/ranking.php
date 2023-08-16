    <h1 class="page_title">랭킹 페이지</h1>
    
    <!-- 콘텐츠 -->
    <div class="content">
      <div class="double_section">
        <div class="wrap">
          <div class="placerank_section">
            <div class="title">
              <h1>천안 명소 TOP 10</h1>
              <div class="line"></div>
              <p>천안의 인기있는 명소 10곳입니다.</p>
            </div>
  
            <div class="placerank col-flex">
              <a href="/game#place" class="btn"><i class="fa fa-gamepad"></i>게임하기</a>
              <div class="container">

                <?php foreach($place as $k => $v): ?>
                  <div class="item">
                    <h2><span><?= $k + 1 ?>위</span><?= $v["name"] ?></h2>
                    <p>별점 <?= $v["score"] ?></p>
                  </div>
                <?php endforeach ?>

              </div>
            </div>
          </div>

          <div class="foodrank_section">
            <div class="title">
              <h1>천안 맛집 TOP 10</h1>
              <div class="line"></div>
              <p>천안의 인기있는 맛집 10가지입니다.</p>
            </div>
  
            <div class="foodrank col-flex">
              <a href="/game#food" class="btn"><i class="fa fa-gamepad"></i>게임하기</a>
              <div class="container">
              
                <?php foreach($food as $k => $v): ?>
                  <div class="item">
                    <h2><span><?= $k + 1 ?>위</span><?= $v["name"] ?></h2>
                    <p>별점 <?= $v["score"] ?></p>
                  </div>
                <?php endforeach ?>
  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>