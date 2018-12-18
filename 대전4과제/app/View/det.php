        <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <!-- page title start-->
              <h1 class="page-title">
                 주문내역
              </h1>
              <!-- page title end-->
            </div>
            <?php
              $sum = 0;
              foreach ($list as $key => $value) {
                $sum += $value['me_price'] * $value['o_count'];
              }
            ?>
            <!-- contents start -->
            <div class="col-12">
              <div class="row">
                <div class="col-6 mb-2 text-left">
                  <h3 style="color: red;">총 결제금액 : <?=number_format($sum)?>원</h3> 
                </div>
                <?php if(isMember()['m_grade'] == "관리자"):?>
                <!-- 관리자모드 -->
                <div class="col-6 mb-2 text-right">
                <form action="">
                  <select class="custom-select col-4" name="member">
                    <option value="">회원검색</option>
                    <?php foreach($memberList as $value):?>
                    <option value="<?=$value['m_idx']?>" <?=$member == $value['m_idx'] ? "selected" : ""?>><?=$value['m_name']?>[<?=$value['m_id']?>]</option>
                    <?php endforeach;?>
                  </select>
                  <button type="submit" class="btn btn-secondary btn-space">확인</button>
                </form>
                </div>
                <?php endif;?>
                <div class="col-12">
                  <div class="card">
                    <div class="table-responsive">
                      <table class="table table-bordered table-vcenter text-nowrap card-table">
                        <thead>
                          <tr>
                            <th>결제일자</th>
                            <th>가맹점정보</th>
                            <th>메뉴이름</th>
                            <th>가격</th>
                            <th>수량</th>
                            <th>주문상태</th>
                            <th>총 합계</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                            $dateI = 0;
                            $boxI = 0;
                            $shopI = 0;

                            for($i = 0; $i < count($list); $i++):
                          ?>
                          <tr>
                            <?php if($dateI == $i): ?>
                            <td class="text-center"  rowspan="<?=$dateCount[0]['cnt']?>">
                              <?=$list[$i]['o_date']?>
                            </td>
                            <?php $dateI += $dateCount[0]['cnt'];array_splice($dateCount,0,1); endif;?>
                            <?php if($shopI == $i):?>
                            <td class="text-center" rowspan="<?=$shopCount[0]['cnt']?>">
                              <img src="/public/upload/<?=$list[$i]['s_member']?>.a?rand<?=rand()?>" alt="">
                              <p class="m-0">
                                <small><?=$list[$i]['s_name']?></small>
                              </p>
                            </td>
                            <?php endif;?>
                            <td class="text-center">
                              <?=$list[$i]['me_name']?>
                            </td>
                            <td class="text-center">
                              <?=number_format($list[$i]['me_price'])?>원
                            </td>
                            <td class="text-center">
                              <?=number_format($list[$i]['o_count'])?>개
                            </td>
                            <?php if($shopI == $i):?>
                            <td class="text-center" rowspan="<?=$shopCount[0]['cnt']?>">
                               <?php if($list[$i]['o_state'] == "배송중"):?>
                                배송중
                              <?php else:?>
                                배송완료
                                <p class="m-0">
                                <a href="/detReview?box=<?=$list[$i]['o_box']?>&shop=<?=$list[$i]['o_shop']?>" class="btn btn-sm btn-outline-primary">리뷰작성</a>
                              </p>
                              <?php endif;?>
                            </td>
                            <?php $shopI += $shopCount[0]['cnt'];array_splice($shopCount,0,1); endif;?>      
                            <?php if($boxI == $i):?>                
                            <td class="text-center" rowspan="<?=$boxCount[0]['cnt']?>">
                              <?=number_format($boxCount[0]['sum'])?>원
                            </td>
                            <?php $boxI += $boxCount[0]['cnt'];array_splice($boxCount,0,1); endif;?>
                          </tr>
                          <?php endfor;?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                
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