<?php

namespace tutoAPI\Controllers;

use tutoAPI\Models\TutoManager;
use tutoAPI\Models\Tuto;
use tutoAPI\Controllers\abstractController;

class tutoController extends abstractController
{

    public function show($id)
    {

        // Données issues du Modèle

        $manager = new TutoManager();

        $tuto = $manager->find($id);

        // Template issu de la Vue

        return $this->jsonResponse($tuto, 200);
    }

    public function index()
    {

        $tutos = [];

        $manager = new TutoManager();

        $tutos = $manager->findAll();

        return $this->jsonResponse($tutos, 200);
    }

    public function add()
    {

        // Ajout d'un tuto
        $tuto = new Tuto;
        $tuto->setTitle($_POST['title']);
        $tuto->setDescription($_POST['description']);
        $now = new \DateTime;
        $dateString = strtotime('%Y-%m-%d', $now->getTimestamp());

        $tuto->setCreatedAt(strtotime('%Y-%m-%d', $dateString));

        $manager = new TutoManager();
        $tuto = $manager->add($tuto);

        // TODO: ajout d'un tuto

        return $this->jsonResponse($tuto, 201);
    }
    public function patch($id)
    {
       

        $manager = new TutoManager();
  
        $tutos = $manager->update($id);

        return $this->jsonResponse($tutos, 200);
    }
    public function deletes($id)
    {
       

        $manager = new TutoManager();
       
        $tutos = $manager->delete($id);

        return $this->jsonResponse($tutos, 200);
    }
}
