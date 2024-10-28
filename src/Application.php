<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

 namespace App;

 use Authentication\AuthenticationService;
 use Authentication\AuthenticationServiceInterface;
 use Authentication\AuthenticationServiceProviderInterface;
 use Authentication\Middleware\AuthenticationMiddleware;
 use Cake\Core\Configure;
 use Cake\Core\Exception\MissingPluginException;
 use Cake\Error\Middleware\ErrorHandlerMiddleware;
 use Cake\Http\BaseApplication;
 use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Middleware\AssetMiddleware;
 use Cake\Routing\Middleware\RoutingMiddleware;
 use Psr\Http\Message\ResponseInterface;
 use Psr\Http\Message\ServerRequestInterface;
 use Cake\Routing\Router;

 class Application extends BaseApplication implements AuthenticationServiceProviderInterface//, AuthorizationServiceProviderInterface
 {
     /**
      * {@inheritDoc}
      */
     public function bootstrap()
     {
         // Call parent to load bootstrap from files.
         parent::bootstrap();
 
         if (PHP_SAPI === 'cli') {
             $this->bootstrapCli();
         }
 
         if (Configure::read('debug')) {
             $this->addPlugin('DebugKit');
         }
 
         $this->addPlugin('Authentication');
     }
 
     /**
      * Setup the middleware queue your application will use.
      *
      * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
      * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
      */
     public function middleware($middlewareQueue)
     {
        
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(null, Configure::read('Error')))
            ->add(new AssetMiddleware(['cacheTime' => Configure::read('Asset.cacheTime')]))
            ->add(new BodyParserMiddleware())
            // Add the AuthenticationMiddleware. It should be after routing and body parser.
            ->add(new AuthenticationMiddleware($this, [
                'requireIdentity' => false, // Disable identity requirement globally
                'unauthenticatedRedirect' => false, // Disable redirect for unauthenticated requests
                'skipCheckCallback' => function ($request) {
                    // Skip identity check for API routes
                    return strpos($request->getParam('prefix'), 'Api') !== false;
                }
            ]))
            ->add(new RoutingMiddleware($this));
            
            
            //  $csrf = new CsrfProtectionMiddleware();
            //  $csrf->whitelistCallback(function ($request) {
            //      if ($request->getParam('prefix') === 'Api') {

            //     return true;
            // }
            //  });
    
            //  $middlewareQueue->add($csrf);
        return $middlewareQueue;
    }
 
     /**
      * Crear y configurar el servicio de autenticación.
      *
      * @return AuthenticationServiceInterface
      */
    //   protected function createAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    //   {
          
  
    //       // $service = new AuthenticationService([
    //       //     'unauthenticatedRedirect' => '/users/login',
    //       //     'queryParam' => 'redirect',
    //       // ]);
  
    //       $service = new AuthenticationService();
  
    //       $fielSeting = [
    //           'username' => 'username',
    //           'password' => 'password',
    //       ];
  
    //       $service->loadIdentifier(
    //           'Authentication.Password',
    //           [
    //               'fields' => $fielSeting,
    //               'returnPayload' => false
    //           ]
    //       );
  
    //       $service->loadAuthenticator('Authentication.Form',  ['fields' => $fielSeting]);
  
  
    //       if (
    //           strpos($request->getParam('prefix') ?? "", 'Api') !== false
    //       ) {
  
    //           // ...
    //           $service->loadIdentifier('Authentication.JwtSubject');
    //           $service->loadAuthenticator('Authentication.Jwt', [
    //               'secretKey' => file_get_contents(CONFIG . '/jwt.pem'),
    //               'algorithm' => 'RS256',
    //               'returnPayload' => false
    //           ]);
    //       } else {
  
    //           $service->loadAuthenticator('Authentication.Session');
    //       }
  
    //       return  $service;
    //   }

      public function getAuthenticationService(ServerRequestInterface $request,ResponseInterface $response): AuthenticationServiceInterface
      {
  
          // $service = new AuthenticationService([
          //     'unauthenticatedRedirect' => '/users/login',
          //     'queryParam' => 'redirect',
          // ]);
  
          $service = new AuthenticationService();
  
          $fieldSetting = [
              'username' => 'username',
              'password' => 'password',
          ];
  
          $service->loadIdentifier(
            'Authentication.Password',
            [
                'fields' => $fieldSetting,
                'returnPayload' => false,
                'resolver' => [
                    'className' => 'Authentication.Orm',
                    'userModel' => 'Usuarios', // Especifica el modelo 'Usuarios'
                ],
            ]
        );
  
          $service->loadAuthenticator('Authentication.Form',  ['fields' => $fieldSetting]);
  
  
          if (
              strpos($request->getParam('prefix') ?? "", 'Api') !== false
          ) {
  
              // ...
              $service->loadIdentifier('Authentication.JwtSubject');
              $service->loadAuthenticator('Authentication.Jwt', [
                  'secretKey' => file_get_contents(CONFIG . '/jwt.pem'),
                  'algorithm' => 'RS256',
                  'returnPayload' => false
              ]);
          } else {
  
              $service->loadAuthenticator('Authentication.Session');
          }
  
          return  $service;
      }
     /**
      * @return void
      */
     protected function bootstrapCli()
     {
         try {
             $this->addPlugin('Bake');
         } catch (MissingPluginException $e) {
             // Do not halt if the plugin is missing
         }
 
         $this->addPlugin('Migrations');
     }
 }
 












//  namespace App;

// use Cake\Core\Configure;
// use Cake\Core\Exception\MissingPluginException;
// use Cake\Error\Middleware\ErrorHandlerMiddleware;
// use Cake\Http\BaseApplication;
// use Cake\Http\Middleware\BodyParserMiddleware;
// use Cake\Routing\Middleware\AssetMiddleware;
// use Cake\Routing\Middleware\RoutingMiddleware;


// /**
//  * Application setup class.
//  *
//  * This defines the bootstrapping logic and middleware layers you
//  * want to use in your application.
//  */
// class Application extends BaseApplication
// {
//     /**
//      * {@inheritDoc}
//      */
//     public function bootstrap()
//     {
//         // Call parent to load bootstrap from files.
//         parent::bootstrap();

//         if (PHP_SAPI === 'cli') {
//             $this->bootstrapCli();
//         }

//         /*
//          * Only try to load DebugKit in development mode
//          * Debug Kit should not be installed on a production system
//          */
//         if (Configure::read('debug')) {
//             $this->addPlugin('DebugKit');
//         }

//         // Load more plugins here
//         $this->addPlugin('Authentication');
//     }

//     /**
//      * Setup the middleware queue your application will use.
//      *
//      * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
//      * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
//      */
//     public function middleware($middlewareQueue)
//     {
//         $middlewareQueue

//             // Catch any exceptions in the lower layers,
//             // and make an error page/response
//             ->add(new ErrorHandlerMiddleware(null, Configure::read('Error')))

//             // Handle plugin/theme assets like CakePHP normally does.
//             ->add(new AssetMiddleware([
//                 'cacheTime' => Configure::read('Asset.cacheTime'),
//             ]))
            
//             ->add(new BodyParserMiddleware())
//             ->add(new \Authentication\Middleware\AuthenticationMiddleware($this))

//             // Add routing middleware.
//             // If you have a large number of routes connected, turning on routes
//             // caching in production could improve performance. For that when
//             // creating the middleware instance specify the cache config name by
//             // using it's second constructor argument:
//             // `new RoutingMiddleware($this, '_cake_routes_')`
//             ->add(new RoutingMiddleware($this));

//         return $middlewareQueue;
//     }

//     /**
//      * @return void
//      */
//     protected function bootstrapCli()
//     {
//         try {
//             $this->addPlugin('Bake');
//         } catch (MissingPluginException $e) {
//             // Do not halt if the plugin is missing
//         }

//         $this->addPlugin('Migrations');

//         // Load more plugins here
//     }
// }
