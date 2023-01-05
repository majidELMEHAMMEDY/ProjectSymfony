<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ProfileController extends AbstractController
{
    /**
     * Undocumented variable
     *
     * @var FlashBagInterface
     */
    private $flashMessage;
   

    public function __construct(FlashBagInterface $flashMessage){
        $this->flashMessage = $flashMessage;
    }
    /**
     * @Route("/profile", name="app_profile", methods={"GET", "POST"})
     */
    public function new(Request $request, SluggerInterface $slugger, UserRepository $userRepository)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($imageName);
                $imageName = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                    $image->move(
                        $this->getParameter('image_directory'),
                        $imageName
                    );

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImage($imageName);
            }

            // ... persist the $product variable or any other work
            $userRepository->add($user, true);
            $this->flashMessage->add("success","Vous avez modifié votre profile");

            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);

            return $this->redirectToRoute('app_profile');
        }

        return $this->renderForm('profile/index.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
    // public function new(Request $request, ProductRepository $productRepository, SluggerInterface $slugger): Response
    // {
    //     $product = new Product();
    //     $form = $this->createForm(ProductType::class, $product);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
           

    //         /** @var UploadedFile $brochureFile */
    //         $imageFile = $form->get('image')->getData();

    //         // this condition is needed because the 'brochure' field is not required
    //         // so the PDF file must be processed only when a file is uploaded
            
             
    //     $product->setImage($newFilename);
    //         $productRepository->add($product, true);

    //         // ... persist the $product variable or any other work

    //         return $this->redirectToRoute('app_product_index');
    //     }
    
    // public function index(Request $request, UserRepository $userRepository): Response
    // {
    //     $user = $this->getUser();
        
        // $form = $this->createForm(UserType::class, $user);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $userRepository->add($user, true);
        //     $this->flashMessage->add("success","Vous avez modifier votre profile");

        //     return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        // }

        // return $this->renderForm('profile/index.html.twig', [
        //     'user' => $user,
        //     'form' => $form,
        // ]);

    // }
    // /**
    //  * @Route("/upload/image", name="upload_image")
    // */
    // public function uploadImage(Request $request, EntityManagerInterface $entityManager)
    // {
    //    $image = $request->files->get("image");
    //    $image_name = $image->getClientOriginalName();
    //    $image->move($this->getParameter("image_directory",$image_name));
    //    $user = $this->getUser();
    //    $user->setImage($image_name);
    //    $entityManager->persist($user);
    //    $entityManager->flush();
    //    return $this->redirectToRoute('app_profile');

    // }
// }
