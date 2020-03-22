<?php

namespace MakvilleRegistry\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * RegistryFields Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Registries
 * @property \Cake\ORM\Association\HasMany $RegistryFieldExtras
 *
 * @method \Registry\Model\Entity\RegistryField get($primaryKey, $options = [])
 * @method \Registry\Model\Entity\RegistryField newEntity($data = null, array $options = [])
 * @method \Registry\Model\Entity\RegistryField[] newEntities(array $data, array $options = [])
 * @method \Registry\Model\Entity\RegistryField|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Registry\Model\Entity\RegistryField patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Registry\Model\Entity\RegistryField[] patchEntities($entities, array $data, array $options = [])
 * @method \Registry\Model\Entity\RegistryField findOrCreate($search, callable $callback = null)
 */
class RegistryFieldsTable extends Table {

    private $dbName = '';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('registry_fields');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Registries', [
            'foreignKey' => 'registry_id',
            'className' => 'MakvilleRegistry.Registries'
        ]);
        $this->hasOne('RegistryFieldExtras', [
            'foreignKey' => 'registry_field_id',
            'className' => 'MakvilleRegistry.RegistryFieldExtras'
        ]);
        $this->dbName = $this->getConnection()->config()['database'];
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

        $validator
                ->allowEmpty('name');

        $validator
                ->allowEmpty('label');

        $validator
                ->allowEmpty('tip');

        $validator
                ->allowEmpty('data_type');

        $validator
                ->allowEmpty('control_type');

        $validator
                ->allowEmpty('options');

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
        $rules->add($rules->existsIn(['registry_id'], 'Registries'));

        return $rules;
    }

    public function createRegistryField($registryField) {
        $registryField->name = $this->Registries->dbName($registryField->label);
        $registry = $this->Registries->get($registryField->registry_id);
        $type = 'VARCHAR(255)';
        switch ($registryField->data_type) {
            case 'short':
            case 'single':
            case 'multiple':
            case 'linear':
                $type = 'VARCHAR(255)';
                break;
            case 'long':
                $type = 'TEXT';
                break;
            case 'grid':
            case 'date':
            case 'time':
            case 'number':
            default :
                $type = 'VARCHAR(255)';
                break;
        }
        $conn = ConnectionManager::get('default');
        $sql = 'ALTER TABLE `' . $this->dbName . '`.`' . $registry->db_name . '` ADD COLUMN `' . $registryField->name . '` ' . $type . ' NULL DEFAULT NULL;';
        try {
            $conn->query($sql);
            //if there's a need to create a new list let do so.
            $registryListId = null;
            if ($registryField->source == 'new') {
                $locator = \Cake\ORM\TableRegistry::getTableLocator();
                $registryListTable = $locator->get('Registry.RegistryLists');
                $registryList = $registryListTable->newEntity(['name' => $registryField->list_name]);
                $registryListId = $registryListTable->createRegistryList($registryList);
            } elseif ($registryField->source == 'existing') {
                $registryListId = $registryField['lists'];
            }
            //save the registry field
            if ($this->save($registryField)) {
                $extras = $this->RegistryFieldExtras->newEntity(array_merge(['registry_field_id' => $registryField->id, 'registry_list_id' => $registryListId], $registryField->toArray()));
                return $this->RegistryFieldExtras->save($extras);
            }
        } catch (\Exception $e) {
            return false;
        }
        return false;
    }

    public function editRegistryField($registryField) {
        $this->clearExtras($registryField->id);
        $oldDbName = $registryField->name;
        $registryField->name = $this->Registries->dbName($registryField->label);
        $registry = $this->Registries->get($registryField->registry_id);
        $type = 'VARCHAR(255)';
        switch ($registryField->data_type) {
            case 'short':
            case 'single':
            case 'multiple':
            case 'linear':
                $type = 'VARCHAR(255)';
                break;
            case 'long':
                $type = 'TEXT';
                break;
            case 'grid':
            case 'date':
            case 'time':
            case 'number':
            default :
                $type = 'VARCHAR(255)';
                break;
        }
        $conn = ConnectionManager::get('default');
        $sql = 'ALTER TABLE `' . $this->dbName . '`.`' . $registry->db_name . '` CHANGE `' . $oldDbName . '` `' . $registryField->name . '` ' . $type . ' NULL DEFAULT NULL;';
        try {
            $conn->query($sql);
            //if there's a need to create a new list let do so.
            $registryListId = null;
            if ($registryField->source == 'new') {
                $registryListTable = \Cake\ORM\TableRegistry::get('Registry.RegistryLists');
                $registryList = $registryListTable->newEntity(['name' => $registryField->list_name]);
                $registryListId = $registryListTable->createRegistryList($registryList);
            } elseif ($registryField->source == 'existing') {
                $registryListId = $registryField['lists'];
            }
            if ($this->save($registryField)) {
                $extras = $this->RegistryFieldExtras->find()->where(['registry_field_id' => $registryField->id])->first();
                if ($extras) {
                    $extras = $this->RegistryFieldExtras->patchEntity($extras, array_merge(['registry_field_id' => $registryField->id, 'registry_list_id' => $registryListId], $registryField->toArray()));
                    return $this->RegistryFieldExtras->save($extras);
                }
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
        return false;
    }

    public function deleteRegistryField($registryField) {
        $this->clearExtras($registryField->id);
        $registry = $this->Registries->get($registryField->registry_id);
        $conn = ConnectionManager::get('default');
        $sql = 'ALTER TABLE `' . $this->dbName . '`.`' . $registry->db_name . '` DROP `' . $registryField->name . '`';
        return $conn->query($sql);
    }

    public function clearExtras($id) {
        $skipFields = ['id', 'registry_field_id'];
        $registryField = $this->get($id);
        //$registryField->options = null;
        if ($this->save($registryField)) {
            $extras = $this->RegistryFieldExtras->find()->where(['registry_field_id' => $registryField->id])->first();
            if ($extras) {
                $array = $extras->toArray();
                foreach ($array as $key => $val) {
                    if (!in_array($key, $skipFields)) {
                        $extras->$key = null;
                    }
                }
                $this->RegistryFieldExtras->save($extras);
                return $this->RegistryFieldExtras->save($extras);
            }
        }
        return false;
    }

    public function sort($registryId, $order) {
        $positions = explode(',', $order);
        foreach ($positions as $position => $field) {
            $field = $this->get($field);
            $field->position = $position;
            $this->save($field);
        }
        return true;
    }

}
