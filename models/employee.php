<?php
  /*
  * Classe de abstração do funcionário também parecido com
  * o Laravel.
  */

  namespace app\models;

  use \app\trait\validatable as validatable;

  class employee {
    # Utiliza a trait de validação de campos.
    use validatable;

    public ?int $id = null;
    public ?string $first_name = null;
    public ?string $last_name = null;
    public ?string $email = null;
    public ?string $department = null;
    public ?string $salary = null;
    public ?string $hire_date = null;

    # O método de construção recebe um argumento que poder ser tanto
    # um array quanto um inteiro. Se for um inteiro ele busca na base
    # de dados o ID correspondente. Se for um array um novo funcionário
    # é inicializado.
    public function __construct($employee) {
      global $_db;

      if(is_array($employee)) {
        foreach($employee as $k => $v) {
          $this->{$k} = $v;
        }
      }
      else {
        try {
          $stmt = $_db->prepare('SELECT * FROM employees WHERE id = ?');
          $stmt->bind_param(
            'i', $employee
          );
          $stmt->execute();
          $result = $stmt->get_result();
          if($result->num_rows === 1) {
            foreach($result->fetch_assoc() as $k => $v) {
              $this->{$k} = $v;
            }
          }
        }
        catch(exeception $e) {
          die($e->getmessage());
        }
      }
    }

    public function save() {
      global $_db;

      # Usando "prepared statements" do mysqli para prevenir injeções SQL.
      # Se o ID estiver preenchido, atualiza um registro existente. Se não,
      # insere um novo.
      try {
        if($this->id) {
          $stmt = $_db->prepare("
            UPDATE employees
            SET first_name = ?, last_name = ?, email = ?, department = ?,
              salary = ?, hire_date = ?
            WHERE id = ?
          ");
          $stmt->bind_param(
            'ssssdsi', $this->first_name, $this->last_name, $this->email, $this->department,
            $this->salary, $this->hire_date, $this->id
          );
        }
        else {
          $stmt = $_db->prepare("
            INSERT INTO employees(
              first_name, last_name, email, department, salary, hire_date
            )
            VALUES (?, ?, ?, ?, ?, ?);
          ");
          $stmt->bind_param(
            'ssssds', $this->first_name, $this->last_name, $this->email, $this->department,
            $this->salary, $this->hire_date
          );
        }

        $stmt->execute();
      }
      catch(exeception $e) {
        die($e->getmessage());
      }
    }

    # Exclui o registro da base referente ao objeto.
    public function delete() {
      global $_db;

      if($this->id) {
        try {
          $stmt = $_db->prepare("
            DELETE FROM employees WHERE id = ?
          ");
          $stmt->bind_param('i', $this->id);
          $stmt->execute();
        }
        catch(exeception $e) {
          die($e->getmessage());
        }
      }
    }

    # Busca todos os funcionários cadastrados.
    # Se o argumento "recentlyHired" estiver preenchido,
    # retorna os funcionários cadastrados nos últimos 6 meses.
    static public function all($recentlyHired = 0) {
      global $_db;

      try {
        $sql = 'SELECT * FROM employees';
        if($recentlyHired) {
          $sql .= ' WHERE hire_date > DATE_SUB(now(), INTERVAL 6 MONTH)';
        }

        $result = $_db->query($sql);
        if($result->num_rows > 0) {
          $employees = $result->fetch_all(MYSQLI_ASSOC);
        }
      }
      catch(exeception $e) {
        die($e->getmessage());
      }

      return (object) [
        'count' => $result->num_rows,
        'data' => $employees
      ];
    }

    # Busca o total dos salários de todos os departamentos.
    static public function getSalaryByDepartment() {
      global $_db;

      try {
        $result = $_db->query('
          SELECT department, SUM(salary) AS total_salary
          FROM employees
          GROUP BY department;
        ');
        if($result->num_rows > 0) {
          $departments = $result->fetch_all(MYSQLI_ASSOC);
        }
      }
      catch(exeception $e) {
        die($e->getmessage());
      }

      return (object) [
        'count' => $result->num_rows,
        'data' => $departments
      ];
    }

    # Aumento de salário em massa.
    # Aceita um número de argumento como percentual de aumento.
    static public function mass_rise($percentage, $department) {
      global $_db;

      $decimal = $percentage / 100;
      try {
        $stmt = $_db->prepare("
          UPDATE employees SET salary = (salary * $decimal + salary)
          WHERE department = ?
        ");
        $stmt->bind_param('s', $department);
        $stmt->execute();
      }
      catch(exeception $e) {
        die($e->getmessage());
      }

      return (object) [
        'count' => $result->num_rows,
        'data' => $departments
      ];
    }
  }
