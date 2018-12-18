  <div class="content-wrapper">
    <div class="container-fluid p-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/">홈</a>
        </li>
        <li class="breadcrumb-item active">로그인</li>
      </ol>
    
      <!-- content-start -->

        <div class="card card-login mx-auto mt-5">
          <div class="card-header">회원로그인</div>
          <div class="card-body">
            <form action="/login" method="post">
              <div class="form-group">
                <label for="id">아이디</label>
                <input class="form-control" id="id" name="id" type="text" aria-describedby="emailHelp" placeholder="ID">
              </div>
              <div class="form-group">
                <label for="password">비밀번호</label>
                <input class="form-control" id="password" name="pw" type="password" placeholder="Password">
              </div>
              <button type="submit" class="btn btn-primary btn-block">로그인</button>
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
