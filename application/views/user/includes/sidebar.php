      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <li class="undefined">
          <a href="<?= base_url() . $this->session->logged_in_user->type . '' ?>">
            <i class="fa fa-dashboard"></i> 
            <span> Dashboard</span>
          </a>
        </li>

        <li class="books">
          <a href="<?= base_url() . $this->session->logged_in_user->type . '/books' ?>">
            <i class="fa fa-book"></i> 
            <span> Borrow Books</span>
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