<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TUser Model
 *
 * @property \App\Model\Table\LoginsTable&\Cake\ORM\Association\BelongsTo $Logins
 * @property \App\Model\Table\EirsTable&\Cake\ORM\Association\BelongsTo $Eirs
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 * @property \App\Model\Table\PdfFirstTable&\Cake\ORM\Association\HasMany $PdfFirst
 *
 * @method \App\Model\Entity\TUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\TUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TUser|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TUser findOrCreate($search, callable $callback = null, $options = [])
 */
class TUserTable extends Table
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

        $this->setTable('t_user');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        /*
        $this->belongsTo('Logins', [
            'foreignKey' => 'login_id',
        ]);
        $this->belongsTo('Eirs', [
            'foreignKey' => 'eir_id',
        ]);
        $this->belongsTo('Partners', [
            'foreignKey' => 'partner_id',
        ]);
        $this->hasMany('PdfFirst', [
            'foreignKey' => 't_user_id',
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
            ->scalar('password')
            ->maxLength('password', 128)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('login_pw')
            ->allowEmptyString('login_pw');

        $validator
            ->integer('type')
            ->allowEmptyString('type');

        $validator
            ->boolean('super')
            ->requirePresence('super', 'create')
            ->notEmptyString('super');

        $validator
            ->scalar('name')
            ->allowEmptyString('name');

        $validator
            ->scalar('post1')
            ->allowEmptyString('post1');

        $validator
            ->scalar('post2')
            ->allowEmptyString('post2');

        $validator
            ->scalar('prefecture')
            ->allowEmptyString('prefecture');

        $validator
            ->scalar('address1')
            ->allowEmptyString('address1');

        $validator
            ->scalar('address2')
            ->allowEmptyString('address2');

        $validator
            ->scalar('tel')
            ->allowEmptyString('tel');

        $validator
            ->scalar('fax')
            ->allowEmptyString('fax');

        $validator
            ->scalar('rep_name')
            ->allowEmptyString('rep_name');

        $validator
            ->scalar('rep_email')
            ->allowEmptyString('rep_email');

        $validator
            ->scalar('rep_name2')
            ->requirePresence('rep_name2', 'create')
            ->notEmptyString('rep_name2');

        $validator
            ->scalar('rep_email2')
            ->requirePresence('rep_email2', 'create')
            ->notEmptyString('rep_email2');

        $validator
            ->scalar('rep_busyo')
            ->allowEmptyString('rep_busyo');

        $validator
            ->scalar('rep_tel1')
            ->allowEmptyString('rep_tel1');

        $validator
            ->scalar('rep_tel2')
            ->allowEmptyString('rep_tel2');

        $validator
            ->scalar('license')
            ->requirePresence('license', 'create')
            ->notEmptyString('license');

        $validator
            ->scalar('license_parts')
            ->requirePresence('license_parts', 'create')
            ->notEmptyString('license_parts');

        $validator
            ->scalar('logo')
            ->allowEmptyString('logo');

        $validator
            ->scalar('logo_name')
            ->requirePresence('logo_name', 'create')
            ->notEmptyString('logo_name');

        $validator
            ->integer('del')
            ->notEmptyString('del');

        $validator
            ->integer('privacy_flg')
            ->notEmptyString('privacy_flg');

        $validator
            ->integer('csvupload')
            ->notEmptyString('csvupload');

        $validator
            ->integer('pdf_button')
            ->notEmptyString('pdf_button');

        $validator
            ->scalar('form_code')
            ->requirePresence('form_code', 'create')
            ->notEmptyString('form_code');

        $validator
            ->integer('form_status')
            ->notEmptyString('form_status');

        $validator
            ->integer('user_status')
            ->notEmptyString('user_status');

        $validator
            ->integer('temp_flg')
            ->requirePresence('temp_flg', 'create')
            ->notEmptyString('temp_flg');

        $validator
            ->scalar('outputPdf')
            ->maxLength('outputPdf', 255)
            ->requirePresence('outputPdf', 'create')
            ->notEmptyString('outputPdf');

        $validator
            ->integer('element_flg')
            ->requirePresence('element_flg', 'create')
            ->notEmptyString('element_flg');

        $validator
            ->integer('sendDayStatus')
            ->requirePresence('sendDayStatus', 'create')
            ->notEmptyString('sendDayStatus');

        $validator
            ->integer('pdf_master_status')
            ->requirePresence('pdf_master_status', 'create')
            ->notEmptyString('pdf_master_status');

        $validator
            ->integer('excel_master_status')
            ->requirePresence('excel_master_status', 'create')
            ->notEmptyString('excel_master_status');

        $validator
            ->boolean('ptTestBtn')
            ->requirePresence('ptTestBtn', 'create')
            ->notEmptyString('ptTestBtn');

        $validator
            ->boolean('csTestBtn')
            ->requirePresence('csTestBtn', 'create')
            ->notEmptyString('csTestBtn');

        $validator
            ->integer('exam_pattern')
            ->allowEmptyString('exam_pattern');

        $validator
            ->dateTime('registtime')
            ->notEmptyDateTime('registtime');

        $validator
            ->dateTime('regist_ts')
            ->notEmptyDateTime('regist_ts');

        $validator
            ->integer('explain_page')
            ->notEmptyString('explain_page');

        $validator
            ->integer('ssltype')
            ->notEmptyString('ssltype');
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
        $rules->add($rules->existsIn(['login_id'], 'Logins'));
        $rules->add($rules->existsIn(['eir_id'], 'Eirs'));
        $rules->add($rules->existsIn(['partner_id'], 'Partners'));

        return $rules;
    }
}
