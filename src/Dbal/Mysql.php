<?php

namespace Masterclass\Dbal;
use PDO;

class Mysql extends AbstractDb
{
    public function fetchOne($sql, array $bind = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql, array $bind = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute($sql, array $bind = [])
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($bind);
    }

}