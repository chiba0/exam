<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ModelAwareTrait;
use Cake\Mailer\Email;
/**
 * Common component
 */
class CommonComponent extends Component
{
    use ModelAwareTrait;
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->TTest = $this->loadModel('TTest'); 
        $this->TUser = $this->loadModel('TUser'); 
        $this->TTestpaper = $this->loadModel('TTestpaper'); 

        $this->controller = $this->_registry->getController();
        
        $this->session = $this->controller->getRequest()->getSession();
    }

    public function __test(){
        echo "test";
    }


    /***************
     * ロゴ画像表示
     */
    public function __setLogo($tuser){
        
        //ログインID
        $login_id = $tuser[ 'login_id' ];
        $this->logopng = D_HOME_URL."logo/".$login_id.".png";
        $this->logojpg = D_HOME_URL."logo/".$login_id.".jpg";
        $this->logogif = D_HOME_URL."logo/".$login_id.".gif";
        if( strlen(file_get_contents($this->logopng)) > 0){
            return $this->logopng;
        }
        if( strlen(file_get_contents($this->logojpg)) > 0 ){
            return $this->logojpg;
        }
        if( strlen(file_get_contents($this->logogif)) > 0 ){
            return $this->logogif;
        }
        return "";

    }

    /**************
     * テスト結果データ登録
     */
    public function __editTTestPaper($tdetail){
        $s_day  = explode( '-', $tdetail['exam_date'] ); 
        $s_time = explode( ':', $tdetail['start_time'] ); 
        $y = $s_day[0];
        $m = $s_day[1];
        $d = $s_day[2];
        //テストの実施時間の取得
        $exam_time = time()-strtotime($tdetail['exam_date'].$tdetail['start_time']);
        
        $edit = [];
        $edit[ 'exam_time' ] = $exam_time;
        $edit[ 'exam_state' ] = 2;
        $edit[ 'fin_exam_date' ] = date('Y-m-d H:i:s');
        $tt = $this->TTestpaper->get($tdetail['id']);
        $tt = $this->TTestpaper->patchEntity($tt, $edit);
        $this->TTestpaper->save($tt);

        //complete_flgの確認
        $complete_flg = $this->__checkCompleteFlg();


        $edit = [];
        $edit[ 'complete_flg' ] = $complete_flg;
        $tt = $this->TTestpaper->get($tdetail['id']);
        $tt = $this->TTestpaper->patchEntity($tt, $edit);
        $this->TTestpaper->save($tt);

    }
    public function __checkCompleteFlg(){
        $test_id = $this->session->read('Exam.testgrp_id');
        $examid = $this->session->read('Exam.examid');
        $where = [];
        $where['testgrp_id'] = $test_id;
        $where['exam_id'] = $examid;
        $where['OR'][]['exam_state'] = 1;
        $where['OR'][]['exam_state'] = 0;

        $ttest = $this->TTestpaper->find()
            ->where($where)
            ->count();
        if($ttest >= 1){
            return 0;
        }else{
            return 1;
        }
    }

    /***************
     * 受検済みメール配信
     */
    public function examSendMails($test){

        $test_id = $this->session->read('Exam.testgrp_id');
        $this->examid = $this->session->read('Exam.examid');
        $where = [];
        $where[ 'testgrp_id' ] = $test_id;
        $where[ 'exam_id' ] = $this->examid;

        //テスト詳細データ
        $query = $this->TTestpaper->find()
            ->where($where);
        $data = $query->first();

        //受検残数
        $this->zan = $this->___getTestZan();
        //ユーザーデータ取得
        $user = $this->TUser->find()->where([
            'id'=>$test[ 'customer_id' ]
        ])->first();
        //パートナー名取得
        $this->partner = $this->TUser->find()
            ->select([
                'name',
                'rep_name',
                'rep_name2',
                'rep_email',
                'rep_email2'
                ])
            ->where([
                'id'=>$test[ 'partner_id' ]
            ])->first();


        //お知らせメール
        if($test[ 'send_mail'] == 1){
            $this->__sendMailInfo($test,$user,1);
            $this->__sendMailInfo($test,$user,1);
        }
        //メール配信受検者残数
        if($test[ 'rest_mail_count' ] > $this->zan){
            
            //メール配信
            //担当者1
            $this->__sendMailZan($test,$user,1);
            //担当者2
            $this->__sendMailZan($test,$user,2);

        }

    }

    /*********************
     * メール配信
     */
    public function __sendMailInfo($test,$user,$type){
        $rep_email = "";
        $testname = $test[ 'name' ];
        
        if($type == 1){$rep_email = $user[ 'rep_email' ];}
        if($type == 2){$rep_email = $user[ 'rep_email2' ];}
        $this->log($testname." お知らせメール配信[".$rep_email."]", "debug");
        $to = $rep_email;
        
        $rep_name = "";
        $rep_name2 = "";
        $rep_email = "";
        $rep_email2 = "";
        
        if($this->partner['rep_name']) $rep_name = $this->partner['rep_name'];
        if($this->partner['rep_name2']) $rep_name2 = $this->partner['rep_name2'];
        if($this->partner['rep_email']) $rep_email = $this->partner['rep_email'];
        if($this->partner['rep_email2']) $rep_email2 = $this->partner['rep_email2'];

        $email = new Email("default");
        $email->transport('default')
		->from(D_MAIL_FROM)
        ->template('examMail')
        
		->viewVars(
            [
                'cname'=>$user['name'],
                'rep_name'=>$user['rep_name'],
                'testname'=>$testname,
                'exam_id'=>$this->examid,
                'partnername'=>$this->partner['name'],
                'rep_name'=>$rep_name,
                'rep_name2'=>$rep_name2,
                'rep_email'=>$rep_email,
                'rep_email2'=>$rep_email2
            ])
            
		->to($to)
		->subject("【".$this->partner['name']."】受検完了メール")
        ->send();

    }
    /*********************
     * 残数メール配信
     */
    public function __sendMailZan($test,$user,$type){
        $partner_email = "";
        $rep_name = "";
        if($type == 1){$partner_email = $this->partner[ 'rep_email' ];}
        if($type == 2){$partner_email = $this->partner[ 'rep_email2' ];}

        $to = $partner_email;
        $this->log("残数メール配信[".$partner_email."]", "debug");
        $partnername = $this->partner['name'];
        $zan = $this->zan;
        $customername = $user['name'];
        $testname = $test['name'];
        $term = $test['period_from']."～".$test[ 'period_to' ];

        $email = new Email("default");
        $email->transport('default')
		->from(D_MAIL_FROM)
        ->template('examZanMail')
        
		->viewVars(
            [
                'partnername'=>$partnername,
                'rep_name'=>$rep_name,
                'zan'=>$zan,
                'customername'=>$customername,
                'testname'=>$testname,
                'term'=>$term,
            ])
            
		->to($to)
		->subject("検査数のお知らせ")
        ->send();




    }
    /********
     * 残数
     */
    public function ___getTestZan(){
        $where = [];
        $test_id = $this->session->read('Exam.testgrp_id');
        $where[ 'testgrp_id' ] = $test_id;
        $where[ 'exam_state < ' ] = 2;
        $query = $this->TTestpaper->find()
            ->where($where)
            ->group('number')
            ;
        $row = $query->count();
        return $row;
    }


}