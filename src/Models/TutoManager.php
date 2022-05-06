<?php

namespace tutoAPI\Models;

use tutoAPI\Services\Manager;

class TutoManager extends Manager
{

    public function find($id)
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos WHERE id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        // Instanciation d'un tuto
        $tuto = new Tuto();
        $tuto->setId($result["id"]);
        $tuto->setTitle($result["title"]);
        $tuto->setDescription($result["description"]);
        $tuto->setCreatedAt($result["createdAt"]);

        // Retour
        return $tuto;
    }

    public function findAll($page = 0)
    {

        // Connexion à la BDD
        $dbh = static::connectDb();
        $page = $_GET['page'];
        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos ORDER BY id ASC   LIMIT '.$page.'');
        $sth->execute();

        $tutos = [];

        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {

            $tuto = new Tuto();
            $tuto->setId($row['id']);
            $tuto->setTitle($row['title']);
            $tuto->setDescription($row['description']);
            $tuto->setCreatedAt($row["createdAt"]);
            $tutos[] = $tuto;
        }

        return $tutos;
    }

    public function add(Tuto $tuto)
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('INSERT INTO tutos (title, description, createdAt) VALUES (:title, :description, :createdAt)');
        $title = $tuto->getTitle();
        $sth->bindParam(':title', $title);
        $description = $tuto->getDescription();
        $sth->bindParam(':description', $description);
        $createdAt = $tuto->getCreatedAt();
        $sth->bindParam(':createdAt', $createdAt);
        $sth->execute();

        // Retour
        $id = $dbh->lastInsertId();
        $tuto->setId($id);
        return $tuto;
    }

    public function update($id)
    {
        $dbh = static::connectDb();
        $sth = $dbh->prepare('UPDATE `tutos` SET `title` = :title ,`description` = :description where `id` = :id ');
        parse_str(file_get_contents('php://input'), $_PATCH);



        $sth->bindParam(':id', $id);

        $sth->bindParam(':title', $_PATCH['title']);

        $sth->bindParam(':description', $_PATCH['description']);

        $sth->execute();
    }

    public function delete($id)
    {
        $dbh = static::connectDb();
        $sth = $dbh->prepare('DELETE FROM tutos WHERE id= :id');


        $sth->bindParam(':id', $id);

        $sth->execute();
    }
}
