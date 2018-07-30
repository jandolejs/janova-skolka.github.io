<?php

    namespace Lesson21;

    class Storage
    {
        static function save($name, $formData)
        {

            $dataToWrite = json_encode($formData);
            $outputFolder = "output";

            do {
                $fileName = $name."_".rand(1000,9999);
                $outputPatch = "$outputFolder/$fileName.json";
            } while (file_exists($outputPatch));

            $outputPatch = "$outputFolder/$fileName.json";
            $outputFile = fopen($outputPatch, "wb");

            fwrite($outputFile, $dataToWrite);
            fclose($outputFile);
        }
    }
