<li class="nav-item dropdown" id="user">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
             {{--  <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="/img/theme/team-1-800x800.jpg">
              </span> --}}
            </div>
            <p>{{ auth()->user()->name }}</p>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a  href="/profile" class="dropdown-item" >
              <i class="ni ni-single-02"></i>
              <span>My profile</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="/logout" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        
        </li>



