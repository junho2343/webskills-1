  <script type="text/javascript">
    $(function(){
      posToggle();
      searchToggle();
    })
  </script>
          <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <!-- page title start-->
              <h1 class="page-title">
                 주문하기
              </h1>
              <!-- page title end-->
            </div>

            <!-- contents start -->
            <div class="col-12">
              <div class="row">
                
                <div class="form-group col-12">
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item" data-type="all">
                      <input type="radio" name="value" value="50" class="selectgroup-input" <?=$type == "" ? "checked" : ""?> >
                      <span class="selectgroup-button">전체보기</span>
                    </label>
                    <label class="selectgroup-item" data-type="a">
                      <input type="radio" name="value" value="100" class="selectgroup-input" <?=$type == "a" ? "checked" : ""?>>
                      <span class="selectgroup-button">한식</span>
                    </label>
                    <label class="selectgroup-item" data-type="b">
                      <input type="radio" name="value" value="100" class="selectgroup-input" <?=$type == "b" ? "checked" : ""?>>
                      <span class="selectgroup-button">중식</span>
                    </label>
                    <label class="selectgroup-item" data-type="c">
                      <input type="radio" name="value" value="100" class="selectgroup-input" <?=$type == "c" ? "checked" : ""?>>
                      <span class="selectgroup-button">일식</span>
                    </label>
                    <label class="selectgroup-item" data-type="d">
                      <input type="radio" name="value" value="100" class="selectgroup-input" <?=$type == "d" ? "checked" : ""?>>
                      <span class="selectgroup-button">치킨</span>
                    </label>
                    <label class="selectgroup-item" data-type="e">
                      <input type="radio" name="value" value="100" class="selectgroup-input" <?=$type == "e" ? "checked" : ""?>>
                      <span class="selectgroup-button">피자</span>
                    </label>
                    <label class="selectgroup-item" data-type="f">
                      <input type="radio" name="value" value="100" class="selectgroup-input" <?=$type == "f" ? "checked" : ""?>>
                      <span class="selectgroup-button">야식</span>
                    </label>
                  </div>
                </div>
                

                <div class="form-group col-4">
                  <div class="row gutters-xs">
                    <div class="col">
                      <input type="text" class="form-control searchForm" placeholder="가맹점검색">
                    </div>
                    <span class="col-auto">
                      <button class="btn btn-secondary sbtn" type="button"><i class="fe fe-search"></i></button>
                    </span>
                  </div>
                </div>

                <div class="form-group col-8 mt-2">
                  <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" name="example-inline-radios" value="option1" <?=$order == "star" ? "checked" : ""?>  data-type="star">
                      <span class="custom-control-label">평점순</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" name="example-inline-radios" value="option2" <?=$order == "review" ? "checked" : ""?> data-type="review">
                      <span class="custom-control-label">리뷰순</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" name="example-inline-radios" value="option3" <?=$order == "dis" ? "checked" : ""?> data-type="dis">
                      <span class="custom-control-label">가까운지점</span>
                    </label>
                  </div>
                </div>
  
                <div class="col-12">
                  <div class="card">
                      <div class="card-map card-map-placeholder">
                          <div id="map"  style="float: left">
                            <img src="/public/Layout/assets/images/GD.php" id="mapimage">
                          </div>
                          <h3 class="text-center mt-6">전체보기</h3>
                          <table style="width: 433px; height: 220px;">
                            <tr>
                              <td style="vertical-align: middle;" class="text-left">
                                <p><img src="/public/Layout/assets/images/red_map_marker.png" style="vertical-align: bottom; margin-left: 150px;"> &nbsp;&nbsp;회원위치</p>
                                <p><img src="/public/Layout/assets/images/blue_map_marker.png" style="vertical-align: bottom; margin-left: 150px;"> &nbsp;&nbsp;가맹점위치</p>  
                                <p><img src="/public/Layout/assets/images/pink_map_marker.png" style="vertical-align: bottom; margin-left: 150px;"> &nbsp;&nbsp;위치표시 가맹점</p>
                              </td>
                            </tr>
                          </table>
                      </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="card">
                    <table class="table card-table table-vcenter affiliationList">
                      <tbody>
                        <?php foreach($list as $value):?>
                        <tr title="피자스타">
                          <td style="width: 10%;"><img src="/public/upload/<?=$value['s_member']?>.a?rand=<?=rand()?>" alt="" class="h-8"></td>
                          <td>
                            <a href="/menu?idx=<?=$value['s_idx']?>" title="<?=$value['s_name']?> 메뉴주문 페이지">
                              <h5><?=$value['s_name']?></h5>
                              <ul class="list">
                                <li>
                                  <span class="title">평점</span>  
                                  <span class="badge badge-primary"><?=$value['star']?>점</span>
                                </li>
                                <li>
                                  <span class="title">리뷰</span>  
                                  <span class="badge badge-primary"><?=$value['review']?>개</span>
                                </li>
                              </ul>
                            </a>
                          </td>
                          <td>
                            가맹점위치<br>
                            회원위치정보(<?=isMember()['m_x']?>,<?=isMember()['m_y']?>), 가맹점위치정보(<?=$value['m_x']?>,<?=$value['m_y']?>)<br>
                            회원위치와 가맹점간의 거리 = <?=$value['dis']?>
                          </td>
                          <td class="text-right">
                            <label class="custom-switch">
                              <input type="radio" name="option" value="1" class="custom-switch-input" data-x="<?=$value['m_x']?>" data-y="<?=$value['m_y']?>" data-idx = "<?=$value['s_idx']?>">
                              <span class="custom-switch-indicator"></span>
                              <span class="custom-switch-description">위치표시</span>
                            </label>
                          </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                    </table>
                  </div>
                </div>

              </div>
            </div>
            <!-- contents end -->

          </div>
        </div>
      </div>
      <script> 
          let param = new URL(location.href).searchParams;
          let type = param.get("type") != null ? param.get("type") : "";
          let order = param.get("order") != null ? param.get("order") : "";
          let search = param.get("search") != null ? param.get("search") : "";


          $(".selectgroup-item").on("click",function(){
            let data = $(this).data("type");
            if(data == "all"){
              location.href = "/order";
              return;
            }
            type = data;
            setLocation();
          })

          $(".custom-control-input").on("click",function(){
            let data = $(this).data("type");
            order = data;
            setLocation();
          })

          $(".sbtn").on("click",function(){
            search = $(".searchForm").val();
            setLocation();
          })

          function setLocation()
          {
            location.href = `/order?type=${type}&order=${order}&search=${search}`;
          }


          let before = "";
          $(".custom-switch-input").on("click",function(){
            let idx = $(this).data("idx");
            if(before == idx){
              $("#mapimage").attr("src",`/public/Layout/assets/images/GD.php?x=-100&y=-100`);
              before = "";
            }else{
              let x = $(this).data("x");
              let y = $(this).data("y");
              before = idx;
              $("#mapimage").attr("src",`/public/Layout/assets/images/GD.php?x=${x}&y=${y}`);
            }

          })
      </script>
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