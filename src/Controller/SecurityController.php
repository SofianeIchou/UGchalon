<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Form\UserType;
use App\Form\ModifyLicensedType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Licensed;
use App\Entity\User;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         //if ($this->getUser()) {
             //return $this->redirectToRoute('home');
         //}

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

     /**
     * Page de modification de profil
     *
     * @Route("/modifier-mon-profil/", name="modify_profil")
     * @Security("is_granted('ROLE_USER')")
     */
    public function profil(Request $request): Response
    {

        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            $this->addFlash('success', 'Profil modifié avec succès !');
            return $this->redirectToRoute('profil');
        }


        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire généré, avec $form->createView()
        return $this->render('security/modifyProfil.html.twig', [
            'modifyForm' => $form->createView()
        ]);
    }

    /**
     * Page de modification des licenciés
     *
     * @Route("/modifier-licencie/{id}/", name="modify_licensed")
     * @Security("is_granted('ROLE_USER')")
     */
    public function modifyLicensed(Licensed $licensed, Request $request): Response
    {

        //TODO: Vérifier que le proprio du licencié est le même que la personne connecté

        $form = $this->createForm(ModifyLicensedType::class, $licensed);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            $this->addFlash('success', 'Licencié modifié avec succès !');
            return $this->redirectToRoute('licensed');
        }


        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire généré, avec $form->createView()
        return $this->render('security/modifyLicensed.html.twig', [
            'modifyLicensedForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/deconnexion", name="app_logout")
     * @Security("is_granted('ROLE_USER')")
     */
    public function logout()
    {

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        $this->addFlash('success', 'Le commentaire a été supprimée avec succès');
    }
}
