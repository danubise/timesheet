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
        $cidNumbers = $this->db->select("number, aconnid FROM `cid` WHERE `cid`='".$userlogin."'");

        if(empty($cidNumbers)){
            $resultstatistic = array();
        }else{
            $calls=explode("\n",file_get_contents('http://95.141.192.21/stat/act.php'));
//            $calls=explode("\n",$this->testData());
            $status = array();
            foreach ($calls as $key => $stringLine){
                foreach($cidNumbers as $key=>$number){
                    if(strstr($stringLine, $number['aconnid'])){
                        $stringLine = str_replace($number['aconnid'], $number['number'], $stringLine);
                    }

                    if(strstr($stringLine, $number['number'])){
                        $lineArray=explode(" ",$stringLine);
                        foreach ($lineArray as $lk=>$lv){
                            if (trim($lv)==true){
                                $status[$number['number']][]=$lv;
                            }
                        }
                        break;
                    }
                }

            }
            unset($calls);

            $resultstatistic = array();
            foreach($cidNumbers as $key=>$valueArray){
                $number= $valueArray['number'];
                if(isset($status[$number])){
                    $resultstatistic[$number][0] = $number;
                    $resultstatistic[$number][1] = $status[$number][4];
                    $resultstatistic[$number][2] = $status[$number][8];
                }else{
                    $resultstatistic[$number][0] = $number;
                    $resultstatistic[$number][1] = "";
                    $resultstatistic[$number][2] = "";
                }

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
        return "SIP/alt-cc-00021760  cc-062785-peers      200                 9 Ring    Dial         sip/a01293,40,t           79198222666     00:00:03 062785                  (None)
                SIP/invatek-000c7e4c macro-1drec          s                  22 Up      Dial         SIP/mtt/79779473919,90,L( 74990090137     00:05:25                         SIP/mtt-000c7e4d
                SIP/telecom-000c75a2 macro-2d             s                  21 Up      Dial         SIP/avalon/83789999893239 79585819290     00:17:20                         SIP/avalon-000c75a3
                SIP/invatek-000c7f7c macro-1drec          s                  22 Up      Dial         SIP/mtt/79189927384,90,L( 74996740285     00:03:41                         SIP/mtt-000c7f7d
                SIP/invatek-000c7959 macro-1drec          s                  22 Up      Dial         SIP/mtt/79116632148,90,L( 74990090137     00:12:27                         SIP/mtt-000c795a
                SIP/telecom-000c7f2b macro-4d             s                  92 Up      Dial         SIP/badaki/998973129406,9 74951621021     00:04:09                         SIP/badaki-000c7f42
                SIP/telecom-000c7f3c macro-2d             s                  21 Up      Dial         SIP/avalon/83789999894242 79585815968     00:04:06                         SIP/avalon-000c7f3d
";
    }
}
