<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 26.03.15
 * Time: 12:08
 */

class Settings extends Core_controller {
    public $dbasterisk='';
    public function __construct() {
        parent::__construct();
        $this->module_name = 'Настройки';
        $this->load_model('campany_model');
        //$this->load_model('trunk_model');
        //$this->load_model('list_model');
        //$this->load_model('numberpool_model');
    }

    public function index($page="",$userid=0) {
        //$users=$this->user_model->users();
        switch($page){
            case "usersave":

                $user=$this->user_model->usersave($_POST);
                $users=$this->user_model->users();
                //printarray($user);
                //die;
                $view = array(
                    'view' => 'settings/index',
                    'module' => 'Отчеты',
                    'var' => array(
                        'timestart'=>date('Y-m-d H:i:s'),
                        'user'=>$user,
                        'users'=>$users
                    )
                );
                break;
            case "useredit":
                $user=$this->user_model->userget($userid);
                //printarray($user);
                //die;
                $view = array(
                    'view' => 'settings/useredit',
                    'module' => 'Отчеты',
                    'var' => array(
                        'timestart'=>date('Y-m-d H:i:s'),
                        'user'=>$user
                    )
                );
                break;
            case "userdelete":
                $this->user_model->userdelete($userid);
                $users=$this->user_model->users();
                $view = array(
                    'view' => 'settings/index',
                    'module' => 'Отчеты',
                    'var' => array(
                        'timestart'=>date('Y-m-d H:i:s'),
                        'users'=>$users
                    )
                );
                break;
            case "useraddview":
                $view = array(
                    'view' => 'settings/useradd',
                    'module' => 'Отчеты',
                    'var' => array(
                        'timestart'=>date('Y-m-d H:i:s')


                    )
                );
                break;
            case "useradd":
                $users=$this->user_model->users();
                if($this->user_model->useradd($_POST['name'],$_POST['password'])){
                    $view = array(
                        'view' => 'settings/index',
                        'module' => 'Отчеты',
                        'var' => array(
                            'timestart'=>date('Y-m-d H:i:s'),
                            'users'=>$users
                        )
                    );
                }else{
                    if(isset($_POST['name'])){$fail="true";} else {$fail=false;}
                    $view = array(
                        'view' => 'settings/useradd',
                        'module' => 'Отчеты',
                        'var' => array(
                            'timestart'=>date('Y-m-d H:i:s'),
                            'addfail'=>$fail,
                            'users'=>$users


                        )
                    );
                }
                break;
            default:
                $users=$this->user_model->users();
                //printarray($users);
                $view = array(
                    'view' => 'settings/index',
                    'module' => 'Отчеты',
                    'var' => array(
                        'timestart'=>date('Y-m-d H:i:s'),
                        'users'=>$users
                    )
                );
        }
        $this->view($view);
    }

    public function logout() {
        $this->user_model->logout();
        header('Location: '.baseurl());
    }
}