<?php
return [

  'default' => 'main',

  'connections' => [

    'main' => [
      'salt' => env('HASHIDS_SALT', 'repository-uniba-madura'),
      'length' => 12,
      'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
    ],

  ],
];
