<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Firebase\JWT\JWT;

/**
 * Usuarios Controller
 *
 * @property \App\Model\Table\UsuariosTable $Usuarios
 *
 * @method \App\Model\Entity\Usuario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsuariosController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setClassName('Json');
    }
    
     public function beforeFilter(\Cake\Event\EventInterface $event)
     {
         parent::beforeFilter($event);
         // Configure the login action to not require authentication, preventing
         // the infinite redirect loop issue
         $this->Authentication->addUnauthenticatedActions(['login', 'index']);
     }
     
     /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
     public function index()
    {
        $usuarios = $this->paginate($this->Usuarios);

        $this->set(compact('usuarios'));
    }

    /**
     * View method
     *
     * @param string|null $id Usuario id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usuario = $this->Usuarios->get($id, [
            'contain' => ['Habilidades'],
        ]);

        $this->set('usuario', $usuario);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usuario = $this->Usuarios->newEntity();
        if ($this->request->is('post')) {
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->getData());
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success(__('The usuario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The usuario could not be saved. Please, try again.'));
        }
        $habilidades = $this->Usuarios->Habilidades->find('list', ['limit' => 200]);
        $this->set(compact('usuario', 'habilidades'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Usuario id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usuario = $this->Usuarios->get($id, [
            'contain' => ['Habilidades'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->getData());
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success(__('The usuario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The usuario could not be saved. Please, try again.'));
        }
        $habilidades = $this->Usuarios->Habilidades->find('list', ['limit' => 200]);
        $this->set(compact('usuario', 'habilidades'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Usuario id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usuario = $this->Usuarios->get($id);
        if ($this->Usuarios->delete($usuario)) {
            $this->Flash->success(__('The usuario has been deleted.'));
        } else {
            $this->Flash->error(__('The usuario could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $privateKey = file_get_contents(CONFIG . '/jwt.key');
            $user = $result->getData();
            $payload = [
                'iss' => 'myapp',
                'sub' => $user->id,
                'exp' => time() + 60,
            ];
            $json = [
                'token' => JWT::encode($payload, $privateKey, 'RS256'),
            ];
            $success = true;
        } else {
            $this->response = $this->response->withStatus(401);
            $json = [];
            $success = false;
        }
        $this->set([
                         'json' => $json,
                         'success'=> $success,
                         '_serialize' => ['json','success']
                 ]);
    }

    // public function login()
    // {
    //     $this->request->allowMethod(['post']);
    
    //     $result = $this->Authentication->getResult();
    
    //     if ($result->isValid()) {
    //         $user = $result->getData();
    //         $this->set([
    //             'success' => true,
    //             'user' => $user,
    //             '_serialize' => ['success', 'user']
    //         ]);
    //     } else {
    //         $this->response = $this->response->withStatus(401);
    //         $this->set([
    //             'success' => false,
    //             'message' => 'Invalid username or password',
    //             '_serialize' => ['success', 'message']
    //         ]);
    //     }
    // }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->response->withType('application/json')->withStringBody(json_encode(['success' => true, 'message' => 'Logout exitoso']));
    }
}
