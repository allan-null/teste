<?php

  /*
  * Essa e a controller do funcionário, e segue um padrão parecido
  * com as controller do Laravel.
  */ 

  namespace app\controllers;

  use \app\models\employee as employeeModel;

  class employee {
    # Carrega a listagem de funcionários.
    public function index() {

      # Carrega a view passando a lista de funcionários para ela.
      viewLoad('list_employees', [
        # Se a query string "recentlyHired" estiver preenchida, filtra
        # adiciona o argumento que filtra os funcionários recém contratados.
        'employees' => employeeModel::all(isset($_GET['recentlyHired']) ? 1 : 0)
      ]);  
    }

    # Carerga o formulário para adiconar um funcionário.
    public function new() {
      viewLoad('add_employee');  
    }

    # Carrega o formulário para editar um funcionário pelo ID.
    public function edit($id) {
      $employee = new employeeModel($id);

      # Se o ID não existir, retorna a páginad e 404.
      if(empty($employee->id)) {
        viewLoad('404');
      }
      else {
        viewLoad('edit_employee', [
          'employee' => $employee
        ]);
      }
    }

    # Exclui um funcionário pelo ID.
    public function delete($id) {
      global $_config;

      $employee = new employeeModel($id);

      # Se o ID não existir, retorna a páginad e 404.
      if(empty($employee->id)) {
        viewLoad('404');
      }
      else {
        # Checa se o usuário já passou pela página de confirmação
        # da ação.
        if(isset($_GET['confirmed'])) {
          $employee->delete();
          
          # Redireciona com mensagem de sucesso genérica.
          header('Location: ' . $_config->baseURL . '/employee?success');
          exit;
        }
        else {
          #Carrega a view.
          viewLoad('delete_employee', [
            'employee' => $employee
          ]);
        }
      }
    }

    # Adiciona ou atualiza os dados de um funcionários.
    public function save() {
      global $_config;

      # Definindo matriz com dados de entrada.
      $input = [
        'first_name' => $_POST['first_name'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'salary' => $_POST['salary'],
        'department' => $_POST['department'],
        'hire_date' => empty($_POST['hire_date']) ? null : $_POST['hire_date']
      ];

      # Definindo regras de validação.
      $validationRules = [
        'first_name' => 'required|max:50',
        'last_name' => 'required|max:50',
        'email' => "required|type:email|max:100|unique:employees,email",
        'salary' => 'required|type:decimal|format:10,2|max:11',
        'department' => 'required|max:50',
        'hire_date' => 'type:date|max:10',
      ];

      # Se o ID estiver vazio, insere um novo funcionário.
      if(empty($_POST['id'])) {
        # Instancia a classe com os dados entrados pelo usuário.
        $employee = new employeeModel($input);

        # Valida os dados entrados pelo usuário de acordo com as regras
        # definidas acima.
        $validatedResult = $employee->validate($validationRules);

        # Se não ouver erros de validação, salva o funcionário.
        if(empty(array_filter($validatedResult['errors']))) {
          $employee->save();

          # Redireciona com mensagem de sucesso genérica.
          header('Location: ' . $_config->baseURL . '/employee?success');
          exit;
        }
        else {
          # Carrega a view passando os dados do funcionário e
          # os erros de validação de cada campo.
          viewLoad('add_employee', [
            'employee' => $employee,
            'errors' => $validatedResult['errors']
          ]);  
        }
      }
      # Se o ID estiver preenchido, atualiza o funcionário
      else {
        # Carrega o funcionário baseado no ID.
        $employee = new employeeModel($_POST['id']);

        # Se o ID não existir, retorna a página de 404.
        if(empty($employee->id)) {
          viewLoad('404');
          exit;
        }
        else {
          foreach($input as $k => $v) {
            $employee->{$k} = $v;
          }

          # Valida os dados entrados pelo usuário de acordo com as regras
          # definidas acima.
          $validatedResult = $employee->validate($validationRules);

          # Se não ouver erros de validação, aualiza os dados e
          # salva o funcionário.
          if(empty(array_filter($validatedResult['errors']))) {
            $employee->save();

            # Redireciona com mensagem de sucesso genérica.
            header('Location: ' . $_config->baseURL . '/employee?success');
            exit;
          }
          else {
            # Carrega a view passando os dados do funcionário e
            # os erros de validação de cada campo.
            viewLoad('add_employee', [
              'employee' => $employee,
              'errors' => $validatedResult['errors']
            ]);  
          }
        }
      }
    }

    # Aumenta o salário de todos os funcionários em 5%
    public function mass_rise_5() {
      global $_config;

      # Checa se o usuário já passou pela página de confirmação
      # da ação.
      if(isset($_GET['confirmed'])) {
        employeeModel::mass_rise(5);
        header('Location: ' . $_config->baseURL . '/employee?success');
        exit;
      }
      else {
        viewLoad('mass_rise_employee', [
          'employee' => $employee
        ]);
      }
    }
  }
