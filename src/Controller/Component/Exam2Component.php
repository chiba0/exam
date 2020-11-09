<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ModelAwareTrait;

/**
 * Common component
 */




class Exam2Component extends Component
{
    use ModelAwareTrait;
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public $raw_data = array(
        1  => array( '-:q4',  '+:q12', '-:q13', '+:q22', '-:q26', '+:q31', 'モニタリング' ),
        2  => array( '-:q1',  '+:q10', '-:q14', '+:q19', '-:q28', '+:q34', '適切な自己評価' ),
        3  => array( '-:q2',  '+:q7' , '-:q16', '+:q24', '-:q25', '+:q36', '肯定的自己像' ),
        4  => array( '-:q7',  '+:q11', '-:q15', '+:q20', '+:q28', '-:q29', '克己抑制' ),
        5  => array( '-:q3',  '+:q8' , '+:q16', '-:q17', '-:q31', '+:q32', '達成動機' ),
        6  => array( '+:q4',  '-:q5' , '-:q19', '+:q23', '-:q27', '+:q35', '楽観性' ),
        7  => array( '+:q9',  '-:q10', '+:q17', '-:q18', '+:q26', '-:q32', '共感性' ),
        8  => array( '+:q5',  '-:q6' , '+:q14', '-:q20', '+:q29', '-:q34', 'センシブル' ),
        9  => array( '+:q2',  '-:q8' , '+:q21', '-:q22', '-:q30', '+:q33', 'サービス精神' ),
        10 => array( '+:q6',  '-:q12', '+:q15', '-:q21', '+:q25', '-:q35', 'リーダーシップ' ),
        11 => array( '+:q3',  '-:q9' , '+:q13', '-:q23', '+:q27', '-:q36', 'アサーション' ),
        12 => array( '+:q1',  '-:q11', '+:q18', '-:q24', '+:q30', '-:q33', 'チームワーク' )
      );
    
    
    public $dev_data = array(
        1 => array( -1.89506172839506, 3.65646807995191, 'モニタリング' ),
        2 => array( 0.916666666666667, 3.32676080614467, '適切な自己評価' ),
        3 => array( -1.18518518518519, 3.37028027464883, '肯定的自己像' ),
        4 => array( 0.0709876543209877, 3.50469268954417, '克己抑制' ),
        5 => array( 2.77469135802469, 3.54036977880829, '達成動機' ),
        6 => array( 2.31172839506173, 2.99406814588868, '楽観性' ),
        7 => array( -0.91358024691358, 2.9503529971483, '共感性' ),
        8 => array( -1.14197530864198, 3.61004323868108, 'センシブル' ),
        9 => array( 1.17901234567901, 4.06206389760258, 'サービス精神' ),
        10 => array( -0.993827160493827, 2.946366631831, 'リーダーシップ' ),
        11 => array( -2.3179012345679, 2.6686206434827, 'アサーション' ),
        12 => array( 1.19444444444444, 3.32489903010174, 'チームワーク' ),
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
                    "a"=>"友人からのアドバイス・指摘は反省の材料として大切にする",
                    "b"=>"友達がたくさんいる。友人関係は良好である ",
                ),
            "2"=>array(
                    "a"=>"私は自分の生き方に誇りを持っている",
                    "b"=>"人が喜んでくれるなら苦労も苦にならない",
                ),
            "3"=>array(
                    "a"=>"運は自らの力で切り開けるし、切り開いていく",
                    "b"=>"不当な扱いには笑顔で堂々と反論できる",
                ),
            "4"=>array(
                    "a"=>"自分の気持ちを自問し、自分の感情と実際の行動との関係を解釈している",
                    "b"=>"転勤・転校などの新天地でも上手くやっていける自信がある",
                ),
            "5"=>array(
                    "a"=>"転勤・転校などの新天地でも上手くやっていける自信がある",
                    "b"=>"人間関係の中心にいる重要な人物が誰かに気づいて、その人物に近づける",
                ),
            "6"=>array(
                    "a"=>"人間関係の中心にいる重要な人物が誰かに気づいて、その人物に近づける",
                    "b"=>"仲間に的確なアドバイスを与えることができる",
                ),
            "7"=>array(
                    "a"=>"緊張場面でも冷静さを保ち落ち着いていられる",
                    "b"=>"私は自分の生き方に誇りを持っている",
                ),
            "8"=>array(
                    "a"=>"人が喜んでくれるなら苦労も苦にならない",
                    "b"=>"運は自らの力で切り開けるし、切り開いていく",
                ),
            "9"=>array(
                    "a"=>"不当な扱いには笑顔で堂々と反論できる",
                    "b"=>"他人の立場にたって共感することができる",
                ),
            "10"=>array(
                    "a"=>"他人の立場にたって共感することができる",
                    "b"=>"友人からのアドバイス・指摘は反省の材料として大切にする",
                ),
            );
        $array_exam[2] = array(
    
            "11"=>array(
                    "a"=>"友達がたくさんいる。友人関係は良好である",
                    "b"=>"緊張場面でも冷静さを保ち落ち着いていられる",
                ),
            "12"=>array(
                    "a"=>"仲間に的確なアドバイスを与えることができる",
                    "b"=>"自分の気持ちを自問し、自分の感情と実際の行動との関係を解釈している",
                ),
            "13"=>array(
                    "a"=>"自分が今どんな感情でいるかをチェックし、自分を理解しようとしている",
                    "b"=>"相手と自分の双方の利益になる結論を見つけるようにしている",
                ),
            "14"=>array(
                    "a"=>"間違いは素直に認め、躊躇（ちゅうちょ）なく訂正することができる",
                    "b"=>"私は人のちょっとした気分の変化が敏感にわかる",
                ),
            "15"=>array(
                    "a"=>"上手くいかなくても粘り強くがんばり続ける",
                    "b"=>"自分は仲間の中でまとめ役である",
                ),
            "16"=>array(
                    "a"=>"私には人を引き付ける人間的魅力が備わってる",
                    "b"=>"チャンスは待つのではなく、自分で作り出す",
                ),
            "17"=>array(
                    "a"=>"チャンスは待つのではなく、自分で作り出す",
                    "b"=>"悲しんでいる相手の話を聞くと、同様の悲しさを感じてしまう",
                ),
            "18"=>array(
                    "a"=>"悲しんでいる相手の話を聞くと、同様の悲しさを感じてしまう",
                    "b"=>"仲間はずれや一人ぼっちがいないか気を配るほうだ",
                ),
            "19"=>array(
                    "a"=>"変化する状況にあわせてやり方を調整するのが得意である",
                    "b"=>"間違いは素直に認め、躊躇（ちゅうちょ）なく訂正することができる",
                ),
            "20"=>array(
                    "a"=>"私は人のちょっとした気分の変化が敏感にわかる",
                    "b"=>"上手くいかなくても粘り強くがんばり続ける",
                ),
            );
        $array_exam[3] = array(
    
            "21"=>array(
                    "a"=>"自分は仲間の中でまとめ役である",
                    "b"=>"もらった人の嬉しそうな顔を想像して、あれこれプレゼントを選ぶのが好き",
                ),
            "22"=>array(
                    "a"=>"もらった人の嬉しそうな顔を想像して、あれこれプレゼントを選ぶのが好き",
                    "b"=>"自分が今どんな感情でいるかをチェックし、自分を理解しようとしている",
                ),
            "23"=>array(
                    "a"=>"相手と自分の双方の利益になる結論を見つけるようにしている",
                    "b"=>"変化する状況にあわせてやり方を調整するのが得意である",
                ),
            "24"=>array(
                    "a"=>"仲間はずれや一人ぼっちがいないか気を配るほうだ",
                    "b"=>"私には人を引き付ける人間的魅力が備わってる",
                ),
            "25"=>array(
                    "a"=>"自分の才能に自信を持っている",
                    "b"=>"対立している仲間の仲裁が得意である",
                ),
            "26"=>array(
                    "a"=>"心の中の本当の気持ちと言動が食い違っていないか確かめるようにしている",
                    "b"=>"仲間の関心事には積極的に興味を示す",
                ),
            "27"=>array(
                    "a"=>"1つのやり方に固執せずに、常に良いものを求め工夫する",
                    "b"=>"自分に対する失礼な言動にはとっさに効果的な反論ができる",
                ),
            "28"=>array(
                    "a"=>"自分ができることと、できない事を自覚している",
                    "b"=>"失敗しても、あきらめず、やつ当たりしない",
                ),
            "29"=>array(
                    "a"=>"失敗しても、あきらめず、やつ当たりしない",
                    "b"=>"重要な人間関係や友人関係を正確に読み取り、利用できる",
                ),
            "30"=>array(
                    "a"=>"人を喜ばせる事柄・イベント・方法などを考えるのが好き",
                    "b"=>"寂しそうにしている仲間には優しい言葉をかける",
                ),
            );
        $array_exam[4] = array(
    
            "31"=>array(
                    "a"=>"努力すれば能力や技能はどんどん向上させられる",
                    "b"=>"心の中の本当の気持ちと言動が食い違っていないか確かめるようにしている",
                ),
            "32"=>array(
                    "a"=>"仲間の関心事には積極的に興味を示す",
                    "b"=>"努力すれば能力や技能はどんどん向上させられる",
                ),
            "33"=>array(
                    "a"=>"寂しそうにしている仲間には優しい言葉をかける",
                    "b"=>"人を喜ばせる事柄・イベント・方法などを考えるのが好き",
                ),
            "34"=>array(
                    "a"=>"重要な人間関係や友人関係を正確に読み取り、利用できる",
                    "b"=>"自分ができることと、できない事を自覚している",
                ),
            "35"=>array(
                    "a"=>"対立している仲間の仲裁が得意である",
                    "b"=>"1つのやり方に固執せずに、常に良いものを求め工夫する",
                ),
            "36"=>array(
                    "a"=>"自分に対する失礼な言動にはとっさに効果的な反論ができる",
                    "b"=>"自分の才能に自信を持っている",
                ),
            );
    

        return $array_exam;
    }

    public function setResult(){
        $tdetail = $this->__getTestDataDetail();
        //重みの取得
        $weights = $this->__getWeight();
        
        list($row,$lv,$standard_score,$dev_number) = $this->__BA2($tdetail,$weights,$this->raw_data,$this->dev_data,1);
        
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
        $where['type'] = "2";
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
    function __BA2($line,$row2,$raw_data,$dev_data,$testFlg=""){
		// 素点算出
		// 準備 [q1～q36の値を-3する]
		if($testFlg){
			// 準備 [q1～q36の値を-3する]
			$k = 0;
			for ( $num = 1; $num <= 36; $num++ ) {
				$row[$k] = $line["q$num"];
				$row["q$num"] = $line["q$num"] - 3;
				$k++;
			}
		}else{
			for ( $num = 1; $num <= 36; $num++ ) {
				$q = 12+$num;
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
					if     ( $pm_data[0] == '+' ) { $dev[$rawkey] = $dev[$rawkey] + $row["$pm_data[1]"]; }
					elseif ( $pm_data[0] == '-' ) { $dev[$rawkey] = $dev[$rawkey] - $row["$pm_data[1]"]; }
				}
			}	
			$dev_count++;
		}

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
					$row["dev$dkey"] = ( ( $dev[$dkey] - $dev_data[$dkey][0] ) / $dev_data[$dkey][1] ) * 10 + 50;
					if ( $row["dev$dkey"] >= 80 ) { $row["dev$dkey"] = 80; }
					if ( $row["dev$dkey"] <= 20 ) { $row["dev$dkey"] = 20; }

					// 比較用データを作成
					$result_dev[$dkey] = $row["dev$dkey"];

				}
			}	
			$dev_count++;
		}

		//データ調整
		foreach($row as $key=>$val){
			if($key == "dev1"){
				//自己感情ﾓﾆﾀﾘﾝｸﾞ力
				$row[ $key ] = 100-$val+3.5;
				$result_dev[ 1 ] = 100-$val+3.5;
			
			}elseif($key == "dev2"){
				$row[ $key ] = 100-$val+0.7;
				$result_dev[ 2 ] = 100-$val+0.7;
			}else{
				$row[ $key ] = $val;
			}
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