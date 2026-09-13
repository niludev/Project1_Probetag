<?php

namespace App\Controller;

use App\Entity\Anfrage;
use App\Repository\TarifRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    #[Route('/api/tarife', name: 'api_tarife', methods: ['GET'])]
    public function tarife(TarifRepository $tarifRepository): Response {
        $tarife = $tarifRepository->findAll();
        $data = [];

        foreach ($tarife as $tarif) {
            $data[] = [
                'name' => $tarif->getName(),
                'preisProQm' => $tarif->getPreisProQm(),
                'glasInklusive' => $tarif->isGlasInklusive(),
                'leistungen' => $tarif->getLeistungen(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/api/anfragen/{id}', name: 'api_anfrage_show', methods: ['GET'])]
    public function anfrageShow(Anfrage $anfrage) {
        $data = [];

        $data = [
            'id' => $anfrage->getId(),
            'wohnflaeche' => $anfrage->getWohnflaeche(),
            'plz' => $anfrage->getPlz(),
            'selbstbeteiligung' => $anfrage->getSelbstbeteiligung(),
            'fahrrad' => $anfrage->isFahrrad(),
            'glas' => $anfrage->isGlas(),
            'elementar' => $anfrage->isElementar(),
            'ergebnis' => $anfrage->getErgebnis(),
            'empfehlung' => $anfrage->getEmpfehlung(),
            'erstelltAm' => $anfrage->getErstelltAm(),
        ];

        return $this->json($data);
    }
}
