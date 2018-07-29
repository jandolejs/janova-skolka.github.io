<?php

    namespace Lesson21;

    class Storage
    {
        private $name;
        private $formData;

        function __construct(Name $name, Data $formData)
        {
            $this->name = $name;
            $this->data = $formData;
        }

        function createFile() {

            $dataToWrite = json_encode($this->data);
            $outputFolder = "output";

            $fileName = getNewFileName($this->name, $outputFolder);
            $outputPatch = "$outputFolder/$fileName.json";
            $outputFile = fopen($outputPatch, "wb");

            fwrite($outputFile, $dataToWrite);
            fclose($outputFile);

        }

        function getNewFileName()
        {

            do {
                $fileName = $this->name."_".rand(1000,9999);
                $outputPatch = "$outputFolder/$fileName.json";
            } while (file_exists($outputPatch));

            return $fileName;
        }
    }
