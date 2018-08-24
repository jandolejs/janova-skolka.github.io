<?php

namespace App\Storage;

use Nette\Utils\Random;
use Nette\Utils\Strings;

class Storage
{

    private $path;
    private $files;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function findKeys()
    {

        $data = [];
        $this->files = scandir($this->path);

        foreach ($this->files as $file) {
            if (preg_match('/^\d{4}(-\d\d){5}-.+\.json$/', $file)) {
                $data[] = $file;
            }
        }

        return $data;
    }

    public function getByKey($key)
    {

        $content = file_get_contents($this->path . "/" . $key);
        $data = json_decode($content, true);

        return $data;
    }

    public function save($name, $data)
    {
        $dataToWrite = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $filePath = $this->getNewFilePath($name);

        $isFileSaved = @file_put_contents($filePath, $dataToWrite);

        if ($isFileSaved === false) {
            throw new StorageException('Unable to save file ' . $filePath);
        }
    }

    private function getNewFilePath($name)
    {
        $outputFolder = $this->path;

        $date = date('Y-m-d-H-i-s');
        $name = $this->sanitizeName($name);
        $random = Random::generate(4);

        return "$outputFolder/$date-$name-$random.json";
    }

    private function sanitizeName($name)
    {
        $name = Strings::webalize($name);
        $name = Strings::truncate($name, '30', '');
        return $name;
    }
}
