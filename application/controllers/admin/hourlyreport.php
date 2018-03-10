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

        $userlogin = $this->db->select("login FROM `users` WHERE `id`='".$_SESSION['id']."'", 0);
        if(isset($_POST['update']) && $userlogin != "admin"){
            $currentDate = $_POST['currentDate'];
            $lastUpdateTime = $this->db->select("`value` FROM `settings` WHERE `parameter`='lasttimeupdate".$userlogin."'", 0);

            if($lastUpdateTime==""){
                $this->db->insert("settings",array(
                        "parameter"=>"lasttimeupdate".$userlogin,
                        "value"=>time()));
            }

            if(time() - $lastUpdateTime > 5){
                $this->update(1, $userlogin, $currentDate);
                $this->update(2, $userlogin, $currentDate);
                $this->db->update("settings",array("value"=>time()),"parameter='lasttimeupdate".$userlogin."'");
            }
        }
        $data = $this->db->select("number, hour , sum(round_session_time) as sec
            FROM `statistic` WHERE `session_start` LIKE('".$currentDate."%') AND `cid`='".$userlogin."' group by number, hour");
        $tabledata= array();
        if(!empty($data)){
            foreach ($data as $key=>$value){
                $tabledata[$value['number']][$value['hour']] = round($value['sec']/60);
            }
        }
        $this->view(
            array(
                'view' => 'timesheet/show',
                'var' => array(
                    'data' => $tabledata,
                    'currentDate' => $currentDate
                )
            )
        );
    }
    
    public function update($destionation, $cid, $currentDate){
        dataUpdate($destionation, $cid , $currentDate);
    }

    public function logout() {
        $this->user_model->logout();
        header('Location: '.baseurl());
    }
}
