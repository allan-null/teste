<?php
  /*
  * Trait de abstração da validação de formulário.
  */

  namespace app\trait;

  trait validatable {
    public array $rules;

    # Regras válidas
    private array $validRules = [
      'required', 'type', 'max', 'unique'
    ];

    # Normaliza as regras e as salva em uma matriz.
    # As regras de validação seguem o estilo Laravel. Ex.:
    # required|type:decimal|format:10,2|max:11
    private function parseRules($rules) {
      $parsedRules = [];

      foreach($rules as $k => $v) {
        $parsedRules[$k] = [];

        $splitRules = explode('|', $v);
        foreach($splitRules as $k2 => $v2) {
          $splitRule = explode(':', $v2);

          if(!empty($splitRule[0])) {
            $parsedRules[$k][$splitRule[0]] = isset($splitRule[1]) ? $splitRule[1]: true;
          }
        }
      }

      return $parsedRules;
    }

    # Validação das regras
    public function validate($rules) {
      global $_db;

      $errors = [];

      $parsedRules = $this->parseRules($rules);
      foreach($parsedRules as $k => $v) {
        $errors[$k] = [];

        # Obrigatoriedade
        if(isset($v['required']) && empty($this->{$k})) {
          array_push($errors[$k], 'Esse item é obrigatório.');
        }

        # Tipo
        if(isset($v['type'])) {
          switch($v['type']) {
            case 'email':
              if(!empty($this->{$k}) && !filter_var($this->{$k}, FILTER_VALIDATE_EMAIL)) {
                array_push($errors[$k], 'Esse item não é um e-mail válido.');
              }
            break;
            case 'decimal':
              $formatSplit = explode(',', $v['format']);
              if(!empty($this->{$k}) && (
                floatval($this->{$k}) != $this->{$k}
                || strlen(str_replace('.', '', $this->{$k})) > $formatSplit[0]
                || strlen(explode('.', $this->{$k})[1]) > $formatSplit[1]
              )) {
                array_push($errors[$k], 'Esse item não é um decimal válido.');
              }
            break;
            case 'date':
              $format = 'Y-m-d';
              $d = new \DateTime($this->{$k});
              if(!empty($this->{$k}) && (!$d || $d->format($format) != $this->{$k})) {
                array_push($errors[$k], 'Esse item não é uma data válida.');
              }
            break;
          }
        }
        
        # Limite de caracteres
        if(isset($v['max']) && strlen($this->{$k}) > $v['max']) {
          array_push($errors[$k], "Esse item ultrapassou o limite máximo de ${v['max']} caracteres.");
        }
        
        # Único
        if(isset($v['unique'])) {
          $argSplit = explode(',', $v['unique']);

            $sql = 'SELECT id FROM '.  $argSplit[0] . ' WHERE ' . $argSplit[1] . ' = ?';
            if(empty($this->id)) {
              $stmt = $_db->prepare($sql);
              $stmt->bind_param(
                's', $this->{$k}
              );
            }
            else {
              $sql .= ' AND id != ?';
              $stmt = $_db->prepare($sql);
              $stmt->bind_param(
                'si', $this->{$k}, $this->id
              );
            }

          try {
            $stmt->execute();
            $result = $stmt->get_result();
          }
          catch(mysqli_sql_exception $e) {
            die($e->getmessage());
          }
          if($result->num_rows > 0) {
            array_push($errors[$k], 'Esse item já se encontra cadastrado em nossa base de dados.');
          }
        }
      }

      # Retorna os erros e as regras.
      return [
        'rules' => $parsedRules,
        'errors' => $errors
      ];
    }
  }
