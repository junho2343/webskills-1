<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SKILLS LOGISTICS</title>
  <link href="/public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="/public/css/bootstrap/bootstrap.css" rel="stylesheet">
  <link href="/public/css/sb-admin.css" rel="stylesheet">
  <link href="/public/js/jquery/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">
  <script type="text/javascript" src="/public/js/jquery/jquery-3.3.1/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="/public/js/jquery/jquery-ui-1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="/public/js/bootstrap/bootstrap.js"></script>
  <?php alert();?>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="/index">
      <img src="/public/images/logo.png" alt="logo">
    </a>
    <!-- header-menu -->
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <div class="col-12 text-right" style="color: #fff">
        <?php if(isMember()):?>
        [아이디 : <?=isMember()['m_id']?>] / [회원구분 : <?=isMember()['m_grade']?>]
      <?php endif;?>
      </div>
    </div>
  </nav>

  <!-- navigation -->
  <div class="navigation">
    <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
      <?php if(isMember()):?>
         <li class="nav-item" data-toggle="tooltip" data-placement="right" title="로그인">
          <a class="nav-link" href="/logout">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">로그아웃</span>
          </a>
        </li>
        <?php else:?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="로그인">
          <a class="nav-link" href="/login">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">로그인</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="회원가입">
          <a class="nav-link" href="/join">
            <i class="fa fa-fw fa-sign-in"></i>
            <span class="nav-link-text">회원가입</span>
          </a>
        </li>
        <?php endif;?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="물류배송신청">
          <a class="nav-link" href="/contract">
            <i class="fa fa-fw fa-pencil-square-o"></i>
            <span class="nav-link-text">물류배송신청</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="물류배송추적">
          <a class="nav-link" href="/delivery">
            <i class="fa fa-fw fa-truck"></i>
            <span class="nav-link-text">물류배송추적</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="지입차량주POS">
          <a class="nav-link" href="/manager">
            <i class="fa fa-fw fa-th-large"></i>
            <span class="nav-link-text">지입차량주POS</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="관리자POS">
          <a class="nav-link" href="/adminpos">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">관리자POS</span>
          </a>
        </li>
      </ul>
  </div>