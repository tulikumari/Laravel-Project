<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login - Fake News Validator</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/updates.css') }}">
        <script src="{{ asset('js/front.js') }}"></script>
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="main-login">
            <div class="container">
                <div class="form-main">
                    {{ Form::open(['url'=> route('login')]) }}
                        <div class="form_body">
                            <h1>Fake News Validator</h1>
                            @if(!empty($errors->first()))
                                <div class="row">
                                    <div class="alert alert-danger">
                                        <span>{{ $errors->first() }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text bg-success"><i class="fa fa-envelope"></i></span></div>
                                {{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email']) }}
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text bg-warning"><i class="fa fa-lock"></i></span></div>
                                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                            </div>
                        </div>
                        <div class="form_buttons">
                            <a href="{{ route('password.forgot') }}" class="forgot_option pull-left btn btn_secondary">Forgot Password</a>
                            {{ Form::submit('Login', ['class' => 'btn pull-right btn btn_primary']) }}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </body>
</html>
