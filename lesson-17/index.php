<?php

    namespace Lesson17;

    $isFormValid = false;
    $errorCaught = null;

    //form send
    if (isFormSent('registration-form')) {
        try {
                $name = getFormValue('name');
                validateRequired($name, 'Jméno') && validateName($name, 'Jméno');

                $phone = getFormValue('phone');
                validateRequired($phone, 'Telefon') && validatePhone($phone, 'Telefon');

                $email = getFormValue("email");
                isFilled($email) && validateEmail($email, "Email");

                $isFormValid = true;
        } catch (\Exception $errorCaught) {
            $errorCaught = $errorCaught->getMessage();
        }
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
            throw new \Exception("Pole $title není vyplněno, prosím, vyplňte jej.");
        }
        return $isValid;
    }


    function validateName($value, $title)
    {
        $isValid = !preg_match('/\d/', $value);
        if (!$isValid) {
            throw new \Exception("Pole $title nesmí obsahovat číslo.");
        }
        return $isValid;
    }

    function validatePhone($value, $title)
    {
        $isValid = preg_match('/^ *(\d *){9}$/', $value);
        if (!$isValid) {
            throw new \Exception("Pole $title musí obsahovat pouze 9 číslic (mezery jsou povoleny).");
        }
        return $isValid;
    }


    function validateEmail($value, $title)
    {
        $isValid = filter_var($value, FILTER_VALIDATE_EMAIL);
        if (!$isValid) {
            throw new \Exception("$title byl vyplněn ale je neplatný.");
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

    <title>Janova školka HTML - Lekce 17</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <p><a href="../">« Další úkoly</a></p>
            <h1>Lekce 17</h1>
            <p><strong>OOP (static)</strong></p>


            <p>Kód ve souboru <code>index.php</code> nám notně bobtná a je čas ho rozdělit do logických celků.</p>

            <p>Tvůj úkol je:</p>
            <ul>
                <li>Zachovat stejnou funkčnost jako v <a href="../lesson-16/">lekci 16</a>.</li>
                <li>Vyčlenit některé funkce do samostatných tříd a to takto:
                    <ul>
                        <li>všechny validační funkce (<code>validate*</code>) do třídy <code>Validate</code>,</li>
                        <li>všechny escapovací funkce (<code>escape*</code>) do třídy <code>Escape</code>,</li>
                        <li>upravit jejich název tak, aby se neduplikoval název (<code>Validate::name()</code> místo <code>Validate::validateName()</code>),</li>
                        <li>soubor s třídou se vždy bude jmenovat stejně jako třída (včetně velikosti písmen),</li>
                        <li>tyto soubory budou v podsložce <code>libs/</code>.</li>
                    </ul>
                </li>
                <li>Každý objekt bude v samostatném souboru.</li>
                <li>Pro jednoduchost budou všechny metody <strong>statické</strong>. Tedy nebudou se vytvořet žádné nové proměnné, ani instance. Jde čistě o přesun funkce do objektu.</li>
                <li>Tip: Pro jednoduchost si nejdříve převeď jednu funkci a otestuj.</li>
            </ul>

            <div class="row">
                <div class="col-sm-12">
                    <h3>Data z formuláře</h3>
                    <?php if($isFormValid): ?>
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
            <?php if($errorCaught !== null): ?>
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
            <div style="margin-top: 2em;size:0.85em;">Pomůcky ke studiu:
                <ul>
                    <li>rozdíl mezi pojmy „funkce“ a „metoda“,</li>
                    <li>rozdíl mezi <a href="http://php.net/manual/en/function.include.php"><code>include</code></a> a <a href="http://php.net/manual/en/function.require.php"><code>require</code></a>,</li>
                    <li>rozdíl mezi pojmy „objekt“ a „třída“,</li>
                    <li><a href="http://php.net/manual/en/language.oop5.php">dokumentace</a> k OOP v PHP.</li>

                </ul>
            </div>
        </div>
    </div>
</body>
</html>
