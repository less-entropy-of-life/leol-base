<?php

namespace App\Service\TodoListService;

use App\Service\DefaultService\DefaultService;

class TodoListService extends DefaultService
{
    public function addTask(int $userId, string $title, string $description = null, int $categoryId = 0) : ?Array
    {
        $db = $this->getDatabaseConnection();

        if (!$db)
            return null;

        $q = $db->prepare('
            insert into user_todo_task (
                title,
                description,
                user_id
            ) values (
                :title,
                :description,
                :user_id
            ) returning id
        ');

        $q->bindParam(':title', $title, \PDO::PARAM_STR);
        $q->bindParam(':description', $description, \PDO::PARAM_STR);
        $q->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $q->execute();

        $r = $q->fetch();

        if ($r && array_key_exists('id', $r))
            return $this->getTask($r['id']);

        return null;
    }

    public function getTask(int $taskId) : ?Array
    {
        $db = $this->getDatabaseConnection();

        if (!$db)
            return null;

        $q = $db->prepare('select id, title, description from user_todo_task where id = :id');
        
        $q->bindParam(':id', $taskId, \PDO::PARAM_INT);
        $q->execute();

        $r = $q->fetch();

        if ($r)
            return $r;

        return null;
    }
}