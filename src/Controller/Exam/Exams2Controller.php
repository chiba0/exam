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
namespace App\Controller\Exam;

use App\Controller\AppController;

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


class Exams2Controller extends AppController
{




    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');
        $this->TTest = $this->loadModel('TTest'); 
        $this->TUser = $this->loadModel('TUser'); 
        $this->TTestpaper = $this->loadModel('TTestpaper'); 
        $this->loadComponent('Common');
        $this->loadComponent('Exam2');

        $this->D_BAJ1_RESULT = Configure::read("D_BAJ1_RESULT");




        $this->session = $this->request->session();
        $this->error = "";
        
        //テスト詳細データ取得
        $this->ttp= $this->Exam2->__getTestDataDetail();
        
    }
    
    /*******************
     * ガイダンスページ
     */
    public function guide($id){
        //セッションの削除
        $this->session->write('exam.token','');
        $this->__getTestData($id);
        
    }
    public function exam($id){

        $this->__getTestData($id);
    }

    //テスト情報取得
    public function __getTestData($id){

        //セッションの確認
        $token = $this->session->read('exam.token');

        if(
            strlen($token) > 0 && 
            $this->request->getParam('_csrfToken') && 
            $token != $this->request->getParam('_csrfToken')
            ){
                throw new NotFoundException(__('token error'));
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

        //ユーザーデータ取得
        $tuser = $this->TUser->find()->where([
            'id'=>$ttest[ 'customer_id' ]
        ])->first();

        $this->tuser=$tuser;

        //ロゴ画像取得
        $logo = $this->Common->__setLogo($tuser);
        
        //テストデータ取得
        $exam = $this->Exam2->__getTest();
        //今のページ
        $pager = 1;
        if($this->request->getData('start')){
            $edit = [];
            $edit[ 'exam_date' ] = date("Y-m-d");
            $edit[ 'start_time' ] = date("H:i:s");
            $edit[ 'exam_state' ] = 1;
            $tt = $this->TTestpaper->get($this->ttp['id']);
            $tt = $this->TTestpaper->patchEntity($tt, $edit);
            $this->TTestpaper->save($tt);
            
        }
        
        $finflag = false;
        if($this->request->getData('next')){
            $pager = $this->request->getData('pager');
            //エラーチェック
            if(!$this->__error($pager)){
                $pager = $this->request->getData('pager')-1;
                $this->Flash->error($this->error);
            }else{
                if($pager == 5){
                    //最終処理フラグ
                    $finflag = true;
                }
            }
            
            //データ登録
            $edit = [];
            if(!empty($this->request->getData('chk'))){
                foreach($this->request->getData('chk') as $key=>$value){
                    $q = "q".$key;
                    $edit[ $q ] = $value;
                }
            }

            $tt = $this->TTestpaper->get($this->ttp['id']);
            $tt = $this->TTestpaper->patchEntity($tt, $edit);
            $this->TTestpaper->save($tt);
            //最終処理
            if($finflag){
                $this->Exam2->setResult();
                //終了メールの配信
                //メール配信フラグの確認
                if($ttest[ 'send_mail' ] == 1){
                    $this->Common->examSendMails($ttest);
                }
                
                header("Location:/exams2/fin/".$id);
                exit();
                
            }
        }
        if($this->request->getData('back')){
            $pager = $this->request->getData('pager')-2;
            if($pager < 1){
                header("Location:/exams2/guide/".$id);
                exit();
            }
        }
        

        //データ取得
        $this->ttp=$this->Exam2->__getTestDataDetail();
        //受検済みの時
        if($this->ttp->exam_state==2){
            header("Location:/exams/menu/".$id);
            exit();
        }
        //tokenの保存
        $token = $this->request->getParam('_csrfToken');
        $this->session->write('exam.token',$token);
        $this->set("id",$id);
        $this->set("ttest", $ttest);
        $this->set("logo", $logo);
        $this->set("tuser", $tuser);
        $this->set("exam", $exam);
        $this->set("pager", $pager);
        $this->set("token", $token);
        $this->set("ttp", $this->ttp);
        

    }
    /**********
     * エラーチェック
     */
    public function __error($pager){
        $chk = $this->request->getData("chk");
        $error = "";
        if($pager == 2){
            
            for($i=1;$i<=10;$i++){
                if(!isset($chk[$i]) ){
                    $error .= $i."が選択されていません\n";
                }
            }
        }
        if($pager == 3){
            for($i=11;$i<=20;$i++){
                if(!isset($chk[$i]) ){
                    $error .= $i."が選択されていません\n";
                }
            }
        }
        if($pager == 4){
            for($i=21;$i<=30;$i++){
                if(!isset($chk[$i]) ){
                    $error .= $i."が選択されていません\n";
                }
            }
        }
        if($pager == 5){
            for($i=31;$i<=36;$i++){
                if(!isset($chk[$i]) ){
                    $error .= $i."が選択されていません\n";
                }
            }
        }
        $this->error =$error;
        if($error){
            return false;
        }
        return true;
    }
    /****************
     * 結果ページ
     */
    public function fin($id){

        //テスト情報の取得
        $ttest = $this->TTest ->find()->where([
            'dir'=>$id
        ])->first();

        //ユーザーデータ取得
        $tuser = $this->TUser->find()->where([
            'id'=>$ttest[ 'customer_id' ]
        ])->first();
        
        //ロゴ画像取得
        $logo = $this->Common->__setLogo($tuser);
        
        //テスト結果の取得
        $soyo = $this->ttp->soyo;
        $result['text0'] = $this->D_BAJ1_RESULT[$soyo][0];
        $result['text1'] = $this->D_BAJ1_RESULT[$soyo][1];
        $result['text2'] = $this->D_BAJ1_RESULT[$soyo][2];
        $result['text3'] = $this->D_BAJ1_RESULT[$soyo][3];
        $result['text4'] = $this->D_BAJ1_RESULT[$soyo][4];

        $this->set("id",$id);
        $this->set("ttest", $ttest);
        $this->set("logo", $logo);
        $this->set("tuser", $tuser);
        $this->set("result", $result);
        $this->set("ttp", $this->ttp);


    }



   
}
