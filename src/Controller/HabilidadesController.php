<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Habilidades Controller
 *
 * @property \App\Model\Table\HabilidadesTable $Habilidades
 *
 * @method \App\Model\Entity\Habilidade[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HabilidadesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $habilidades = $this->paginate($this->Habilidades);

        $this->set([
            'habilidades' => $habilidades,
            '_serialize' => ['habilidades']
        ]);
    }

    /**
     * View method
     *
     * @param string|null $id Habilidade id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $habilidade = $this->Habilidades->get($id, [
            'contain' => ['Usuarios'],
        ]);

        $this->set('habilidade', $habilidade);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $habilidade = $this->Habilidades->newEntity();
        if ($this->request->is('post')) {
            $habilidade = $this->Habilidades->patchEntity($habilidade, $this->request->getData());
            if ($this->Habilidades->save($habilidade)) {
                $this->Flash->success(__('The habilidade has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The habilidade could not be saved. Please, try again.'));
        }
        $usuarios = $this->Habilidades->Usuarios->find('list', ['limit' => 200]);
        $this->set(compact('habilidade', 'usuarios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Habilidade id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $habilidade = $this->Habilidades->get($id, [
            'contain' => ['Usuarios'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $habilidade = $this->Habilidades->patchEntity($habilidade, $this->request->getData());
            if ($this->Habilidades->save($habilidade)) {
                $this->Flash->success(__('The habilidade has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The habilidade could not be saved. Please, try again.'));
        }
        $usuarios = $this->Habilidades->Usuarios->find('list', ['limit' => 200]);
        $this->set(compact('habilidade', 'usuarios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Habilidade id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $habilidade = $this->Habilidades->get($id);
        if ($this->Habilidades->delete($habilidade)) {
            $this->Flash->success(__('The habilidade has been deleted.'));
        } else {
            $this->Flash->error(__('The habilidade could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
