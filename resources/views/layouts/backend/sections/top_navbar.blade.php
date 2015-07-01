<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ route('backend') }}">
            @include('_partials.site-logo', ['unstyled' => true])
            &#124;&nbsp;backend
        </a>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li class="dropdown {{ eq(Request::segment(2), 'articles') ? 'active' : '' }}">
                <a href="#" class="dropdown-toggle" data-hover="dropdown"><i class="fa fa-question-circle"></i>&nbsp;Help
                    articles
                    <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ route('backend.articles.index') }}"><i class="fa fa-eye"></i>&nbsp;View all help
                            articles</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('backend.articles.create') }}"><i class="fa fa-plus"></i>&nbsp;Add an article
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown {{ eq(Request::segment(2), 'counties') ? 'active' : '' }}">
                <a href="#" class="dropdown-toggle" data-hover="dropdown"><i class="fa fa-map-marker"></i>&nbsp;Counties
                    <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ route('backend.counties.index') }}"><i class="fa fa-eye"></i>&nbsp;View all counties</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('backend.counties.create') }}"><i class="fa fa-plus"></i>&nbsp;Add a county
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="fa fa-bar-chart"></i>&nbsp;County
                            reports </a></li>
                </ul>
            </li>
            <li class="dropdown {{ eq(Request::segment(2), 'users') ? 'active' : '' }}">
                <a href="#" class="dropdown-toggle" data-hover="dropdown"><i class="glyphicon glyphicon-user"></i>&nbsp;Users<span
                            class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ route('backend.users.index') }}"><i class="fa fa-eye"></i>&nbsp;View All users</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{ route('backend.users.create') }}"><i class="fa fa-user-plus"></i>&nbsp;Add user</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{ route('backend.security.access-control.roles.index') }}"><i class="fa fa-user-secret"></i>&nbsp;Users
                            & roles</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="fa fa-bar-chart"></i>&nbsp;User
                            reports</a></li>
                </ul>
            </li>
            <li class="dropdown {{ eq(Request::segment(2), 'orders') ? 'active' : '' }}">
                <a href="#" class="dropdown-toggle" data-hover="dropdown"><i class="fa fa-sellsy"></i>&nbsp;Product Orders<span
                            class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ route('backend.orders.index') }}"><i class="fa fa-user"></i>&nbsp;View user orders</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{ route('backend.orders.index', ['guest' => 1]) }}"><i class="fa fa-user"></i>&nbsp;View guest orders</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{ route('reports.sales') }}"><i class="fa fa-bar-chart"></i>&nbsp;Order reports</a></li>
                </ul>
            </li>
            <li class="dropdown {{ eq(Request::segment(2), 'products') ? 'active' : '' }}">
                <a href="#" class="dropdown-toggle" data-hover="dropdown"><i
                            class="fa fa-desktop"></i>&nbsp;Inventory<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="{{ route('backend.products.create') }}">
                            <i class="fa fa-plus"></i>&nbsp;Add a new product
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('backend.products.index') }}">
                            <i class="fa fa-eye"></i>&nbsp;View All products
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('backend.brands.index') }}">
                            <i class="fa fa-apple"></i>&nbsp; Product Brands
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('backend.categories.index') }}">
                            <i class="glyphicon glyphicon-arrow-right"></i>
                            Product Categories
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('backend.subcategories.index') }}">
                            <i class="glyphicon glyphicon-arrow-right"></i> Product Sub-categories
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <i class="fa fa-bar-chart"></i>&nbsp;Inventory reports
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown  {{ eq(Request::segment(2), 'security') ? 'active' : '' }}">
                <a href="#" class="dropdown-toggle" data-hover="dropdown" role="button" aria-expanded="false">
                    <i class="fa fa-user-secret"></i>&nbsp;System Security <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="{{ route('backend.security.roles.index') }}">
                            <i class="fa fa-eye"></i>&nbsp;View System Roles
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('backend.security.permissions.index') }}">
                            <i class="glyphicon glyphicon-lock"></i> Role permissions
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('backend.security.access-control.roles.create') }}"><i class="fa fa-users"></i>&nbsp;Assign
                            Roles</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('backend.security.access-control.roles.index') }}">
                            <i class="fa fa-user-secret"></i>&nbsp;Users and Roles
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <i class="fa fa-bar-chart"></i>&nbsp;Security reports
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right" style="margin-right: 5px;">
            <li class="dropdown  {{ eq(Request::segment(2), 'myaccount') ? 'active' : '' }}">
                <a href="#" class="dropdown-toggle" data-hover="dropdown">
                    {{ $auth_user->present()->fullName }}
                    <b class="caret"></b>
                    @if($is_logged_in)
                        @if(!empty($auth_user->avatar))
                            <img class="nav-user-avatar img-circle" src="{{ asset($auth_user->avatar) }} ">&nbsp;
                        @else
                            <img class="nav-user-avatar img-circle" src="{{ default_user_avatar() }} ">&nbsp;
                        @endif

                    @endif
                </a>

                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('myaccount') }}"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <div class="p-all-10">
                            {!! Form::open(['url' => route('backend.logout'), 'method' => 'GET']) !!}

                            <button class="btn btn-success btn-block">
                                <i class="fa fa-fw fa-sign-out"></i> Log Out
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>