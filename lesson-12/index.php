<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">

    <title>Janova školka HTML - Lekce 12</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <p><a href="../">« Další úkoly</a></p>
            <h1>Lekce 12</h1>

            <p><strong>První PHP</strong></p>
            <p>Tvůj úkol je:
            <ul>
                <li>Vypsat zde jméno z formuláře při odeslání. Pokud se nic neodešle, tak vypsat pomlčku.</li>
            </ul>

            <div class="row">
                <div class="col-sm-12">
                    Jméno odeslané ve formuláři:
                    <strong>
                        <?php
                            if(isset($_POST["name"])) {echo $_POST["name"]; }
                            else {echo '-'; }
                        ?>
                    </strong>
                </div>
            </div>
            <form action="" method="post">
            <div class="form-group">
                <label for="name">Jméno</label>
                <input type="text" class="form-control" name="name">
                <input type="submit" value="Odeslat" class="btn btn-primary">
            </div>
        </form>
            <p><small>Pomůcka: <code>$_POST['name']</code></p>
        </div>
    </div>
</body>
</html>
