<?php //POSTデータを呼び出してTableを作ります。
$Days = $_POST["Attendances_daily"][0]; //Database Days Data
//selected YearMonth in Timesheet
$SelectYear = substr($_POST["YearMonth"], 0, 4);
$SelectMonth = substr($_POST["YearMonth"], 4, 6);
$SelectYM = $SelectYear.$SelectMonth;
$time = mktime(0, 0, 0, $SelectMonth, 1, $SelectYear);
$monthlyDay = date("t", $time); //一か月の最終日
$month = date("m", $time); // 現在の月
$year = date("Y", $time); // 現在の年
$strtotime = $year."-".$month."-1"; //毎月1日の曜日を求めるための変数
$dailyInt = date('w', strtotime($strtotime)); // date関数は0~6の数字をreturnする
$daily = array('日','月','火','水','木','金','土');
$workarray = array();
?>
    <table>
      <tr>
        <th class="small-cell">日</th>
        <th class="small-cell">曜</th>
        <th>勤務地</th>
        <th>出勤</th>
        <th>退勤</th>
        <th>休憩</th>
        <th>残業</th>
      </tr>
      <?php //print Days
      for($i=1;$i<$monthlyDay+1;$i++) {
      if($i < 10) $i = "0".$i; //日が 1~9の場合
      $day = $daily[$dailyInt]; //曜日を表すための変数
      foreach($Days as $key=>$value) { //日出力して比較
        $Daycheck = true;
        $WP = "";
        $ET = "";
        $ST = "";
        $RT = "";
        $OT = 0;

        if($year.$month.$i == $key) {
          $WP = $value["workplace"];
          $ST = $value["start_time"];
          $ET = $value["end_time"];
          $RT = $value["rest_time"];
          $OT = substr($ET, 0, 2)-substr($ST, 0, 2)-substr($RT, 0, 2)-8; //残業時間
          break;
        } else {
          $Daycheck = false;
        }
      }
      ?>
      <tr>
        <td class="small-cell"><?=$i?></td>
        <td class="small-cell"><?=$day?></td>
        <?php
        $dayarray = array();
        array_push($dayarray, $i, $day, $WP, $ST, $ET, $RT); //dayarray
        array_push($workarray, $dayarray); //workarray
        if($Daycheck == true) { ?>
          <td id="WPid<?=$i?>"><?=$WP?></td>
          <td><input type="text" id="STid<?=$i?>" value=<?=$ST?>></input></td> <!-- StartTime -->
          <td><input type="text" id="ETid<?=$i?>" value=<?=$ET?>></input></td> <!-- EndTime -->
          <td><input type="text" id="RTid<?=$i?>" value=<?=$RT?>></input></td> <!-- RestTime -->
          <td><?=$OT?></td>
        <?php } else { ?>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        <?php } ?>
      </tr>
      <?php if($dailyInt<6) {$dailyInt++;} else {$dailyInt=0;}
      } ?>

      <input type=hidden name="workdata" value=<?=json_encode($workarray) ?>></input>
      <input type=hidden name="YM" value=<?=$SelectYM ?>></input>
      <tr class="memo-cell">
        <th colspan="2">備考</th>
        <td colspan="6"><textarea name="text" rows="8" cols="80"></textarea>
        </td>
      </tr>

    </table>