<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta http-equiv="Content-Language" content="en" />
    <title>우리동네배달</title>
    <script type="text/javascript" src="/public/Layout/assets/js/jquery/jquery-3.3.1/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="/public/Layout/assets/js/jquery/jquery-ui-1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="/public/Layout/assets/js/bootstrap-4.1.1-dist/bootstrap.js"></script>
    <script type="text/javascript" src="/public/Layout/assets/js/script.js"></script>
    <link href="/public/Layout/assets/js/jquery/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" />
    <link href="/public/Layout/assets/css/dashboard.css" rel="stylesheet" />
  </head>
  
  <body>
    <div class="page">
      <div class="page-main">
        <div class="header py-4">
          <div class="container">
            <div class="d-flex text-center">
              <a class="header-brandm col-12" href="/">
                <img src="/public/Layout/assets/images/logo.png" class="header-brand-img" alt="우리동네배달">
              </a>
            </div>
          </div>
        </div>
        <div class="header d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-lg-row">

                  <li class="nav-item">
                    <a href="/" class="nav-link <?=$title == "index" ? "active" : ""?>"><i class="fe fe-home"></i> Home</a>
                  </li>
                  
                  <?php if(isMember()):?>

                  <li class="nav-item">
                    <a href="/logout" class="nav-link <?=$title == "login" ? "active" : ""?>"><i class="fe fe-log-in"></i> 로그아웃</a>
                  </li>
                  <li class="nav-item">
                    <a href="/my" class="nav-link <?=$title == "my" ? "active" : ""?>"><i class="fe fe-home"></i> 내 정보변경</a>
                  </li>
                  <?php else:?>
                  <li class="nav-item">
                    <a href="/login" class="nav-link <?=$title == "login" ? "active" : ""?>"><i class="fe fe-log-in"></i> 로그인</a>
                  </li>
                  <li class="nav-item">
                    <a href="/join" class="nav-link <?=$title == "join" ? "active" : ""?>"><i class="fe fe-home"></i> 회원가입</a>
                  </li>
                  <?php endif;?>

                  <li class="nav-item">
                    <a href="/order" class="nav-link <?=$title == "order" ? "active" : ""?>"><i class="fe fe-home"></i> 주문하기</a>
                  </li>
                  <li class="nav-item">
                    <a href="/det" class="nav-link <?=$title == "det" ? "active" : ""?>"><i class="fe fe-home"></i> 주문내역</a>
                  </li>
                  <li class="nav-item">
                    <a href="/aff" class="nav-link <?=$title == "aff" ? "active" : ""?>"><i class="fe fe-home"></i> 가맹회원</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>