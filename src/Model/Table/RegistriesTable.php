<?php

namespace MakvilleRegistry\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Database\Expression\BetweenExpression;
use Cake\Database\Type\DateTimeType;
use Cake\Database\Driver\Mysql;

/**
 * Registries Model
 *
 * @property \Cake\ORM\Association\HasMany $RegistryFields
 *
 * @method \Registry\Model\Entity\Registry get($primaryKey, $options = [])
 * @method \Registry\Model\Entity\Registry newEntity($data = null, array $options = [])
 * @method \Registry\Model\Entity\Registry[] newEntities(array $data, array $options = [])
 * @method \Registry\Model\Entity\Registry|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Registry\Model\Entity\Registry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Registry\Model\Entity\Registry[] patchEntities($entities, array $data, array $options = [])
 * @method \Registry\Model\Entity\Registry findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RegistriesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('registries');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('RegistryFields', [
            'dependent' => true,
            'foreignKey' => 'registry_id',
            'className' => 'MakvilleRegistry.RegistryFields',
            'sort' => ['RegistryFields.position' => 'ASC']
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

        $validator
                ->allowEmpty('name');

        $validator
                ->allowEmpty('description');

        return $validator;
    }

    public function removeSpecialCharacters($string) {
        $specialCharacters = ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', ')', '_', '+', '=', '{', '[', '}', ']', '~', '`', ';', ':', '"', "'", ',', '<', '.', '>', '/', '?', '\\', '|'];
        foreach ($specialCharacters as $character) {
            $parts = explode($character, $string);
            $string = implode('', $parts);
        }
        return strtolower($string);
    }

    public function dbName($name) {
        $name = $this->removeSpecialCharacters($name);
        return substr(implode('_', explode(' ', $name)), 0, 64);
    }

    public function createRegistry($registry) {
        //create a table using a safe version of the name
        $tableName = $this->dbName($registry->name);
        $registry->db_name = 'reg_data_' . $tableName;
        $conn = ConnectionManager::get('default');
        $sql = sprintf(file_get_contents(\Cake\Core\Plugin::configPath('MakvilleRegistry') . 'schema/create_registry.sql'), $conn->config()['database'], $registry->db_name);
        $conn->query($sql);
        //save the registry object in the table 
        return $this->save($registry);
    }

    public function editRegistry($registry) {
        $oldTableName = $registry->db_name;
        $registry->db_name = $this->dbName($registry->name);
        if ($oldTableName != $registry->db_name) {
            //we need to edit the name of the table in the database
            $conn = ConnectionManager::get('default');
            $db = $conn->config()['database'];
            $sql = "ALTER TABLE `$db`.`$oldTableName` RENAME TO  `$db`.`" . $registry->db_name . "` ;";
            $conn->query($sql);
        }
        return $this->save($registry);
    }

    public function deleteRegistry($registry) {
        $conn = ConnectionManager::get('default');
        $db = $conn->config()['database'];
        $sql = "DROP TABLE IF EXISTS `$db`.`" . $registry->db_name . "` ;";
        $conn->query($sql);
        return $this->delete($registry);
    }

    public function getData($id, $userId = null) {
        $registry = $this->get($id);
        $dbName = $registry->db_name;
        $locator = TableRegistry::getTableLocator();
        $table = $locator->get(Inflector::camelize($dbName));
        if (is_null($userId)) {
            return $table->find('all');
        } else {
            return $table->find('all')->where(['user_id' => $userId]);
        }
    }

    public function getLists() {
        $locator = TableRegistry::getTableLocator();
        $registryListTable = $locator->get('MakvilleRegistry.RegistryLists');
        return $registryListTable->find('list')->toArray();
    }

    public function getListData($registryListId) {
        $locator = TableRegistry::getTableLocator();
        $registryListTable = $locator->get('MakvilleRegistry.RegistryLists');
        $list = $registryListTable->get($registryListId);
        $dbName = $list->db_name;
        $table = $locator->get(Inflector::camelize($dbName));
        return $table->find('list')->toArray();
    }

    public function getFields($id) {
        return $this->RegistryFields->find('all')
                        ->where(['RegistryFields.registry_id' => $id])
                        ->orderAsc('RegistryFields.position')
                        ->contain(['RegistryFieldExtras'])
                        ->toArray();
    }

    public function scrubber($data) {
        $scrubbed = [];
        $formater = new DateTimeType();
        $driver = new Mysql();
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $scrubbed[$key] = implode('|', array_values($value));
            } elseif ($this->isDate($value)) {
                $scrubbed[$key] = $this->scrubDate($value);
            } elseif ($this->isTime($value)) {
                $scrubbed[$key] = $this->scrubTime($value);
            } elseif ($key == 'created') {
                $scrubbed[$key] = $formater->toPHP($value, $driver);
            } else {
                $scrubbed[$key] = $value;
            }
        }
        return $scrubbed;
    }

    protected function scrubDate($value) {
        $parts = explode('/', $value);
        $reParts = array_reverse($parts);
        return implode('-', $reParts);
    }

    protected function scrubTime($value) {
        $parts = explode(' ', $value);
        $inParts = explode(':', $parts[0]);
        if ($parts[1] == 'AM' || $inParts[0] == '12') {
            return $parts[0] . ':00';
        } else {
            return ($inParts[0] + 12) . ':' . $inParts[1] . ':00';
        }
    }

    protected function isDate($value) {
        $parts = explode('/', $value);
        if (is_array($parts) && count($parts) == 3) {
            if ((is_numeric($parts[0]) && $parts[0] > 0) && (is_numeric($parts[1]) && $parts[1] > 0) && (is_numeric($parts[2]) && $parts[2] > 0)) {
                return true;
            }
        }
        return false;
    }

    protected function isTime($value) {
        $parts = explode(' ', $value);
        if ((is_array($parts) && count($parts) == 2) && in_array($parts[1], ['AM', 'PM'])) {
            $inParts = explode(':', $parts[0]);
            if (is_array($inParts) && count($inParts) == 2) {
                if (is_numeric($inParts[0]) && is_numeric($inParts[1])) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function canFilter ($options) {
        //it must have a filter mode
        if (in_array($options['filter_mode'], ['restrictive', 'permissive'])) {
            foreach ($options['Parameters'] as $parameter) {
                if ($parameter['operator'] != '' && $parameter['operand'] != '') {
                    return true;
                }
            }
        }
        return false;
    }

    public function filter($options) {
        $registry = $this->get($options['registry_id']);
        $dbName = $registry->db_name;
        $locator = TableRegistry::getTableLocator();
        $table = $locator->get(Inflector::camelize($dbName));
        $query = $table->find();
        if (!$this->canFilter($options)) {
            return $query->toArray();
        }
        if ($options['filter_mode'] == 'permissive') {
            //$query->where(function ($exp) use ($options) {
            $query->where(function ($exp) use ($options) {
                return $exp->or(function($or) use ($options) {
                            foreach ($options['Parameters'] as $parameter) {
                                //only use parameters for which both an operator and an operand was defined
                                if ($parameter['operator'] != '' && $parameter['operand'] != '') {
                                    $column = $parameter['column'];
                                    $operand = trim($parameter['operand']);
                                    switch ($parameter['operator']) {
                                        case 'equals':
                                            $or->eq($column, $operand);
                                            break;
                                        case 'not_equal':
                                            $or->notEq($column, $operand);
                                            break;
                                        case 'greater_than':
                                            $or->gt($column, $operand);
                                            break;
                                        case 'greater_than_or_equal_to':
                                            $or->gte($column, $operand);
                                            break;
                                        case 'less_than':
                                            $or->lt($column, $operand);
                                            break;
                                        case 'less_than_or_equal_to':
                                            $or->lte($column, $operand);
                                            break;
                                        case 'between':
                                            $parts = explode(',', $operand);
                                            $or->between($column, trim($parts[0]), trim($parts[1]));
                                            break;
                                        case 'not_between':
                                            $parts = explode(',', $operand);
                                            $or->not(new BetweenExpression($column, trim($parts[0]), trim($parts[1])));
                                            break;
                                        case 'among':
                                            $parts = explode(',', $parameter['operand']);
                                            foreach ($parts as $index => $part) {
                                                $parts[$index] = trim($part);
                                            }
                                            $or->in($column, $parts);
                                            break;
                                        case 'not_among':
                                            $parts = explode(',', $parameter['operand']);
                                            foreach ($parts as $index => $part) {
                                                $parts[$index] = trim($part);
                                            }
                                            $or->notIn($column, $parts);
                                            break;
                                        case 'contains':
                                            $or->like($column, "%$operand%");
                                            break;
                                        case 'does_not_contain':
                                            $or->notLike($column, "%$operand%");
                                            break;
                                    }
                                }
                            }
                            return $or;
                        });
            });
        } elseif ($options['filter_mode'] == 'restrictive') {
            foreach ($options['Parameters'] as $parameter) {
                //only use parameters for which both an operator and an operand was defined
                if ($parameter['operator'] != '' && $parameter['operand'] != '') {
                    $column = $parameter['column'];
                    $operand = trim($parameter['operand']);
                    switch ($parameter['operator']) {
                        case 'equals':
                            $query->where([$column => $operand]);
                            break;
                        case 'not_equal':
                            $query->where(function ($exp) use ($column, $operand) {
                                return $exp->notEq($column, $operand);
                            });
                            break;
                        case 'greater_than':
                            $query->where(function ($exp) use ($column, $operand) {
                                return $exp->gt($column, $operand);
                            });
                            break;
                        case 'greater_than_or_equal_to':
                            $query->where(function ($exp) use ($column, $operand) {
                                return $exp->gte($column, $operand);
                            });
                            break;
                        case 'less_than':
                            $query->where(function ($exp) use ($column, $operand) {
                                return $exp->lt($column, $operand);
                            });
                            break;
                        case 'less_than_or_equal_to':
                            $query->where(function ($exp) use ($column, $operand) {
                                return $exp->lte($column, $operand);
                            });
                            break;
                        case 'between':
                            $query->where(function ($exp) use ($column, $operand) {
                                $parts = explode(',', $operand);
                                return $exp->between($column, trim($parts[0]), trim($parts[1]));
                            });
                            break;
                        case 'not_between':
                            $query->where(function ($exp) use ($column, $operand) {
                                $parts = explode(',', $operand);
                                return $exp->not(new BetweenExpression($column, trim($parts[0]), trim($parts[1])));
                            });
                            break;
                        case 'among':
                            $parts = explode(',', $operand);
                            foreach ($parts as $index => $part) {
                                $parts[$index] = trim($part);
                            }
                            $query->where(function ($exp) use ($column, $parts) {
                                return $exp->in($column, $parts);
                            });
                            break;
                        case 'not_among':
                            $parts = explode(',', $parameter['operand']);
                            foreach ($parts as $index => $part) {
                                $parts[$index] = trim($part);
                            }
                            $query->where(function ($exp) use ($column, $parts) {
                                return $exp->notIn($column, $parts);
                            });break;
                        case 'contains':
                            $query->where(function ($exp) use ($column, $operand) {
                                return $exp->like($column, "%$operand%");
                            });
                            break;
                        case 'does_not_contain':
                            $query->where(function ($exp) use ($column, $operand) {
                                return $exp->notLike($column, "%$operand%");
                            });
                            break;
                    }
                }
            }
        }
        return $query->toArray();
    }

    public function userTotal($id, $userId) {
        $registry = $this->get($id);
        $dbName = $registry->db_name;
        $locator = TableRegistry::getTableLocator();
        $table = $locator->get(Inflector::camelize($dbName));
        return $table->find()->where(['user_id' => $userId])->count();
    }

    public function userSummary($id, $userId) {
        //do we have data spaning more than one year for this user
        $registry = $this->get($id);
        $dbName = $registry->db_name;
        $locator = TableRegistry::getTableLocator();
        $table = $locator->get(Inflector::camelize($dbName));
        $firstData = $table->find()->where(['user_id' => $userId])->orderAsc('created');
        $first = $firstData->first();
        if (!empty($first)) {
            $lastData = $table->find()->where(['user_id' => $userId])->orderDesc('created');
            $last = $lastData->first();
            $firstYear = $first->created->i18nFormat('YYYY');
            $lastYear = $last->created->i18nFormat('YYYY');
            $data = [];
            if ($firstYear != $lastYear) {
                //there are multiple years
                $type = 'multiple';
                for ($i = $firstYear; $i <= $lastYear; $i++) {
                    $data[$i] = $table->find()
                                    ->where(['user_id' => $userId])
                                    ->andWhere([function ($exp) use ($i) {
                                            $start = "$i-01-01 00:00:00";
                                            $stop = "$i-12-31 23:59:59";
                                            return $exp->between('created', $start, $stop, 'datetime');
                                        }
                                    ])->count();
                }
            } else {
                //all records are under one year
                $type = 'single';
                for ($i = 1; $i <= 12; $i++) {
                    $data[$i] = $table->find()
                                    ->where(['user_id' => $userId])
                                    ->andWhere([function ($exp) use ($i, $firstYear) {
                                            $start = "$firstYear-$i-01";
                                            $stop = "$firstYear-$i-31";
                                            return $exp->between('created', $start, $stop, 'datetime');
                                        }
                                    ])->count();
                }
            }
            return ['type' => $type, 'data' => $data];
        } else {
            return ['type' => '', 'data' => ''];
        }
    }

    public function userDailySummary($id, $userId) {
        $dailySummary = [];
        //do we have data spaning more than one year for this user
        $registry = $this->get($id);
        $dbName = $registry->db_name;
        $locator = TableRegistry::getTableLocator();
        $table = $locator->get(Inflector::camelize($dbName));
        $firstData = $table->find()->where(['user_id' => $userId])->orderAsc('created');
        $first = $firstData->first();
        if (!empty($first)) {
            $lastData = $table->find()->where(['user_id' => $userId])->orderDesc('created');
            $last = $lastData->first();
            $currentDate = $first->created;
            $lastDate = $last->created;
            while ($currentDate->lte($lastDate)) {
                $count = $table->find()
                                ->where(['user_id' => $userId])
                                ->andWhere([function ($exp) use ($currentDate) {
                                        $start = $currentDate->i18nFormat('YYYY-MM-dd') . " 00:00:00";
                                        $stop = $currentDate->i18nFormat('YYYY-MM-dd') . " 23:59:59";
                                        return $exp->between('created', $start, $stop, 'datetime');
                                    }
                                ])->count();
                $dailySummary [] = ['date' => $currentDate->i18nFormat('YYYY-MM-dd'), 'value' => $count];
                $currentDate = $currentDate->addDay(1);
            }
        }
        return $dailySummary;
    }

    public function userEntries($id, $userId) {
        //do we have data spaning more than one year for this user
        $registry = $this->get($id);
        $dbName = $registry->db_name;
        $locator = TableRegistry::getTableLocator();
        $table = $locator->get(Inflector::camelize($dbName));
        $day = $table->find()
                ->where(['user_id' => $userId])
                ->andWhere([function ($exp) {
                        $today = \Cake\I18n\Date::now()->i18nFormat('YYYY-MM-dd');
                        $start = $today . " 00:00:00";
                        $stop = $today . " 23:59:59";
                        return $exp->between('created', $start, $stop, 'datetime');
                    }])
                ->count();
        $month = $table->find()
                ->where(['user_id' => $userId])
                ->andWhere([function ($exp) {
                        $today = \Cake\I18n\Date::now();
                        $start = $today->year . "-" . $today->month . "-01 00:00:00";
                        $stop = $today->year . "-" . $today->month . "-31 23:59:59";
                        return $exp->between('created', $start, $stop, 'datetime');
                    }])
                ->count();
        $year = $table->find()
                ->where(['user_id' => $userId])
                ->andWhere([function ($exp) {
                        $today = \Cake\I18n\Date::now();
                        $start = $today->year . "-" . "01-01 00:00:00";
                        $stop = $today->year . "-" . "12-31 23:59:59";
                        return $exp->between('created', $start, $stop, 'datetime');
                    }])
                ->count();
        return ['day' => $day, 'month' => $month, 'year' => $year];
    }

    public function entrySummary($id) {
        //do we have data spaning more than one year for this user
        $registry = $this->get($id);
        $dbName = $registry->db_name;
        $locator = TableRegistry::getTableLocator();
        $table = $locator->get(Inflector::camelize($dbName));
        $day = $table->find()
                ->where([function ($exp) {
                        $today = \Cake\I18n\Date::now()->i18nFormat('YYYY-MM-dd');
                        $start = $today . " 00:00:00";
                        $stop = $today . " 23:59:59";
                        return $exp->between('created', $start, $stop, 'datetime');
                    }])
                ->count();
        $month = $table->find()
                ->where([function ($exp) {
                        $today = \Cake\I18n\Date::now();
                        $start = $today->year . "-" . $today->month . "-01 00:00:00";
                        $stop = $today->year . "-" . $today->month . "-31 23:59:59";
                        return $exp->between('created', $start, $stop, 'datetime');
                    }])
                ->count();
        $year = $table->find()
                ->where([function ($exp) {
                        $today = \Cake\I18n\Date::now();
                        $start = $today->year . "-" . "01-01 00:00:00";
                        $stop = $today->year . "-" . "12-31 23:59:59";
                        return $exp->between('created', $start, $stop, 'datetime');
                    }])
                ->count();
        return ['day' => $day, 'month' => $month, 'year' => $year];
    }

}
