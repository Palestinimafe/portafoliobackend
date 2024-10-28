<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Table\HabilidadesTable;
use Cake\Datasource\ModelAwareTrait;

/**
 * Habilidades Controller
 *
 * @method \App\Model\Entity\Habilidade[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HabilidadesController extends AppController
{
    use ModelAwareTrait;
    private $Habilidades;
    
    public function initialize()
    {
        parent::initialize();
        $this->Habilidades = $this->loadModel("Habilidades");

    }
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['index']);
    }
    public function index()
    {
        $habilidades = $this->Habilidades->find();
        
        // $this->set('habilidades', $habilidades);

        $this->viewBuilder()->setClassName('Json');
        $this->set(['habilidades' => $habilidades,'_serialize' => ['habilidades']]);
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
        $id = (int)$id;
        $habilidad = $this->Habilidades->get($id, [
            'contain' => ['Usuarios'],
        ]);
        $this->viewBuilder()->setClassName('Json');

        $this->set( ['habilidad' => $habilidad,'_serialize' => ['habilidad']]);
    }

       public function add()
    {
        $this->request->allowMethod(['post']);
        $habilidad = $this->Habilidades->newEntity();
        $habilidad = $this->Habilidades->patchEntity($habilidad, $this->request->getParsedBody());
        if ($this->Habilidades->save($habilidad)) {
            $this->viewBuilder()->setClassName('Json');
            $this->set( ['mensaje' => 'Guardado','_serialize' => ['mensaje']]);

        } else {
            $this->viewBuilder()->setClassName('Json');
            $this->set( ['mensaje' => 'Error','_serialize' => ['mensaje']]);
        }
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
            $this->viewBuilder()->setClassName('Json');
            $this->set( ['mensaje' => 'Guardado','_serialize' => ['mensaje']]);

        } else {
            $this->viewBuilder()->setClassName('Json');
            $this->set( ['mensaje' => 'Error','_serialize' => ['mensaje']]);
        }

    }
}
