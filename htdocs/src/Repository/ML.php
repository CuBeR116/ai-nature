<?php

declare(strict_types = 1);

namespace App\Repository;

use Phpml\Estimator;
use Phpml\ModelManager;
use App\Enum\ML as MLEnum;
use Phpml\Exception\FileException;
use Phpml\Exception\SerializeException;
use Phpml\Classification\KNearestNeighbors;

class ML
{
    private Estimator $classifier;
    private ModelManager $modelManager;

    public function __construct()
    {
        $this->modelManager = new ModelManager();
    }

    /**
     * @throws FileException
     * @throws SerializeException
     */
    public function save(): void
    {
        $this->modelManager->saveToFile($this->classifier, MLEnum::SAVE_DIR);
    }

    /**
     * @throws SerializeException
     */
    public function load():void
    {
        try {
            $this->classifier = $this->modelManager->restoreFromFile(MLEnum::SAVE_DIR);
        } catch (FileException $e) {
            $this->classifier = new KNearestNeighbors();
        }
    }
    
    public function get(): Estimator
    {
        return $this->classifier;
    }
}
