<main class='col-md-9 ms-sm-auto col-lg-10 px-md-4'>
  <!-- Início do título -->
  <div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>
    <h1 class='h2'>Listagem de funcionários<?=(isset($_GET['recentlyHired']) ? ' contratados nos últimos 6 meses' : '')?></h1>
    <div class='btn-toolbar mb-2 mb-md-0'>
      <div class='btn-group me-2'>
      <?php
        if(isset($_GET['recentlyHired'])) {
      ?>
        <a type='button' class='btn btn-sm btn-outline-primary' href='<?=$_config->baseURL?>/employee'>
          <i class='bi bi-list-ol' aria-hidden='true'></i> Ver todos
        </a>
      <?php
        }
      ?>
        <a type='button' class='btn btn-sm btn-outline-primary' href='<?=$_config->baseURL?>/employee/new'>
          <i class='bi bi-plus-lg' aria-hidden='true'></i> Adicionar
        </a>
      </div>
    </div>
  </div>
  <!-- Término do título -->

<?php
  if(isset($_GET['success'])) {
?>
  <div class='alert alert-success' role='alert'>
    Ação realizada com sucesso!
  </div>
<?php
  }
?>

  <!-- Início da tabela -->
  <table class='table table-striped'>
    <thead>
      <tr>
        <th scope='col'>ID</th>
        <th scope='col'>Primeiro nome</th>
        <th scope='col'>Segundo nome</th>
        <th scope='col'>E-mail</th>
        <th scope='col'>Salário</th>
        <th scope='col'>Departamento</th>
        <th scope='col'>Data de contrato</th>
        <th scope='col'>Ações</th>
      </tr>
    </thead>
    <tbody>
<?php 
    if($employees->count > 0) {
      foreach($employees->data as $employee) {
?>
      <tr>
        <th scope='row'><?=htmlspecialchars($employee['id'])?></th>
        <td><?=htmlspecialchars($employee['first_name'])?></td>
        <td><?=htmlspecialchars($employee['last_name'])?></td>
        <td><?=htmlspecialchars($employee['email'])?></td>
        <td>R$ <?=number_format($employee['salary'], 2, ',', '.')?></td>
        <td><?=htmlspecialchars($employee['department'])?></td>
        <td>
          <?=(empty($employee['hire_date']) ? '' : (
            new DateTimeImmutable($employee['hire_date'])
          )->format('d/m/Y'))?>
        </td>
        <td>
          <a type='button' class='btn btn-sm btn-outline-primary' href='<?=$_config->baseURL?>/employee/edit/<?=$employee['id']?>'>
            <i class='bi bi-pencil-square' aria-hidden='true'></i> Editar
          </a>
          <a type='button' class='btn btn-sm btn-outline-danger' href='<?=$_config->baseURL?>/employee/delete/<?=$employee['id']?>'>
            <i class='bi bi-trash' aria-hidden='true'></i> Excluir
          </a>
        </td>
      </tr>
<?php
        }
    }
    else {
      echo '<tr><td colspan="8">Nenhum funcionário encontrado.</td></tr>';
    }
?>
    </tbody>
  </table>
  <!-- Fim da tabela -->

<?php
  if(!isset($_GET['recentlyHired'])) {
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2"></h1>
  <div class="btn-toolbar mb-2 mb-md-0 text-right">
    <div class="btn-group me-2">
    </div>
  </div>
</div>
<?php
  }
?>
</main>
