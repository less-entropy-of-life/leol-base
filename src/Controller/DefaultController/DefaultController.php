<?php

namespace App\Controller\DefaultController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function index()
    {
        return new Response('less entropy of life v1 api');
    }

    public function successResponse(array $data, int $code = 200)
    {
        return new JsonResponse(['response' => $data], $code);
    }

    public function errorResponse(string $msg, array $params = [], int $code = 200)
    {
        return new JsonResponse(['error' => ['message' => $msg, 'params' => $params]], $code);
    }
}