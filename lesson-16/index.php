<?php

    $errorCaught = "";

    //form send
    try{
        if (isFormSent('registration-form')) {
            $name = getFormValue('name');
            validateRequired($name, 'Jméno') && validateName($name, 'Jméno');

            $phone = getFormValue('phone');
            validateRequired($phone, 'Telefon') && validatePhone($phone, 'Telefon');

            $email = getFormValue("email");
            isFilled($email) && validateEmail($email, "Email");
        }
    } catch (Exception $errorCaught) {
        $errorCaught = $errorCaught->getMessage();
    }


    // === Pomocné funkce ===
    function escapeHtml($text)
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }


    function getFormValue($inputName, $default = '')
    {
        if (isset($_POST[$inputName])) {
            return $_POST[$inputName];
        }
        return $default;
    }


    function isFormSent($formName)
    {
        return getFormValue('action') === $formName;
    }


    function validateRequired($value, $title)
    {
        $isValid = ($value !== '');
        if (!$isValid) {
            throw new Exception("Pole $title není vyplněno, prosím, vyplňte jej.");
        }
        return $isValid;
    }


    function validateName($value, $title)
    {
        $isValid = !preg_match('/\d/', $value);
        if (!$isValid) {
            throw new Exception("Pole $title nesmí obsahovat číslo.");
        }
        return $isValid;
    }

    function validatePhone($value, $title)
    {
        $isValid = preg_match('/^ *(\d *){9}$/', $value);
        if (!$isValid) {
            throw new Exception("Pole $title musí obsahovat pouze 9 číslic (mezery jsou povoleny).");
        }
        return $isValid;
    }


    function validateEmail($value, $title)
    {
        $isValid = filter_var($value, FILTER_VALIDATE_EMAIL);
        if (!$isValid) {
            throw new Exception("$title byl vyplněn ale je neplatný.");
        }
        return $isValid;
    }


    function isFilled($value)
    {
        return $value !== '';
    }

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">

    <title>Janova školka HTML - Lekce 16</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <p><a href="../">« Další úkoly</a></p>
            <h1>Lekce 16</h1>

            <p>Tvůj úkol je:</p>
            <ul>
                <li>Zachovat stejnou funkčnost jako v <a href="../lesson-15/">lekci 15</a>,</li>
                <li>jen s tím rozdílem, že se při zpracování formuláře použijí výjimky a to takto:
                    <ul>
                        <li>zpracování formuláře bude v jednom <code>try {}</code> bloku,</li>
                        <li>pokud bude jakákoliv chyba, vyhodí se výjimka,</li>
                        <li>ta se zachytí a podle ní se nastaví chybové oznámení pro uživatele.</li>
                        <li>Použij základní výjimku <code>\Exception</code>, nevytvářej zatím žádnou vlastní.</li>
                        <li>Zvaž změnu chování <code>$errors</code> z pole na něco vhodného.</li>
                    </ul>
                </li>
                <li>Drobná změna funkčnosti bude spočívat v tom, že místo <strong>všech</strong> chyb se uživateli vypíše jen jedna (ta první). Není to správný UX příklad, ale nevadí.</li>
            </ul>

            <div class="row">
                <div class="col-sm-12">
                    <h3>Data z formuláře</h3>
                    <?php if(!$errorCaught): ?>
                    <div class="alert alert-success" role="alert">
                        Formulář úspěšně odeslán
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Jméno:</th>
                            <td>
                            <?php echo escapeHtml($_POST['name']); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Telefon:</th>
                            <td>
                            <?php echo escapeHtml($_POST['phone']); ?>
                            </td>
                        </tr>
                        <?php if(isFilled(getFormValue("email"))): ?>
                        <tr>
                            <th>Email:</th>
                            <td>
                            <?php echo escapeHtml($_POST['email']); ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </table>
                    <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        Formulář nebyl odeslán
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <h3>Formulář</h3>
            <?php if($errorCaught != ""): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorCaught; ?>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Jméno *</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?php echo escapeHtml(getFormValue('name')); ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Telefon *</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo escapeHtml(getFormValue('phone')); ?>">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" class="form-control" name="email" id="email" value="<?php echo escapeHtml(getFormValue('email')); ?>">
                </div>
                <input type="hidden" name="action" value="registration-form">
                <input type="submit" name="submit" value="Odeslat" class="btn btn-primary">
            </form>
            <div style="margin-top: 2em;"><small>Pomůcka:
                    <a href="https://www.google.cz/search?q=php+v%C3%BDjimky">Google</a>
                    (zejména <a href="https://www.interval.cz/clanky/oop-v-php-vyjimky-v-oop/">tenhle</a> a
                    <a href="https://phpfashion.com/php-triky-standardni-vyjimky">tenhle</a> článek),
                    <a href="http://php.net/manual/en/language.exceptions.php">dokumentace</a>.
                </small></div>
        </div>
    </div>
</body>
</html>
