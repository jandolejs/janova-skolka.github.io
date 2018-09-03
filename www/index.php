<?php

namespace App;

use App\Content;
use App\Storage\Storage;
use App\Validator\ValidateException;
use Tracy\Debugger;
use Tracy\ILogger;

// ===== Autoloader knihoven a start Laděnky ====

require __DIR__ . '/../vendor/autoload.php';

Debugger::enable(Debugger::DETECT, __DIR__ . '/../log');

(new \Nette\Loaders\RobotLoader)->addDirectory(__DIR__ . '/../libs')
    ->setTempDirectory(__DIR__ . '/../temp/cache')->register();

// ===== Inicializace ===========================

$checkExistence = true;
$user = null;
$error = null;
$storage = new Storage(__DIR__ . '/../output');


// ===== Aplikace ===============================

if (Helpers::isFormSent('registration-form')) {
    $checkExistence = true;
    try {

        $user = new User(
            new Content\Username(Helpers::getFormValue('username')),
            new Content\Password(Helpers::getFormValue('password')),
            new Content\Name(Helpers::getFormValue('name'))
        );

        if (Helpers::isFilled(Helpers::getFormValue('phone'))) {
            $user->setPhone(new Content\Phone(Helpers::getFormValue('phone')));
        }

        if (Helpers::isFilled(Helpers::getFormValue('email'))) {
            $user->setEmail(new Content\Email(Helpers::getFormValue('email')));
            //Mail\Mailer::sendMail($user->toArray());
        }

        $storage->save($user->getName(), $user->toArray(User::WITH_PASSWORD));

    } catch (Mail\MailerException $e) {
        Debugger::log('email_not_sent="' . $e->getMessage() . '"');
        $error = 'Email se nepovedlo odeslat z tohoto důvodu: ' . $e->getMessage();
    } catch (ValidateException $e) {
        $error = $e->getMessage();
    } catch (\Exception $e) {
        Debugger::log($e, ILogger::ERROR);
        $error = 'Omlouváme se, něco se pokazilo, zkuste to znovu později nebo nás kontaktujte na support@service.cz';
    }
}

$pageNum = "404";
$pageAddress = $_SERVER['PHP_SELF'];

switch ($pageAddress) {
    case "/www/index.php/add" :
        $pageNum = 'add';
        break;
    case "/www/index.php/show" :
        $pageNum = 'show';
    break;
    case "/www/index.php" :
        $pageNum = 'welcome';
    break;
    case preg_match('/change\/.*/i', $pageAddress) || preg_match('/change$/i', $pageAddress) :
        $pageNum = 'change';
    break;

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

    <nav class="navbar navbar-default">
        <div class="navButtons">

            <a class="navbar-brand">
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                Name
            </a>

            <ul class="nav navbar-nav">
                <li class="<?= ($pageNum == 'welcome') ? 'active' : ''; ?>">
                    <a href="/www"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Úvodní stránka</a>
                </li>
                <li class="<?= ($pageNum == 'add') ? 'active' : ''; ?>">
                    <a href="/www/add"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Registrace uživatele</a>
                </li>
                <li class="<?= ($pageNum == 'show') ? 'active' : ''; ?>">
                    <a href="/www/show"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Seznam uživatelů</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="jumbotron">

        <h1>Zkušební aplikace</h1>

        <?php if ($pageNum == 'show') {

            echo '<h2>Uživatelé</h2>';

            if ($storage->findKeys()) {

                echo '<table class="table table-bordered table-hover">';

                foreach ($storage->findKeys() as $user) {

                    $data = $storage->getByKey($user);

                    echo '<tr>';

                    echo '<td>';
                    if (isset($data['username'])) {
                        echo '<a href="' . '/www/change/' . $data['username'] . '">Upravit</a>';
                    }

                    echo '<td>' . (isset($data['name']) ? $data['name'] : "-") . '</td>';
                    echo '<td>' . (isset($data['username']) ? $data['username'] : "-") . '</td>';
                    echo '<td>' . (isset($data['phone']) ? $data['phone'] : "-") . '</td>';
                    echo '<td>' . (isset($data['email']) ? $data['email'] : "-") . '</td>';
                    echo '</tr>';
                }

                echo '</table>';
            } else {
                echo '<h4>žádný uživatel</h4>';
            }
        } ?>

        <?php if ($pageNum == 'add') { ?>
            <?php if ($user instanceof User) { ?>
                <div class="row">
                    <div class="col-sm-12">

                        <div class="alert alert-success" role="alert">
                            Registrace byla úspěšně dokončena.
                            <a class="btn btn-success" style="margin-left: 2%;" href="/www/add"> Registrace dalšího uživatele</a>
                        </div>

                        <h3>Data z formuláře</h3>

                        <table class="table table-bordered">
                            <tr>
                                <th>Uživatelské jméno:</th>
                                <td><?php echo Escape::html($user->getUsername()); ?></td>
                            </tr>
                            <tr>
                                <th>Jméno:</th>
                                <td><?php echo Escape::html($user->getName()); ?></td>
                            </tr>
                            <?php if ($user->hasPhone()): ?>
                                <tr>
                                    <th>Telefon:</th>
                                    <td><?php echo Escape::html($user->getPhone()); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($user->hasEmail()): ?>
                                <tr>
                                    <th>Email:</th>
                                    <td><?php echo Escape::html($user->getEmail()); ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>

                    </div>
                </div>

            <?php } else { ?>

                <h3>Registrace uživatele</h3>

                <?php if ($error !== null) { ?>
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <?php echo $error; ?>
                    </div>
                <?php } ?>

                <form action="" method="post">
                    <div class="form-group"><label for="name">Jméno *</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo Escape::html(Helpers::getFormValue('name')); ?>" autocomplete="name">
                    </div>
                    <div class="form-group"><label for="username">Uživatelské jméno *</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo Escape::html(Helpers::getFormValue('username')); ?>" autocomplete="username">
                    </div>
                    <div class="form-group"><label for="password">Heslo *</label>
                        <input type="password" class="form-control" name="password" id="password"></div>
                    <div class="form-group"><label for="phone">Telefon</label>
                        <input type="text" class="form-control" name="phone" id="phone" value="<?php echo Escape::html(Helpers::getFormValue('phone')); ?>" autocomplete="tel-national">
                    </div>
                    <div class="form-group"><label for="email">E-mail</label>
                        <input type="text" class="form-control" name="email" id="email" value="<?php echo Escape::html(Helpers::getFormValue('email')); ?>" autocomplete="email">
                    </div>
                    <input type="hidden" name="action" value="registration-form">
                    <input type="submit" name="submit" value="Registrovat se" class="btn btn-primary">
                </form>

            <?php } ?>
        <?php } ?>

        <?php if ($pageNum == '404') {
            http_response_code(404);
            echo '<h2>Stránka nenalezena :(</h2>';
        } ?>

        <?php if ($pageNum == 'welcome') { ?>
            <p>Nějaký pěkný popis téhle aplikace který může obsahovat třeba návod na ovládání nebo jiné užitečné rady.</p>
        <?php } ?>

        <?php if ($pageNum == 'change') { ?>

            <?php
            $username = preg_replace('/.*?change\//i', "", $pageAddress);
            $changing = null;
            $testUser = null;
            $e = null;

            foreach ($storage->findKeys() as $user) {
                $data = $storage->getByKey($user);
                if (isset($data['username']) && $data['username'] == $username) {
                    $changing = $user;
                }
            }

            $data = $storage->getByKey($changing);
            if ($data !== null) {
                if (Helpers::isFormSent('changing-form')) {

                    try {

                        $checkExistence = false;
                        $testUser = new User(
                            new Content\Username(Helpers::getFormValue('username')),
                            new Content\Password('aby se nereklo :)'),
                            new Content\Name(Helpers::getFormValue('name'))
                        );

                        if (Helpers::isFilled(Helpers::getFormValue('phone'))) {
                            $testUser->setPhone(new Content\Phone(Helpers::getFormValue('phone')));
                        }

                        if (Helpers::isFilled(Helpers::getFormValue('email'))) {
                            $testUser->setEmail(new Content\Email(Helpers::getFormValue('email')));
                        }
                    } catch (ValidateException $e) {
                        $error = $e->getMessage();
                    } catch (\Exception $e) {
                        Debugger::log($e, ILogger::ERROR);
                        $error = 'Omlouváme se, něco se pokazilo, zkuste to znovu později nebo nás kontaktujte na support@service.cz';
                    }

                    if ($testUser instanceof User && $e === null) {

                        $values = [];
                        $values['name'] = Helpers::getFormValue('name');
                        $values['username'] = Helpers::getFormValue('username');
                        $values['phone'] = Helpers::getFormValue('phone');
                        $values['email'] = Helpers::getFormValue('email');
                        $storage->changeInfo($changing, $values);

                        ?>

                        <div class="row">
                            <div class="col-sm-12">

                                <div class="alert alert-success" role="alert">
                                    Položky úspěšně upraveny.
                                    <a class="btn btn-success" style="margin-left: 2%;" href="/www/show"> Zobrazit seznam uživatelů</a>
                                </div>

                                <h3>Data z formuláře</h3>

                                <table class="table table-bordered">
                                    <tr>
                                        <th>Uživatelské jméno:</th>
                                        <td><?php echo Escape::html($testUser->getUsername()); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jméno:</th>
                                        <td><?php echo Escape::html($testUser->getName()); ?></td>
                                    </tr>
                                    <?php if ($testUser->hasPhone()) { ?>
                                        <tr>
                                            <th>Telefon:</th>
                                            <td><?php echo Escape::html($testUser->getPhone()); ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($testUser->hasEmail()) { ?>
                                        <tr>
                                            <th>Email:</th>
                                            <td><?php echo Escape::html($testUser->getEmail()); ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>

                            </div>
                        </div>
                    <?php } else { ?>

                        <div class="alert alert-warning" role="alert">
                            <span class="glyphicon glyphicon-warning-sign"></span>
                            Upravujete údaje
                        </div>

                        <?php if ($error !== null) { ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>
                        <?php
                    }

                    $data['name'] = Helpers::getFormValue('name');
                    $data['username'] = Helpers::getFormValue('username');
                    $data['phone'] = Helpers::getFormValue('phone');
                    $data['email'] = Helpers::getFormValue('email');
                }
                if (!$testUser instanceof User || $e !== null) {
                    ?>
                    <form action="" method="post">
                        <div class="form-group"><label for="name">Jméno *</label>
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo(isset($data['name']) ? $data['name'] : ""); ?>" autocomplete="name">
                        </div>
                        <div class="form-group"><label for="username">Uživatelské jméno *</label>
                            <input type="hidden" class="form-control" name="username" id="username" value="<?php echo(isset($data['username']) ? $data['username'] : ""); ?>" autocomplete="username">
                            <input type="text" class="form-control" name="usernamex" id="usernamex" placeholder="<?php echo(isset($data['username']) ? $data['username'] : ""); ?>" autocomplete="username" disabled>
                        </div>
                        <div class="form-group"><label for="phone">Telefon</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo(isset($data['phone']) ? $data['phone'] : ""); ?>" autocomplete="tel-national">
                        </div>
                        <div class="form-group"><label for="email">E-mail</label>
                            <input type="text" class="form-control" name="email" id="email" value="<?php echo(isset($data['email']) ? $data['email'] : ""); ?>" autocomplete="email">
                        </div>
                        <input type="hidden" name="action" value="changing-form">
                        <input type="submit" name="submit" value="Potvrdit změny" class="btn btn-primary">
                    </form>
                <?php } ?>
            <?php } else {?>
                <div class="alert alert-warning" role="alert">
                    <span class="glyphicon glyphicon-warning-sign"></span>
                    Uživatel neexistuje
                    <a class="btn btn-primary" style="margin-left: 2%;" href="/www/show"> Zobrazit seznam uživatelů</a>
                </div>
            <?php }?>
        <?php } ?>
    </div>
</div>
</body>
</html>
