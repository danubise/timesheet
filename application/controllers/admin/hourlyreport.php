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
        $date1 = $datetime->format('d.m.Y');
        $datetime = new DateTime('tomorrow');
        $date2 =  $datetime->format('d.m.Y');
        $data = $this->db->select();
        $this->view(
            array(
                'view' => 'timesheet/show',
                'var' => array(
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
