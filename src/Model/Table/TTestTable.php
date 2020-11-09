<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TTest Model
 *
 * @property \App\Model\Table\EirsTable&\Cake\ORM\Association\BelongsTo $Eirs
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\TestsTable&\Cake\ORM\Association\BelongsTo $Tests
 *
 * @method \App\Model\Entity\TTest get($primaryKey, $options = [])
 * @method \App\Model\Entity\TTest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TTest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TTest|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TTest saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TTest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TTest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TTest findOrCreate($search, callable $callback = null, $options = [])
 */
class TTestTable extends Table
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

        $this->setTable('t_test');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
/*
        $this->belongsTo('Eirs', [
            'foreignKey' => 'eir_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Partners', [
            'foreignKey' => 'partner_id',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
        ]);
        $this->belongsTo('Tests', [
            'foreignKey' => 'test_id',
            'joinType' => 'INNER',
        ]);
        */
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        /*
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->allowEmptyString('name');

        $validator
            ->scalar('period_from')
            ->allowEmptyString('period_from');

        $validator
            ->scalar('period_to')
            ->allowEmptyString('period_to');

        $validator
            ->integer('number')
            ->allowEmptyString('number');

        $validator
            ->scalar('dir')
            ->maxLength('dir', 255)
            ->requirePresence('dir', 'create')
            ->notEmptyString('dir');

        $validator
            ->integer('fin_disp')
            ->requirePresence('fin_disp', 'create')
            ->notEmptyString('fin_disp');

        $validator
            ->scalar('url')
            ->allowEmptyString('url');

        $validator
            ->scalar('qrcode')
            ->allowEmptyString('qrcode');

        $validator
            ->scalar('type')
            ->allowEmptyString('type');

        $validator
            ->integer('weight')
            ->notEmptyString('weight');

        $validator
            ->numeric('w1')
            ->notEmptyString('w1');

        $validator
            ->numeric('w2')
            ->notEmptyString('w2');

        $validator
            ->numeric('w3')
            ->notEmptyString('w3');

        $validator
            ->numeric('w4')
            ->notEmptyString('w4');

        $validator
            ->numeric('w5')
            ->notEmptyString('w5');

        $validator
            ->numeric('w6')
            ->notEmptyString('w6');

        $validator
            ->numeric('w7')
            ->notEmptyString('w7');

        $validator
            ->numeric('w8')
            ->notEmptyString('w8');

        $validator
            ->numeric('w9')
            ->notEmptyString('w9');

        $validator
            ->numeric('w10')
            ->notEmptyString('w10');

        $validator
            ->numeric('w11')
            ->notEmptyString('w11');

        $validator
            ->numeric('w12')
            ->notEmptyString('w12');

        $validator
            ->numeric('ave')
            ->notEmptyString('ave');

        $validator
            ->numeric('sd')
            ->notEmptyString('sd');

        $validator
            ->integer('enabled')
            ->notEmptyString('enabled');

        $validator
            ->integer('del')
            ->notEmptyString('del');

        $validator
            ->dateTime('registtime')
            ->notEmptyDateTime('registtime');

        $validator
            ->integer('minute_rest')
            ->requirePresence('minute_rest', 'create')
            ->notEmptyString('minute_rest');

        $validator
            ->integer('rsei_type')
            ->requirePresence('rsei_type', 'create')
            ->notEmptyString('rsei_type');

        $validator
            ->integer('language')
            ->requirePresence('language', 'create')
            ->notEmptyString('language');

        $validator
            ->scalar('tamen_type')
            ->requirePresence('tamen_type', 'create')
            ->notEmptyString('tamen_type');

        $validator
            ->scalar('vf4_object')
            ->requirePresence('vf4_object', 'create')
            ->notEmptyString('vf4_object');

        $validator
            ->integer('send_mail')
            ->requirePresence('send_mail', 'create')
            ->notEmptyString('send_mail');

        $validator
            ->scalar('pdfdownload')
            ->requirePresence('pdfdownload', 'create')
            ->notEmptyString('pdfdownload');

        $validator
            ->integer('stress_flg')
            ->requirePresence('stress_flg', 'create')
            ->notEmptyString('stress_flg');

        $validator
            ->integer('no_disp_flg')
            ->notEmptyString('no_disp_flg');

        $validator
            ->integer('temp_flg')
            ->requirePresence('temp_flg', 'create')
            ->notEmptyString('temp_flg');

        $validator
            ->integer('rest_mail_count')
            ->requirePresence('rest_mail_count', 'create')
            ->notEmptyString('rest_mail_count');

        $validator
            ->integer('rowflg')
            ->requirePresence('rowflg', 'create')
            ->notEmptyString('rowflg');

        $validator
            ->integer('enq_status')
            ->notEmptyString('enq_status');

        $validator
            ->integer('pdf_slice')
            ->requirePresence('pdf_slice', 'create')
            ->notEmptyString('pdf_slice');

        $validator
            ->scalar('array_tensaku_title_status')
            ->maxLength('array_tensaku_title_status', 512)
            ->requirePresence('array_tensaku_title_status', 'create')
            ->notEmptyString('array_tensaku_title_status');

        $validator
            ->scalar('array_tensaku_text')
            ->maxLength('array_tensaku_text', 255)
            ->requirePresence('array_tensaku_text', 'create')
            ->notEmptyString('array_tensaku_text');

        $validator
            ->integer('recommen')
            ->notEmptyString('recommen');

        $validator
            ->integer('graph_status')
            ->notEmptyString('graph_status');

        $validator
            ->integer('pdf_output_limit')
            ->notEmptyString('pdf_output_limit');

        $validator
            ->date('pdf_output_limit_from')
            ->requirePresence('pdf_output_limit_from', 'create')
            ->notEmptyDate('pdf_output_limit_from');

        $validator
            ->date('pdf_output_limit_to')
            ->requirePresence('pdf_output_limit_to', 'create')
            ->notEmptyDate('pdf_output_limit_to');

        $validator
            ->integer('pdf_output_limit_count')
            ->requirePresence('pdf_output_limit_count', 'create')
            ->notEmptyString('pdf_output_limit_count');

        $validator
            ->integer('pdf_output_count')
            ->requirePresence('pdf_output_count', 'create')
            ->notEmptyString('pdf_output_count');

        $validator
            ->integer('download_excel')
            ->requirePresence('download_excel', 'create')
            ->notEmptyString('download_excel');

        $validator
            ->integer('pdf_log_use')
            ->allowEmptyString('pdf_log_use');

        $validator
            ->integer('excel_type')
            ->notEmptyString('excel_type');

        $validator
            ->integer('judge_login')
            ->allowEmptyString('judge_login');
*/
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
        $rules->add($rules->existsIn(['eir_id'], 'Eirs'));
        $rules->add($rules->existsIn(['partner_id'], 'Partners'));
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        $rules->add($rules->existsIn(['test_id'], 'Tests'));
*/
        return $rules;
    }

}
