  <script type="text/javascript">
    $(function(){
      mapMarker();
    })
  </script>
          <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <!-- page title start-->
              <h1 class="page-title">
                내 정보변경
              </h1>
              <!-- page title end-->
            </div>

            <!-- contents start -->
            <div class="col-8 mx-auto mt-2">
              <div class="row">
            
                <form class="card" action="/update" method="post">
                  <div class="card-body p-6">
                    <div class="card-title">내 정보변경</div>
                    <div class="form-group">
                      <label class="form-label">아이디</label>
                      <input type="text" class="form-control" value="<?=isMember()['m_id']?>" readonly="readonly">
                    </div>
                    <div class="form-group">
                      <label class="form-label">성명</label>
                      <input type="text" class="form-control" value="<?=isMember()['m_name']?>" readonly="readonly">
                    </div>
                    <div class="form-group">
                      <label class="form-label">비밀번호</label>
                      <input type="password" class="form-control" placeholder="영문숫자조합 4~8자이내" name="pw">
                    </div>
                    <div class="form-group">
                      <label class="form-label">회원구분</label>
                      <div>
                        <select class="form-control custom-select">
                          <option value="">선택</option>
                          <option <?=isMember()['m_grade'] == "일반회원" ? "selected" : "" ?> >일반회원</option>
                          <option <?=isMember()['m_grade'] == "가맹회원" ? "selected" : "" ?> >가맹회원</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">전화번호</label>
                      <input type="text" class="form-control" placeholder="0000-0000-0000형식" name="phone" value="<?=isMember()['m_phone']?>">
                    </div> 
                    <div class="form-group">
                      <label class="form-label">위치정보</label>
                        <div>
                          <div class="card">
                            <div class="card-header">
                              <h3 class="card-title">위치좌표(x, y)</h3>
                              <div class="col-3">
                                <input type="text" class="form-control position" readonly="readonly" value="<?=isMember()['m_x']?>,<?=isMember()['m_y']?>" name="location">
                              </div>
                              <span>지도에 위치를 클릭해주세요.</span>
                            </div>
                            <div class="card-map card-map-placeholder">
                                <div id="map">
                                  <img src="/public/Layout/assets/images/map.jpg" id="map">
                                  <img src="/public/Layout/assets/images/red_map_marker.png" id="marker">
                                </div>

                            </div>
                           
                          </div>
                        </div>
                    </div>

                    <div class="form-footer">
                      <div class="btn-list mt-4 text-center">
                        <button type="reset" class="btn btn-secondary btn-space">다시작성하기</button>
                        <button type="submit" class="btn btn-primary btn-space">회원정보변경</button>
                      </div>
                    </div>
                  </div>
                </form>
                
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