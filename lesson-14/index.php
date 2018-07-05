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

    <title>Janova školka HTML - Lekce 14</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <p><a href="../">« Další úkoly</a></p>
            <h1>Lekce 14</h1>

            <p><strong>Pokročilá validace formuláře</strong></p>
            <p>Tvůj úkol je:
            <ul>
                <li>Vypsat zde jméno a telefon z formuláře při odeslání. Pokud se nic neodešle, tak schovat celou tabulku a místo ní napsat jen „Formulář nebyl odeslán“.</li>
                <li>Podmínky formuláře:
                <ul>
                    <li>Jméno i telefon jsou povinné a nesmí být prázdné.</li>
                    <li>Jméno nesmí obsahovat číslo</li>
                    <li>Telefon musí obsahovat právě 9 čísel, libovolně prokládaných mezerami (např. <code>123456789</code> i <code>123 45 67 89</code>)</li>
                <li>Pokud data z formuláře nesplňují všechny podmínky, tak se považuje za neodeslaný a je potřeba vyhodit uživateli chybovou hlášku.</li>
                <li>Chybová hláška musí být smysluplná, aby uživatel pochopil, co má špatně</li>
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
                <div class="alert alert-danger" role="alert"><strong>Pozor!</strong> Musíte vyplnit všechna políčka.</div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Jméno *</label>
                    <?php if($isInvalid){$valueToForm = escapeHtml($_POST["name"]); } ?>
                    <input type="text" class="form-control" name="name" id="name" value="<?php if($isInvalid){echo $valueToForm; } ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Telefon *</label>
                    <?php if($isInvalid){$valueToForm = escapeHtml($_POST["phone"]); } ?>
                    <input type="text" class="form-control" name="phone" id="phone" value="<?php if($isInvalid){echo $valueToForm; } ?>">
                </div>
                <input type="hidden" name="action" value="registration-form">
                <input type="submit" name="submit" value="Odeslat" class="btn btn-primary">
            </form>
            <p><small>Pomůcka: <code>var_dump($_POST)</code> a <code>preg_match()</code></small></p>
        </div>
    </div>
</body>
</html>
