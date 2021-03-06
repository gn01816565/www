<?php
$id = $_GET['id']; //編輯id

#叫出電子報資料
$sqlEdit = "SELECT * FROM  Admin_EdmContent where AEC_ID = '".$id."'";
$rsEdit = $Language_db->query($sqlEdit);
$dataEdit = $rsEdit->fetch();
?>
<script src="library/ckeditor/ckeditor.js"></script>
<script>
function checkSerialize() {
  for ( instance in CKEDITOR.instances ) {
    CKEDITOR.instances[instance].updateElement(); //將ckeditor重新更新
  }
return true; 
}
function checkPost() { //送出前檢查欄位
  var checkstatus = 1; //先預設有值
  $('#addFile_Alert').html(' '); //檔案判斷
  $('#title_Alert').html(' '); //標題判斷

  /*
  if(!$('#addFile').val()) {
    $('#addFile_Alert').html('<i class="fa fa-warning">！</i>'); //檔案判斷
    checkstatus=0;
  } else {
    var ext = $('#addFile').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
      $('#addFile_Alert').html('<i class="fa fa-warning">不符合檔案類型，請重新選擇!</i>'); //檔案類型判斷
      checkstatus=0;
    } 
  }
  */
  if(!$('#title').val()) {
    $('#title_Alert').html('<i class="fa fa-warning">請輸入標題！</i>');
    checkstatus=0;
  }
  /*
  if(!$('#content').val()) {
    $('#content_Alert').html('<i class="fa fa-warning">請輸入電子報內文！</i>');
    checkstatus=0;
  }
  */
  
  if(checkstatus==1) {
    $('#checkButton').hide(); //按扭隱藏
    $('#loadingImg').show(); //顯示loading
    return true;
  } else {
    return false;
  }
}
//單檔刪除圖片, 編輯id
function delImg(id, fileName) {
  var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php";
  $.ajax({
    url: URLs,
    data: { id:id,fileName:fileName,act:"editDel"},
    type:"POST",
    async:false, //有回傳值才會執行以下的js
    dataType:'json',
      
    success: function(msg){ //成功執行完畢  
      swal({
        title:msg.remsg,
        text: "",
        type: "success"
        },
        function() {
          $('#addFileDiv').html('<input type="file" name="addFile" id="addFile"><span id="addFileAlert"></span>');
        }
      );
    },
    
    //beforeSend:function(){ },//執行中
    //complete:function(){ },//執行完畢,不論成功或失敗
    
    error:function(xhr, ajaxOptions, thrownError){ //丟出錯誤
      alert(xhr.status);
      alert(thrownError);
      //alert('更新失敗!');
    }
  });
}
</script>

<div id="pageMainWarp">
  <div id="pageWarp">
    <div id="pageWarpTR">
      <?php
      include('aside.php');
      ?>
      <section id="rightWarp">
        <div id="placeWarp" class="boxWarp">
          <div class="title red_T">目前位置：</div>
          <span><?=$pageMainTitle;?></span>
          <span>></span>
          <a href="page_index.php?pageData=<?=$subDirectory?>" title="<?=$pageTitle;?>"><?=$pageTitle;?></a>
        </div>
        <div class="clearBoth"></div>
        <div id="pageIndexWarp" class="boxWarp">

          <div id="newsWarp" class="boxWarp">
            <h2 class="red">資料編輯</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="formFileAdd" name="formFileAdd" action="manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="act" value="edit">
                  <input type="hidden" id="pageURL" value="<?=$_GET['pageData'];?>">
                  <input type="hidden" id="eid" name="eid" value="<?=$dataEdit['AEC_ID'];?>">
                  <table>
                    <tr>
                      <td class="num titleTxt" style='width:100px;'>電子報編號</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$dataEdit['AEC_Num'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">信件標題</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="title" id="title" placeholder="請輸入電子報標題..." value="<?=$dataEdit['AEC_Title'];?>">
                        <span id="title_Alert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">內容</td>
                      <td class="txtLeft" style="text-align:left;" id="ckeditor">
                        <textarea id="content" name="content" class="ckeditor" placeholder="請輸入電子報內文..."><?=$dataEdit['AEC_Content'];?></textarea>
                        <span id="content_Alert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">上傳檔案</td>
                      <td class="txtLeft" style="text-align:left;">
                        <!--
                        <input type="file" name="addFile" id="addFile"> 
                        <span id="addFile_Alert"></span>
                      -->
                      <?php
                      if($dataEdit['AEC_File']) {
                      /*
                      echo "<button class='yellow' id='checkFile".$i."' name='checkFile".$i."' type='button' onclick=imgOpen('../images/supplier/".$_SESSION['SAD_Account']."/product/contentImage/".$dataImg[0]['SPI_Image']."') target='_blank'>".$dataImg[0]['SPI_Image']."</button>
                      <input type='file' name='file".$i."' id='file".$i."'><span id='file".$i."Alert'></span><br><br>";
                      */
                      ?>
                      <span id="addFileDiv">
                        <button class="yellow" type="button" onclick="location.href='../download.php?f=<?=$dataEdit['AEC_File'];?>&url=images/edm/'"><?=$dataEdit['AEC_File'];?><button>
                        <button class="red" type="button" onclick="delImg('<?=$dataEdit['AEC_ID'];?>','<?=$dataEdit['AEC_File'];?>')">刪除</button>
                      </span>
                        <?php
                      } else {
                        echo "<span id='addFileDiv'>";
                        echo "<input type='file' name='addFile' id='addFile'><span id='addFileAlert'></span><br>";
                        echo "</span>";
                      }
                      ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">建立日期</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$dataEdit['AEC_Date'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">新增人員</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$_SESSION['AM_Account'];?>
                      </td>
                    </tr>
                  </table>
                
              </div><!--<div id="formTable">-->  
            </div>
          </div>
        <div class="pageBtnWarp">
          <ul>
            <li><button type="button" id="returePage" class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button></li>
            <li>
              <!--<button class="red" onclick="upSubmit()">新增</button>-->
              <span id="loadingImg" style="display:none;"><img id="loadingImg" src="../images/ajax-loader.gif" stle="height:30px;">上傳中</span>
              <button class="red" id="checkButton" type="submit">更新</button>
            </li>
          </ul>
        </div>  
      </form>
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

