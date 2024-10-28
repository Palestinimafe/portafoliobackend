return [
    'Authentication' => [
        'default' => [
            'identifier' => [
                'className' => 'Authentication.Password',
                'fields' => [
                    'username' => 'username',
                    'password' => 'password',
                ],
                'resolver' => [
                    'className' => 'Authentication.Orm',
                    'userModel' => 'Usuarios',
                ],
            ],
            'authenticators' => [
                'Authentication.Session',
                'Authentication.Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password',
                    ],
                    'loginUrl' => '/login',
                ],
            ],
        ],
    ],
];
