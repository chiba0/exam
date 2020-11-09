<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ExamsController extends AppController
{


    public function initialize()
    {
        parent::initialize();

        $this->TTest = $this->loadModel('TTest'); 
        $this->TUser = $this->loadModel('TUser'); 
        $this->TTestpaper = $this->loadModel('TTestpaper'); 
        $this->loadComponent('Common');
    }
    
    public function menu($id){


        $session = $this->request->session();
        $this->session=$session;
        $examlogin = $session->read('Exam.login');
        $examid = $session->read('Exam.examid');
        $test_id = $session->read('Exam.test_id');
        $testgrp_id = $session->read('Exam.testgrp_id');
        $number = $session->read('Exam.number');
        $partner_id = $session->read('Exam.partner_id');
        $customer_id = $session->read('Exam.customer_id');

        //unset($_SESSION[ 'Exam' ]);

        //var_dump($id,$examlogin,$test_id,$customer_id);

        if($examlogin == "on"){

            //テスト情報の取得
            $ttest = $this->TTest ->find()->where([
                'dir'=>$id
            ])->first();
            //日付の確認
            $now = date("Y/m/d");
            if($ttest->period_from > $now
                || $ttest->period_to < $now
            ){
                $this->session->delete('Exam.login');
                $this->log(date('Y-m-d H:i:s')."テストに期間外", "error");
                throw new NotFoundException(__('TEST 期間外'));

            }

            //ユーザーデータ取得
            $tuser = $this->TUser->find()->where([
                'id'=>$ttest[ 'customer_id' ]
            ])->first();
    
            $this->tuser=$tuser;
    
            //ロゴ画像取得
            $logo = $this->Common->__setLogo($tuser);
        
            //メニューデータ取得
            $where = [];
            $where['test_id'] = $test_id;
            $where['testgrp_id'] = $testgrp_id;
            $where['exam_id'] = $examid;
            $menu = $this->TTestpaper->__getMenu($where);

            $this->set("id",$id);
            $this->set("ttest", $ttest);
            $this->set("logo", $logo);
            $this->set("tuser", $tuser);
            $this->set("menu", $menu);
            
        }else{
            $this->log(date('Y-m-d H:i:s')."メニュー画面遷移失敗", "error");
            
            throw new NotFoundException(__('User not found'));
        }
        
    }



   
}
