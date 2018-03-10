<?php
/**
 * Created by PhpStorm.
 * User: Slava
 * Date: 14.10.2015
 * Time: 23:45
 */

class Hourlyreport extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->module_name = 'Time sheet';
    }

    public function index() {
    global $_config;
    $date1="01.03.2018";
    $date2="09.03.2018";

    $id="2319%2C2322";
    $cid="2433";
    $url = 'http://'.$_config['billing']['host'].'/bgbilling/executer?user='.$_config['billing']['user'].
        '&pswd='.$_config['billing']['password'].
        '&module=voiceip'.
        '&direct=2'.
        '&mid=4'.
        '&pageSize=999'.
        '&date2='.date('d.m.Y', strtotime($date2)).
        '&date1='.date('d.m.Y', strtotime($date1)).
        '&unit=1'.
        '&pageIndex=1'.
        '&action=LoginSessions'.
        '&id='.$id.
        '&contentType=xml'.
        '&cid='.$cid.
        '&mask=';



    $data = simplexml_load_string(file_get_contents($url));
    echo $url."<br>";
    if ((string)$data['status'] == 'ok') {
        var_dump($data);
         $countOfRows= $data->table->data->attributes();
         for ($i =0 ; $i< $countOfRows; $i++) {
            $from_to_temp= $data->table->data->row[$i]['from_to']->__toString();
            $from_to = explode("/",$from_to_temp);
            $number = trim($from_to[1]);
            $durationstring = $data->table->data->row[$i]['round_session_time']->__toString();
            $durationtime_temp = explode("[",$durationstring);
            $durationtime_temp = explode("]",$durationtime_temp[1]);
            $round_session_time = $durationtime_temp[0];

            echo " time = ".$round_session_time;
            echo " startat = ".$data->table->data->row[$i]['session_start']->__toString();
            echo "<br>";
            $session_start=date("Y-m-d H:i:s", strtotime( $data->table->data->row[$i]['session_start']->__toString() ));
            $log_id = (int)$data->table->data->row[$i]['log_id'];
            $this->db->insert("statistic", array(
            "number"=>$number,
            "session_start"=>$session_start,
            "round_session_time" => (int)$round_session_time,
            "typeinout" => 2,
            "log_id" => $log_id
            ));
            echo $this->db->query->last."<br>";
         }

    }
//        $this->view(
//            array(
//                'view' => 'timesheet/show',
//                'var' => array(
//                )
//            )
//        );
    }

    public function logout() {
        $this->user_model->logout();
        header('Location: '.baseurl());
    }
}
