<style>
</style>
<table border=1>
    <?php
print_r($incalldata);
echo "<br>";
print_r($outcalldata);

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
    <tr>
        <th></th><th colspan="8">Входящие</th>
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
 <table border=1>
    <tr>
        <th></th><th colspan="8">Исходящие</th>
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