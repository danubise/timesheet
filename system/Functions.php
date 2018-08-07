<?php
/**
 * Created by Unix develop team.
 * User: vlad
 * Date: 19.02.15
 * Time: 22:14
 */

function printarray($out) {
    echo"<pre>";
    print_r($out);
    echo"</pre>";
}

function baseurl($url = '') {
    global $core_dir;
    return 'http://'.$_SERVER['HTTP_HOST'].'/'.(($core_dir)? $core_dir : '').$url;
}

function check_controller($controller) {
    if(file_exists(controllers.$controller.EXT)) {
        require_once controllers.$controller.EXT;
        return true;
    }
    return false;
}

function connect_mysql() {
    global $_config;
    if(empty($_config['mysql']['user']) or empty($_config['mysql']['password'])) {
        return false;
    }
//    $connect = new db($_config['mysql']['host'],
//        $_config['mysql']['user'],
//        $_config['mysql']['password'],
//        $_config['mysql']['database']);
    $connect = new db($_config['mysql']);
    $connect->set_charset("utf8");
    return $connect;
}

function &get_instance() {
    return Core::get_instance();
}

function get_month() {
	return array(
		'Январь',
		'Февраль',
		'Март',
		'Апрель',
		'Май',
		'Июнь',
		'Июль',
		'Август',
		'Сентябрь',
		'Октябрь',
		'Ноябрь',
		'Декабрь'
	);
}

function get_alias($route) {
    if(!empty($route)) {
        global $Core;
        if(isset($Core->config->route->{$route})) {
            return $Core->config->route->{$route};
        }
    }
    return false;
}
function cp1251_to_utf8($s)
{
    if ((mb_detect_encoding($s,'UTF-8,CP1251')) == "WINDOWS-1251")
    {
        $c209 = chr(209); $c208 = chr(208); $c129 = chr(129);
        for($i=0; $i<strlen($s); $i++)
        {
            $c=ord($s[$i]);
            if ($c>=192 and $c<=239) $t.=$c208.chr($c-48);
            elseif ($c>239) $t.=$c209.chr($c-112);
            elseif ($c==184) $t.=$c209.$c209;
            elseif ($c==168)    $t.=$c208.$c129;
            else $t.=$s[$i];
        }
        return $t;
    }
    else
    {
        return $s;
    }
}

function utf8_to_cp1251($s)
{
    if ((mb_detect_encoding($s,'UTF-8,CP1251')) == "UTF-8")
    {
        for ($c=0;$c<strlen($s);$c++)
        {
            $i=ord($s[$c]);
            if ($i<=127) $out.=$s[$c];
            if ($byte2)
            {
                $new_c2=($c1&3)*64+($i&63);
                $new_c1=($c1>>2)&5;
                $new_i=$new_c1*256+$new_c2;
                if ($new_i==1025)
                {
                    $out_i=168;
                } else {
                    if ($new_i==1105)
                    {
                        $out_i=184;
                    } else {
                        $out_i=$new_i-848;
                    }
                }
                $out.=chr($out_i);
                $byte2=false;
            }
            if (($i>>5)==6)
            {
                $c1=$i;
                $byte2=true;
            }
        }
        return $out;
    }
    else
    {
        return $s;
    }
}

function dataUpdate( $destination, $cid, $date1 ){
    global $_config;

    $datetime = new DateTime($date1);
    $date1 = $datetime->format('d.m.Y');
//    $datetime->modify('+1 day');
//    $datetime = new DateTime('tomorrow');
    $date2 =  $datetime->format('d.m.Y');

    //echo $date1."  =>> ".$date2."!!!!!!!!!";

    //die;
//    $date1="01.03.2018";
//    $date2="09.03.2018";

    $db = connect_mysql();
    $users_id = $db->select("user_id from `cid` where `cid`='".$cid."'");
    $id="";
    foreach($users_id as $key=>$value){
        $id=$id.$value." ";
    }
    $id= str_replace(" ","%2C",trim($id));

    $url = 'http://'.$_config['billing']['host'].'/bgbilling/executer?user='.$_config['billing']['user'].
        '&pswd='.$_config['billing']['password'].
        '&module=voiceip'.
        '&direct='.$destination.
        '&mid=4'.
        '&pageSize=9999999'.
        '&date2='.$date2.
        '&date1='.$date1.
        '&unit=1'.
        '&pageIndex=1'.
        '&action=LoginSessions'.
        '&id='.$id.
        '&contentType=xml'.
        '&cid='.$cid.
        '&mask=';
    //echo $url."<br>";
    saveToLog($url);
    register_shutdown_function('shutdown');

    $dataFromBilling=file_get_contents($url);
    saveToLog($dataFromBilling);
    $data = simplexml_load_string($dataFromBilling);
    if ((string)$data['status'] == 'ok') {
         $countOfRows= $data->table->data->attributes();
         for ($i =0 ; $i< $countOfRows; $i++) {
            $from_to_temp= $data->table->data->row[$i]['from_to']->__toString();
            $from_to = explode("/",$from_to_temp);
            $number = trim($from_to[$destination-1]);
            $durationstring = $data->table->data->row[$i]['round_session_time']->__toString();
            $durationtime_temp = explode("[",$durationstring);
            $durationtime_temp = explode("]",$durationtime_temp[1]);
            $round_session_time = $durationtime_temp[0];

            $session_start=date("Y-m-d H:i:s", strtotime( $data->table->data->row[$i]['session_start']->__toString() ));
            $hour=date("H", strtotime( $data->table->data->row[$i]['session_start']->__toString() ));
            $log_id = (int)$data->table->data->row[$i]['log_id'];
            $db->insert("statistic", array(
            "number"=>$number,
            "cid" => (int)$cid,
            "session_start"=>$session_start,
            "hour" => $hour,
            "round_session_time" => (int)$round_session_time,
            "typeinout" => $destination,
            "log_id" => $log_id
            ));
         //   echo $db->query->last."<br>";
         }
    }
}

function saveToLog($data){
    $datetime = new DateTime();
    $date1 = $datetime->format("Y-m-d H:i:s");
    file_put_contents("/var/log/asterisk/timesheet_debug.log", "\n".$date1." ".$data."\n", FILE_APPEND | LOCK_EX);
}

function shutdown(){
    if (($error = error_get_last())) {
       ob_clean();
       echo "Ошибка обработки данных";
       saveToLog("ERROR: ". var_export($error,true));
    }
}