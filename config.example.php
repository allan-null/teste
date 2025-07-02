<?php
  /*
  * Copie esse arquivo para /config.php e o configure de acordo.
  */

  $_config = (object) [
    # Geral
    'baseURL' => 'http://127.0.0.1:8080', # URL base para carregar os assets
    'title' => 'Teste', # Nome do site
    'defaultController' => 'employee', # Controller padrão
    'defaultAction' => 'index', # Ação padrão

    # Base de dados
    'db' => (object) [
      'host' => 'localhost',
      'db' => 'company',
      'user' => 'root',
      'password' => '',
      'port' => 3306
    ],
  ];
