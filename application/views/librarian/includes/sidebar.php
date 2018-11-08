      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <li>
          <a href="<?= base_url() . $this->session->logged_in_user->type . '' ?>">
            <i class="fa fa-dashboard"></i> 
            <span> Dashboard</span>
          </a>
        </li>

        <li>
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/users' ?>">
            <i class="fa fa-user"></i> 
            <span> User Management</span>
          </a>
        </li>

        <li>
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/publishers' ?>">
            <i class="fa fa-upload"></i> 
            <span> Publisher Management</span>
          </a>
        </li>

        <li>
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/categories' ?>">
            <i class="fa fa-list"></i> 
            <span> Category Management</span>
          </a>
        </li>

        <li>
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/authors' ?>">
            <i class="fa fa-users"></i> 
            <span> Author Management</span>
          </a>
        </li>

        <li>
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/books' ?>">
            <i class="fa fa-book"></i>
            <span> Book Management</span>
          </a>
        </li>

        <li>
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/logout' ?>">
            <i class="fa fa-sign-out"></i>
            <span> Logout</span>
          </a>
        </li>
      </ul>
    </section>
  </aside>