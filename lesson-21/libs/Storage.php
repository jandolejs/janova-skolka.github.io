<?php

    namespace Lesson21;
    use Nette\Utils\Strings;

    class Storage
    {
        static function save($name, $formData)
        {

            $name = Strings::webalize($name);
            $dataToWrite = json_encode($formData);
            $outputFolder = "output";

            do {
                $fileName = $name."-".rand(1000,9999);
                $outputPatch = "$outputFolder/$fileName.json";
            } while (file_exists($outputPatch));

            $outputPatch = "$outputFolder/$fileName.json";
            $outputFile = fopen($outputPatch, "wb");

            fwrite($outputFile, $dataToWrite);
            fclose($outputFile);
        }
    }
