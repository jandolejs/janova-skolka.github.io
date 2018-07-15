<?php

    namespace Lesson19;

    require_once __DIR__ . '/libs/Escape.php';
    require_once __DIR__ . '/libs/Validate.php';
    require_once __DIR__ . '/libs/User.php';
    require_once __DIR__ . '/libs/ContentType.php';
    require_once __DIR__ . '/libs/Name.php';
    require_once __DIR__ . '/libs/Phone.php';
    require_once __DIR__ . '/libs/Email.php';

    $user = null;
    $errorCaught = null;

    //form send
    if (isFormSent('registration-form')) {
        try {
            $name  = new Name(getFormValue('name'));
            $phone = new Phone(getFormValue('phone'));

            if(isFilled(getFormValue('email'))) {
                $email = new Email(getFormValue('email'));
            } else {
                $email = null;
            }

            $user = new User($name, $phone, $email);
        } catch (\Exception $errorCaught) {
            $errorCaught = $errorCaught->getMessage();
        }
    }


    // === Pomocné funkce ===
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

    function isFilled($value) {
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

    <title>Janova školka HTML - Lekce 19</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <p><a href="../">« Další úkoly</a></p>
        <h1>Lekce 19</h1>
        <p><strong>OOP (constructor, getter)</strong></p>

        <p>Tvůj úkol je:</p>
        <ul>
            <li>Zachovat stejnou funkčnost jako v <a href="../lesson-18/">lekci 18</a>.</li>
            <li>Přesunout valicaci hodnot do třídy <code>User</code>:
                <ul>
                    <li>Proměnné v třídě se změní na <code>private</code>, což znamená, že je nebude možné zapisovat ani číst zvenku (<code>$user->phone</code>)</li>
                    <li>třídě se budou data předávat tzv. <a href="http://php.net/manual/en/language.oop5.decon.php">konstruktorem</a> (<code>$user = new User($name, $phone, …)</code>)</li>
                    <li>uvnitř třídy se použíje magická metoda <code>__construct(…)</code>, která data přijme, zkontroluje a zapíše do vnitřní proměnné přes <code>$this->phone</code>,</li>
                    <li>protože data v objektu nelze z venku číst přímo, vytvoř metody stylem <code>getPhone()</code>.</li>
                </ul>
            </li>
        </ul>

        <div class="row">
            <div class="col-sm-12">
                <h3>Data z formuláře</h3>
                <?php if($user instanceof User): ?>
                    <div class="alert alert-success" role="alert">
                        Formulář úspěšně odeslán
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Jméno:</th>
                            <td>
                                <?php echo Escape::html($user->getName()); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Telefon:</th>
                            <td>
                                <?php echo Escape::html($user->getPhone()); ?>
                            </td>
                        </tr>
                        <?php if($user->hasEmail()): ?>
                            <tr>
                                <th>Email:</th>
                                <td>
                                    <?php echo Escape::html($user->getEmail()); ?>
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
                <input type="text" class="form-control" name="name" id="name" value="<?php echo Escape::html(getFormValue('name')); ?>">
            </div>
            <div class="form-group">
                <label for="phone">Telefon *</label>
                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo Escape::html(getFormValue('phone')); ?>">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" class="form-control" name="email" id="email" value="<?php echo Escape::html(getFormValue('email')); ?>">
            </div>
            <input type="hidden" name="action" value="registration-form">
            <input type="submit" name="submit" value="Odeslat" class="btn btn-primary">
        </form>
        <div style="margin-top: 2em;size:0.85em;">Pomůcky ke studiu:
            <ul>
                <li>Operátor <a href="http://php.net/manual/en/language.operators.type.php"><code>instanceof</code></a> pro zjištění typu objektu v proměnné,</li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
