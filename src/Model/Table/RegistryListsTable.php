<?php

namespace MakvilleRegistry\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * RegistryLists Model
 *
 * @method \Registry\Model\Entity\RegistryList get($primaryKey, $options = [])
 * @method \Registry\Model\Entity\RegistryList newEntity($data = null, array $options = [])
 * @method \Registry\Model\Entity\RegistryList[] newEntities(array $data, array $options = [])
 * @method \Registry\Model\Entity\RegistryList|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Registry\Model\Entity\RegistryList patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Registry\Model\Entity\RegistryList[] patchEntities($entities, array $data, array $options = [])
 * @method \Registry\Model\Entity\RegistryList findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RegistryListsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('registry_lists');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
                ->allowEmpty('description');

        return $validator;
    }

    protected function getRegistryTable() {
        $locator = \Cake\ORM\TableRegistry::getTableLocator();
        return $locator->get('MakvilleRegistry.Registries');
    }

    public function createRegistryList($registryList) {
        $registryTable = $this->getRegistryTable();
        //create a table using a safe version of the name
        $tableName = $registryTable->dbName($registryList->name);
        $registryList->db_name = 'list_data_' . $tableName;
        $conn = ConnectionManager::get('default');
        $sql = sprintf(file_get_contents(\Cake\Core\Plugin::configPath('MakvilleRegistry') . 'schema/create_list.sql'), $conn->config()['database'], $registryList->db_name);
        $conn->query($sql);
        //save the registry object in the table 
        if ($this->save($registryList)) {
            return $registryList->id;
        }
    }

    public function editRegistryList($registryList) {
        $registryTable = $this->getRegistryTable();
        $oldTableName = $registryList->db_name;
        $registryList->db_name = $registryTable->dbName($registryList->name);
        if ($oldTableName != $registryList->db_name) {
            //we need to edit the name of the table in the database
            $conn = ConnectionManager::get('default');
            $db = $conn->config()['database'];
            $sql = "ALTER TABLE `$db`.`$oldTableName` RENAME TO  `$db`.`" . $registryList->db_name . "` ;";
            $conn->query($sql);
        }
        return $this->save($registry);
    }

    public function deleteRegistryList($registryList) {
        $conn = ConnectionManager::get('default');
        $db = $conn->config()['database'];
        $sql = "DROP TABLE IF EXISTS `$db`.`" . $registryList->db_name . "` ;";
        $conn->query($sql);
        return $this->delete($registryList);
    }

}
