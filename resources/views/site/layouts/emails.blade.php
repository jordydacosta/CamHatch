<?php
$css = (object)array(
        'body' => 'background-color:#FFF; font-family:verdana, arial, sans-serif; font-size:12px; line-height:18px; color:#000;',
        'wrapper' => 'background-color:#FFF; color:#2A2B2A; font-size:12px;',

        'header' => 'color:#e20816; height:83px; padding:20px; border-bottom:1px solid #EFEFEF',
        'header_a' => 'color:#FFF; text-decoration:none; font-weight:200;',


        'content' => 'padding:20px 80px 20px 20px;',

        'footer' => 'padding:20px 20px 40px 20px; border-top:1px solid #EFEFEF; color:#AAA',
        'footer_a' => 'text-decoration:none; font-weight:200; color:#AAA;',
);

$settings = (object)array(
        'width' => 650
);
?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title')</title>

    <style type="text/css">

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        body {
            width: 100% !important;
            -webkit-text-size-adjust: none;
            margin: 0;
            padding: 0;
        }

        #background {
            margin: 0;
            padding: 0;
            width: 100% !important;
        }

        table td {
            border-collapse: collapse;
        }

        a {
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0
        }

        img {
            border: 0;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        /* custom styles */
        body, #background {
        {{ $css->body }}
        }

        .wrapper, #wrapper {
        {{ $css->wrapper }}
        }

        .content, #content {
        {{ $css->content }}
        }

        .header, #header {
        {{ $css->header }}
        }

        .header a, #header a {
        {{ $css->header_a }}
        }

        .footer, #footer {
        {{ $css->footer }}
        }

        .footer a, #footer a {
        {{ $css->footer_a }}
        }

        a {
            color: #e20816;
            text-decoration: none;
        }

        h1 {
            font-family: 'Helvetica Neue Light', 'helvetica', 'arial';
            font-size: 40px;
            line-height: 50px;
            color: #e20816;
            font-weight: 300;
            padding: 5px 0;
        }

        h2 {
            font-size: 16px;
            line-height: 16px;
            color: #333;
            font-weight: 300;
            padding: 5px 0;
            margin-bottom: 5px;
        }

        hr {
            border: 0;
            height: 1px;
            background-color: #DDD;
            color: #DDD;
            margin: 20px 0;
        }

        .pipe {
            color: #CCC;
            margin: 0 3px;
        }

        .large,
        .large a {
            font-family: 'Helvetica Neue Light', 'helvetica', 'arial';
            font-size: 20px;
            line-height: 30px;
            color: #e20816;
            text-decoration: none;
        }
    </style>
</head>


<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="{{ $css->body }}">
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="{{ $css->body }}" id="background">
    <tr>
        <td align="center">

            <table border="0" cellpadding="0" cellspacing="0" width="{{ $settings->width }}" class="wrapper"
                   id="#wrapper" style="{{ $css->wrapper }}">
                {{-- HEADER --}}
                <tr valign="top" align="left">
                    <td>
                        <div class="header" id="#header" style="{{ $css->header }}">
                            <a href="">
                                <img src="{{ url('img/logo.png') }}">
                            </a>
                        </div>
                    </td>
                </tr>

                {{-- CONTENT --}}
                <tr valign="top" align="left">
                    <td>
                        <div class="content" id="content" style="{{ $css->content }}">
                            @yield('content')
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="content">
                            <b>Datum:</b> {{ date("d M Y, g:i") }}<br/>
                        </div>
                    </td>
                </tr>

                <br>

                {{-- FOOTER --}}
                <tr valign="top" align="left">
                    <td>
                        <div class="footer" id="footer" style="{{ $css->footer }}">
                            &copy;<?php echo Date('Y'); ?> CamHatch
                            <span class="pipe">|</span>
                            <a href="http://www.camhatch.com">www.camhatch.com</a>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
