<?php

$rootDir = __DIR__ . DIRECTORY_SEPARATOR . '..';

echo "\n\nGenerátor nové lekce\n";
echo "====================\n\n";

$max = 0;
foreach (new DirectoryIterator($rootDir) as $file) {
    if (is_dir($file->getPathname()) && preg_match('/^lesson-(\d+)\Z/', $file->getFilename(), $matches)) {
        $num = (int)$matches[1];
        if ($max < $num) {
            $max = $num;
        }
    }
}

if ($max === 0) {
    throw new RuntimeException('Vypadá to jako by se nepovedlo najíz žádné lekce');
}

echo "Poslední nalezená lekce: $max\n";

$currentDir = $rootDir . DIRECTORY_SEPARATOR . sprintf('lesson-%02d', $max);
$newDir = $rootDir . DIRECTORY_SEPARATOR . sprintf('lesson-%02d', $max + 1);

$cmd = sprintf('cp -r %s %s', escapeshellarg($currentDir), escapeshellarg($newDir));

echo "Vytvářím novou lekci podle poslední:\n - $cmd\n";
exec($cmd, $cmdOutput, $cmdReturn);
if($cmdReturn > 0) {
    throw new RuntimeException('Zkopírování adresáře selhalo');
}

echo "Upravuji PHP soubory:\n";

/** @var SplFileInfo $file */
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($newDir,
    FilesystemIterator::SKIP_DOTS)) as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        foreach (['Lekce %d', 'Lesson%d'] as $token) {
            $cmd = sprintf(
                "sed -i '' 's/$token/$token/g' %s",
                $max,
                $max + 1,
                escapeshellarg($file->getPathname())
            );

            echo " - $cmd\n";
            exec($cmd, $cmdOutput, $cmdReturn);
            if ($cmdReturn > 0) {
                throw new RuntimeException("Úprava v souboru selhala - příkaz: $cmd");
            }
        }
    }
}

$max++;
echo "Hotovo, lekce $max je připravena!\n";
