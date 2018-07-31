<?php

    namespace Lesson21\Storage;
    use Nette\Utils\Strings;

    class Storage
    {

        static function save($name, $formData)
        {

            $formData['sendTime'] = date('y-m-d--h-m');
            $dataToWrite = json_encode($formData);
            $outputFolder = __DIR__."/../output";

            if (file_exists($outputFolder)) {

                $name = Storage::getNewFileName($name, $outputFolder);
                $outputFile = $outputFolder.'/'.$name.'.json';

                $outputFile = fopen($outputFile, "wb");
                fwrite($outputFile, $dataToWrite);
                fclose($outputFile);
            } else {
                throw new StorageException("Soubor s údaji nelze uložit!");
            }
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
