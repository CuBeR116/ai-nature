<?php

namespace App\Controller;

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
    /**
     * @throws SerializeException
     */
    #[Route('/ai/result', methods: ['POST'])]
    public function getResult(Request $request, MLRepository $ml): Response
    {
        $ml->load();
        $classifier = $ml->get();
        $values = $request->get('values');
        $predict = $classifier->predict($values);

        return $this->json(['result' => $predict]);
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
