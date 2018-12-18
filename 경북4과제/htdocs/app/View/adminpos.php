  <div class="content-wrapper">
    <div class="container-fluid p-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/">홈</a>
        </li>
        <li class="breadcrumb-item active">관리자POS</li>
      </ol>
    
      <!-- content-start -->
      
      <style type="text/css">
        .tableCu{ width: auto; text-align: center; }
        .tableCu td{ border: #dfdfdf solid 1px; width: 60px; height: 60px; }
        .tdYellow { background: yellow; border: 0 !important}
        .last { border-right: yellow solid 1px !important; }
        .tdBlue { background: blue; border: 0 !important; color: #fff}
        .tdRed { background: red; }
      </style>
      <table class="tableCu mx-auto">
        <tr>
          <td class="tdYellow">

          </td>
          <td class="tdBlue">
             서울
          </td>
          <td class="tdBlue">
             경기 
          </td>
          <td class="tdBlue">
             강원
          </td>
          <td class="tdBlue">
             충북
          </td>
          <td class="tdBlue">
             충남
          </td>
          <td class="tdBlue">
             대전
          </td>
          <td class="tdBlue">
             경남
          </td>
          <td class="tdBlue">
             경북
          </td>
          <td class="tdBlue">
             전남
          </td>
          <td class="tdBlue">
             전북
          </td>
          <td class="tdBlue">
             <strong>도착지</strong>
             <p class="m-0">▲</p>
          </td>
        </tr>
        <?php foreach($data as $key => $value):?>
        <tr>
          <td class="tdYellow">
             <?=$key?>
          </td>
          <?php foreach($value as $val):?>
          <td class="<?=$val == 0 ? "tdRed" : "" ?>">
             <?=$val?>km 
          </td>
          <?php endforeach;?>
          <td class="tdBlue">
            
          </td>
        </tr>
        <?php endforeach;?>
        <tr>
          <td class="tdYellow">
             <strong>출발지</strong>
             <p class="m-0">▶</p>
          </td>
          <td class="tdYellow">
              
          </td>
          <td class="tdYellow">
             
          </td>
          <td class="tdYellow">
             
          </td>
          <td class="tdYellow">

          </td>
          <td class="tdYellow">
             
          </td>
          <td class="tdYellow">
             
          </td>
          <td class="tdYellow">
             
          </td>
          <td class="tdYellow">
            
          </td>
          <td class="tdYellow">
             
          </td>
          <td class="tdYellow last">
             
          </td>
          <td class="tdBlue">
            
          </td>
        </tr>


      </table>
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