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
        dataUpdate("2433");


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
