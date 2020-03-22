<?php

namespace MakvilleRegistry\Controller;

use MakvilleRegistry\Controller\AppController;

/**
 * RegistryFields Controller
 *
 * @property \Registry\Model\Table\RegistryFieldsTable $RegistryFields
 */
class RegistryFieldsController extends AppController {

    public $answerTypes = ['short' => 'Short Answer', 'long' => 'Long Answer', 'single' => 'Single choice from a list', 'multiple' => 'Multiple choices from a list', 'linear' => 'Linear scale'/*, 'grid' => 'Multiple choice grid'*/, 'date' => 'Date', 'time' => 'Time', 'number' => 'Number'];
    
    public function initialize(): void {
        parent::initialize();
    }
    
    public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event);
        /*$this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Headers', '*');
        $this->response->setHeader('Access-Control-Expose-Headers', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', '*');*/
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($registryId) {
        $this->paginate = [
            'conditions' => ['registry_id' => $registryId],
            'contain' => ['Registries'],
            'order' => ['position'],
            'limit' => 50
        ];
        $registryFields = $this->paginate($this->RegistryFields);
        $answerTypes = $this->answerTypes;
        $registry = $this->RegistryFields->Registries->get($registryId);
        $this->set(compact('registry', 'registryFields', 'answerTypes'));
        $this->set('_serialize', ['registryFields']);
    }

    /**
     * View method
     *
     * @param string|null $id Registry Field id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $registryField = $this->RegistryFields->get($id, [
            'contain' => ['Registries', 'RegistryFieldExtras']
        ]);

        $this->set('registryField', $registryField);
        $this->set('_serialize', ['registryField']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($registryId) {
        $registryField = $this->RegistryFields->newEmptyEntity();
        if ($this->request->is('post')) {
            $registryField = $this->RegistryFields->patchEntity($registryField, $this->request->getData());
            if ($this->RegistryFields->createRegistryField($registryField)) {
                $this->Flash->success(__('The registry field has been saved.'));

                return $this->redirect(['action' => 'index', $registryId]);
            } else {
                $this->Flash->error(__('The registry field could not be saved. Please, try again.'));
            }
        }
        $answerTypes = $this->answerTypes;
        $lists = $this->RegistryFields->Registries->getLists();
        $registry = $this->RegistryFields->Registries->get($registryId);
        $this->set(compact('registryField', 'registry', 'answerTypes', 'lists'));
        $this->set('_serialize', ['registryField']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Registry Field id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $registryId = null) {
        $registryField = $this->RegistryFields->get($id, [
            'contain' => ['RegistryFieldExtras']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            var_dump($this->request->getData());
            $registryField = $this->RegistryFields->patchEntity($registryField, $this->request->getData());
            if ($this->RegistryFields->editRegistryField($registryField)) {
                $this->Flash->success(__('The registry field has been saved.'));

                return $this->redirect(['action' => 'index', $registryId]);
            } else {
                $this->Flash->error(__('The registry field could not be saved. Please, try again.'));
            }
        }
        $registries = $this->RegistryFields->Registries->find('list', ['limit' => 200]);
        $answerTypes = $this->answerTypes;
        $lists = $this->RegistryFields->Registries->getLists();
        $registry = $this->RegistryFields->Registries->get($registryId);
        $this->set(compact('registryField', 'registries', 'registry', 'answerTypes', 'lists'));
        $this->set('_serialize', ['registryField']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Registry Field id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $registryField = $this->RegistryFields->get($id);
        if ($this->RegistryFields->delete($registryField)) {
            $this->Flash->success(__('The registry field has been deleted.'));
        } else {
            $this->Flash->error(__('The registry field could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function sort () {
        $this->viewBuilder()->layout('ajax');
        $registryId = $this->request->getQuery('registry_id');
        $order = $this->request->getQuery('order');
        $this->RegistryFields->sort($registryId, $order);
        $this->set(compact('status'));
        $this->set('_serialize', 'status');
        exit();
    }
}
