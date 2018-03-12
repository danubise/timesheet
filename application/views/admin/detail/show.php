<style>
table.blueTable {
  border: 1px solid #1C6EA4;
  background-color: #EEEEEE;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
table.blueTable td, table.blueTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.blueTable tbody td {
  font-size: 13px;
}
table.blueTable tr:nth-child(even) {
  background: #D0E4F5;
}
table.blueTable thead {
  background: #1C6EA4;
  background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  border-bottom: 2px solid #444444;
}
table.blueTable thead th {
  font-size: 15px;
  font-weight: bold;
  color: #FFFFFF;
  border-left: 2px solid #D0E4F5;
}
table.blueTable thead th:first-child {
  border-left: none;
}

table.blueTable tfoot td {
  font-size: 14px;
}
table.blueTable tfoot .links {
  text-align: right;
}
table.blueTable tfoot .links a{
  display: inline-block;
  background: #1C6EA4;
  color: #FFFFFF;
  padding: 2px 8px;
  border-radius: 5px;
}
</style>
<?php
function displaydata($data){
    foreach ($data as $number=>$statdata){
        echo "<tr><td>".$number."</td>";
        echo "<td>".$statdata['countofcalls']."</td>";
        echo "<td>".round($statdata['umountminut'],2)."</td>";
        echo "<td>".$statdata['answered']."</td>";
        echo "<td>".round($statdata['answeredpercent'],2)."</td>";
        echo "<td>".$statdata['missed']."</td>";
        echo "<td>".round($statdata['missedpercent'],2)."</td>";
        echo "<td>".round($statdata['averageminut'],2)."</td>";
        echo "</tr>";
    }
}
?>

<form method="post"  enctype="multipart/form-data" action="<?=baseurl('detailreport/index/')?>">

    <div class="form-group">
        <input name="date1" type="date" data-date-inline-picker="true"  value="<?=$date1?>"/>
        <input name="date2" type="date" data-date-inline-picker="true"  value="<?=$date2?>"/>
        <button name="submit" type="submit" class="btn btn-success" id="getReport">Сформировать</button>
    </div>
    <table class="blueTable">

        <tr>
            <th colspan="8">Исходящие</th>
        </tr>
        <tr>
        <th>номер\данные</th>
        <th>количество набранных (N)</th>
        <th>количество проговорённых минут (M)</th>
        <th>количество отвеченных (O)</th>
        <th>количество отвеченных в %</th>
        <th>количество неотвеченных (NO)</th>
        <th>количество неотвеченных в %</th>
        <th>средняя длительность разговора (M/O)</th>
        </tr>

        <?php
            displaydata($incalldata);
        ?>
     </table>
     <br>
     <br>
     <br>
     <table class="blueTable">
        <tr>
            <th colspan="8">Входящие</th>
        </tr>
        <tr>
            <th>номер\данные</th>
            <th>количество набранных (N)</th>
            <th>количество проговорённых минут (M)</th>
            <th>количество отвеченных (O)</th>
            <th>количество отвеченных в %</th>
            <th>количество неотвеченных (NO)</th>
            <th>количество неотвеченных в %</th>
            <th>средняя длительность разговора (M/O)</th>
        </tr>
        <?php
            displaydata($outcalldata);
        ?>
    </table>

</form >
