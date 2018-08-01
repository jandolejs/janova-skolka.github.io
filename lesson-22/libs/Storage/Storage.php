<?php

namespace Lesson22;

use Nette\Utils\Random;
use Nette\Utils\Strings;

class Storage
{

    private $path;

    function __construct(Path $path)
    {
        $this->path = $path;
    }

    static function save($name, $formData)
    {
        $formData['date'] = date(DATE_ATOM);
        $dataToWrite = json_encode($formData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $filePath = self::getNewFilePath($name);

        $isFileSaved = @file_put_contents($filePath, $dataToWrite);

        if ($isFileSaved === false) {
            throw new StorageException("Soubor $filePath se nepodařilo uložit");
        }
    }


    static function getNewFilePath($name)
    {
        $outputFolder = $this->path;

        $date = date('Y-m-d-H-i-s');
        $name = self::sanitizeName($name);
        $random = Random::generate(4);

        return "$outputFolder/$date-$name-$random.json";
    }


    static function sanitizeName($name)
    {
        $name = Strings::webalize($name);
        $name = Strings::truncate($name, '30', '');
        return $name;
    }
}
