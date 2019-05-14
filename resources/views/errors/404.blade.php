<!DOCTYPE html>
<html>
<head>
    <title>@lang('general.brand') | @lang('general.ch_slogan')</title>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300' rel='stylesheet' type='text/css'>

    <style>
        html, body {
            height: 100%;
            background-color: #F4F4F4;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #353535;
            display: table;
            font-weight: 100;
            font-family: 'Open Sans';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
            background-color: #FFF;
            padding: 120px 60px;
            width: 650px;

            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .title {
            margin-top: 40px;
            font-size: 35px;
            margin-bottom: 40px;
            font-weight: bold;
        }

        .text {
            font-size: 18px;
        }

        .logo {
            background: url('/img/logo.png') 0px 0px no-repeat;
            background-size: 100% auto;
            width: 98px;
            height: 44px;
            display: inline-block;
            margin-bottom: 20px;
        }

        html.svg .logo {
            background-image: url('/img/logo.svg');
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <a href="{{ route('home') }}" class="logo"></a>
        <div class="title">@lang('errors.404_title')</div>
        <div class="text">
            <p>
                @lang('errors.404_text_1')
            </p>
            <p>
                @lang('errors.404_text_2', ['url' => route('home')])
            </p>
        </div>
    </div>
</div>
</body>
</html>
