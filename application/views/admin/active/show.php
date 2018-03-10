<table>
    <tr>
        <th>A-num</th>
        <th>B-num</th>
        <th>Статус</th>
        <th>Длительность</th>
    </tr>
    <?php
        if(!empty($resultstatistic)){
            foreach ($resultstatistic as $number=>$valueArray){
                if($valueArray[2]=="Up"){
                    $bgcolor="bgcolor=#edf8ff";
                }
                echo "<tr ".$bgcolor." >";
                foreach($valueArray as $key=>$value){
                    echo "<td>".$value."</td>";
                }
                echo "</tr>";
                $bgcolor="";
            }
        }

    ?>
</table>