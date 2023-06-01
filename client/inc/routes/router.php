<?php

$page = filter_input(INPUT_GET, "page") ? filter_input(INPUT_GET, "page") : "login";

if(file_exists('./' . 'pages/' . $page . '/' . $page . ".php"))
{
    switch($page)
    {
        case "home":

            $data = home();
            break;

        case "login":

            $data = login();
            break;
    }
    exit();
}
else
{
    http_response_code(404);
    exit();
}

?>