<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Licensed;
use App\Form\LicensedType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;



class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('main/home.html.twig');
    }

    /**
     * Page de profil
     *
     * @Route("/mon-profil/", name="profil")
     * @Security("is_granted('ROLE_USER')")
     */
    public function profil(): Response
    {
        return $this->render('main/profil.html.twig');
    }

    /**
     * Page de contact
     *
     * @Route("/contact/", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('main/contact.html.twig');
    }

    /**
     * Page d'ajout d'un licencié
     *
     * @Route("/ajouter-licence/", name="add_licensed")
     * @Security("is_granted('ROLE_USER')")
     */
    public function addLicensed(Request $request): Response
    {

        // Création d'un nouvel objet de la classe Licensed, vide pour le moment
        $newLicensed = new Licensed();

        // Création d'un nouveau formulaire à partir de notre formulaire LicensedType et de notre licencié encore vide
        $form = $this->createForm(LicensedType::class, $newLicensed);

        $form->handleRequest($request);

        // Validation du formulaire
        if($form->isSubmitted() && $form->isValid()){

            $newLicensed
                ->setUser($this->getUser())
            ;

            $em = $this->getDoctrine()->getManager();

            $em->persist($newLicensed);

            $em->flush();

            $this->addFlash('success', 'Licencié bien ajouté.');

            return $this->redirectToRoute('licensed');

        }

        return $this->render('main/addLicensed.html.twig', [
            'licensedForm' => $form->createView()
        ]);
    }

    /**
     * Page d'affichage des infos. du ou des licenciés
     *
     * @Route("/licence/", name="licensed")
     * @Security("is_granted('ROLE_USER')")
     */
    public function licensed(): Response
    {
        return $this->render('main/licensed.html.twig');
    }

    /**
     * Page d'affichage des données utilisateurs'
     *
     * @Route("/admin/utilisateurs/", name="user_data")
     */
    public function userData(): Response
    {

        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $usersFound = $userRepository->findAll();


        return $this->render('main/userData.html.twig', [
            'users' => $usersFound
        ]) ;
    }

}


