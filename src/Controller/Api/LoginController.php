<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;

class LoginController extends AppController
{
 //   public function initialize(): void
    // {
    //     parent::initialize();
    //     $this->loadComponent('Authentication.Authentication');
    // }

    /**
     * Método de inicio de sesión
     */
    public function login()
    {
        $this->request->allowMethod(['post']);
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $user = $result->getData();
            $this->set([
                'success' => true,
                'user' => $user,
                '_serialize' => ['success', 'user']
            ]);
        } else {
            $this->response = $this->response->withStatus(401);
            $this->set([
                'success' => false,
                'message' => 'Invalid username or password',
                '_serialize' => ['success', 'message']
            ]);
        }        
    }

    /**
     * Método para cerrar sesión
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            // Cerrar sesión del usuario
            $this->Authentication->logout();
            return $this->redirect('/'); // Redirigir al inicio
        }
    }
}
