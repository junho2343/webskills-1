  <script type="text/javascript">
   $(function(){
    $('#date').datepicker({
      dateFormat : 'yy년 mm월 dd일',
      minDate : +1
    });
    let d = "<?=$date?>";
    if(d != ""){
       $(".container-fluid p-3").hide();
      setTimeout(() => {
        $(".loading").hide();
        $(".container-fluid p-3").show();
      },2000);
    }

  });
  </script>
  <?php use app\Core\DB; ?>
    <div class="content-wrapper">
      <!-- loadin -->
      <?php if($date != ""):?>
    <img src="/public/images/loding.gif" style="width: 100%;height: 100%;left:0;top:0" class="loading">
      <?php endif;?>
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
              <input class="form-control" id="date" type="text" placeholder="배송일검색" readonly="readonly" name="date">
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

                <?php $no = 1;;foreach($list as $value):$cnt = 0;?>
                
                  <?php foreach($value as  $val):?>
                <tr>
                  <?php if(isset($val['m_name'])):?>
                  <?php if($cnt == 0):?>
                  <td rowspan="<?=count($value)?>" class="w-1"><?=$no++?></td>
                  <td rowspan="<?=count($value)?>"><?=cdate2($val['c_date'])?></td>
                  <?php endif;?>
                  <td class="text-left">
                    <p class="m-0">배송번호 : <?=$val['c_code']?></p>
                    <p class="m-0">아이디 : <?=$val['m_id']?></p>
                    <p class="m-0">회사명 : <?=$val['m_name']?></p>
                    <p class="m-0">배송중량 : <?=$val['c_weight']?>톤</p>
                    <p class="m-0">신청일자 : <?=cdate2($val['c_rdate'])?></p>
                  </td>
                  <td><?=$val['c_area']?></td>
                  <?php if($cnt == 0):?>
                  <td rowspan="<?=count($value)?>"><?=$this->max?>톤</td>
                  <td rowspan="<?=count($value)?>"><?=$value['min']?>km</td>
                  <td rowspan="<?=count($value)?>">
                    <?php foreach($value['path'] as $path):?>
            
                        <?php
                            $i = [];
                            $p = [];
                            foreach ($path as $pp) {
                                $i[] = $pp['c_idx'];
                                $p[] = $pp['c_area'];
                            }

                        ?>

                    <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input select-path" name="example-inline-radios1" value="option1" checked="checked" data-path="<?=join("-",$p)?>" data-idx="<?=join("-",$i)?>" data-min="<?=$value['min']?>" data-max="<?=$this->max?>">
                      <span class="custom-control-label"><?=join("-",$p)?></span>
                    </label>
          					<br />
                    <?php endforeach;?>

                  </td>
                  <td rowspan="<?=count($value)?>">
                    <button href="truck-info.html" class="btn btn-primary btn-sm insu-btn">인수하기</button>
                  </td>
                  <?php endif;?>
                  <?php endif;?>
                </tr>
                <?php $cnt++;endforeach;?>
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
                $cnt = 1;
                $boxI = 0;
                    for($i = 0; $i < count($myList); $i++):
                ?>
                <tr>
                  <?php if($i ==$boxI):?>
                  <td rowspan="<?=$boxCount[0]['cnt']?>" class="w-1"><?=$cnt++?></td>
                  <td rowspan="<?=$boxCount[0]['cnt']?>"><?=cdate2($myList[$i]['c_date'])?></td>
                  <?php endif;?>
                  <td class="text-left">
                    <p class="m-0">배송번호 : <?=$myList[$i]['c_code']?></p>
                    <p class="m-0">아이디 : <?=$myList[$i]['m_id']?></p>
                    <p class="m-0">회사명 : <?=$myList[$i]['m_name']?></p>
                    <p class="m-0">배송중량 : <?=$myList[$i]['c_weight']?>톤</p>
                    <p class="m-0">신청일자 : <?=cdate2($myList[$i]['c_rdate'])?></p>
                  </td>
                  <td><?=$myList[$i]['c_area']?></td>
                  <?php if($i ==$boxI):?>
                  <td rowspan="<?=$boxCount[0]['cnt']?>"><?=$myList[$i]['i_max']?>톤</td>
                  <td rowspan="<?=$boxCount[0]['cnt']?>"><?=$myList[$i]['i_min']?>km</td>
                  <td rowspan="<?=$boxCount[0]['cnt']?>">
                    <div class="selectgroup selectgroup-pills">
                      <?php
                        $path = explode("-",$myList[$i]['i_path']);
                          foreach($path as $key => $p):
                      ?>
                      <?php if($myList[$i]['i_state'] != "배송대기"):?>
                        <?php
                            $n = DB::fetch("SELECT * FROM insu WHERE i_box = ? AND i_me = ?",[$myList[$i]['i_box'],$key]);

                            $check = $n['i_suc'] == 0 ? "checked" : "disabled";
                        ?>
                        <label class="selectgroup-item m-0 suc-label">
                          <input type="checkbox" name="value" value="HTML" class="selectgroup-input suc-btn" <?=$check?> data-box="<?=$myList[$i]["i_box"]?>" data-me="<?=$key?>">
                          <span class="selectgroup-button">
                            <p class="m-0"><?=$p?></p>
                            배송완료
                          </span>
                        </label>
                        <?php elseif($myList[$i]['i_state'] == "배송대기"):?>
                          <?=$p?>
                        <?php endif;?>
                        <?php if(count($path)-1 != $key):?>
                        <p class="m-0">▼</p>
                        <?php endif;?>
                        <?php endforeach;?>
                    </div>
                  </td>
                  <td rowspan="<?=$boxCount[0]['cnt']?>">
                    <?php
                        if(strtotime(Date("Y-m-d")) >= strtotime($myList[$i]['c_date']) && $myList[$i]['c_state'] == "배송대기"):
                    ?>
                    <a href="/start?box=<?=$myList[$i]['i_box']?>" class="btn btn-primary btn-sm">배송하기</a>
                  <?php else:?>
                    <?=$myList[$i]['i_state']?>
                  <?php endif;?>
                  </td>
                  <?php $boxI+=$boxCount[0]['cnt']; array_splice($boxCount, 0,1); endif;?>
                </tr>
                <?php endfor;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- content-end -->
    <script type="text/javascript">
        $(".insu-btn").on("click",function(){
          let input = $(this).parents("tr").find(".select-path");
          let target = false;

          input.each(function(){
            if($(this).prop("checked")) target = $(this);
          })

          if(!target){
            alert("선택된 경로가 없습니다.");
            return;
          }
          let idx = target.data("idx");
          let path = target.data("path");
          let max = target.data("max");
          let min = target.data("min");

          location.href= `/addInsu?idx=${idx}&path=${path}&max=${max}&min=${min}`;
          return;

        }) 

        $(".suc-btn").on("click",function(){
          let target = $(this);
          let index = target.parent().index()/2;
          let label = target.parents("tr").find(".suc-label");

          for(let i = 0; i < index; i++){
            if(label.eq(i).find(".suc-btn").prop("checked")){
              alert("이전 지역부터 배송 해야 합니다.");
              target.prop("checked",true);
              return;
            }
          } 


          let box = target.data("box");
          let me = target.data("me");
          location.href = `/suc?box=${box}&me=${me}`;
          console.log(box);
        })

    </script>
    </div>
    <footer>
      <div class="footer-inner">
        <div class="text-center">
          <small>Copyright © Your Website 2018</small>
        </div>
      </div>
    </footer>
  </div>

</body>

</html>
