<?php
  # Carrega uma view.
  # O parâmetro $includeStructure indica se deve carregar o topo a o rodapé.
  function viewLoad($name, $variables = [], $includeStructure = true) {
    global $_config, $controller, $action;

    extract($variables);

    if($includeStructure) {
      include_once('../views/top.php');
      include_once('../views/sidebar.php');
    }

    include_once("../views/${name}.php");

    if($includeStructure) {
      include_once('../views/bottom.php');
    }
  }
