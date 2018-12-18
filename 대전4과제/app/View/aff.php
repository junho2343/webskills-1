     <?php use app\Core\DB; ?>
        <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <!-- page title start-->
              <h1 class="page-title">
                 가맹회원
              </h1>
              <!-- page title end-->
            </div>

            <!-- contents start -->
            <div class="col-12">
              <div class="row">
                  <?php if(isMember()['m_grade'] == "가맹회원"):?>
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title" style="font-size: 1.2em; font-weight: bold;">가맹점등록</h3>
                    </div>
                    <div class="card-body1 p-5">
                      <form action="/addShop" method="post" enctype="multipart/form-data">
                        <div class="form-group col-12">
                          <label class="form-label">가맹점분류</label>
                          <select class="custom-select col-2" name="type">
                            <option value="">가맹점분류선택</option> 
                            <option value="a">한식</option> 
                            <option value="b">중식</option>
                            <option value="c">일식</option> 
                            <option value="d">치킨</option>
                            <option value="e">피자</option> 
                            <option value="f">야식</option>
                          </select>
                        </div>
                        <div class="form-group col-12">
                          <label class="form-label">가맹점로고</label>
                          <input type="file" class="form-control" name="file">
                        </div>

                        <div class="form-group col-12">
                          <label class="form-label">가맹점명</label>
                          <input type="text" class="form-control" name="name">
                        </div>
                        <div class="col-12">
                          <?php if($shop):?>
                          <img src="/public/upload/<?=$shop['s_member']?>.a?rand=<?=rand()?>">
                          <strong><?=$shop['s_name']?></strong>
                          <?php endif;?>
                        </div>
                        <div class="form-footer col-12">
                          <button type="submit" class="btn btn-primary btn-block">가맹점등록</button>
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="card mt-7">
                    <div class="card-header">
                      <h3 class="card-title" style="font-size: 1.2em; font-weight: bold;">메뉴등록</h3>
                    </div>
                    <div class="card-body1 p-5">
                      <form action="/addMenu" method="post">
                        <div class="form-group col-12">
                          <label class="form-label">메뉴이름</label>
                          <input type="text" class="form-control" name="name">
                        </div>

                        <div class="form-group col-12">
                          <label class="form-label">가격</label>
                          <input type="text" class="form-control" name="price">
                        </div>
                        <div class="form-footer col-12">
                          <button type="submit" class="btn btn-primary btn-block">메뉴등록</button>
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="card mt-7">
                    <div class="card-header">
                      <h3 class="card-title" style="font-size: 1.2em; font-weight: bold;">메뉴목록</h3>
                    </div>
                    <div class="card-body1 p-5">
                      <div class="table-responsive">
                      <table class="table table-bordered table-vcenter text-nowrap card-table menuTable" style="border-top: 1px solid rgba(0, 40, 100, 0.12)">
                        <thead>
                          <tr>
                            <th>메뉴이름</th>
                            <th>가격</th>
                            <th>판매수량</th>
                            <th>등록일</th>
                            <th>메뉴삭제</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          foreach($menu as $value):
                            $cnt = DB::fetch("SELECT SUM(o_count) as sum FROM orderlist WHERE o_menu = ?",[$value['me_idx']]);
                          ?>
                          <tr>
                            <td class="text-center">
                              <?=$value['me_name']?>
                            </td>
                            <td class="text-center">
                             <?=number_format($value['me_price'])?>원
                            </td>
                            <td class="text-center">
                              <?=number_format($cnt['sum'])?>개 
                            </td>
                            <td class="text-center">
                              <?=$value['me_date']?>
                            </td>
                            <td class="text-center">
                              <a href="/deleteMenu?idx=<?=$value['me_idx']?>" class="btn btn-secondary btn-space m-1">삭제</a>
                            </td>
                          </tr>
                          <?php endforeach;?>
                        </tbody>
                      </table>
                    </div>
                    </div>
                  </div>


                  <div class="card mt-7">
                    <div class="card-header">
                      <h3 class="card-title" style="font-size: 1.2em; font-weight: bold;">주문목록</h3>
                    </div>
                    <div class="card-body1 p-5">
                      <div class="table-responsive">
                      <table class="table table-bordered table-vcenter text-nowrap card-table" style="border-top: 1px solid rgba(0, 40, 100, 0.12)">
                        <thead>
                          <tr>
                            <th>주문일자</th>
                            <th>아이디</th>
                            <th>성명</th>
                            <th>전화번호</th>
                            <th>위치정보</th>
                            <th>메뉴이름</th>
                            <th>수량</th>
                            <th>가격</th>
                            <th>총 합계</th>
                            <th>주문상태</th>
                          </tr>
                        </thead>
                        <tbody class="text-center">
                          <?php
                            $boxI = 0;
                            for($i = 0; $i < count($order); $i++):
                              $member = DB::fetch("SELECT * FROM member WHERE m_idx = ?",[$order[$i]['o_member']]);
                          ?>
                          <tr>
                            <?php if($boxI == $i):?>
                            <td rowspan="<?=$boxCount[0]['cnt']?>"><?=$order[$i]['o_date']?></td>
                            <td rowspan="<?=$boxCount[0]['cnt']?>"><?=$member['m_id']?></td>
                            <td rowspan="<?=$boxCount[0]['cnt']?>"><?=$member['m_name']?></td>
                            <td rowspan="<?=$boxCount[0]['cnt']?>"><?=$member['m_phone']?></td>
                            <td rowspan="<?=$boxCount[0]['cnt']?>">(<?=$member['m_x']?>,<?=$member['m_y']?>)</td>
                            <?php endif;?>
                            <td><?=$order[$i]['me_name']?></td>
                            <td><?=number_format($order[$i]['o_count'])?>개</td>
                            <td><?=number_format($order[$i]['me_price'])?>원</td>
                            <?php if($boxI == $i):?>
                            <td rowspan="<?=$boxCount[0]['cnt']?>"><?=number_format($boxCount[0]['sum'])?>원</td>

                            <td rowspan="<?=$boxCount[0]['cnt']?>">
                              <?php if($order[$i]['o_state'] == "배송중"):?>
                                <a href="/delivery?box=<?=$order[$i]['o_box']?>&shop=<?=$shop['s_idx']?>" class="btn btn-secondary btn-space">배송</a>
                              <?php else:?>
                                  배송완료
                              <?php endif;?>
                            </td>

                            <?php $boxI += $boxCount[0]['cnt']; array_splice($boxCount, 0,1); endif;?>

                          </tr>
                          <?php endfor;?>

                        </tbody>
                      </table>
                    </div>
                    </div>
                  </div>
                  <?php endif;?>
        
                  <?php if(isMember()['m_grade'] == "관리자"):?>

                  <!-- 관리자모드 -->
                  <div class="card mt-7">
                    <div class="card-header">
                      <h3 class="card-title" style="font-size: 1.2em; font-weight: bold;">가맹점 메뉴목록</h3>
                      <div class="col text-right">
                      <form action="">
                        <select class="custom-select col-2" name="member">
                          <option value="">가맹회원선택</option>
                          <?php foreach($shopList as $value):?>
                          <option value="<?=$value['s_member']?>" <?=$value['s_member'] == $member ? "selected" : "" ?>><?=$value['s_name']?></option>
                          <?php endforeach;?>
                        </select>
                        <button type="submit" class="btn btn-secondary btn-space">확인</button>
                      </form>
                      </div>
                    </div>
                    <div class="card-body1 p-5">
                      <div class="table-responsive">
                      <table class="table table-bordered table-vcenter text-nowrap card-table" style="border-top: 1px solid rgba(0, 40, 100, 0.12)">
                        <thead>
                          <tr>
                            <th>메뉴이름</th>
                            <th>가격</th>
                            <th>판매수량</th>
                           
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($menu as $value): 
                            $cnt = DB::fetch("SELECT SUM(o_count) as sum FROM orderlist WHERE o_menu = ?",[$value['me_idx']]);
                          ?>
                          <tr>
                            <td class="text-center">
                              <?=$value['me_name']?>
                            </td>
                            <td class="text-center">
                             <?=number_format($value['me_price'])?>원
                            </td>
                            <td class="text-center">
                              <?=number_format($cnt['sum'])?>개 
                            </td>
                          </tr>
                        <?php endforeach;?>
                        </tbody>
                      </table>
                    </div>
                    </div>
                  </div>

                  <div class="card mt-7">
                    <div class="card-header">
                      <h3 class="card-title" style="font-size: 1.2em; font-weight: bold;">메뉴랭킹</h3>
                    </div>
                    <div class="card-body1 p-5">
                      <div class="table-responsive">
                      <table class="table table-bordered table-vcenter text-nowrap card-table" style="border-top: 1px solid rgba(0, 40, 100, 0.12)">
                        <thead>
                          <tr>
                            <th>랭킹</th>
                            <th>가맹점명</th>
                            <th>메뉴이름</th>
                            <th>가격</th>
                            <th>판매수량</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $cnt = 1; foreach($rank as $value):
                            $shop = DB::fetch("SELECT * FROM shop WHERE s_idx = ?",[$value['me_shop']]);
                          ?>
                          <tr>
                            <td class="text-center" style="width: 5%">
                              <?=$cnt++?>위
                            </td>
                            <td class="text-center">
                             <?=$shop['s_name']?>
                            </td>
                            <td class="text-center">
                              <?=$value['me_name']?>
                            </td>
                            <td class="text-center">
                              <?=number_format($value['me_price'])?>원
                            </td>
                            <td class="text-center">
                              <?=number_format($value['cnt'])?>개
                            </td>
                          </tr>
                        <?php endforeach;?>                     
                        </tbody>
                      </table>
                    </div>
                    </div>
                  </div>
                  
                  <?php endif;?>


                
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