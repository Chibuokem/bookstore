 <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          {{-- <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li> --}}
           <li class="nav-item">
            <a href="{{ route('home') }}"  class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href=""  class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Profile
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
           <li class="nav-item">
           <a href=""  class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
               My Orders
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
           
            
          @if(Auth::user()->admin_level == 1)
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Admin
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
               <a href="{{route('view-books')}}"  class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Books
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>

               <li class="nav-item">
            <a href=""  class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Orders
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('create-new-card')}}"  class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Create card
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
              <li class="nav-item">
            <a href="{{route('cards')}}"  class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              View cards
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('sync-cards')}}"  class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Sync cards
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>

           <li class="nav-item">
            <a href=""  class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Orders
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>

         

              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li> --}}
            </ul>
          </li>
          @endif

          <li class="nav-item">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Logout
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
        </ul>
      </nav>