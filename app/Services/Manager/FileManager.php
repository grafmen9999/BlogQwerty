<?php
namespace App\Services\Manager;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\File;

class FileManager
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    private function createDirectory($dirNames)
    {
        if ($this->filesystem->missing($dirNames)) {
            $this->filesystem->makeDirectory($dirNames, 0755, true, true);
            $file = fopen($dirNames . '.gitignore', 'w');
            fprintf($file, "*\n!.gitignore");
            fclose($file);
        }
    }

    private function store(string $path, $file)
    {
        // save file to storage
        $file = new File($file);
        return $this->filesystem->copy($file, $path);
    }

    public function create(string $directory, string $filename, $file, bool $isCreateDirectory = true)
    {
        if ($isCreateDirectory) {
            $this->createDirectory($directory);
        }

        return $this->store($directory . $filename, $file);
    }

    public function rename($oldName, $newName)
    {
        return $this->filesystem->move($oldName, $newName);
    }
}
