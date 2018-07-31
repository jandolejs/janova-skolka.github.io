<?php

namespace Lesson22\Mail;

class Mailer
{
    /**
     * @param array $data
     * @return array
     * @throws MailerException
     */
    public static function sendMail(array $data): array
    {
        return self::submitData('https://sql.jandolejs.cz/send-mail', $data);
    }


    /**
     * @param $url
     * @param $data
     * @return array
     * @throws MailerException
     */
    private static function submitData($url, $data): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
            ],
        ]);

        $response = curl_exec($curl);

        if ($err = curl_error($curl)) {
            throw new MailerException($err);
        }

        $content = \json_decode($response, true);
        if (!\is_array($content)) {
            throw new MailerException('Unable to decode response (JSON)');
        }
        /** @var array $content */

        $code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        if ($code !== 200) {
            $message = $content['error'];
            if (isset($content['tip'])) {
                $message .= " ({$content['tip']})";
            }
            throw new MailerException($message, $code);
        }

        curl_close($curl);
        return $content;
    }
}
