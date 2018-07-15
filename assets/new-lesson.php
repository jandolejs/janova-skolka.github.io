<?php

$rootDir = __DIR__ . DIRECTORY_SEPARATOR . '..';

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

$currentDir = $rootDir . DIRECTORY_SEPARATOR . sprintf('lesson-%02d', $max);
$newDir = $rootDir . DIRECTORY_SEPARATOR . sprintf('lesson-%02d', $max + 1);

$cmd = sprintf('cp -r %s %s', escapeshellarg($currentDir), escapeshellarg($newDir));

exec($cmd, $cmdOutput, $cmdReturn);
if($cmdReturn > 0) {
    throw new RuntimeException('Zkopírování adresáře selhalo');
}

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
            exec($cmd, $cmdOutput, $cmdReturn);
            if ($cmdReturn > 0) {
                throw new RuntimeException("Úprava v souboru selhala - příkaz: $cmd");
            }
        }
    }
}
