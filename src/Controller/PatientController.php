<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/patient")
 */
class PatientController extends AbstractController
{
    
    private $flashMessage;
    public function __construct(FlashBagInterface $flashMessage){
        $this->flashMessage = $flashMessage;
        
    }
    /**
     * @Route("/", name="app_patient_index", methods={"GET"})
     */
    public function index(PatientRepository $patientRepository): Response
    {
        $user = $this->getUser();
        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findAll(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/new", name="app_patient_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PatientRepository $patientRepository): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $user = $this->getUser();
            // $patient->setUser($user);
            $patientRepository->add($patient, true);
            $this->flashMessage->add("success","Vous avez ajouté un Patient");
            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_patient_show", methods={"GET"})
     */
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_patient_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Patient $patient, PatientRepository $patientRepository): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patientRepository->add($patient, true);
            $this->flashMessage->add("success","Vous avez modifier le Patient");

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_patient_delete", methods={"GET"})
     */
    public function delete(Patient $patient, PatientRepository $patientRepository): Response
    {
            $patientRepository->remove($patient, true);
            $this->flashMessage->add("error","Vous avez supprimé le Patient");

        return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
    }

    public function connexion(){
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
    }
}
