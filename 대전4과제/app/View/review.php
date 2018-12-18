        <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <!-- page title start-->
              <h1 class="page-title">
                <?=$name?> 리뷰
              </h1>
              <!-- page title end-->
            </div>

            <!-- contents start -->
            <div class="col-12">
              <div class="row">
                  <div class="col-12">
                    <div class="mb-2 text-right">
                      <button type="submit" class="btn btn-primary" onclick="history.back()">메뉴목록</button>
                    </div>
                  </div>
                  
                  <?php foreach($list as $value):?>
                  <div class="card">
                    <div class="card-body1 p-5">
                      <article class="media">
                        <div class="media-body">
                          <div class="content">
                            <p class="h5">
                              <small><?=$value['m_name']?> (<?=idStart($value['m_id'])?>)</small> 
                              <small>평점 : 5점</small> 
                              <?php $date = explode("-",$value['r_date'])?>
                              <small class="float-right text-muted"><?=join(". ",$date)?></small>
                            </p>
                            <p>
                              <?=$value['r_content']?>
                            </p>
                          </div>
                        </div>
                      </article>
                    </div>
                  </div>
                  <?php endforeach;?>
              </div>
            </div>
            <!-- contents end -->

          </div>
        </div>
      </div>
     
      <footer class="footer">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-auto col-lg-auto mt-3 mt-lg-0 text-center">
              Copyright © 2018 <a href="">우리동네배달</a> All rights reserved.
            </div>
          </div>
        </div>
      </footer>
    </div>
  </body>
</html>