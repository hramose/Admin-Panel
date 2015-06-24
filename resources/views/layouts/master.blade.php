<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $siteName or 'Admin Panel' }}{{ isset($title) ? ' | ' . $title : null }}</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

@include('adminPanel::layouts.partials.nav')

@if(Session::has('message'))
    <div class="status-message">
        <div class="col-lg-12">
            <div class="alert alert-success">
                {{ Session::get('message') }}
            </div>
        </div>
    </div>
@endif

<div class="container">
    @yield('content')
</div>

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

@yield('footer_scripts')

</body>
</html>