
  <div class="content-wrapper">
    <div class="container-fluid p-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/">홈</a>
        </li>
        <li class="breadcrumb-item active">물류배송추적</li>
      </ol>
    
      <!-- content-start -->
      <div class="card card-register mx-auto mt-5" style="max-width: 80rem">
        <div class="card-header">물류배송추적검색</div>
        <div class="card-body">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group col-12">
				<span class="input-group-append">
                <select class="form-control" name="type">
				  <option>배송번호</option>
				  <option>배송경로</option>
				</select>
              </span>
              <input class="form-control" type="text" placeholder="배송번호(ex: 20181009-0001) 또는 배송경로(ex: ㄷ구)" name="search">
              <span class="input-group-append">
                <button class="btn btn-primary" type="submit">
                  <i class="fa fa-truck"></i>
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
            <table class="table card-table table-vcenter text-nowrap">
              <thead>
                <tr>
                  <th class="w-1">No.</th>
                  <th>배송번호</th>
                  <th>배송지역</th>
                  <th>배송상태</th>
                  <th>배송경로</th>
                  <th>배송일</th>
                  <th>배송중량</th>
                  <th>현위치</th>
                  <th>신청일자</th>
                  <th>차량정보</th>
                </tr>
              </thead>
              <tbody>
                <?php $cnt = 1;foreach($list as $value):?>
                <tr>
                  <td class="w-1"><?=$cnt++?></td>
                  <td><?=$value['c_code']?></td>
                  <td><?=$value['c_area']?></td>
                  <td><?=$value['c_state']?></td>
                  <td><?=isset($value['i_idx']) ? $value['myPath'] : ""?></td>
                  <td><?=cdate2($value['c_date'])?></td>
                  <td><?=$value['c_weight']?>톤</td>
                  <td><?=isset($value['i_idx']) ? $value['now'] : ""?></td>
                  <td><?=cdate2($value['c_rdate'])?></td>
                  <td>
                     <?php if($value['c_state'] == '배송대기' || $value['c_state'] == '배송중'):?>
                      <a href="/truck-info?box=<?=$value['i_box']?>&car=<?=$value['i_car']?>" class="btn btn-primary btn-sm">차량정보</a>
                    <?php endif;?>
                  </td>
                </tr>
              <?php endforeach;?>
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

</body>

</html>