<?php

    namespace Lesson21;
    use Nette\Utils\Strings;

    class Storage
    {
        static function save($name, $formData)
        {

            $dataToWrite = json_encode($formData);
            $outputFolder = "output";

            do {
                $name = Storage::getNewFileName($name);
                $outputPatch = "$outputFolder/$name.json";
            } while (file_exists($outputPatch));

            $outputPatch = "$outputFolder/$name.json";
            $outputFile = fopen($outputPatch, "wb");

            fwrite($outputFile, $dataToWrite);
            fclose($outputFile);
        }

        static function getNewFileName($name)
        {

            $name = Strings::webalize($name);
            $name = $name."-".rand(1000,9999);

            return $name;
        }
    }
