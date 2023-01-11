<?php

namespace SamirSabiee\Hotfix;

use Exception;

class StubManager
{
    protected string $name;

    protected string $path = 'app/Hotfixes';

    protected array $config;

    public function __construct()
    {
        $this->config = config('hotfix');
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return StubManager
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function create()
    {
        $stubPath = __DIR__ . '/Stubs/Hotfix.stub';

        // If we cant find the stub at all simply fail.
        if (!file_exists($stubPath)) {
            throw new Exception ('Could not find stub in path ' . $stubPath);
        }

        $outputFile = $this->getPath() . '/' . now()->timestamp . '_' . $this->getName() . '.php';

        if (file_exists($outputFile)) {
            throw new Exception($outputFile . ' already exists');
        }

        $stubContent = file_get_contents($stubPath);

        $namespace = ['App', 'Hotfixes'];
        $dirs = explode('/', $this->getName());
        $className = array_pop($dirs);
        foreach ($dirs as $dir) {
            $namespace[] = $dir;
        }

        $namespace = implode('\\', $namespace);

        $newContent = str_replace('{NAMESPACE}', $namespace, $stubContent);

        $newContent = str_replace('{CLASS_NAME}', $className, $newContent);

        if (!file_exists(base_path($this->getPath() . '/' . implode('/', $dirs)))) {
            mkdir(base_path($this->getPath() . '/' . implode('/', $dirs)), 0755, true);
        }

        if (!file_put_contents($outputFile, $newContent)) {
            throw new Exception('Could not write to ' . $outputFile);
        }

        return $outputFile;
    }
}
