      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <li class="undefined">
          <a href="<?= base_url() . $this->session->logged_in_user->type . '' ?>">
            <i class="fa fa-dashboard"></i> 
            <span> Dashboard</span>
          </a>
        </li>

        <li class="users">
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/users' ?>">
            <i class="fa fa-user"></i> 
            <span> User Management</span>
          </a>
        </li>

        <li class="publishers">
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/publishers' ?>">
            <i class="fa fa-upload"></i> 
            <span> Publisher Management</span>
          </a>
        </li>

        <li class="categories">
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/categories' ?>">
            <i class="fa fa-list"></i> 
            <span> Category Management</span>
          </a>
        </li>

        <li class="authors">
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/authors' ?>">
            <i class="fa fa-users"></i> 
            <span> Author Management</span>
          </a>
        </li>

        <li class="books">
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/books' ?>">
            <i class="fa fa-book"></i>
            <span> Book Management</span>
          </a>
        </li>

        <li class="transactions">
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/transactions' ?>">
            <i class="fa fa-file"></i>
            <span> Transactions</span>
          </a>
        </li>

        <li class="settings">
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/settings' ?>">
            <i class="fa fa-gear"></i>
            <span> Settings</span>
          </a>
        </li>

        <li>
          <a class="logout">
            <i class="fa fa-sign-out"></i>
            <span> Logout</span>
          </a>
        </li>
      </ul>
    </section>
  </aside>