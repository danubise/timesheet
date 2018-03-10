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
<form method="post"  enctype="multipart/form-data" action="<?=baseurl('hourlyreport/index/')?>">

<div class="form-group">
    <input name="currentDate" type="date" data-date-inline-picker="true"  value="<?=$currentDate?>"/>
    <button name="update" type="submit" class="btn btn-success" id="getReport">Получить</button>
</div>
<table class="blueTable">
    <?php
    echo "<tr><th colspan=\"25\">".$currentDate." </th></tr><tr><th>Номер\Часы</th>";
    for($i=0; $i<24;$i++){
        echo "<th>".sprintf("%02d", $i)."</th>";
    }
    echo "</tr>";
    foreach($data as $number => $hours){
        echo "<tr><td>".$number."</td>";
        for($i=0; $i<24;$i++){
            if(isset($hours[$i])){
                if($hours[$i]>=0 && $hours[$i]<=15) {
                    $color="style=\"background-color: #05FC02;\"";
                }elseif ($hours[$i]>15 && $hours[$i]<=30){
                    $color="style=\"background-color: #FCFC02;\"";
                }elseif ($hours[$i]>30 && $hours[$i]<=45){
                    $color="style=\"background-color: #FC8E02;\"";
                }else{
                    $color="style=\"background-color: #FC0202;\"";
                }
                echo "<td ".$color.">".$hours[$i]."</td>";
            }else{
                echo "<td>0</td>";
            }
        }
        echo "</tr>";
    }
    ?>
</table>

</form>