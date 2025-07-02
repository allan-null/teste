<main class='col-md-9 ms-sm-auto col-lg-10 px-md-4'>
  <!-- Início do título -->
  <div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>
  <h1 class='h2'>Excluir funcionário de ID <?=$employee->id?>?</h1>
    <div class='btn-toolbar mb-2 mb-md-0'>
      <div class='btn-group me-2'>
        <a type='button' class='btn btn-sm btn-outline-primary' href='<?=$_config->baseURL?>/employee'>
          <i class='bi bi-list-ol' aria-hidden='true'></i> Voltar à listagem
        </a>
        <a type='button' class='btn btn-sm btn-outline-primary' href='<?=$_config->baseURL?>/employee/edit/<?=$employee->id?>'>
          <i class='bi bi-pencil-square' aria-hidden='true'></i> Visualizar dados do funcionário
        </a>
      </div>
    </div>
  </div>
  <!-- Término do título -->

  <a type='button' class='btn btn-sm btn-outline-danger' href='<?=$_config->baseURL?>/employee/delete/<?=$employee->id?>?confirmed'>
    <i class='bi bi-trash' aria-hidden='true'></i> Excluir
  </a>
  <a type='button' class='btn btn-sm btn-outline-primary' href='<?=$_config->baseURL?>/employee'>
    <i class='bi bi-arrow-left' aria-hidden='true'></i> Voltar
  </a>
</main>
