<?php

namespace Lesson23;

use Nette\Utils\Random;
use Nette\Utils\Strings;
use Tracy\Debugger;

class Storage
{

    private $path;

    function __construct($path)
    {
        $this->path = $path;
    }

    function save($name, $formData)
    {
        $formData['date'] = date(DATE_ATOM);
        $dataToWrite = json_encode($formData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $filePath = $this->getNewFilePath($name);

        $isFileSaved = @file_put_contents($filePath, $dataToWrite);

        if ($isFileSaved === false) {
            throw new StorageException('Unable to save file ' . $filePath);
        }
    }


    function getNewFilePath($name)
    {
        $outputFolder = $this->path;

        $date = date('Y-m-d-H-i-s');
        $name = $this->sanitizeName($name);
        $random = Random::generate(4);

        return "$outputFolder/$date-$name-$random.json";
    }


    function sanitizeName($name)
    {
        $name = Strings::webalize($name);
        $name = Strings::truncate($name, '30', '');
        return $name;
    }
}
