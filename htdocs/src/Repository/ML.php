<?php

declare(strict_types = 1);

namespace App\Repository;

use Phpml\Estimator;
use Phpml\ModelManager;
use App\Enum\ML as MLEnum;
use Phpml\Exception\FileException;
use Phpml\Exception\SerializeException;
use Phpml\Classification\KNearestNeighbors;
use Symfony\Component\HttpKernel\KernelInterface;

class ML
{
    private Estimator $classifier;
    private ModelManager $modelManager;
    private string $rootPath;

    public function __construct(KernelInterface $kernel)
    {
        $this->rootPath = $kernel->getProjectDir() . '/public/upload';
        $this->modelManager = new ModelManager();
    }

    /**
     * @throws FileException
     * @throws SerializeException
     */
    public function save(): void
    {
        $this->modelManager->saveToFile($this->classifier, $this->rootPath . MLEnum::SAVE_DIR);
    }

    /**
     * @throws SerializeException
     */
    public function load():void
    {
        try {
            $this->classifier = $this->modelManager->restoreFromFile($this->rootPath . MLEnum::SAVE_DIR);
        } catch (FileException $e) {
            $this->classifier = new KNearestNeighbors();
        }
    }
    
    public function get(): Estimator
    {
        return $this->classifier;
    }
}
