<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * TTestpaper Model
 *
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\TestsTable&\Cake\ORM\Association\BelongsTo $Tests
 * @property \App\Model\Table\TestgrpsTable&\Cake\ORM\Association\BelongsTo $Testgrps
 * @property \App\Model\Table\ExamsTable&\Cake\ORM\Association\BelongsTo $Exams
 *
 * @method \App\Model\Entity\TTestpaper get($primaryKey, $options = [])
 * @method \App\Model\Entity\TTestpaper newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TTestpaper[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TTestpaper|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TTestpaper saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TTestpaper patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TTestpaper[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TTestpaper findOrCreate($search, callable $callback = null, $options = [])
 */
class TTestpaperTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('t_testpaper');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->connection = ConnectionManager::get('default');

    }

    /***********************
     * メニュー情報の取得
     */
    public function __getMenu($data){
        $test_id = $data[ 'test_id' ];
        $testgrp_id = $data[ 'testgrp_id' ];
        $exam_id = $data[ 'exam_id' ];

        $sql = "
                SELECT 
                    em.name,
                    em.jp,
                    tt.type,
                    tt.exam_state,
                    tt.complete_flg,
                    tt.exam_date,
                    tt.exam_id

                FROM 
                    t_testpaper as tt 
                    LEFT JOIN exam_master as em ON tt.type = em.key
                WHERE 
                    tt.test_id = ${test_id} AND 
                    tt.testgrp_id = ${testgrp_id} AND 
                    tt.exam_id = '${exam_id}' 
                             
                ";
        $list = $this->connection->execute($sql)->fetchAll('assoc');
        
        return $list;
    }
    /********************
     * テスト詳細存在確認
     * 生年月日が登録されているときはチェックを行い
     * されていないときは後程、個人情報登録時に登録を行う
     */
    public function ___checkTestpaper($t,$ttest){
        if(
            !($t->request->getData('userid')) ||
            !$t->request->getData('birth_y') ||
            !$t->request->getData('birth_m') ||
            !$t->request->getData('birth_d')  
            
        ){

            return false;
        }
        $loginid = $t->request->getData("userid");
        $where = [];
        $where['exam_id'] = $loginid;
        $where[ 'testgrp_id' ] = $ttest[ 'id' ];
        $birth = sprintf("%04d/%02d/%02d"
            ,$t->request->getData('birth_y')
            ,$t->request->getData('birth_m')
            ,$t->request->getData('birth_d')
        );
        $table = TableRegistry::get($this->_registryAlias);
        $query = $table->find()->where($where)->toArray();
        //誕生日が登録されているときは誕生日のチェックを併せて行う
        if($query[0]['birth']){
            if($query[0]['birth'] == $birth){
                $this->ttestpaper = $query;
                return true;
            }
        }else{
            $this->ttestpaper = $query;
            return true;
        }

        return false;
    }
    
    public function validationExam(Validator $validator){

        $validator 
                ->requirePresence('name1') 
                ->notEmpty('name1', '名前が入力されていません。(姓)') ;
        $validator 
                ->requirePresence('name2') 
                ->notEmpty('name2', '名前が入力されていません。(名)') ;
        $validator 
                ->requirePresence('kana1') 
                ->notEmpty('kana1', 'ふりがなが入力されていません。(姓)') ;
        $validator 
                ->requirePresence('kana2') 
                ->notEmpty('kana2', 'ふりがなが入力されていません。(名)') ;
        $validator 
                ->requirePresence('gender',true,"性別が選択されていません") 
                ->notEmpty('gender', '性別が選択されていません') ;
        

        return $validator;
    }
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator->notEmpty('name', '未入力です');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        /*
        $rules->add($rules->existsIn(['partner_id'], 'Partners'));
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        $rules->add($rules->existsIn(['test_id'], 'Tests'));
        $rules->add($rules->existsIn(['testgrp_id'], 'Testgrps'));
        $rules->add($rules->existsIn(['exam_id'], 'Exams'));
*/
        return $rules;
    }
}
