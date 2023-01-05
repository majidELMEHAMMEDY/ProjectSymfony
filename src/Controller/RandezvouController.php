<?php

namespace App\Controller;

use App\Entity\Randezvou;
use App\Form\RandezvouType;
use App\Repository\RandezvouRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * @Route("/randezvou")
 */
class RandezvouController extends AbstractController
{
    private $flashMessage;
    public function __construct(FlashBagInterface $flashMessage){
        $this->flashMessage = $flashMessage;
        
    }
    /**
     * @Route("/", name="app_randezvou_index", methods={"GET"})
     */
    public function index(RandezvouRepository $randezvouRepository): Response
    {
        return $this->render('randezvou/index.html.twig', [
            'randezvous' => $randezvouRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_randezvou_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RandezvouRepository $randezvouRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $randezvou = new Randezvou();
        $form = $this->createForm(RandezvouType::class, $randezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $randezvouRepository->add($randezvou, true);
            $this->flashMessage->add("success","Vous avez ajouté un Rendez vous");
            return $this->redirectToRoute('app_randezvou_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('randezvou/new.html.twig', [
            'randezvou' => $randezvou,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_randezvou_show", methods={"GET"})
     */
    public function show(Randezvou $randezvou): Response
    {
        return $this->render('randezvou/show.html.twig', [
            'randezvou' => $randezvou,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_randezvou_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Randezvou $randezvou, RandezvouRepository $randezvouRepository): Response
    {
        $form = $this->createForm(RandezvouType::class, $randezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $randezvouRepository->add($randezvou, true);
            $this->flashMessage->add("success","Vous avez modifié le Rendez vous");
            return $this->redirectToRoute('app_randezvou_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('randezvou/edit.html.twig', [
            'randezvou' => $randezvou,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_randezvou_delete", methods={"GET"})
     */
    public function delete(Request $request, Randezvou $randezvou, RandezvouRepository $randezvouRepository): Response
    {
        //if ($this->isCsrfTokenValid('delete'.$randezvou->getId(), $request->request->get('_token'))) {
            $randezvouRepository->remove($randezvou, true);
       // }
       $this->flashMessage->add("error","Vous avez supprimé un Rendez vous");
        return $this->redirectToRoute('app_randezvou_index', [], Response::HTTP_SEE_OTHER);
    }
}
