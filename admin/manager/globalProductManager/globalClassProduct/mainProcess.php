<?php
session_start(); //讓session可執行

include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
 

$act = $_POST['act']; //執行動作判斷 

if($act == 'add') { //新增

  $title = $_POST['title']; //標題
  $remark = $_POST['remark']; //備註

  #資料庫語法
  $sqladd = "INSERT INTO Admin_GlobalProductMainClass (AGPMC_Name, AGPMC_Remark, AGPMC_Sort ) VALUES ('".$title."', '".$remark."', '1' )";
  $result = $Language_db->prepare($sqladd);
  $result->execute();

  $ar["remsg"] = "新增成功";
  echo json_encode($ar);
} //if($act == 'add') { //新增

if($act == 'edit') { //編輯
  
  $title = $_POST['title']; //標題
  $remark = $_POST['remark']; //備註
  $id = $_POST['agpmcID']; //id

  #更新資料庫語法
  $sqlUp = "UPDATE Admin_GlobalProductMainClass SET AGPMC_Name ='".$title."', AGPMC_Remark = '".$remark."' WHERE AGPMC_ID = '".$id."'";
  $result = $Language_db->prepare($sqlUp);
  $result->execute();

  $ar["remsg"] = "更新成功";
  echo json_encode($ar);
} //if($act == 'edit') { //編輯

if($act == 'del') {
  
  $id = $_POST['id'];
  /* Delete all rows from the FRUIT table */
  $count = $Language_db->exec("DELETE FROM Admin_GlobalProductMainClass WHERE AGPMC_ID = '".$id."'");

  $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
  echo json_encode($ar);
}

?>  