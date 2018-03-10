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
        <input name="selecteddate" type="date" data-date-inline-picker="true"  value="<?=$selecteddate?>"/>
        <button name="submit" type="submit" class="btn btn-success" id="getReport">Сформировать</button>
    </div>
    <table border=1>

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
            displaydata($incalldata);
        ?>
     </table>
     <br>
     <br>
     <br>
     <table border=1>
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
            displaydata($outcalldata);
        ?>
    </table>

</form >