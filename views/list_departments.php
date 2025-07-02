<main class='col-md-9 ms-sm-auto col-lg-10 px-md-4'>
  <!-- Início do título -->
  <div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>
    <h1 class='h2'>Listagem de departamentos</h1>
  </div>
  <!-- Término do título -->

  <!-- Início da tabela -->
  <table class='table table-striped'>
    <thead>
      <tr>
        <th scope='col'>Departamento</th>
        <th scope='col'>Salário total</th>
        <th scope='col'>Ações</th>
      </tr>
    </thead>
    <tbody>
<?php 
    if($departments->count > 0) {
      foreach($departments->data as $employee) {
?>
      <tr>
        <td><?=htmlspecialchars($employee['department'])?></td>
        <td>R$ <?=number_format($employee['total_salary'], 2, ',', '.')?></td>
        <td>
          <form method='post' action='<?=$_config->baseURL?>/employee/mass-rise-5'>
            <input type='hidden' name='department' value='<?=htmlspecialchars($employee['department'])?>'>
            <button type='submit' class='btn btn-sm btn-danger'>
              <i class='bi bi-currency-dollar' aria-hidden='true'></i> Aumento de 5%
            </button>
          </form>
        </td>
      </tr>
<?php
        }
    }
    else {
      echo '<tr><td colspan="3">Nenhum departamento encontrado.</td></tr>';
    }
?>
    </tbody>
  </table>
  <!-- Fim da tabela -->
</main>
