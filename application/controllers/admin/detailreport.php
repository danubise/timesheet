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
        $datetime = new DateTime();
        $date1 = $datetime->format('Y-m-d');
        $datetime = new DateTime('tomorrow');
        $date2 =  $datetime->format('Y-m-d');
            $date1="2018-03-01";
            $date2="2018-03-09";

/*
количество набранных (N) ---
количество проговорённых минут (M) ---
количество отвеченных (O) ---
количество отвеченных в %
количество неотвеченных (NO) ----
количество неотвеченных в %
средняя длительность разговора (M/O)
*/
        $data = $this->db->select("* FROM `statistic` WHERE `session_start` >= '".$date1."'
            AND `session_start` < '".$date2."' AND `typeinout`=1");
        $incalls = $this->calculateStatistic($data);

        $data = $this->db->select("* FROM `statistic` WHERE `session_start` >= '".$date1."'
            AND `session_start` < '".$date2."' AND `typeinout`=2");
        $outcalls =  $this->calculateStatistic($data);

        $this->view(
            array(
                'view' => 'detail/show',
                'var' => array(
                    'incalldata' => $incalls,
                    'outcalldata' => $outcalls

                )
            )
        );
    }

    private function calculateStatistic($data){
        $tabledata= array();
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
            $tabledata[$value['number']]['answeredpercent'] = 100*$tabledata[$value['number']]['answered'] / $tabledata[$value['number']]['countofcalls'];
            $tabledata[$value['number']]['missedpercent'] = 100*$tabledata[$value['number']]['missed'] / $tabledata[$value['number']]['countofcalls'];
            $tabledata[$value['number']]['averageminut'] = $tabledata[$value['number']]['umountminut'] / $tabledata[$value['number']]['countofcalls'];
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
