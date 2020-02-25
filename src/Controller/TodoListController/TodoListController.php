<?php

namespace App\Controller\TodoListController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\DefaultController\DefaultController;
use App\Service\TodoListService\TodoListService;

/**
 * Class for work with TODO-lists.
 * allow methods:
 * - add - add new task to todo-list;
 * - get - get list of tasks for user;
 * - edit - change task-date;
 * - delete - delete task from todo-list;
 * - move.
 */
class TodoListController extends DefaultController
{
    public function __construct(TodoListService $todoListService)
    {
        $this->todoListService = $todoListService;
    }

    /**
     * Add task to todo-list.
     * 
     * @return default task object
     * 
     * @final
     */
    public function add(Request $request)
    {
        if (!$request->isMethod('POST'))
            return $this->errorResponse('method not allowed', $request->query->all());

        $token = $request->request->get('access_token');
        $title = $request->request->get('title');
        $description = $request->request->get('description');

        if (!$token)
            return $this->errorResponse('Request failed: required parameter \"token\" not passed', $request->request->all());

        if (!$title)
            return $this->errorResponse('Request failed: required parameter \"title\" not passed', $request->request->all());

        $task = $this->todoListService->addTask(1, $title, $description);

        return $this->successResponse(['task' => $task]);
    }
}