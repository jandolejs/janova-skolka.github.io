<?php

namespace ServerSide;

/**
 * Class AwsLoader
 * @package ServerSide
 */
class AwsLoader
{
    /**
     * @return \Aws\Sdk
     */
    public static function getAws(): \Aws\Sdk
    {
        $config = [
            'version' => 'latest',
            'region' => 'eu-west-1',
            'credentials' => [
                'key' => 'AKIAJBNCW53DVHSOOGBA',
                'secret' => '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'
            ]
        ];
        return new \Aws\Sdk($config);
    }
}
