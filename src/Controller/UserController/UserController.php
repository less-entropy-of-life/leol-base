<?php

namespace App\Controller\UserController;

use App\Controller\DefaultController\DefaultController;
use App\Service\UserService\UserService;
use Symfony\Component\HttpFoundation\Request;

class UserController extends DefaultController
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function add(Request $request)
    {
        if (!$request->isMethod('POST'))
            return $this->errorResponse('method not allowed', $request->query->all());

        $firstName = $request->request->get('first_name');
        $lastName = $request->request->get('last_name');
        $pin = $request->request->get('pin');

        if (!$firstName)
            return $this->errorResponse(
                'Request failed: required parameter \"firstName\" not passed', 
                $request->request->all()
            );

        if (!$lastName)
            return $this->errorResponse(
                'Request failed: required parameter \"lastName\" not passed', 
                $request->request->all()
            );

        if (!$pin)
            return $this->errorResponse(
                'Request failed: required parameter \"pin\" not passed', 
                $request->request->all()
            );

        $user = $this->userService->addUser($firstName, $lastName, $pin);

        return $this->successResponse(['user' => $user]);
    }
}