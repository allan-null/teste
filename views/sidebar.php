<div class='sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary'>
  <div class='offcanvas-md offcanvas-end bg-body-tertiary' tabindex='-1' id='sidebarMenu' aria-labelledby='sidebarMenuLabel'>
    <div class='offcanvas-header'>
      <h5 class='offcanvas-title' id='sidebarMenuLabel'><?=$_config->title?></h5>
      <button type='button' class='btn-close' data-bs-dismiss='offcanvas' data-bs-target='#sidebarMenu' aria-label='Close'></button>
    </div>
    <div class='offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto'>
      <ul class='nav flex-column'>
        <li class='nav-item'>
          <a class='nav-link d-flex align-items-center gap-2<?=($controller == 'employee' && !isset($_GET['recentlyHired']) ? " active' aria-current='page'" : "'")?> href='<?=$_config->baseURL?>/employee'>
            <i class='bi bi-people' aria-hidden='true'></i> Funcionários
          </a>
        </li>
        <li class='nav-item'>
          <a class='nav-link d-flex align-items-center gap-2<?=($controller == 'employee' && isset($_GET['recentlyHired']) ? " active' aria-current='page'" : "'")?> href='<?=$_config->baseURL?>/employee?recentlyHired'>
            <i class='bi bi-clock-history'></i> Funcionários contratos nos últimos 6 meses
          </a>
        </li>
        <li class='nav-item'>
          <a class='nav-link d-flex align-items-center gap-2<?=($controller == 'report' && $action == 'salary_by_department' ? " active' aria-current='page'" : "'")?> href='<?=$_config->baseURL?>/report/salary-by-department'>
            <i class='bi bi-file-earmark-spreadsheet'></i> Salário por departamento
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
