<?php

namespace App\Controller;

use App\Mutator\ArrayMutator;
use Phpml\Exception\FileException;
use App\Repository\ML as MLRepository;
use App\Service\ML as MLService;
use Phpml\Exception\SerializeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AIController extends AbstractController
{
    private const TEST1 = [
        [1, 2],
        [2, 1],
        [2, 0],
        [2, 2],
        [1, 0],
        [1, 1],
    ];
    private const TEST2 = [
        [1, 0],
        [2, 0],
        [2, 2],
        [2, 1],
        [1, 2],
        [1, 1],
    ];
    private const TEST3 = [
        [1, 1],
        [2, 0],
        [2, 1],
        [2, 2],
        [1, 0],
        [1, 2],
    ];
    private const TEST4 = [
        [1, 0],
        [2, 2],
        [2, 0],
        [2, 1],
        [1, 2],
        [1, 1],
    ];

    /**
     * @throws SerializeException
     */
    #[Route('/ai/result', methods: ['POST'])]
    public function getResult(Request $request, MLRepository $ml): Response
    {
        $ml->load();
        $classifier = $ml->get();
        $result = $classifier->predict(ArrayMutator::getAllArrayValues($request->get('values')));

        return $this->json(['result' => $result]);
    }

    /**
     * @throws SerializeException
     * @throws FileException
     */
    #[Route("/ai/train", methods: ['GET'])]
    public function train(MLRepository $ml): Response
    {
        $ml->load();
        $classifier = $ml->get();

        $train = new MLService($classifier);
        $train->train();
        $ml->save();

        return $this->json(['result' => 'success']);
    }
}
