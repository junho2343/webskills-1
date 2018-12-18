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
        <li class="breadcrumb-item active">물류배송신청</li>
      </ol>
    
      <!-- content-start -->
      <div class="card card-register mx-auto mt-5" style="max-width: 80rem">
        <div class="card-header">물류배송신청</div>
        <div class="card-body">
          <form action="/contract" method="post">
            <div class="form-group">
              <label for="id">아이디</label>
              <input class="form-control" id="id" type="email" aria-describedby="emailHelp" value="<?=isMember()['m_id']?>" readonly="readonly">
            </div>
            <div class="form-group">
              <label for="name">회사명</label>
              <input class="form-control" id="name" type="email" aria-describedby="emailHelp" value="<?=isMember()['m_name']?>" readonly="readonly">
            </div>
            <div class="form-group">
              <label for="tel">전화번호</label>
              <input class="form-control" id="tel" type="email" aria-describedby="emailHelp" value="<?=isMember()['m_phone']?>" readonly="readonly">
            </div>
            <div class="form-group">
              <label for="weight">배송중량</label>
              <select name="weight" id="weight" class="form-control">
                <option value="">선택</option>
                <option value="1">1톤</option>
                <option value="4">4톤</option>
                <option value="8">8톤</option>
                <option value="15">15톤</option>
                <option value="24">24톤</option>
              </select>
            </div>
            <div class="form-group">
              <label for="location">배송지역</label>
              <select name="area" id="location" class="form-control">
                <option value="">선택</option>
                <option>서울</option>
                <option>경기</option>
                <option>강원</option>
                <option>충북</option>
                <option>대전</option>
                <option>경남</option>
                <option>경북</option>
                <option>전남</option>
                <option>전북</option>
                <option>충남</option>
              </select>
            </div>
            <div class="form-group">
              <label for="date">배송일</label>
              <input class="form-control" id="date" name="date" type="email" aria-describedby="emailHelp" placeholder="" readonly="readonly">
            </div>
            <button type="submit" class="btn btn-primary btn-block">배송신청</button>
          </form>
          
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