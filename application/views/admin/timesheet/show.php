<?php
    print_r($data);
?>
<style>
</style>
<table border=1>
    <?php
    echo "<th>Номер\Часы</th>";
    for($i=0; $i<24;$i++){
        echo "<th>".$i."</th>";
    }
    foreach($data as $number => $hours){
        echo "<tr><td>".$number."</td>";
        for($i=0; $i<24;$i++){
            if(isset($hours[$i])){
                if($hours[$i]>=0 && $hours[$i]<=15) {
                    $color="#05FC02";
                }elseif ($hours[$i]>15 && $hours[$i]<=30){
                    $color="#FCFC02";
                }elseif ($hours[$i]>30 && $hours[$i]<=45){
                    $color="#FC8E02";
                }else{
                    $color="#FC0202";
                }
                echo "<td bgcolor=\"".$color."\">".$hours[$i]."</td>";
            }else{
                echo "<td>0</td>";
            }

        }
        echo "</tr>";
    }
    ?>

</table>