<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ModelAwareTrait;

/**
 * Common component
 */




class Exam12Component extends Component
{
    use ModelAwareTrait;
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public $raw_data = array(
        1  => array( '-:q4',  '+:q10', '-:q14', '+:q24', '-:q25', '+:q31', 'モニタリング' ),
        2  => array( '-:q2',  '+:q12', '-:q13', '+:q19', '-:q28', '+:q36', '適切な自己評価' ),
        3  => array( '-:q1',  '+:q7' , '-:q16', '+:q22', '-:q26', '+:q34', '肯定的自己像' ),
        4  => array( '-:q7',  '+:q8' , '-:q17', '+:q23', '-:q27', '+:q28', '克己抑制' ),
        5  => array( '-:q5',  '+:q11', '-:q15', '+:q16', '-:q31', '+:q35', '達成動機' ),
        6  => array( '-:q3',  '+:q4' , '-:q19', '+:q20', '-:q29', '+:q32', '楽観性' ),
        7  => array( '+:q5',  '-:q10', '-:q20', '+:q21', '+:q26', '-:q30', '共感性' ),
        8  => array( '-:q8',  '+:q9' , '+:q14', '-:q18', '+:q33', '-:q34', 'センシブル' ),
        9  => array( '+:q2',  '-:q6' , '+:q17', '-:q22', '+:q29', '-:q32', 'サービス精神' ),
        10 => array( '+:q3',  '-:q12', '+:q18', '-:q23', '+:q25', '-:q33', 'リーダーシップ' ),
        11 => array( '+:q6',  '-:q11', '+:q13', '-:q21', '+:q30', '-:q36', 'アサーション' ),
        12 => array( '+:q1',  '-:q9' , '+:q15', '-:q24', '+:q27', '-:q35', 'チームワーク' )
      );
    
    
    public $dev_data = array(
        1 => array( -2.22094564737075, 3.83810209584864, 'モニタリング' ),
        2 => array( -0.607158638974812, 3.40571923193921, '適切な自己評価' ),
        3 => array( -3.52261010458094, 3.5371486665457, '肯定的自己像' ),
        4 => array( -1.63816467815584, 3.45374535910044, '克己抑制' ),
        5 => array( 0.0233465900721756, 3.4974037775748, '達成動機' ),
        6 => array( 1.22433348063043, 3.52077641367019, '楽観性' ),
        7 => array( 2.23619089703933, 3.94365874100903, '共感性' ),
        8 => array( 1.54116953896008, 3.39747930063903, 'センシブル' ),
        9 => array( 1.18846663720725, 3.48025199197222, 'サービス精神' ),
        10 => array( -0.486669612608632, 4.32246024919477, 'リーダーシップ' ),
        11 => array( -0.524230372661659, 3.30271067209346, 'アサーション' ),
        12 => array( 2.78627191044336, 3.49133504881389, 'チームワーク' ),
      );

    public $components = ['Common'];
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->TTest = $this->loadModel('TTest'); 
        $this->TUser = $this->loadModel('TUser'); 
        $this->TTestpaper = $this->loadModel('TTestpaper'); 

        $this->controller = $this->_registry->getController();
        
        $this->session = $this->controller->getRequest()->getSession();
        
    }


    public function __getTest(){
        
        $array_exam = [];

        
        $array_exam[1] = array(
			"1"=>array(
					"a"=>"自分には人並み以上の知力がある",
					"b"=>"仲間とはいっしょに楽しい時間を過ごす",
				),
			"2"=>array(
					"a"=>"自分が、なぜ、こんな気持ちになったのかを考えることが多い",
					"b"=>"やり直しを要求されても、その指摘が正しければ、進んでやり直す",
				),
			"3"=>array(
					"a"=>"窮地に立たされても、何とかなると思う",
					"b"=>"私の意見は仲間に反映されることが多い",
				),
			"4"=>array(
					"a"=>"「怒っているな」とか「不快だな」としばしば感情を自覚するようにしている",
					"b"=>"窮地に立たされても、何とかなると思う",
				),
			"5"=>array(
					"a"=>"将来、大きな仕事をしようと心に決めている",
					"b"=>"人の話をじっくり聞くことが得意である",
				),
			"6"=>array(
					"a"=>"やり直しを要求されても、その指摘が正しければ、進んでやり直す",
					"b"=>"雰囲気を壊さずに自分の意見を明快に主張できる",
				),
			"7"=>array(
					"a"=>"怒りや不快を顔にださず速やかに静められる",
					"b"=>"自分には人並み以上の知力がある",
				),
			"8"=>array(
					"a"=>"微妙な表情や会話の間から相手の気持ちの変化を感じる",
					"b"=>"怒りや不快を顔にださず速やかに静められる",
				),
			"9"=>array(
					"a"=>"仲間とはいっしょに楽しい時間を過ごす",
					"b"=>"微妙な表情や会話の間から相手の気持ちの変化を感じる",
				),
			"10"=>array(
					"a"=>"人の話をじっくり聞くことが得意である",
					"b"=>"「怒っているな」とか「不快だな」としばしば感情を自覚するようにしている",
				),
			);
        $array_exam[2] = array(
                "11"=>array(
                        "a"=>"雰囲気を壊さずに自分の意見を明快に主張できる",
                        "b"=>"将来、大きな仕事をしようと心に決めている",
                    ),
                "12"=>array(
                        "a"=>"私の意見は仲間に反映されることが多い",
                        "b"=>"自分が、なぜ、こんな気持ちになったのかを考えることが多い",
                    ),
                "13"=>array(
                        "a"=>"自分の得意分野で勝負するように心がけている",
                        "b"=>"顔をつぶさずに反対者を説き伏せる自信がある",
                    ),
                "14"=>array(
                        "a"=>"あせり・恐怖・喜び・悲しみなど、いつも自分の今の感情に名前をつけられる",
                        "b"=>"すこし話をすると相手の好みや性格が把握できる",
                    ),
                "15"=>array(
                        "a"=>"自らのスキルを磨き、常に自分を向上させる",
                        "b"=>"仲間を出し抜いて自分の手柄にしようとは思わない",
                    ),
                "16"=>array(
                        "a"=>"自分は成功するだけの能力がある",
                        "b"=>"自らのスキルを磨き、常に自分を向上させる",
                    ),
                "17"=>array(
                        "a"=>"あせりや恐怖に打ち勝って冷静に行動できる",
                        "b"=>"ハイキングや飲み会などの集まりを企画して仲間を喜ばせることが好き",
                    ),
                "18"=>array(
                        "a"=>"すこし話をすると相手の好みや性格が把握できる",
                        "b"=>"人を引っ張っていく力がある",
                    ),
                "19"=>array(
                        "a"=>"失敗の恐れより、成功の喜びを期待して信じるほうだ",
                        "b"=>"自分の得意分野で勝負するように心がけている",
                    ),
                "20"=>array(
                        "a"=>"人から悩みを相談されることが多い",
                        "b"=>"失敗の恐れより、成功の喜びを期待して信じるほうだ",
                    ),
                );
        $array_exam[3] = array(
                "21"=>array(
                        "a"=>"顔をつぶさずに反対者を説き伏せる自信がある",
                        "b"=>"人から悩みを相談されることが多い",
                    ),
                "22"=>array(
                        "a"=>"ハイキングや飲み会などの集まりを企画して仲間を喜ばせることが好き",
                        "b"=>"自分は成功するだけの能力がある",
                    ),
                "23"=>array(
                        "a"=>"人を引っ張っていく力がある",
                        "b"=>"あせりや恐怖に打ち勝って冷静に行動できる",
                    ),
                "24"=>array(
                        "a"=>"仲間を出し抜いて自分の手柄にしようとは思わない",
                        "b"=>"あせり・恐怖・喜び・悲しみなど、いつも自分の今の感情に名前をつけられる",
                    ),
                "25"=>array(
                        "a"=>"自分は本当はどうしたいのだろう、どんな気持ちなのだろうと、いつも考える",
                        "b"=>"集団の中ではリーダーシップを発揮する",
                    ),
                "26"=>array(
                        "a"=>"私は自分が好きであり、肯定的に受け止めている",
                        "b"=>"涙もろく、もらい泣きをするほうである",
                    ),
                "27"=>array(
                        "a"=>"かっとなったり、我を忘れて怒ったりしない",
                        "b"=>"チームワークを大切にしている",
                    ),
                "28"=>array(
                        "a"=>"自分の弱点を知り、その点で強がらないようにしている",
                        "b"=>"かっとなったり、我を忘れて怒ったりしない",
                    ),
                "29"=>array(
                        "a"=>"臨機応変に優先順位を変えながら楽しく課題をかたづける",
                        "b"=>"気難しい客のいる店の接客の仕事（アルバイト）も辛くない",
                    ),
                "30"=>array(
                        "a"=>"涙もろく、もらい泣きをするほうである。",
                        "b"=>"理解できない説明には、ためらわず率直に質問する",
                    ),
                );
        $array_exam[4] = array(

                "31"=>array(
                        "a"=>"私が頑張れば、必ず、状況を好転させられる",
                        "b"=>"自分は本当はどうしたいのだろう、どんな気持ちなのだろうと、いつも考える",
                    ),
                "32"=>array(
                        "a"=>"気難しい客のいる店の接客の仕事（アルバイト）も辛くない",
                        "b"=>"臨機応変に優先順位を変えながら楽しく課題をかたづける",
                    ),
                "33"=>array(
                        "a"=>"集団の中ではリーダーシップを発揮する",
                        "b"=>"本音と建前の違いを、私は素早く見抜いてしまう",
                    ),
                "34"=>array(
                        "a"=>"本音と建前の違いを、私は素早く見抜いてしまう",
                        "b"=>"私は自分が好きであり、肯定的に受け止めている",
                    ),
                "35"=>array(
                        "a"=>"チームワークを大切にしている",
                        "b"=>"私が頑張れば、必ず、状況を好転させられる",
                    ),
                "36"=>array(
                        "a"=>"理解できない説明には、ためらわず率直に質問する",
                        "b"=>"自分の弱点を知り、その点で強がらないようにしている",
                    ),
                );
   
    

        return $array_exam;
    }

    public function setResult(){
        $tdetail = $this->__getTestDataDetail();
        //重みの取得
        $weights = $this->__getWeight();
        
        list($row,$lv,$standard_score,$dev_number) = $this->__BA12($tdetail,$weights,$this->raw_data,$this->dev_data);
        
        //計算データ登録
        
        $edit = [];
        $edit[ 'exam_state' ] = 2;
		$edit[ 'level'      ] = $lv;
        $edit[ 'score'      ] = $standard_score;
        for($i=1;$i<=12;$i++){
			$dev = "dev".$i;
			$edit[$dev] = $row[ $dev ];
        }

        $edit[ 'soyo'       ] = $dev_number;
        $tt = $this->TTestpaper->get($tdetail['id']);
        $tt = $this->TTestpaper->patchEntity($tt, $edit);
        $this->TTestpaper->save($tt);

        //最終の登録情報保存
        $this->Common->__editTTestPaper($tdetail);
        
        return true;
    }

    /*****************
     * 重み取得
     */
    public function __getWeight(){
        $test_id = $this->session->read('Exam.testgrp_id');
        $where = [];
        $where['type'] = "12";
        $where['test_id'] = $test_id;
        $wt = $this->TTest->find()
            ->where($where)
            ->first();
        return $wt;
    }
    /************
     * テスト詳細データ取得
     */
    public function __getTestDataDetail(){
        $testgrp_id = $this->session->read('Exam.testgrp_id');
        $examid = $this->session->read('Exam.examid');
        $where = [];
        $where['testgrp_id'] = $testgrp_id;
        $where['exam_id'] = $examid;
        $ttp = $this->TTestpaper->find()
                            ->where($where)
                            ->first();
        return $ttp;
    }


    /********************
     * 計算
     */
    function __BA12($line,$row2,$raw_data,$dev_data,$flg=""){
    
        	// 素点算出
            // 準備 [q1～q36の値を-3する]
            $q = "";
            if($flg){
                $k = 13;
                for ( $num = 1; $num <= 36; $num++ ) {
                    $q = $k;
                    $row["q$num"] = $line[$q] - 3;
                    $k++;
                }
            }else{
                for ( $num = 1; $num <= 36; $num++ ) {
                    $q = "q".$num;
                    $row["q$num"] = $line[$q] - 3;
                }
            }
            // 素点計算
            $dev = array();
            $dev_count = 1;
            // 素点データ読み込み
            foreach ($raw_data as $rawkey => $rawval) {
                $pm_data = array();
                // キーNoの比較

                if ( $rawkey == $dev_count ) {
                    $dev[$rawkey] = 0;
                    for ( $num = 0; $num <= 5; $num++ ) {
                        // 各要素の値を分解（+,-と比較問題に分ける）
                        $pm_data = explode( ':',$raw_data[$rawkey][$num] );
                        if( $pm_data[0] == '+' ) {
                            $dev[$rawkey] = $dev[$rawkey] + $row["$pm_data[1]"];
                        }elseif ( $pm_data[0] == '-' ) {
                            $dev[$rawkey] = $dev[$rawkey] - $row["$pm_data[1]"];
                        }
                    }
                }	
                $dev_count++;
            }

        //読み込み
            // ステップ②
            // 偏差値算出
            $dev_count = 1;

            // 比較用dev
            $result_dev = array();
            // 偏差値データの読み込み
            foreach ($dev_data as $dkey => $dval) {
                // キーNoの比較
                if ( $dkey == $dev_count ) {
                    $row["dev$dkey"] = 0;
                    for ( $num = 0; $num <= 1; $num++ ) {
                        // それぞれの値を計算
                        //自己感情モニタリング力
                        $devskey = "dev".$dkey;
                        if($devskey == 'dev1' ){
                            $row["dev$dkey"] = 100- ( ( ( $dev[$dkey] - $dev_data[$dkey][0] ) / $dev_data[$dkey][1] ) * 10 + 50  )+3.5;
                        }elseif($devskey == 'dev2' ){
                            $row["dev$dkey"] = 100- ( ( ( $dev[$dkey] - $dev_data[$dkey][0] ) / $dev_data[$dkey][1] ) * 10 + 50  )+0.7;
                        }else{
                            $row["dev$dkey"] = ( ( $dev[$dkey] - $dev_data[$dkey][0] ) / $dev_data[$dkey][1] ) * 10 + 50;
                        }

                        if ( $row["dev$dkey"] >= 80 ) { $row["dev$dkey"] = 80; }
                        if ( $row["dev$dkey"] <= 20 ) { $row["dev$dkey"] = 20; }

                        // 比較用データを作成
                        $result_dev[$dkey] = $row["dev$dkey"];

                    }
                }	
                $dev_count++;
            }

            
            // 総合得点素点算出(おもみ付け)
            $all_score = ($row['dev1'] * $row2['w1']) + ($row['dev2'] * $row2['w2']) + ($row['dev3'] * $row2['w3']) + ($row['dev4'] * $row2['w4']) + ($row['dev5'] * $row2['w5']) + ($row['dev6'] * $row2['w6']) + ($row['dev7'] * $row2['w7']) + ($row['dev8'] * $row2['w8']) + ($row['dev9'] * $row2['w9']) + ($row['dev10'] * $row2['w10']) + ($row['dev11'] * $row2['w11']) + ($row['dev12'] * $row2['w12']);


            // 総合得点の偏差値算出

            if ($row2['sd'] > 0 ) {
                $standard_score = (( $all_score - $row2['ave'] ) / $row2['sd']) * 10 + 50;
            } else {
                $standard_score = 0;
            }
            if ( $standard_score >= 80 ) { $standard_score = 80; }
            if ( $standard_score <= 20 ) { $standard_score = 20; }
            
            $lv = '';

            if ( $standard_score <= 80 && $standard_score >= 65 ) { $lv = 5; }
            elseif ( $standard_score < 65 && $standard_score >= 55 ) { $lv = 4; }
            elseif ( $standard_score < 55 && $standard_score >= 45 ) { $lv = 3; }
            elseif ( $standard_score < 45 && $standard_score >= 35 ) { $lv = 2; }
            elseif ( $standard_score < 35 && $standard_score >= 20 ) { $lv = 1; }
            else { ; }
            
            $max_dev = max($result_dev);
            
            $dev_number = 0;
            for( $dcount = 1; $dcount <= 12; $dcount++ ) {
                if ( $row["dev$dcount"] == $max_dev && $dev_number == '' ) {
                    $dev_number = $dcount;
                }
            }



            return array($row,$lv,$standard_score,$dev_number);

	
    }

}