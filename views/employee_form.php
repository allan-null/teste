<?php
  if(!empty($errors) && !empty(array_filter($errors))) {
?>
  <div class='alert alert-danger' role='alert'>
    Alguns itens precisam de atenção no formulário abaixo.
  </div>
<?php
  }
?>
<form method='post' action='<?=$formAction?>'>
  <input type='hidden' name='id' value='<?=$employee->id?>'>
  <div class='row mb-3'>
    <div class='col-lg-4 col-md-6'>
      <div class='form-group'>
        <label for='first_name'>Primeiro nome <sup class='text-danger'>*</sup></label>
        <input
          type='text'
          class='form-control<?=!empty($errors['first_name']) ? ' is-invalid' : ''?>'
          id='first_name'
          name='first_name'
          placeholder='Ex.: João'
          value='<?=$employee->first_name?>'
        >
        <div class="invalid-feedback">
          <?php
            foreach($errors['first_name'] as $v) {
              echo "<p class='m-0'>$v</p>";
            }
          ?>
        </div>
      </div>
    </div>
    <div class='col-lg-4 col-md-6'>
      <div class='form-group'>
        <label for='last_name'>Último sobrenome <sup class='text-danger'>*</sup></label>
        <input
          type='text'
          class='form-control<?=!empty($errors['last_name']) ? ' is-invalid' : ''?>'
          id='last_name'
          name='last_name'
          placeholder='Ex.: da Silva'
          value='<?=$employee->last_name?>'
        >
        <div class="invalid-feedback">
          <?php
            foreach($errors['last_name'] as $v) {
              echo "<p class='m-0'>$v</p>";
            }
          ?>
        </div>
      </div>
    </div>
    <div class='col-lg-4 col-md-6'>
      <div class='form-group'>
        <label for='email'>Endereço de e-mail <sup class='text-danger'>*</sup></label>
        <input
          type='email'
          class='form-control<?=!empty($errors['email']) ? ' is-invalid' : ''?>'
          id='email'
          name='email'
          placeholder='Ex.: joao@gmail.com'
          value='<?=$employee->email?>'
        >
        <div class="invalid-feedback">
          <?php
            foreach($errors['email'] as $v) {
              echo "<p class='m-0'>$v</p>";
            }
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class='row mb-3'>
    <div class='col-lg-6 col-md-6'>
      <div class='form-group'>
        <label for='department'>Departamento <sup class='text-danger'>*</sup></label>
        <input
          type='text'
          class='form-control<?=!empty($errors['department']) ? ' is-invalid' : ''?>'
          id='department'
          name='department'
          placeholder='Ex.: Recursos humanos'
          value='<?=$employee->department?>'
        >
        <div class="invalid-feedback">
          <?php
            foreach($errors['department'] as $v) {
              echo "<p class='m-0'>$v</p>";
            }
          ?>
        </div>
      </div>
    </div>
    <div class='col-lg-3 col-md-6'>
      <div class='form-group'>
        <label for='salary'>Salário <sup class='text-danger'>*</sup></label>
        <input
          type='number'
          class='form-control<?=!empty($errors['salary']) ? ' is-invalid' : ''?>'
          id='salary'
          name='salary'
          placeholder='Ex.: 2000,00'
          step='0.01'
          value='<?=$employee->salary?>'
        >
        <div class="invalid-feedback">
          <?php
            foreach($errors['salary'] as $v) {
              echo "<p class='m-0'>$v</p>";
            }
          ?>
        </div>
      </div>
    </div>
    <div class='col-lg-3 col-md-6'>
      <div class='form-group'>
        <label for='hire_date'>Data de contratação</label>
        <input
          type='date'
          class='form-control<?=!empty($errors['hire_date']) ? ' is-invalid' : ''?>'
          id='hire_date'
          name='hire_date'
          placeholder='Ex.: 01/06/2025'
          value='<?=$employee->hire_date?>'
        >
        <div class="invalid-feedback">
          <?php
            foreach($errors['hire_date'] as $v) {
              echo "<p class='m-0'>$v</p>";
            }
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class='row'>
    <small class='col-12 mb-3'><span class='text-danger'>*</span> Os campos marcados com asterísco são obrigatórios.</small>
  </div>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"></h1>
    <div class="btn-toolbar mb-2 mb-md-0 text-right">
      <button type='submit' class='btn btn-primary'>
        <i class='bi bi-floppy' aria-hidden='true'></i> Salvar
      </button>
      <a class='btn btn-secondary ms-2' href='<?=$resetAction?>'>
        <i class='bi bi-x-circle' aria-hidden='true'></i> Limpar
      </a>
    </div>
  </div>
</form>
