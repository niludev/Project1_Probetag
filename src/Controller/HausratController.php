<?php

namespace App\Controller;

use App\Entity\Anfrage;
use App\Entity\Enum\Selbstbeteiligung;
use App\Repository\TarifRepository;
use App\Service\Beitragsrechner;
use App\Service\TarifEmpfehlung;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HausratController extends AbstractController
{
    #[Route('/', name: 'hausrat_form')]
    public function form(
        Request $request,
        TarifRepository $tarifRepository,
        EntityManagerInterface $em,
        Beitragsrechner $beitragsrechner,
        TarifEmpfehlung $tarifEmpfehlung,
    ): Response
    {
        if ($request->isMethod('POST')) {
            $data = $this->validateValues($request);

            if (count($data['errors']) > 0) {
                return $this->render('hausrat/form.html.twig', [
                    'errors' => $data['errors'],
                ]);
            }

            $tarife = $tarifRepository->findAll();
            $ergebnisse = [];

            foreach ($tarife as $tarif) {
//            Beitragsrechner::jahresbeitragsRechner($jahresbeitrag, $tarif);

                $jahresbeitrag = $beitragsrechner->jahresbeitragsRechner(
                    $tarif,
                    $data['wohnflaeche'],
                    $data['fahrrad'],
                    $data['glas'],
                    $data['elementar'],
                    Selbstbeteiligung::from($data['selbstbeteiligung']),
                );

                $ergebnisse[] = [
                    'name' => $tarif->getName(),
                    'jahresbeitrag' => $jahresbeitrag,
                    'monatsbeitrag' => round($jahresbeitrag / 12, 2),
                ];
            }

            usort($ergebnisse, function (array $a, array $b) {
                return $a['jahresbeitrag'] <=> $b['jahresbeitrag'];
            });

            $empfehlung = $tarifEmpfehlung->empfehlung($data['wohnflaeche'], $data['glas'], $data['elementar'], $data['fahrrad']);

            $anfrage = new Anfrage();
            $anfrage->setEmpfehlung($empfehlung['tarif']);
            $anfrage->setElementar($data['elementar']);
            $anfrage->setFahrrad($data['fahrrad']);
            $anfrage->setGlas($data['glas']);
            $anfrage->setSelbstbeteiligung($data['selbstbeteiligung']);
            $anfrage->setPlz($data['plz']);
            $anfrage->setWohnflaeche($data['wohnflaeche']);
            $anfrage->setErstelltAm(new \DateTimeImmutable());
            $anfrage->setErgebnis($ergebnisse);

            $em->persist($anfrage);
            $em->flush();

            return $this->redirectToRoute('anfrage_show', ['id' => $anfrage->getId()],);
        }

        return $this->render('hausrat/form.html.twig', [
            'errors' => []]);
    }

    #[Route('/anfrage/{id}', name: 'anfrage_show')]
    public function show(
        Anfrage $anfrage,
        TarifEmpfehlung $tarifEmpfehlung,
    ): Response
    {
        $empfehlung = $tarifEmpfehlung->empfehlung(
            $anfrage->getWohnflaeche(),
            $anfrage->isGlas(),
            $anfrage->isElementar(),
            $anfrage->isFahrrad(),
        );

        $versicherungssumme = $anfrage->getWohnflaeche() * 650;

        return $this->render('hausrat/result.html.twig', [
            'ergebnisse' => $anfrage->getErgebnis(),
            'empfehlung' => $empfehlung,
            'versicherungssumme' => $versicherungssumme,
        ]);
    }

    private function validateValues(Request $request):array {
        $wohnflaeche = (int) $request->request->get('wohnflaeche');
        $plz = $request->request->get('plz');
        $selbstbeteiligung = (int) $request->request->get('selbstbeteiligung');
        $fahrrad = $request->request->getBoolean('fahrrad');
        $glas = $request->request->getBoolean('glas');
        $elementar = $request->request->getBoolean('elementar');

        $errors = [];

        if ($wohnflaeche < 10 || $wohnflaeche > 500) {
            $errors['wohnflaeche'] = 'Wohnfläche muss zwischen 10 und 500 m² liegen.';
        }

        if (!preg_match('/^[0-9]{5}$/', $plz)) {
            $errors['plz'] = 'Postleitzahl  muss genau 5 Ziffern haben.';
        }

        if (!in_array($selbstbeteiligung, [0, 150, 300], true)) {
            $errors['selbstbeteiligung'] = 'Ungültige Selbstbeteiligung (0 oder 150 oder 300).';
        }

        return [
            'wohnflaeche' => $wohnflaeche,
            'plz' => $plz,
            'selbstbeteiligung' => $selbstbeteiligung,
            'fahrrad' => $fahrrad,
            'glas' => $glas,
            'elementar' => $elementar,
            'errors' => $errors,
        ];
    }
}
