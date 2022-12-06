<?php
class ViewPresenter{
    public static function createLayout($data = "", $title = "prohlížeč databáze"){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        echo "
            <!doctype html>
                <html lang='cs'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport'
                          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
                    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                    <title>" . $title . "
        </title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi' crossorigin='anonymous'>
        <style>
        .sorted{
        color:red;
        }
        </style>
        </head>
        <body>
<nav class='navbar navbar-expand-lg navbar-light bg-light px-4'>
  <a class='navbar-brand' href='homepage.php'>Prohlížeč databáze</a>
  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
    <ul class='navbar-nav mr-auto'>
      <li class='nav-item active'>
        <a class='nav-link' href='lide.php'>Seznam zaměstnanců</a>
      </li>
      <li class='nav-item'>
        <a class='nav-link' href='mistnosti.php'>Seznam místností</a>
      </li>
    </ul>
  </div>
</nav>
". $data ."
        </body></html>";
    }
}