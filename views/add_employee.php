<main class='col-md-9 ms-sm-auto col-lg-10 px-md-4'>
  <!-- Início do título -->
  <div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>
    <h1 class='h2'>Adicionar funcionário</h1>
    <div class='btn-toolbar mb-2 mb-md-0'>
      <div class='btn-group me-2'>
        <a type='button' class='btn btn-sm btn-outline-primary' href='<?=$_config->baseURL?>/employee'>
          <i class='bi bi-list-ol' aria-hidden='true'></i> Voltar à listagem
        </a>
      </div>
    </div>
  </div>
  <!-- Término do título -->

<?php
  viewLoad('employee_form', [
    'formAction' => $_config->baseURL . '/employee/save',
    'resetAction' => $_config->baseURL . '/employee/new',
    'employee' => $employee,
    'errors' => $errors,
  ], false);
