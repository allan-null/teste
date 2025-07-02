<?php
  /*
  * Copie esse arquivo para /config.php e o configure de acordo.
  */

  $_config = (object) [
    # Geral
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
