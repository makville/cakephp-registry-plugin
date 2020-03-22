<?php

namespace MakvilleRegistry\Controller;

use MakvilleRegistry\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * Registries Controller
 *
 * @property \Registry\Model\Table\RegistriesTable $Registries
 */
class RegistriesController extends AppController {

    public function initialize(): void {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $registries = $this->paginate($this->Registries);

        $this->set(compact('registries'));
        $this->set('_serialize', ['registries']);
    }

    /**
     * View method
     *
     * @param string|null $id Registry id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $registry = $this->Registries->get($id, [
            'contain' => ['RegistryFields']
        ]);

        $this->set('registry', $registry);
        $this->set('_serialize', ['registry']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $registry = $this->Registries->newEmptyEntity();
        if ($this->request->is('post')) {
            $registry = $this->Registries->patchEntity($registry, $this->request->getData());
            $user = $this->Authentication->getIdentity();
            $registry->owner = $user->id;
            if ($this->Registries->createRegistry($registry)) {
                $this->Flash->success(__('The registry has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The registry could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('registry'));
        $this->set('_serialize', ['registry']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Registry id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $registry = $this->Registries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $registry = $this->Registries->patchEntity($registry, $this->request->getData());
            if ($this->Registries->editRegistry($registry)) {
                $this->Flash->success(__('The registry has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The registry could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('registry'));
        $this->set('_serialize', ['registry']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Registry id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $registry = $this->Registries->get($id);
        if ($this->Registries->deleteRegistry($registry)) {
            $this->Flash->success(__('The registry has been deleted.'));
        } else {
            $this->Flash->error(__('The registry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function newEntry($id) {
        $registry = $this->Registries->get($id, ['contain' => ['RegistryFields' => ['RegistryFieldExtras']]]);
        $lists = [];
        foreach ($registry->registry_fields as $field) {
            if (in_array($field->data_type, ['single', 'multiple'])) {
                //does it have its options list?
                if (strlen(trim($field->options)) == 0) {
                    $registryListId = $field->registry_field_extra->registry_list_id;
                    if (is_numeric($registryListId) && $registryListId > 0) {
                        if (!array_key_exists($registryListId, $lists)) {
                            $lists[$registryListId] = $this->Registries->getListData($registryListId);
                        }
                    }
                }
            }
        }
        if ($this->request->is('post')) {
            //lets try to get the db name from the registry
            $dbName = $registry->db_name;
            $table = TableRegistry::get(Inflector::camelize($dbName));
            $entity = $table->newEntity($this->Registries->scrubber($this->request->getData()));
            if ($table->save($entity)) {
                return $this->redirect(['action' => 'get-registry-data', $id]);
            }
        }
        $this->set(compact('registry', 'lists'));
    }

    public function viewEntries($id) {
        $this->set(compact('id'));
    }

    public function getData($id) {
        $registry = $this->Registries->get($id, ['contain' => ['RegistryFields' => ['RegistryFieldExtras']]]);
        $lists = [];
        foreach ($registry->registry_fields as $field) {
            if (in_array($field->data_type, ['single', 'multiple'])) {
                //does it have its options list?
                if (strlen(trim($field->options)) == 0) {
                    $registryListId = $field->registry_field_extra->registry_list_id;
                    if (is_numeric($registryListId) && $registryListId > 0) {
                        if (!array_key_exists($registryListId, $lists)) {
                            $lists[$registryListId] = $this->Registries->getListData($registryListId);
                        }
                    }
                }
            }
        }
        $columns = $this->Registries->getFields($id);
        //lets try to get the db name from the registry
        $dbName = $registry->db_name;
        $table = TableRegistry::get(Inflector::camelize($dbName));
        $data = $table->find('all')->toArray();
        $this->set(compact('registry', 'lists', 'data', 'columns'));
    }

    public function getRegistryData($id, $auto = 'no') {
        $user = $this->Authentication->getIdentity();
        $registry = $this->Registries->get($id, ['contain' => ['RegistryFields' => ['RegistryFieldExtras']]]);
        $lists = [];
        foreach ($registry->registry_fields as $field) {
            if (in_array($field->data_type, ['single', 'multiple'])) {
                //does it have its options list?
                if (strlen(trim($field->options)) == 0) {
                    $registryListId = $field->registry_field_extra->registry_list_id;
                    if (is_numeric($registryListId) && $registryListId > 0) {
                        if (!array_key_exists($registryListId, $lists)) {
                            $lists[$registryListId] = $this->Registries->getListData($registryListId);
                        }
                    }
                }
            }
        }
        $data = [];
        if ($this->request->is('post')) {
            if (!$this->Registries->canFilter($this->request->getData())) {
                $this->Flash->error('You have either not selected a filter mode or you have not defined any filter', ['plugin' => 'MakvilleControlPanel']);
            }
            $data = $this->Registries->filter($this->request->getData());
        } else {
            //is this user a global user
            if ($auto == 'yes' || ($this->request->getData('button') !== null && $this->request->getData('button') == 'excel')) {
                if ($registry->owner == $user->id) {
                    $data = $this->Registries->getData($id)->toArray();
                } else {
                    $data = $this->Registries->getData($id, $user->id)->toArray();
                }
            } else {
                if ($registry->owner == $user->id) {
                    $data = $this->paginate($this->Registries->getData($id));
                } else {
                    $data = $this->paginate($this->Registries->getData($id, $user->id));
                }
            }
        }
        $columns = $this->Registries->getFields($id);
        $allowFilter = false;
        if ($registry->owner == $user->id) {
            $allowFilter = true;
        }
        $this->set(compact('registry', 'lists', 'data', 'columns', 'allowFilter', 'auto', 'user'));
    }

    public function editEntry($id, $entryId) {
        $registry = $this->Registries->get($id, ['contain' => ['RegistryFields' => ['RegistryFieldExtras']]]);
        $lists = [];
        foreach ($registry->registry_fields as $field) {
            if (in_array($field->data_type, ['single', 'multiple'])) {
                //does it have its options list?
                if (strlen(trim($field->options)) == 0) {
                    $registryListId = $field->registry_field_extra->registry_list_id;
                    if (is_numeric($registryListId) && $registryListId > 0) {
                        if (!array_key_exists($registryListId, $lists)) {
                            $lists[$registryListId] = $this->Registries->getListData($registryListId);
                        }
                    }
                }
            }
        }
        if ($this->request->is('post')) {
            //lets try to get the db name from the registry
            $dbName = $registry->db_name;
            $table = TableRegistry::get(Inflector::camelize($dbName));
            $entity = $table->get($entryId);
            $entity = $table->patchEntity($entity, $this->Registries->scrubber($this->request->getData()));
            if ($table->save($entity)) {
                return $this->redirect(['action' => 'get-registry-data', $id]);
            }
        }
        $columns = $this->Registries->getFields($id);
        //lets try to get the db name from the registry
        $dbName = $registry->db_name;
        $locator = TableRegistry::getTableLocator();
        $table = $locator->get(Inflector::camelize($dbName));
        $data = $table->get($entryId)->toArray();
        $user = $this->Authentication->getIdentity();
        if ($user->id == $registry->owner) {
            $this->set(compact('registry', 'lists', 'columns', 'data'));
        } else {
            $this->Flash->error('You are not authorized to edit this entry');
            return $this->redirect(['action' => 'get-registry-data', $id]);
        }
    }

    public function viewEntry($id, $entryId) {
        $locator = TableRegistry::getTableLocator();
        $registry = $this->Registries->get($id, ['contain' => ['RegistryFields' => ['RegistryFieldExtras']]]);
        $lists = [];
        foreach ($registry->registry_fields as $field) {
            if (in_array($field->data_type, ['single', 'multiple'])) {
                //does it have its options list?
                if (strlen(trim($field->options)) == 0) {
                    $registryListId = $field->registry_field_extra->registry_list_id;
                    if (is_numeric($registryListId) && $registryListId > 0) {
                        if (!array_key_exists($registryListId, $lists)) {
                            $lists[$registryListId] = $this->Registries->getListData($registryListId);
                        }
                    } else {
                        //I'm confused!!!
                    }
                }
            }
        }
        if ($this->request->is('post')) {
            //lets try to get the db name from the registry
            $dbName = $registry->db_name;
            $table = $locator->get(Inflector::camelize($dbName));
            $entity = $table->get($entryId);
            $entity = $table->patchEntity($entity, $this->Registries->scrubber($this->request->getData()));
            if ($table->save($entity)) {
                return $this->redirect(['action' => 'get-registry-data', $id]);
            }
        }
        $columns = $this->Registries->getFields($id);
        //lets try to get the db name from the registry
        $dbName = $registry->db_name;
        $table = $locator->get(Inflector::camelize($dbName));
        $data = $table->get($entryId)->toArray();
        $this->set(compact('registry', 'lists', 'columns', 'data'));
    }

    public function deleteEntry($id, $entryId) {
        $registry = $this->Registries->get($id, ['contain' => ['RegistryFields' => ['RegistryFieldExtras']]]);
        $dbName = $registry->db_name;
        $table = TableRegistry::get(Inflector::camelize($dbName));
        $entity = $table->get($entryId);
        if (($user['is_global'] != 1 || $user['is_system'] != 1 ) || !$entity->created->wasWithinLast('3 months')) {
            $this->Flash->error('You are not authorized to delete this entry');
            return $this->redirect(['action' => 'get-registry-data', $id]);
        }
        if ($table->delete($entity)) {
            return $this->redirect(['action' => 'get-registry-data', $id]);
        }
    }

    public function filter($id) {
        $registry = $this->Registries->get($id, ['contain' => ['RegistryFields' => ['RegistryFieldExtras']]]);
        $lists = [];
        foreach ($registry->registry_fields as $field) {
            if (in_array($field->data_type, ['single', 'multiple'])) {
                //does it have its options list?
                if (strlen(trim($field->options)) == 0) {
                    $registryListId = $field->registry_field_extra->registry_list_id;
                    if (is_numeric($registryListId) && $registryListId > 0) {
                        if (!array_key_exists($registryListId, $lists)) {
                            $lists[$registryListId] = $this->Registries->getListData($registryListId);
                        }
                    } else {
                        //I'm confused!!!
                    }
                }
            }
        }
        if ($this->request->is('post')) {
            $columns = $this->Registries->getFields($this->request->getData('registry_id'));
            $data = $this->Registries->filter($this->request->getData());
            $this->set(compact('data', 'columns'));
        }
        $this->set(compact('registry', 'lists'));
    }

}
