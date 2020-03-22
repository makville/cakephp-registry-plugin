<?php

namespace MakvilleRegistry\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RegistryFieldExtras Model
 *
 * @property \Cake\ORM\Association\BelongsTo $RegistryFields
 *
 * @method \Registry\Model\Entity\RegistryFieldExtra get($primaryKey, $options = [])
 * @method \Registry\Model\Entity\RegistryFieldExtra newEntity($data = null, array $options = [])
 * @method \Registry\Model\Entity\RegistryFieldExtra[] newEntities(array $data, array $options = [])
 * @method \Registry\Model\Entity\RegistryFieldExtra|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Registry\Model\Entity\RegistryFieldExtra patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Registry\Model\Entity\RegistryFieldExtra[] patchEntities($entities, array $data, array $options = [])
 * @method \Registry\Model\Entity\RegistryFieldExtra findOrCreate($search, callable $callback = null)
 */
class RegistryFieldExtrasTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('registry_field_extras');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('RegistryFields', [
            'foreignKey' => 'registry_field_id',
            'className' => 'MakvilleRegistry.RegistryFields'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
                ->integer('id')
                ->allowEmpty('id', 'create');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker {
        $rules->add($rules->existsIn(['registry_field_id'], 'RegistryFields'));

        return $rules;
    }

}
