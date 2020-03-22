<?php
namespace MakvilleRegistry\Controller;

use MakvilleRegistry\Controller\AppController;

/**
 * RegistryFieldExtras Controller
 *
 * @property \Registry\Model\Table\RegistryFieldExtrasTable $RegistryFieldExtras
 */
class RegistryFieldExtrasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['RegistryFields']
        ];
        $registryFieldExtras = $this->paginate($this->RegistryFieldExtras);

        $this->set(compact('registryFieldExtras'));
        $this->set('_serialize', ['registryFieldExtras']);
    }

    /**
     * View method
     *
     * @param string|null $id Registry Field Extra id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $registryFieldExtra = $this->RegistryFieldExtras->get($id, [
            'contain' => ['RegistryFields']
        ]);

        $this->set('registryFieldExtra', $registryFieldExtra);
        $this->set('_serialize', ['registryFieldExtra']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $registryFieldExtra = $this->RegistryFieldExtras->newEmptyEntity();
        if ($this->request->is('post')) {
            $registryFieldExtra = $this->RegistryFieldExtras->patchEntity($registryFieldExtra, $this->request->getData());
            if ($this->RegistryFieldExtras->save($registryFieldExtra)) {
                $this->Flash->success(__('The registry field extra has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The registry field extra could not be saved. Please, try again.'));
            }
        }
        $registryFields = $this->RegistryFieldExtras->RegistryFields->find('list', ['limit' => 200]);
        $this->set(compact('registryFieldExtra', 'registryFields'));
        $this->set('_serialize', ['registryFieldExtra']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Registry Field Extra id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $registryFieldExtra = $this->RegistryFieldExtras->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $registryFieldExtra = $this->RegistryFieldExtras->patchEntity($registryFieldExtra, $this->request->getData());
            if ($this->RegistryFieldExtras->save($registryFieldExtra)) {
                $this->Flash->success(__('The registry field extra has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The registry field extra could not be saved. Please, try again.'));
            }
        }
        $registryFields = $this->RegistryFieldExtras->RegistryFields->find('list', ['limit' => 200]);
        $this->set(compact('registryFieldExtra', 'registryFields'));
        $this->set('_serialize', ['registryFieldExtra']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Registry Field Extra id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $registryFieldExtra = $this->RegistryFieldExtras->get($id);
        if ($this->RegistryFieldExtras->delete($registryFieldExtra)) {
            $this->Flash->success(__('The registry field extra has been deleted.'));
        } else {
            $this->Flash->error(__('The registry field extra could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
