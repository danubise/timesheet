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
        $datetime = new DateTime();
        $currentDate = $datetime->format('Y-m-d');
        $currentDate="2018-03-07";

        $userlogin = $this->db->select("login FROM `users` WHERE `id`='".$_SESSION['id']."'", 0);
        $data = $this->db->select("number, hour , sum(round_session_time) as sec
            FROM `statistic` WHERE `session_start` LIKE('".$currentDate."%') AND `cid`='".$userlogin."' group by number, hour");
        $tabledata= array();
        foreach ($data as $key=>$value){
            $tabledata[$value['number']][$value['hour']] = round($value['sec']/60);
        }
        $this->view(
            array(
                'view' => 'timesheet/show',
                'var' => array(
                    'data' => $tabledata,
                    'currentdate' => $currentDate
                )
            )
        );
    }
    
    public function update($destionation, $cid){
        dataUpdate($destionation, $cid );
    }

    public function logout() {
        $this->user_model->logout();
        header('Location: '.baseurl());
    }
}
