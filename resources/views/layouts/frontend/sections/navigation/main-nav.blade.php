@if($small == true)
    <nav class="navbar navbar-inverse navbar-static-top navbar-md very-top" id="1st"
         style="z-index: auto; margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-brand site-logo" href="{{ route('home') }}">
                @include('_partials.site-logo', ['unstyled' => true])
                @if(isset($altText))
                    &#124;&nbsp;<span class="alt-text">{{ $altText }}</span>
                @endif
            </a>
        </div>

        <div style="padding-right: 20px">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ route('cart.view') }}" target="_blank"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;
                        My Cart ({{ !empty($cart['products']) ? array_get($cart['cart'], 'total_products') : 0 }})
                    </a>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-hover="dropdown"><i class="fa fa-question-circle"></i>&nbsp;I
                        need Help
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('faq') }}" target="_blank">Visit FAQ page</a>
                        </li>
                        <li>
                            <a href="{{ route('help') }}" target="_blank">Visit help page</a>
                        </li>
                    </ul>
                </li>
                <li><a href="{{ route('contact') }}" target="_blank">Contact Us</a>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-hover="dropdown">
                        <i class="fa fa-share-alt"></i>&nbsp;Social links
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"> <i class=" fa fa-facebook">   </i> </a></li>
                        <li><a href="#"> <i class="fa fa-twitter">   </i> </a></li>
                        <li><a href="#"> <i class="fa fa-google-plus">   </i> </a></li>
                        <li><a href="#"> <i class="fa fa-pinterest">   </i> </a></li>
                        <li><a href="#"> <i class="fa fa-youtube">   </i> </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

@else
    <nav class="navbar navbar-inverse navbar-static-top yamm" id="2cnd" role="navigation"
         style="z-index: auto; margin-bottom: 0">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#site-navigation-bar-main">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand site-logo" href="{{ route('home') }}">
                @include('_partials.site-logo', ['unstyled' => true])
            </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="site-navigation-bar-main" style="padding-right: 10px">
            <ul class="nav navbar-nav">
                @foreach($categories as $category)
                    <li class="dropdown yamm">
                        <a href="#" class="dropdown-toggle" data-hover="dropdown">{{ beautify($category->name) }}<span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            @if($category->subcategories->count() > 5)
                                                @foreach($category->subcategories as $subcategory)
                                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                                        <ul class="links">
                                                            <li>
                                                                <a href="{{ route('subcategories.shop', ['subcategory' => $subcategory->id]) }}">{!! $subcategory->name !!}</a>
                                                            </li>
                                                            <li class="divider"></li>
                                                        </ul>
                                                    </div>
                                                @endforeach
                                            @else
                                                @foreach($category->subcategories as $subcategory)
                                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                                        <ul class="links">

                                                            <li>
                                                                <a href="{{ route('subcategories.shop', ['subcategory' => $subcategory->id]) }}">{!! $subcategory->name !!}</a>
                                                            </li>
                                                            <li class="divider"></li>

                                                        </ul>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>
                @endforeach
            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-hover="dropdown">
                        <i class="glyphicon glyphicon-shopping-cart cart-icon"></i>
                        &nbsp;<span
                                class="item-count">({{ !empty($cart['products']) ? array_get($cart['cart'], 'total_products') : "0" }}
                            )</span>
                        <span class="caret"></span>
                    </a>

                    @if(empty($cart['products']))
                        <ul class="dropdown-menu" style="right: 40px" role="menu">
                            <li>
                                <div class="shopping-cart">
                                    <div class="alert alert-warning">
                                        <p>Your shopping cart is empty. Give it purpose by filling it with products</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @else

                        <ul class="dropdown-menu" role="menu" style="right: 30px;">
                            <li>
                                <div class="shopping-cart">
                                    @foreach($cart['products'] as $product)
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p class="text text-primary text-left">
                                                    <a href="{{ route('product.view', ['id' => $product['id'], ]) }}">
                                                        {{ str_limit($product['name']) }}
                                                    </a>
                                                </p>

                                                <div class="pull-left">
                                                <span class="text text-danger">
                                                    {{ $product['quantity'] > 1 ? $product['quantity'] .' '. str_plural('item') : $product['quantity'] .' '. str_singular('items') }}
                                                </span>

                                                </div>

                                                &nbsp;
                                                <div class="pull-right">
                                                <span class="text text-info">
                                                    {{ format_money($product['total_price']) }}
                                                </span>

                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                    @endforeach
                                    <div class="row">
                                        <div class="col-xs-12 m-t-5">
                                            <div class="pull-left">
                                                <p class="text text-primary bold">
                                                    Sub Total:
                                                </p>
                                            </div>
                                            <div class="pull-right">
                                                <p class='text text-primary bold'>
                                                    {{ format_money($cart['cart']['basket_total']) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <a href="{{ route('cart.view') }}">
                                                <button class="btn btn-primary btn-block m-t-10">
                                                    <i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;&nbsp;View
                                                    Shopping Cart ({{ array_get($cart['cart'], 'total_products') }}
                                                    items)
                                                </button>
                                            </a>
                                        </div>

                                    </div>

                                </div>
                            </li>
                        </ul>
                    @endif
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-hover="dropdown">
                        {{ $is_logged_in ? $auth_user->present()->fullName : "Login&nbsp;/&nbsp;Register" }}
                        <b class="caret"></b>
                        @if($is_logged_in)
                            @if(!empty($auth_user->avatar))
                                <img class="nav-user-avatar img-circle" src="{{ asset($auth_user->avatar) }} ">&nbsp;
                            @else
                                <img class="nav-user-avatar img-circle" src="{{ default_user_avatar() }} ">&nbsp;
                            @endif

                        @endif
                    </a>
                    <ul class="dropdown-menu" style="right: 12px" role="menu">
                        <li>

                            @if(!$is_logged_in)
                                <div class="auth">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h3 class="bold text-center">My Account</h3>

                                            <div class="col-xs-12">
                                                <a href="{{ secure_url('/account/login') }}" class="link-btn">
                                                    <button class="btn btn-info btn-block">
                                                        <i class="fa fa-sign-in"></i>&nbsp;Sign In
                                                    </button>
                                                </a>

                                                <div class="strike m-t-10 m-b-10">
                                                    <span>or</span>
                                                </div>
                                                <p>{!! link_to('/account/register', 'Create a PC-World Account', [], true) !!}</p>

                                                <p class="text-small">An account will allow you to view your orders,
                                                    create
                                                    wishlists, checkout fast, and much more</p>

                                                {!! link_to_route('myaccount', 'Account home', [], []) !!}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="auth">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <ul>
                                                <li>{!! link_to_route('myaccount', 'Account home', [], []) !!}</li>
                                                <li>{!! link_to_route('mycart', 'My shopping cart', [], []) !!}</li>
                                                <li>{!! link_to_route('myorders', 'My orders', [], []) !!}</li>
                                                @if($auth_user->canAccessBackend())
                                                    <li class="divider"></li>
                                                    <li>{!! link_to('/backend', 'Site backend', ['target' => '_blank'], true) !!}</li>
                                                @endif
                                            </ul>

                                            <hr/>
                                            {!! Form::open(['url' => route('logout'), 'method' => 'GET']) !!}
                                            <button class="btn btn-success btn-block" type="submit">
                                                <i class="fa fa-sign-out"></i>&nbsp;Sign out
                                            </button>
                                            {!! Form::close() !!}

                                        </div>
                                    </div>
                                </div>
                            @endif

                        </li>
                    </ul>
                </li>
            </ul>
            <div class="col-md-4 col-xs-12 col-sm-12 pull-right m-t-10 m-b-10">
                {!! Form::open(['route' => 'client.search', 'method' => 'get', 'id' => 'suggestiveSearch']) !!}
                <div class="input-group">
                    {!! Form::text('q', null, ['class' => 'search-query form-control', 'placeholder' => 'search for a product...', 'id' => 'searchInput', 'maxlength' => 255]) !!}
                    <div class="input-group-btn">
                        <button class="btn btn-default" id="s" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
        <!-- /.navbar-collapse -->
    </nav>

@endif
