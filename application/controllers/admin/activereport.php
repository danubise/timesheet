<?php
/**
 * Created by PhpStorm.
 * User: Slava
 * Date: 14.10.2015
 * Time: 23:45
 */

class Activereport extends Core_controller {
    public function __construct() {
        parent::__construct();
        $this->module_name = 'Active report';
    }

    function getNumberFromLine($dialString){
        //SIP/avalon/83789999893767
        //SIP/mtt/79189927384,90,L(
        $tmpArray = explode("/",$dialString);
        $numberline=$tmpArray[count($tmpArray)-1];
        if (strstr($numberline,",")){
            $tmpArray=explode(",",$numberline);
            $numberline = $tmpArray[0];
        }
        return $numberline;

    }
    public function index() {

        $userlogin = $this->db->select("login FROM `users` WHERE `id`='".$_SESSION['id']."'", 0);
        $cidNumbers = $this->db->select("number FROM `cid` WHERE `cid`='".$userlogin."'");
        if(empty($cidNumbers)){
            $resultstatistic = array();
        }else{
            $calls=file('/var/www/html/stat/act.php');
            $calls=explode("\n",$this->testData());
            $status = array();
            foreach ($calls as $key => $stringLine){
                foreach($cidNumbers as $key=>$number){
                    if(strstr($stringLine,$number)){
                        $lineArray=explode(" ",$stringLine);
                        foreach ($lineArray as $lk=>$lv){
                            if (trim($lv)==true){
                                $status[$number][]=$lv;
                            }
                        }
                        break;
                    }
                }
            }
            unset($calls);

            $resultstatistic = array();
            foreach($status as $number=>$valuearray){
                $resultstatistic[$number][0] = $valuearray[7];
                $resultstatistic[$number][1] = $this->getNumberFromLine($valuearray[6]);
                $resultstatistic[$number][2] = $valuearray[4];
                $resultstatistic[$number][3] = $valuearray[8];
            }
            unset($status);
        }
        $this->view(
            array(
                'view' => 'active/show',
                'var' => array(
                    'resultstatistic'=>$resultstatistic
                )
            )
        );
    }

    public function logout() {
        $this->user_model->logout();
        header('Location: '.baseurl());
    }


    public function testData(){
        return "SIP/invatek-000c7e4c macro-1drec          s                  22 Up      Dial         SIP/mtt/79779473919,90,L( 74990090137     00:05:25                         SIP/mtt-000c7e4d
                SIP/telecom-000c75a2 macro-2d             s                  21 Up      Dial         SIP/avalon/83789999893239 79585819290     00:17:20                         SIP/avalon-000c75a3
                SIP/invatek-000c7f7c macro-1drec          s                  22 Up      Dial         SIP/mtt/79189927384,90,L( 74996740285     00:03:41                         SIP/mtt-000c7f7d
                SIP/invatek-000c7959 macro-1drec          s                  22 Up      Dial         SIP/mtt/79116632148,90,L( 74990090137     00:12:27                         SIP/mtt-000c795a
                SIP/telecom-000c7f2b macro-4d             s                  92 Up      Dial         SIP/badaki/998973129406,9 79585772991     00:04:09                         SIP/badaki-000c7f42
                SIP/telecom-000c7f3c macro-2d             s                  21 Up      Dial         SIP/avalon/83789999894242 79585815968     00:04:06                         SIP/avalon-000c7f3d
                SIP/telecom-000c7e6c macro-2d             s                  21 Up      Dial         SIP/avalon/83789999894511 74951621021     00:05:08                         SIP/avalon-000c7e6d
                SIP/telecom-000c7e76 macro-2d             s                  21 Up      Dial         SIP/avalon/83789999894513 79847771997     00:05:05                         SIP/avalon-000c7e77
                SIP/telecom-000c7e70 macro-2d             s                  21 Up      Dial         SIP/avalon/83789999894202 79585816406     00:05:07                         SIP/avalon-000c7e71
                SIP/telecom-000c7e72 macro-2d             s                  21 Up      Dial         SIP/avalon/83789999894304 79844440951     00:05:06                         SIP/avalon-000c7e73
                SIP/telecom-000c79e4 macro-2d             s                  21 Up      Dial         SIP/avalon/83789999894124 79585819243     00:11:39                         SIP/avalon-000c79e5
                SIP/mea-000c8216     macro-3d             s                  46 Ring    Dial         SIP/castle/998979286677,9 74951621022    00:00:00                         (None)
                SIP/telecom-000c7d94 macro-2d             s                  21 Up      Dial         SIP/avalon/83789999893391 79585802361     00:06:20                         SIP/avalon-000c7d95
                SIP/telecom-000c81a0 macro-2d             s                  21 Up      Dial         SIP/avalon/83789999893626 79585819246     00:00:46                         SIP/avalon-000c81a1
                SIP/invatek114-000c8 macro-1drec          s                  22 Ring    Dial         SIP/mtt/79043316905,90,L( 78124822043     00:00:43                         (None)
                SIP/telecom-000c7d71 macro-2d             s                  46 Up      Dial         SIP/lexico/00309#99557915 +79277045561    00:06:32                         SIP/lexico-000c7d75
                SIP/telecom-000c7d09 macro-2d             s                  21 Up      Dial         SIP/avalon/83789999893695 79585817854     00:07:08                         SIP/avalon-000c7d0b
                SIP/invatek-000c81fe macro-1drec          s                  22 Ring    Dial         SIP/mtt/79537840527,90,L( 79055066980     00:00:06                         (None)
                SIP/telecom-000c81e8 macro-2d             s                  21 Ring    Dial         SIP/avalon/83789999893729 79585819836     00:00:13                         (None)
                SIP/invatek-000c8117 macro-1drec          s                  22 Up      Dial         SIP/mtt/79267540435,90,L( 78123134311     00:01:25                         SIP/mtt-000c8118
                SIP/telecom-000c81ee macro-2d             s                  21 Ring    Dial         SIP/avalon/83789999894280 79585802997     00:00:11                         (None)
                SIP/telecom-000c78b2 macro-4d             s                  92 Up      Dial         SIP/badaki/998973887699,9 79585811910     00:13:28                         SIP/badaki-000c78c4
                SIP/telecom-000c7826 macro-2d             s                  21 Up      Dial         SIP/avalon/83789999894386 79585816715     00:14:21                         SIP/avalon-000c7827
                SIP/telecom-000c810c macro-2d             s                  21 Up      Dial         SIP/avalon/83789999894330 79844449073     00:01:28                         SIP/avalon-000c810d
                SIP/melliton-000c81e macro-2d             s                  21 Ring    Dial         SIP/cawcprem/79040136878, 2127942230      00:00:14                         (None)
                SIP/telecom-000c80fc macro-2d             s                  46 Up      Dial         SIP/lexico/00309#99557907 +79284896740    00:01:32                         SIP/lexico-000c8105
                SIP/setion.237-000c8 macro-1d             s                  21 Ring    Dial         SIP/speedflow/6278#995557 2348024393604   00:00:06                         (None)
                SIP/telecom-000c7745 macro-2d             s                  21 Up      Dial         SIP/avalon/83789999894331 79844446992     00:15:19                         SIP/avalon-000c7747
                SIP/stelton-000c7fea macro-3d             s                  70 Up      Dial         SIP/melliton/37477134284, 33751498188     00:02:58                         SIP/melliton-000c7fe
                SIP/telecom-000c8165 macro-2d             s                  21 Up      Dial         SIP/avalon/83789999893767 74951621020     00:01:02                         SIP/avalon-000c8166
                SIP/invatek-000c80a6 macro-1drec          s                  22 Up      Dial         SIP/mtt/79506836321,90,L( 79250465442     00:02:03                         SIP/mtt-000c80a7
                SIP/invatek-000c74af macro-1drec          s                  22 Up      Dial         SIP/mtt/79304174782,90,L( 74990090137     00:18:30                         SIP/mtt-000c74b0
                SIP/invatek-000c7e09 macro-1drec          s                  22 Up      Dial         SIP/mtt/79173124337,90,L( 79262561107     00:05:42                         SIP/mtt-000c7e0a
                SIP/invatek-000c80db macro-1drec          s                  22 Up      Dial         SIP/mtt/79250756700,90,L( 79152297150     00:01:42                         SIP/mtt-000c80dc
";
    }
}
