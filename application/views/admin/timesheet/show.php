<?php
    print_r($data);
?>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?=baseurl('pub/tablestyle/images/icons/favicon.ico')?>"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=baseurl('pub/tablestyle/vendor/bootstrap/css/bootstrap.min.css')?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=baseurl('pub/tablestyle/fonts/font-awesome-4.7.0/css/font-awesome.min.css')?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=baseurl('pub/tablestyle/vendor/animate/animate.css')?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=baseurl('pub/tablestyle/vendor/select2/select2.min.css')?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=baseurl('pub/tablestyle/vendor/perfect-scrollbar/perfect-scrollbar.css')?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=baseurl('pub/tablestyle/css/util.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=baseurl('pub/tablestyle/css/main.css')?>">
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