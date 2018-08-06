<?php
/**
 * Created by PhpStorm.
 * User: Slava
 * Date: 14.10.2015
 * Time: 23:45
 */

class Detailreport extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->module_name = 'Detail sheet';
    }

    public function index() {

        if(isset($_POST['submit'])){
            $date1 = $_POST['date1'];
            $date2 = $_POST['date2'];
        }else{
            $datetime = new DateTime();
            $date1 = $datetime->format('Y-m-d');
            $date2 = $date1;
        }
/*
количество набранных (N) ---
количество проговорённых минут (M) ---
количество отвеченных (O) ---
количество отвеченных в %
количество неотвеченных (NO) ----
количество неотвеченных в %
средняя длительность разговора (M/O)
*/
        $userlogin = $this->db->select("login FROM `users` WHERE `id`='".$_SESSION['id']."'", 0);

        $data = $this->db->select("* FROM `statistic` WHERE
             `session_start` >= '".$date1."' AND
             `session_start` <= '".$date2."'
             AND `typeinout`=1 AND `cid`='".$userlogin."'");
        $incalls = $this->calculateStatistic($data);

        $data = $this->db->select("* FROM `statistic` WHERE
            `session_start` >= '".$date1."' AND
            `session_start` <= '".$date2."' AND
            `typeinout`=2 AND `cid`='".$userlogin."'");
        $outcalls =  $this->calculateStatistic($data);

        $this->view(
            array(
                'view' => 'detail/show',
                'var' => array(
                    'incalldata' => $incalls,
                    'outcalldata' => $outcalls,
                    'date1' => $date1,
                    'date2' => $date2

                )
            )
        );
    }

    private function calculateStatistic($data){
        $tabledata= array();
        if(empty($data)){
            return $tabledata;
        }

        foreach ($data as $key=>$value){
            if(!isset($tabledata[$value['number']])){
                $tabledata[$value['number']] = array(
                    'countofcalls' => 0,
                    'umountminut' => 0,
                    'answered' => 0,
                    'missed' => 0,
                    'answeredpercent' => 0,
                    'missedpercent' => 0,
                    'averageminut' => 0
                );
            }
        }

        foreach ($data as $key=>$value){
            $tabledata[$value['number']]['countofcalls']++;
            $tabledata[$value['number']]['umountminut']=$tabledata[$value['number']]['umountminut'] + $value['round_session_time']/60;
            if($value['round_session_time'] >0){
                 $tabledata[$value['number']]['answered']++;
            }else{
                $tabledata[$value['number']]['missed']++;
            }
            if($tabledata[$value['number']]['countofcalls']>0){
                $tabledata[$value['number']]['answeredpercent'] =
                    100*$tabledata[$value['number']]['answered'] / $tabledata[$value['number']]['countofcalls'];
                $tabledata[$value['number']]['missedpercent'] =
                    100*$tabledata[$value['number']]['missed'] / $tabledata[$value['number']]['countofcalls'];
            }
            if($tabledata[$value['number']]['answered']>0){
                $tabledata[$value['number']]['averageminut'] =
                    $tabledata[$value['number']]['umountminut'] / $tabledata[$value['number']]['answered'];
            }
        }

        return $tabledata;
    }
    
    public function update($destionation, $cid){
        dataUpdate($destionation, $cid );
    }

    public function logout() {
        $this->user_model->logout();
        header('Location: '.baseurl());
    }
}
