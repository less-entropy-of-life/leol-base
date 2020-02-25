<?php

namespace App\Service\UserService;

use App\Service\DefaultService\DefaultService;

class UserService extends DefaultService
{
    public function addUser(string $firstName, string $lastName, string $pin) : ?Array
    {
        $db = $this->getDatabaseConnection();

        if (!$db)
            return null;

        $q = $db->prepare('
            insert into user_profile (
                first_name,
                last_name,
                pin
            ) values (
                :fname,
                :lname,
                :pin
            ) returning id
        ');

        $pinHash = md5(sha1($pin));

        $q->bindParam(':fname', $firstName, \PDO::PARAM_STR);
        $q->bindParam(':lname', $lastName, \PDO::PARAM_STR);
        $q->bindParam(':pin', $pinHash, \PDO::PARAM_STR);
        $q->execute();

        $r = $q->fetch();

        if ($r && array_key_exists('id', $r))
            return $this->getUser($r['id']);
        
        return null;
    }

    public function getUser(int $userId) : ?Array
    {
        $db = $this->getDatabaseConnection();

        if (!$db)
            return null;

        $q = $db->prepare('
            select 
                id,
                first_name, 
                last_name, 
                picture
            from
                user_profile
            where
                id = :id
        ');

        $q->bindParam(':id', $userId, \PDO::PARAM_INT);
        $q->execute();

        $r = $q->fetch();

        if ($r)
            return $r;
        
        return null;
    }
}