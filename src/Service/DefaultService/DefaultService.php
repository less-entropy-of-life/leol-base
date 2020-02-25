<?php

namespace App\Service\DefaultService;

class DefaultService
{
    protected function getDatabaseConnection() : \PDO
    {
        try {
            $dbh = new \PDO($_ENV['DATABASE_URL']);
            $dbh->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (\PDOException $th) {
            throw $th;
        }

        return $dbh;
    }
}