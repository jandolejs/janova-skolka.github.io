<?php

    namespace Lesson20;

    require __DIR__ . '/../vendor/autoload.php';
    $loader = new \Nette\Loaders\RobotLoader;
    $loader->addDirectory(__DIR__ . '/libs');
    $loader->setTempDirectory(__DIR__ . '/../temp/cache');
    $loader->register(); // spustíme RobotLoader

    // === Ukázka použítí maileru pro odeslání e-mailu ===
    // Pro odeslání e-mailu je povinné vyplnění: jména, e-mailu a zprávy
    // Telefon není povinný – polud jej ale chceš poslat, přidej do parametrů 'phone'



    $user = null;
    $errorCaught = null;
    $mainParameters = [
       // 'name' => 'Jan Dolejš',
       // 'email' => 'janova-skolka@googlegroups.com',
       // 'message' => 'Toto je DEMO zpráva...',
    ];

    //form send
    if (isFormSent('registration-form')) {
        try {

            $name  = new Name(getFormValue('name'));
            $mainParameters['name'] = $name->getContent();

            $message = new Message(getFormValue('message'));
            $mainParameters['message'] = $message->getContent();

            if(isFilled(getFormValue('phone'))) {
                $phone = new Phone(getFormValue('phone'));
                $mainParameters['phone'] = $phone->getContent();
            } else {
                $phone = null;
            }

            if(isFilled(getFormValue('email'))) {
                $email = new Email(getFormValue('email'));
                $mainParameters['email'] = $email->getContent();
                Mail\Mailer::sendMail($mainParameters);
            } else {
                $email = null;
            }

            $user = new User($name, $phone, $email, $message);

        } catch (Mail\MailerException $e) {
            $errorCaught = 'Email se nepovedlo odeslat z tohoto důvodu: ' . $e->getMessage();
        } catch (\Exception $e) {
            $errorCaught = $e->getMessage();
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

    <title>Janova školka HTML - Lekce 20</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <p><a href="../">« Další úkoly</a></p>
        <h1>Lekce 20</h1>
        <p><strong>OOP (použití)</strong></p>

        <p>Tvůj úkol je:</p>
        <ul>
            <li>Zachovat stejnou funkčnost jako v <a href="../lesson-19/">lekci 19</a> s těmito rozdíly:</li>
            <li>Přidej nové políčko <strong>Zpráva</strong>, které bude víceřádkové. Bude povinné vyplnění.</li>
            <li>Změň telefon na nepovinný.</li>
            <li>Pokud je vyplněn e-mail, pak se uživateli odešle e-mail – k tomu slouží v kódu připravená funkce <code>Mail\Mailer::sendMail()</code>.</li>
            <li>Pokud funkce vyhodí nějakou výjimku, tak ji vrátit uživateli stejně jako chybu ve formuláři</li>
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
                        <?php if($user->hasPhone()): ?>
                            <th>Telefon:</th>
                            <td>
                                <?php echo Escape::html($user->getPhone()); ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if($user->hasEmail()): ?>
                            <tr>
                                <th>Email:</th>
                                <td>
                                    <?php echo Escape::html($user->getEmail()); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Zpráva:</th>
                            <td>
                                <?php echo Escape::html($user->getMessage()); ?>
                            </td>
                        </tr>
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
                <label for="phone">Telefon</label>
                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo Escape::html(getFormValue('phone')); ?>">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" class="form-control" name="email" id="email" value="<?php echo Escape::html(getFormValue('email')); ?>">
            </div>
            <div class="form-group">
                <label for="message">Zpráva*</label>
                <textarea rows="5" type="text" class="form-control" name="message" id="message"><?php echo Escape::html(getFormValue('message')); ?></textarea>
            </div>
            <input type="hidden" name="action" value="registration-form">
            <input type="submit" name="submit" value="Odeslat" class="btn btn-primary">
        </form>
    </div>
</div>
</body>
</html>
