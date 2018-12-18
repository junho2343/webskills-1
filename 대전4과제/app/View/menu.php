  <script type="text/javascript">
    $(function(){
      qt();
    })
  </script>
          <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <!-- page title start-->
              <h1 class="page-title">
                <?=$shop['s_name']?> 메뉴목록 
              </h1>
              <!-- page title end-->
            </div>

            <!-- contents start -->
            <div class="col-12">
              <div class="row">
                
                <div class="card" style="position: fixed; margin-left: 1180px; top: 210px; max-height: 600px; width: 350px; z-index: 900;">
                  <div class="card-header">
                    <h4 class="card-title" style="font-size: 1.2em; font-weight: bold;">주문함 (<?=count($orderBox)?>개)</h4>
                  <div class="col text-right">
                    <a href="/clearOrderBox" class="btn btn-sm btn-outline-primary">비우기</a>
                  </div>
                
                  </div>
                  <div class="card-body1 o-auto p-3" style="height: 600px">
                  <form action="/addOrderList" method="post">

                    <ul class="list-unstyled list-separated">
                      <?php $sum = 0;foreach($orderBox as $value):?>
                      <li class="list-separated-item">
                        
                        <input type="hidden" name="shop[]" value="<?=$value['ob_shop']?>">
                        <input type="hidden" name="menu[]" value="<?=$value['ob_menu']?>">
                        <input type="hidden" name="count[]" value="<?=$value['ob_count']?>">

                        <div class="row align-items-center">
                          <div class="col" style="word-break: break-all;">
                            <strong><?=$value['me_name']?></strong><br>
                            주문수량 : <?=number_format($value['ob_count'])?> 개<br>
                            가 격 : <?=number_format($value['me_price'])?>원<br>
                            합 계 : (<?=number_format($value['ob_count'] * $value['me_price'])?>원)
                          </div>
                          <div class="col-auto">
                            <a href="/deleteOrderBox?idx=<?=$value['ob_idx']?>" class="icon"><i class="fe fe-x"></i></a>
                          </div>
                        </div>
                      </li>
                      <?php $sum+= $value['ob_count'] * $value['me_price']; endforeach;?>
                    </ul>
                  </div>
                  <div class="text-right" style="border-top: #dfdfdf solid 1px">
                    <div style="color: blue; font-size: 1.3em" class="mt-2 mr-3">총 주문금액 : <?=number_format($sum)?>원</div>
                      <button type="submit" class="btn btn-primary btn-space mt-3 mb-3 mr-3">결제하기</button>
                    </form>
                  </div>
                </div>

                <div class="col-12">
                <div class="mb-2 text-right">
                  <button type="submit" class="btn btn-primary" onclick="window.location='/review?shop=<?=$shop['s_idx']?>'">리뷰보기<span class="badge badge-primary"><?=$review?>개</span></button>
                </div>
                <div class="card">
                  <div class="table-responsive">
                    <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                      <thead>
                        <tr class="text-center">
                          <th><strong>메뉴이름</strong></th>
                          <th><strong>가격</strong></th>
                          <th><strong>수량</strong></th>
                          <th><strong>합계</strong></th>
                          <th><strong>주문함담기</strong></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($menu as $value):?>
                        <tr class="text-center">
                          <td>
                            <?=$value['me_name']?>
                          </td>
                          <td data-price="<?=$value['me_price']?>">
                            <?=number_format($value['me_price'])?>원
                          </td>
                          <td style="width: 10%">
                            <input type="number" class="form-control qt" placeholder="1" min="1" value="1">
                          </td>
                          <td style="width: 20%">
                            <input type="text" class="form-control text-right price" readonly="readonly" value="<?=$value['me_price']?>">
                          </td>
                          <td>
                            <button type="button" class="btn btn-secondary btn-space addob" data-menu = "<?=$value['me_idx']?>" data-shop="<?=$value['me_shop']?>">주문함담기</button>
                          </td>
                        </tr>
                        <?php endforeach;?>
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
      <script>
          $(".addob").on("click",function(){
            let menu = $(this).data("menu");
            let cnt = $(this).parents("tr").find(".qt").val();
            let shop = $(this).data("shop");
            location.href = `/addOrderBox?count=${cnt}&menu=${menu}&shop=${shop}`;
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