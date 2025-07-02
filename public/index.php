<?php
  namespace app;

  # Carrega as configurações.
  require_once('../config.php');

  # Carrega os arquivos necessários.
  require_once('../helpers/functions.php');
  require_once('../helpers/database.php');
  require_once('../helpers/validatable.trait.php');
  require_once('../models/employee.php');
  require_once('../controllers/employee.php');
  require_once('../controllers/report.php');

  # Interpretando as rotas
  $uri = explode('?', $_SERVER['REQUEST_URI']);
  $route = explode('/', $uri[0]);

  # Seleciona a controller
  if(empty($route[1])) {
    $controller = $_config->defaultController;
  }
  else {
    $controller = $route[1];
  }
  $controller = preg_replace('/[^a-zA-Z0-9_]/', '', $controller);

  $class = "\\app\\controllers\\$controller";

  # Checa se a classe existe.
  if(class_exists($class)) {
    $controllerInstance = new $class();

    # Seleciona a ação
    if(isset($route[2])) {
      $action = $route[2];
    }
    else {
      $action = $_config->defaultAction;
    }
    $action = preg_replace('/[^a-zA-Z0-9_]/', '', str_replace('-', '_', $action));

    # Checa se a função da classe existe.
    if(is_callable([ $controllerInstance, $action ])) {
      $controllerInstance->$action(isset($route[3]) ? $route[3] : null);
    }
    else {
      viewLoad('404');
    }
  }
  else {
    viewLoad('404');
  }
