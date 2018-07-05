<?php

    function escapeHtml($text){
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    $areSet = false;
    $isInvalid = false;

    if(isset($_POST["name"]) && isset($_POST["phone"])){
        //  formulář odeslaný
        if($_POST["name"] != "" && $_POST["phone"] != ""){
            $areSet = true;
        } else {
            //  byl odeslán ale není validní
            $isInvalid = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">

    <title>Janova školka HTML - Lekce 13</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <p><a href="../">« Další úkoly</a></p>
            <h1>Lekce 13</h1>

            <p><strong>Validace formuláře</strong></p>
            <p>Tvůj úkol je:
            <ul>
                <li>Vypsat zde jméno a telefon z formuláře při odeslání. Pokud se nic neodešle, tak vypsat pomlčku.</li>
                <li>Podmínka formuláře: Jméno i telefon jsou povinné a nesmí být prázdné.</li>
                <li>Pokud data z formuláře nesplňují všechny podmínky, tak se považuje za neodeslaný a je potřeba vyhodit uživateli chybovou hlášku.</li>
            </ul>

            <div class="row">
                <div class="col-sm-12">
                    <h3>Data z formuláře</h3>
                    <table class="table table-bordered">
                        <tr>
                            <th>Jméno:</th>
                            <td>
                            <?php
                                if($areSet) {
                                    echo escapeHtml($_POST["name"]);
                                } else {
                                    echo '-';
                                }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Telefon:</th>
                            <td>
                            <?php
                                if($areSet) {
                                    echo escapeHtml($_POST["phone"]);
                                } else {
                                    echo '-';
                                }
                            ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <h3>Formulář</h3>
            <?php if($isInvalid): ?>
                <div class="alert alert-danger" role="alert"><strong>Pozor!</strong> Musíte vypnit všechna políčka.</div>
            <?php endif; ?>
            <form action="" method="post">
            <div class="form-group">
                <label for="name">Jméno *</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="form-group">
                <label for="phone">Telefon *</label>
                <input type="text" class="form-control" name="phone" id="phone">
            </div>
            <input type="submit" value="Odeslat" class="btn btn-primary">
        </form>
            <p><small>Pomůcka: <a href="https://getbootstrap.com/docs/3.3/components/#alerts">Alert box</a> pro vypsání pěkné chybové hlášky.</small></p>
        </div>
    </div>
</body>
</html>
