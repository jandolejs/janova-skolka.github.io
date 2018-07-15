<?php

namespace ServerSide;

set_exception_handler(function (\Exception $e) {
    errorResponse(
        'Unhandled exception ' . \get_class($e) . ', with message: ' . $e->getMessage(),
        null,
        500
    );
});

require_once __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    errorResponse('Invalid method', 'You must use POST request', 405);
}

try {
    $name = new Name(getPost('name', ''));
    $email = new Email(getPost('email', ''));
    $phone = getPost('phone', null) !== null ? new Phone(getPost('phone', '')) : '-';
    $message = new Message(getPost('message', ''));
} catch (ValidatorException $e) {
    errorResponse('Validation error: ' . $e->getMessage(), null, 400);
}

$allowedRecipients = [
    'pan@jakubboucek.cz',
    'jandolejs1999@gmail.com',
    'janova-skolka@googlegroups.com',
];

if (!\in_array($email->getContent(), $allowedRecipients, true)) {
    errorResponse(
        'Is not allowed to sending message to ' . $email->getContent(),
        'Try use one of emails: ' . implode(', ', $allowedRecipients),
        403
    );
}

$ses = AwsLoader::getAws()->createSes();

$messageText = <<<EOT
Vážený pane $name,
děkujeme za vaši zprávu.

===========================
Rekapitulace zaslané zprávy
===========================
Jméno: $name,
Telefon: $phone,
Email: $email,
Zpráva: $message
EOT;


$response = $ses->sendEmail([
    'Source' => '"Janova skolka" <janova.skolka@ion.cz>',
    'Destination' => [
        'ToAddresses' => [$email->getContent()]
    ],
    'Message' => [
        'Body' => [
            'Text' => [
                'Data' => $messageText
            ]
        ],
        'Subject' => [
            'Data' => 'Potvrzení odeslané zprávy'
        ]
    ]
]);

sendResponse(['status' => true, 'messageId' => $response['MessageId']]);

function getPost($name, $default = null)
{
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }

    return $default;
}


function successResponse($data)
{
    $response = [
        'data' => $data,
    ];
    sendResponse($response);
    die();
}


function errorResponse($message, $tip = null, $code = 500)
{
    $response = [
        'error' => $message,
    ];
    if ($tip) {
        $response['tip'] = $tip;
    }
    sendResponse($response, $code);
    die();
}


function sendResponse($response, $code = null)
{
    header('Content-Type: application/json; charset=utf-8', true, $code);
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}