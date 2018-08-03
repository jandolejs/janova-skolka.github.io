<?php

namespace Lesson23;

use Tracy\Debugger;

// ===== Autoloader knihoven ====================

require __DIR__ . '/../vendor/autoload.php';
(new \Nette\Loaders\RobotLoader)->addDirectory(__DIR__ . '/libs')
    ->setTempDirectory(__DIR__ . '/../temp/cache')->register();

// ===== Inicializace ===========================

$user = null;
$error = null;
$formData = [];
$storage = new Storage(__DIR__ . '/output');
Debugger::enable(Debugger::DETECT, __DIR__ . '/log');

// ===== Aplikace ===============================

if (Helpers::isFormSent('registration-form')) {
    try {

        $name = new Name(Helpers::getFormValue('name'));
        $formData['name'] = $name->getContent();

        $message = new Message(Helpers::getFormValue('message'));
        $formData['message'] = $message->getContent();

        if (Helpers::isFilled(Helpers::getFormValue('phone'))) {
            $phone = new Phone(Helpers::getFormValue('phone'));
            $formData['phone'] = $phone->getContent();
        } else {
            $phone = null;
        }

        if (Helpers::isFilled(Helpers::getFormValue('email'))) {
            $email = new Email(Helpers::getFormValue('email'));
            $formData['email'] = $email->getContent();
            Mail\Mailer::sendMail($formData);
        } else {
            $email = null;
        }

        $storage->save($name, $formData);
        $user = new User($name, $phone, $email, $message);

    } catch (Mail\MailerException $e) {
        Debugger::log("Email not sent: " . $e);
        $error = 'Email se nepovedlo odeslat z tohoto důvodu: ' . $e->getMessage();
    } catch (\Exception $e) {
        $error = $e->getMessage();
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

    <title>Janova školka HTML - Lekce 23</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
          integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"
          integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <p><a href="../">« Další úkoly</a></p>
        <h1>Lekce 23</h1>
        <p><strong>Logování</strong></p>

        <p>Tvůj úkol je:</p>
        <ul>
            <li>Zachovat stejnou funkčnost.</li>
            <li>
                Uživatelé sice vidí chybu, ale ty jako správce webu nikoliv. Ale bylo by dobré vědět, co se na webu děje.
            </li>
            <li>
                Budeme tedy logovat důležité události – jako například situaci, kdy se nepovedlo soubor uložit.
            </li>
            <li>
                Pro logování použijeme knihovnu <a href="https://tracy.nette.org/cs/">Tracy</a>, která za nás udělá hodně
                práce. Jak ji použít, jistě najdeš :)
            </li>

        </ul>

        <div class="row">
            <div class="col-sm-12">
                <h3>Data z formuláře</h3>
                <?php if ($user instanceof User): ?>
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
                            <?php if ($user->hasPhone()): ?>
                            <th>Telefon:</th>
                            <td>
                                <?php echo Escape::html($user->getPhone()); ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if ($user->hasEmail()): ?>
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
        <?php if ($error !== null): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="name">Jméno *</label>
                <input type="text" class="form-control" name="name" id="name"
                       value="<?php echo Escape::html(Helpers::getFormValue('name')); ?>">
            </div>
            <div class="form-group">
                <label for="phone">Telefon</label>
                <input type="text" class="form-control" name="phone" id="phone"
                       value="<?php echo Escape::html(Helpers::getFormValue('phone')); ?>">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" class="form-control" name="email" id="email"
                       value="<?php echo Escape::html(Helpers::getFormValue('email')); ?>">
            </div>
            <div class="form-group">
                <label for="message">Zpráva *</label>
                <textarea rows="5" class="form-control" name="message"
                          id="message"><?php echo Escape::html(Helpers::getFormValue('message')); ?></textarea>
            </div>
            <input type="hidden" name="action" value="registration-form">
            <input type="submit" name="submit" value="Odeslat" class="btn btn-primary">
        </form>
    </div>
</div>
</body>
</html>
