<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item">
      <a class="nav-link" href="index.php">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>

    
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#report" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Report</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-calendar-month menu-icon"></i>

      </a>
      <div class="collapse" id="report">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="monthly-expense-report.php">Monthly Expense</a></li>
          <li class="nav-item"> <a class="nav-link" href="yearly-expense-report.php">Yearly Expense</a></li>
          <li class="nav-item"> <a class="nav-link" href="monthly-deposit-report.php">Monthly Deposit</a></li>
          <li class="nav-item"> <a class="nav-link" href="yearly-deposit-report.php">Yearly Deposit</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#member-details" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Member</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-account menu-icon"></i>

      </a>
      <div class="collapse" id="member-details">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="view-members.php">View Members</a></li>
          <li class="nav-item"> <a class="nav-link" href="add-member.php">Add Member Profile</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#clause-details" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Clause</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-file-document menu-icon"></i>

      </a>
      <div class="collapse" id="clause-details">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="view-clause.php">View Clause</a></li>
          <li class="nav-item"> <a class="nav-link" href="add-clause.php">Add Clause</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="get-funds.php">
        <span class="menu-title">Get Funds</span>
        <i class="mdi mdi-cash-multiple menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="deposit-amount.php">
        <span class="menu-title">Deposit Amount</span>
        <i class="mdi mdi-cash menu-icon"></i>
      </a>
    </li>

  </ul>
</nav>