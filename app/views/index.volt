<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Gutshot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gutshot">
    <meta name="author" content="Gutshot">
    {{ stylesheet_link('css/bootstrap.min.css') }}
    {{ stylesheet_link('css/bootstrap-responsive.min.css') }}
    {{ stylesheet_link('css/style.css') }}
    {{ javascript_include('js/jquery.min.js') }}
    {{ javascript_include('js/bootstrap.min.js') }}
    {{ javascript_include('js/holder.min.js') }}
    {{ javascript_include('js/jquery.nicescroll.min.js') }}


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    {{ javascript_include('js/html5shiv.js') }}
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://{{publicUrl}}/img/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://{{publicUrl}}/img/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://{{publicUrl}}/img/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="http://{{publicUrl}}/img/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="http://{{publicUrl}}/img/favicon.ico">
</head>
<body>

{{ content() }}

</body>
</html>