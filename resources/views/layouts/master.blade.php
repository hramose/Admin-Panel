<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $siteName or 'Admin Panel' }}{{ isset($title) ? ' | ' . $title : null }}</title>

    <link rel="stylesheet" href="{{asset('packages/adminPanel/app.css')}}"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">{{$siteName or 'Admin Panel'}}</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                {!!$leftMenu or null!!}
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="{{ route('admin.login') }}">Авторизация</a></li>
                @else
                    <li><a href="{{ route('admin.register') }}">Регистрация пользователя</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('admin.logout') }}">Выход</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>

@if(Session::has('message'))
    <div class="status-message">
        <div class="col-lg-12">
            <div class="alert alert-success">
                {{Session::get('message')}}
            </div>
        </div>
    </div>
@endif

@yield('content')

<!-- /.container -->

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js"></script>

<script>

    function updateContainer() {
        $.get(window.location.href, function (data) {
            var container = '.table';

            $(container).html($(data).find(container).html());
        });
    }

    $('table').on('click', 'a[data-method]', function(){

        if (confirm("Delete item?")) {

            var method = $(this).data('method');

            $.post($(this).attr('href'), {
                "_method": method,
                "_token": "<?php echo csrf_token() ?>"
            }, function (response) {
                updateContainer();
            });
        }

        return false;
    });
</script>

</body>
</html>