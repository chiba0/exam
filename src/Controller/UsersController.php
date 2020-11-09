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
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        global $array_gender;
        $this->array_gender = $array_gender;
        $this->TTest = $this->loadModel('TTest'); 
        $this->TUser = $this->loadModel('TUser'); 
        $this->TTestpaper = $this->loadModel('TTestpaper'); 
        $this->loadComponent('Common');
    }
    public function login($id=""){
        
        
        
        if (empty($id)) {
            $this->log(date('Y-m-d H:i:s')."テストにidが入力されていません", "error");
            throw new NotFoundException(__('User not found'));
        }
        //テスト情報の取得
        $ttest = $this->TTest ->find()->where([
            'dir'=>$id
        ])->first();
        //日付の確認
        $now = date("Y/m/d");
        if($ttest->period_from > $now
            || $ttest->period_to < $now
        ){
            $this->log(date('Y-m-d H:i:s')."テストに期間外", "error");
            throw new NotFoundException(__('TEST 期間外'));

        }
        
        $this->ttest = $ttest;
        if (empty($ttest)) {
            $this->log(date('Y-m-d H:i:s')."テストデータがありません。", "error");
            throw new NotFoundException(__('User not found'));
        }

        //ユーザーデータ取得
        $tuser = $this->TUser->find()->where([
            'id'=>$ttest[ 'customer_id' ]
        ])->first();

        $this->tuser=$tuser;
        
        //ロゴ画像取得
        $logo = $this->Common->__setLogo($tuser);

       //ログイン実行
        if($this->request->getData('login')){
            $loginid = $this->request->getData("userid");
            $this->log(date('Y-m-d H:i:s')."ログイン実行[".$loginid."]");
            
            //ログインチェック
            
            if($this->TTestpaper->___checkTestpaper($this,$ttest)){
                //個人情報登録画面に遷移
                $this->__registHuman($id);
            }else{
                
                $this->Flash->error('ログインに失敗しました。');
            }
            
        }
        //個人情報登録
        //登録成功時に検査メニュー
        $errmsg = "";
        if($this->request->getData('regist')){
            $ttp = $this->TTestpaper->newEntity();
            $ttp  = $this->TTestpaper->patchEntity($ttp,$this->request->data, ['validate' => 'exam']);


            if(count($ttp->errors()) > 0 ){
                //エラーメッセージ表示
                $this->log(date('Y-m-d H:i:s')."個人情報登録誤り[".$id."]", "error");
                if($ttp->errors('name1')) $errmsg .= $ttp->errors('name1')['_empty']."\n";
                if($ttp->errors('name2')) $errmsg .= $ttp->errors('name2')['_empty']."\n";
                if($ttp->errors('kana1')) $errmsg .= $ttp->errors('kana1')['_empty']."\n";
                if($ttp->errors('kana2')) $errmsg .= $ttp->errors('kana2')['_empty']."\n";
                if($ttp->errors('gender')) $errmsg .= $ttp->errors('gender')['_required']."\n";
                $this->Flash->error($errmsg);
                
                $this->log(date('Y-m-d H:i:s')."個人情報登録誤り[".$id."]".$errmsg, "error");
                //個人情報登録画面に遷移
                $this->__registHuman($id);
            }else{
                //個人情報の登録
                //ttestidの取得
                $loginid = $this->request->getData("userid");
                $this->log(date('Y-m-d H:i:s')."ログイン実行[".$loginid."]");
                
                //ログインチェック
                if($this->TTestpaper->___checkTestpaper($this,$ttest)){               
                    $ttestpaper = $this->TTestpaper->ttestpaper;
                    foreach($ttestpaper as $key=>$value){
                        $tid = $value['id'];
                        $tt = $this->TTestpaper->get($tid);
                        $edit = [];
                        $edit[ 'name' ] = $this->request->getData('name1')." ".$this->request->getData('name2');
                        $edit[ 'kana' ] = $this->request->getData('kana1')." ".$this->request->getData('kana2');
                        $edit['sex'] = $this->request->getData("gender");
                        $edit['birth'] = sprintf("%04d/%02d/%02d"
                                            ,$this->request->getData('birth_y')
                                            ,$this->request->getData('birth_m')
                                            ,$this->request->getData('birth_d')
                                            );
                        $ttSet = $this->TTestpaper->patchEntity($tt, $edit);
                        $this->TTestpaper->save($ttSet);
                    }
                    //登録成功検査トップにリダイレクト
                    $session = $this->request->session();
                    $session->write('Exam.login', 'on');
                    $session->write('Exam.examid', $loginid);
                    $session->write('Exam.test_id', $ttestpaper[0]['test_id']);
                    $session->write('Exam.testgrp_id', $ttestpaper[0]['testgrp_id']);
                    $session->write('Exam.number', $ttestpaper[0]['number']);
                    $session->write('Exam.partner_id', $ttestpaper[0]['partner_id']);
                    $session->write('Exam.customer_id', $ttestpaper[0]['customer_id']);
                    $session->write('Exam.dir', $id);
                    header("Location:/users/login/".$id);
                    exit();
                }
                
            }

        }

       $this->set("id",$id);
       $this->set("ttest", $this->ttest);
       $this->set("tuser", $this->tuser);
       $this->set("logo", $logo);

    }

    /*************
     * 個人情報登録画面
     */
    public function __registHuman($id){
        //ロゴ画像取得
        $logo = $this->Common->__setLogo($this->tuser);

 
        $birth_y = $this->request->getData("birth_y");
        $birth_m = $this->request->getData("birth_m");
        $birth_d = $this->request->getData("birth_d");

        
        $name1 = "";
        if(!empty($this->request->getData("name1"))){
            $name1 = $this->request->getData("name1");
        }elseif(!empty($this->TTestpaper->ttestpaper[0]->name)){
            $ex = explode(" ",$this->TTestpaper->ttestpaper[0]->name);
            $name1 = $ex[0];
        }
        $name2 = "";
        if(!empty($this->request->getData("name2"))){
            $name2 = $this->request->getData("name2");
        }elseif(!empty($this->TTestpaper->ttestpaper[0]->name)){
            $ex = explode(" ",$this->TTestpaper->ttestpaper[0]->name);
            $name2 = $ex[1];
        }

        
        $kana1 = "";
        if(!empty($this->request->getData("kana1"))){
            $kana1 = $this->request->getData("kana1");
        }elseif(!empty($this->TTestpaper->ttestpaper[0]->kana)){
            $ex = explode(" ",$this->TTestpaper->ttestpaper[0]->kana);
            $kana1 = $ex[0];
        }

        $kana2 = "";
        if(!empty($this->request->getData("kana2"))){
            $kana2 = $this->request->getData("kana2");
        }elseif(!empty($this->TTestpaper->ttestpaper[0]->kana)){
            $ex = explode(" ",$this->TTestpaper->ttestpaper[0]->kana);
            $kana2 = $ex[1];
        }


        $gender = "";
        
        if(!empty($this->request->getData("gender"))){
            $gender = $this->request->getData("gender");
        }
        else{
            if(!empty($this->TTestpaper->ttestpaper[0]->sex)){
                $gender = $this->TTestpaper->ttestpaper[0]->sex;
            }  
        }

        $this->set("id",$id);
        $this->set("ttest", $this->ttest);
        $this->set("logo", $logo);
        $this->set("tuser", $this->tuser);
        $this->set("birth_y", $birth_y);
        $this->set("birth_m", $birth_m);
        $this->set("birth_d", $birth_d);
        $this->set("name1", $name1);
        $this->set("name2", $name2);
        $this->set("kana1", $kana1);
        $this->set("kana2", $kana2);
        $this->set("array_gender", $this->array_gender);
        $this->set("gender", $gender);
        $this->render("regist");
    }
}
