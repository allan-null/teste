<?php
  # Inicializa a conexão com a base de dados MySQL
  # como definido no arquivo de configuração.
  try {
    $_db = new mysqli(
      $_config->db->host,
      $_config->db->user,
      $_config->db->password,
      $_config->db->db,
      $_config->db->port
    );
  }
  catch(Exception $e) {
    die($e->getMessage());
  }
