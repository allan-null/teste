<?php
  namespace app\controllers;

  use \app\models\employee as employeeModel;

  class report {
    # Gera a tabela de salário por departamento.
    public function salary_by_department() {
      viewLoad('list_departments', [
        'departments' => employeeModel::getSalaryByDepartment()
      ]);  
    }
  }
