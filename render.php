<?php

function embed($html) {
    return "
        <!DOCTYPE html>
        <html lang='en'>

        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>PHP-WFC - result</title>
            <link rel='stylesheet' href='style.css'>
        </head>

        <body>
            <main class='container container--output'>
                $html
                <footer>
                    <button onclick='document.location.reload()' class='button link-button output-button'>Retry</button>
                    <a href='https://dorianm.com/demos/php-wfc' class='button link-button output-button'>Home</a>
                </footer>
            </main>
        </body>

        </html>
    ";
}

function renderError($error) : string {
        $html = "
            <div class='notice notice--error'>
                <span class='notice-message'>$error</span>
            </div>
        ";
    return embed($html);
}

function renderResult($result, $isComplete) : string {
    $html = "<div class='result'>$result</div>";
    if (!$isComplete) {
        $html .= "
            <div class='notice notice--warning'>
                <span class='notice-message'>
                    WFC algorithm has not been able to compute the result within the preset attempt limit.
                </span>
            </div>
        ";
    } 
    return embed($html);
}
