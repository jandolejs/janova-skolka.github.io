<?php

    namespace Lesson21;
    use Nette\Utils\Strings;

    class Storage
    {

        static function save($name, $formData)
        {

            $formData['sendTime'] = date('y-m-d--h-m');
            $dataToWrite = json_encode($formData);
            $outputFolder = "output";

            $name = Storage::getNewFileName($name, $outputFolder);
            $outputPatch = __DIR__."/../$outputFolder/$name.json";
            if(!$outputFile = fopen($outputPatch, "wb")) {
                throw new StorageException("Soubor s údaji nebylo možné uložit!");
            }

            fwrite($outputFile, $dataToWrite);
            fclose($outputFile);
        }

        static function getNewFileName($name, $outputFolder)
        {

            $name = Strings::webalize($name);

            do {
                $name = $name."-".rand(1000,9999);
                $outputPatch = "$outputFolder/$name.json";
            } while (file_exists($outputPatch));

            return $name;
        }
    }
