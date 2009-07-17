<div class="navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            {{ link_to(null, 'class': 'brand', 'Gutshot')}}
            <div class="nav-collapse collapse">

                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ auth.getName() }} <b
                                class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>{{ link_to('users/changePassword', 'Change Password') }}</li>
                            <li>{{ link_to('users/account', 'My Account') }}</li>
                            <li>{{ link_to('users/profile?Player=' ~ auth.getPlayer(), 'My Profile') }}</li>
                            <li>{{ link_to('session/logout', 'Logout') }}</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">

            {{ content() }}

        </div>
    </div>
</div>