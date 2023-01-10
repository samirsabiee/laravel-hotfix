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
     * @return string
     */
    private function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     * @return StubManager
     * @throws Exception
     */
    public function setPath(string $path = null): static
    {
        if (is_null($path)) {
            return $this;
        }
        if(str_contains('\\', $path)){
            throw new Exception('The address must not contain \ character Use / instead');
        }
        $this->path = $path;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function create(bool $forceOverwrite)
    {
        $stubPath = __DIR__ . '/Stubs/Hotfix.stub';

        // If we cant find the stub at all simply fail.
        if (!file_exists($stubPath)) {
            throw new Exception ('Could not find stub in path ' . $stubPath);
        }

        if (!file_exists(base_path($this->getPath()))) {
            mkdir($this->getPath(), 0755, true);
        }

        $outputFile = $this->getPath() . '/' . $this->getName() . '.php';

        if ($forceOverwrite === false && file_exists($outputFile)) {
            throw new Exception($outputFile . ' already exists, consider trying with "--force" to overwrite.');
        }

        $stubContent = file_get_contents($stubPath);

        $namespace = [];

        foreach (explode('/', $this->getPath()) as $dir){
            $namespace[] = ucfirst($dir);
        }

        $namespace = implode('/', $namespace);

        $newContent = str_replace('{NAMESPACE}', $namespace, $stubContent);

        $newContent = str_replace('{CLASS_NAME}', $this->getName(), $newContent);

        if (!file_put_contents($outputFile, $newContent)) {
            throw new Exception('Could not write to ' . $outputFile);
        }

        return $outputFile;
    }
}
