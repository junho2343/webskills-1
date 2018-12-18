  <script type="text/javascript">
   $(function(){
    $('#date').datepicker({
      dateFormat : 'yy년 mm월 dd일',
      minDate : +1
    });
  });
  </script>
    <div class="content-wrapper">
    <div class="container-fluid p-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/">홈</a>
        </li>
        <li class="breadcrumb-item active">지입차량주POS</li>
      </ol>
    
      <!-- content-start -->
      <div class="card card-register mx-auto mt-5" style="max-width: 80rem">
        <div class="card-header">물류배송신청검색</div>
        <div class="card-body">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group col-12">
              <input class="form-control" id="date" name="date" type="text" placeholder="배송일검색" readonly="readonly">
              <span class="input-group-append">
                <button class="btn btn-primary" type="submit">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </div>
      </div>
      <div class="mx-auto mt-5" style="max-width: 80rem">
        <div class="card">
          <div class="card-header">물류배송신청목록</div>
          <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap text-center table-bordered" >
              <thead>
                <tr>
                  <th class="w-1">No.</th>
                  <th>배송일</th>
                  <th>배송정보</th>
                  <th>배송지역</th>
                  <th>총 배송중량</th>
                  <th>총 배송거리</th>
                  <th>배송경로</th>
                  <th>Order인수</th>
                </tr>
              </thead>
              <tbody>
                <?php $cnt = 1;foreach($find as $box):
                      $len = count($box);
                      $i = 0;
                      $this->min = 9999;
                      $this->path = [];
                      $this->minStack = [];
                      $this->getPath(0,$len,$box,0);
                ?>
                  <?php foreach($box as $value):?>
                <tr>
                  <?php if($i == 0):?>
                  <td rowspan="<?=$len?>" class="w-1"><?=$cnt++;?></td>
                  <td rowspan="<?=$len?>"><?=convertDate2($value['c_date'])?></td>
                  <?php endif;?>
                  <td class="text-left">
                    <p class="m-0">배송번호 : <?=$value['c_code']?></p>
                    <p class="m-0">아이디 : <?=$value['m_id']?></p>
                    <p class="m-0">회사명 : <?=$value['m_name']?></p>
                    <p class="m-0">전화번호 : <?=$value['m_phone']?></p>
                    <p class="m-0">배송중량 : <?=$value['c_weight']?>톤</p>
                    <p class="m-0">신청일자 : <?=convertDate2($value['c_rdate'])?></p>
                  </td>
                  <td><?=$value['c_area']?></td>
                  <?php if($i == 0):?>
                  <td rowspan="<?=$len?>"><?=$this->findMax?>톤</td>
                  <td rowspan="<?=$len?>"><?=$this->min?>km</td>
                  <td rowspan="<?=$len?>">
                    <?php 
                    foreach($this->minStack as $path):
                        $pathArr = []; 
                        $idxArr = [];
                        foreach($path as $val):
                          $pathArr[] = $val['c_area'];
                          $idxArr[] = $val['c_idx'];
                        endforeach; 
                        $pathArr = join("-",$pathArr);
                        $idxArr = join("-",$idxArr);
                      ?>
                    <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input path-input" data-idx="<?=$idxArr?>" data-path="<?=$pathArr?>" data-dis="<?=$this->min?>" data-max="<?=$this->findMax?>" name="example-inline-radios " value="option1" checked="checked">
                      <span class="custom-control-label"><?=$pathArr?></span>
                    </label>
                    <br>
                    <?php endforeach;?>
                  </td>
                  <td rowspan="<?=$len?>">
                    <button href="truck-info.html" class="btn btn-primary btn-sm insubtn">인수하기</button>
                  </td>
                <?php endif;?>
                </tr>
                <?php $i++; endforeach;?>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>


       <div class="mx-auto mt-5" style="max-width: 80rem">
        <div class="card">
          <div class="card-header">배송리스트</div>
          <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap text-center table-bordered" >
              <thead>
                <tr>
                  <th class="w-1">No.</th>
                  <th>배송일</th>
                  <th>배송정보</th>
                  <th>배송지역</th>
                  <th>총 배송중량</th>
                  <th>총 배송거리</th>
                  <th>배송경로</th>
                  <th>배송상태</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $boxI = 0;
                  $cnt = 1;
                  for($i = 0, $len = count($list); $i < $len; $i++):
                ?>
                <tr>
                  <?php if($boxI == $i):?>
                  <td rowspan="<?=$boxCount[0]['cnt']?>" class="w-1"><?=$cnt++?></td>
                  <td rowspan="<?=$boxCount[0]['cnt']?>"><?=convertDate2($list[$i]['c_date'])?></td>
                  <?php endif;?>
                  <td class="text-left">
                    <p class="m-0">배송번호 : <?=$list[$i]['c_code']?></p>
                    <p class="m-0">아이디 : <?=$list[$i]['m_id']?></p>
                    <p class="m-0">회사명 : <?=$list[$i]['m_name']?></p>
                    <p class="m-0">전화번호 : <?=$list[$i]['m_phone']?></p>
                    <p class="m-0">배송중량 : <?=$list[$i]['c_weight']?>톤</p>
                    <p class="m-0">신청일자 : <?=convertDate2($list[$i]['c_rdate'])?></p>
                  </td>
                  <td><?=$list[$i]['c_area']?></td>
                  <?php if($boxI == $i):?>
                  <td rowspan="<?=$boxCount[0]['cnt']?>"><?=$list[$i]['d_max']?>톤</td>
                  <td rowspan="<?=$boxCount[0]['cnt']?>"><?=$list[$i]['d_dis']?>km</td>
                  <td rowspan="<?=$boxCount[0]['cnt']?>">
                    <?php if($boxCount[0]['state'] != "배송대기"):?>
                    <div class="selectgroup selectgroup-pills">
                      <?php
                        $path = explode("-",$list[$i]['d_path']);
                        foreach($path as $key => $p):
                          $check = app\Core\DB::fetch("SELECT * FROM delivery WHERE d_box = ? AND d_me = ?",[$list[$i]['d_box'],$key])['d_suc'];
                          $check = $check == 0 ? "checked" : "disabled";
                      ?>
                        <label class="selectgroup-item m-0">
                          <input type="checkbox" name="value" value="HTML" data-box="<?=$list[$i]['d_box']?>" data-me="<?=$key?>" class="selectgroup-input deli" <?=$check?> >
                          <span class="selectgroup-button">
                            <p class="m-0"><?=$p?></p>
                            배송완료
                          </span>
                        </label>
                        <?php if($key != count($path) - 1):?>
                        <p class="m-0">▼</p>
                        <?php endif;?>
                      <?php endforeach;?>
                    </div>
                    <?php endif;?>
                  </td>
                  <td rowspan="<?=$boxCount[0]['cnt']?>">
                    <?php?>
                    <?php if(strtotime(date("Y-m-d")) < strtotime($list[$i]['c_date'])):?>
                      배송대기
                    <?php elseif(strtotime(date("Y-m-d")) >= strtotime($list[$i]['c_date']) && $boxCount[0]['state'] == "배송대기"):?>
                    <a href="/start?box=<?=$list[$i]['d_box']?>" class="btn btn-primary btn-sm">배송하기</a>
                    <?php else:?>
                      <?=$boxCount[0]['state']?>
                    <?php endif;?>
                  </td>
                  <?php $boxI += $boxCount[0]['cnt']; array_splice($boxCount,0,1); endif;?>
                </tr>
                <?php endfor;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- content-end -->

    </div>
    <footer>
      <div class="footer-inner">
        <div class="text-center">
          <small>Copyright © Your Website 2018</small>
        </div>
      </div>
    </footer>
  </div>
  <script type="text/javascript">
        $(".insubtn").on("click",function(){
          let input = $(this).parents("tr").find("input[type='radio']");
          let flag = true;
          let target;

          input.each(function(){
            if($(this).prop("checked")){
              flag = false;
              target = $(this);
            }
          })

          if(flag){
            alert("배송경로를 선택해 주세요.");
            return;
          }else{
            let idx = target.data("idx");
            let path = target.data("path");
            let dis = target.data("dis");
            let max = target.data("max");
            location.href = `/addInsu?idx=${idx}&path=${path}&dis=${dis}&max=${max}`;
          }
        })

        $(".deli").on("click",function(){
          let label = $(this).parents("label");
          let labels = label.parents("td").find("label");
          let index = label.index() / 2;
          let box = $(this).data("box");
          let me = $(this).data("me");
          for (var i = 0; i < index; i++) {
              if(labels.eq(i).find(".deli").prop("checked")){
                alert("이전 지역부터 배송해주세요.");
                $(this).prop("checked",true);
                return;
              }
          }
          location.href = `/suc?box=${box}&me=${me}`;
        })

  </script>
</body>

</html>
