<?php

namespace MakvilleRegistry\Controller;

use MakvilleRegistry\Controller\AppController;

/**
 * RegistryLists Controller
 *
 * @property \Registry\Model\Table\RegistryListsTable $RegistryLists
 */
class RegistryListsController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $registryLists = $this->paginate($this->RegistryLists);

        $this->set(compact('registryLists'));
        $this->set('_serialize', ['registryLists']);
    }

    /**
     * View method
     *
     * @param string|null $id Registry List id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $registryList = $this->RegistryLists->get($id, [
            'contain' => []
        ]);

        $this->set('registryList', $registryList);
        $this->set('_serialize', ['registryList']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $registryList = $this->RegistryLists->newEmptyEntity();
        if ($this->request->is('post')) {
            $registryList = $this->RegistryLists->patchEntity($registryList, $this->request->getData());
            if ($this->RegistryLists->createRegistryList($registryList)) {
                $this->Flash->success(__('The registry list has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The registry list could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('registryList'));
        $this->set('_serialize', ['registryList']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Registry List id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $registryList = $this->RegistryLists->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $registryList = $this->RegistryLists->patchEntity($registryList, $this->request->getData());
            if ($this->RegistryLists->save($registryList)) {
                $this->Flash->success(__('The registry list has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The registry list could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('registryList'));
        $this->set('_serialize', ['registryList']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Registry List id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $registryList = $this->RegistryLists->get($id);
        if ($this->RegistryLists->delete($registryList)) {
            $this->Flash->success(__('The registry list has been deleted.'));
        } else {
            $this->Flash->error(__('The registry list could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function entries($id) {
        $list = $this->RegistryLists->get($id);
        $locator = \Cake\ORM\TableRegistry::getTableLocator();
        $table = $locator->get(\Cake\Utility\Inflector::camelize($list->db_name));
        $data = $table->find('all');
        $this->set(compact('list', 'data'));
    }

    public function newEntry($id) {
        if ($this->request->is('post')) {
            $list = $this->RegistryLists->get($id);
            $locator = \Cake\ORM\TableRegistry::getTableLocator();
            $table = $locator->get(\Cake\Utility\Inflector::camelize($list->db_name));
            $entry = $table->newEntity($this->request->getData());
            if ($table->save($entry)) {
                $this->Flash->success('Entry saved successfully');
                return $this->redirect(['action' => 'entries', $id]);
            } else {
                $this->Flash->error('Entry can not be saved');
            }
        }
    }

    public function editEntry ($id, $entryId) {
        $list = $this->RegistryLists->get($id);
        $locator = \Cake\ORM\TableRegistry::getTableLocator();
        $table = $locator->get(\Cake\Utility\Inflector::camelize($list->db_name));
        $entry = $table->get($entryId);
        $data = $this->request->getData();
        if (count($data) > 0) {
            $entry = $table->patchEntity($entry, $this->request->getData());
            if ($table->save($entry)) {
                $this->Flash->success('Entry saved successfully');
                return $this->redirect(['action' => 'entries', $id]);
            } else {
                $this->Flash->error('Entry can not be saved');
            }
        }
        $this->set(compact('entry'));
    }
    
    public function deleteEntry ($id, $entryId) {
        $list = $this->RegistryLists->get($id);
        $locator = \Cake\ORM\TableRegistry::getTableLocator();
        $table = $locator->get(\Cake\Utility\Inflector::camelize($list->db_name));
        $entry = $table->get($entryId);
        if($this->request->is('post')) {
            if ($table->delete($entry)) {
                $this->Flash->success('Entry deleted successfully');
                return $this->redirect(['action' => 'entries', $id]);
            } else {
                $this->Flash->error('Entry can not be deleted');
            }
        }
    }
}
