<?php

return [
  'db' => [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'name' => 'bdcuestionario',
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  ],
  'db.oracle' => [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'name' => 'tutorial_crud',
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  ],
  'db.postgresql' => [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'name' => 'tutorial_crud',
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  ]
];