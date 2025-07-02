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
  $route = array_values(array_filter(explode('/', $uri[0])));

  # Seleciona a controller
  if(empty($route[0])) {
    $controller = $_config->defaultController;
  }
  else {
    $controller = $route[0];
  }
  $controller = preg_replace('/[^a-zA-Z0-9_]/', '', $controller);

  $class = "\\app\\controllers\\$controller";

  # Checa se a classe existe.
  if(class_exists($class)) {
    $controllerInstance = new $class();

    # Seleciona a ação
    if(empty($route[1])) {
      $action = $_config->defaultAction;
    }
    else {
      $action = $route[1];
    }
    $action = preg_replace('/[^a-zA-Z0-9_]/', '', str_replace('-', '_', $action));

    # Checa se a função da classe existe.
    if(is_callable([ $controllerInstance, $action ])) {
      $controllerInstance->$action(isset($route[2]) ? $route[2] : null);
    }
    else {
      viewLoad('404');
    }
  }
  else {
    viewLoad('404');
  }
