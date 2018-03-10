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
        $date1 = $datetime->format('Y-m-d');
        $datetime = new DateTime('tomorrow');
        $date2 =  $datetime->format('Y-m-d');
            $date1="2018-03-01";
            $date2="2018-03-09";
        $data = $this->db->select("number, hour , sum(round_session_time) as sec
            FROM `statistic` WHERE `session_start` >= '".$date1."'
            AND `session_start` < '".$date2."' group by number, hour");
        $tabledata= array();
        foreach ($data as $key=>$value){
            $tabledata[$value['number']][$value['hour']] = round($value['sec']/60);
        }
        $this->view(
            array(
                'view' => 'timesheet/show',
                'var' => array(
                    'data' => $tabledata
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
