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
use App\Form\UserType;
use App\Form\ModifyLicensedType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Entity\Phone;
use App\Form\PhoneType;

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
     * Page des discipline
     *
    * @Route("/disciplines/", name="disciplines")
    */
    public function disciplines(): Response
    {
        return $this->render('main/disciplines.html.twig');
    }

    /**
     * Page de gymnastique artistique masculine
     *
    * @Route("/disciplines/gam", name="disciplines_gam")
    */
    public function disciplines_gam(): Response
    {
        return $this->render('main/disciplines_gam.html.twig');
    }

    /**
     * Page de babygym
     *
    * @Route("/disciplines/babygym", name="disciplines_babygym")
    */
    public function disciplines_babygym(): Response
    {
        return $this->render('main/disciplines_babygym.html.twig');
    }

    /**
     * Page de loisir
     *
    * @Route("/disciplines/loisirs", name="disciplines_loisirs")
    */
    public function disciplines_loisirs(): Response
    {
        return $this->render('main/disciplines_loisirs.html.twig');
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
     * @Route("/ajouter-licencie/", name="add_licensed")
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

            $this->addFlash('success', 'Licencié(e) bien ajouté.');

            return $this->redirectToRoute('licensed');

        }

        return $this->render('main/addLicensed.html.twig', [
            'licensedForm' => $form->createView()
        ]);
    }

    /**
     * Page d'affichage des infos. du ou des licenciés de l'utilisateur
     *
     * @Route("/licencie/", name="licensed")
     * @Security("is_granted('ROLE_USER')")
     */
    public function licensed(): Response
    {
        return $this->render('main/licensed.html.twig');
    }

    /**
     * Page d'affichage des données de tous les licenciés du site
     *
     * @Route("/admin/licencie/", name="licensed_data")
     */
    public function licensedData(): Response
    {

        $licensedRepository = $this->getDoctrine()->getRepository(Licensed::class);

        $licensedsFound = $licensedRepository->findAll();

        $phoneRepository = $this->getDoctrine()->getRepository(Phone::class);

        $phonesFound = $phoneRepository->findAll();



        return $this->render('main/licensedData.html.twig', [
            'licenseds' => $licensedsFound,
            'phones' => $phonesFound
        ]) ;
    }

    /**
     * Page de modification de profil
     *
     * @Route("/modifier-mon-profil/", name="modify_profil")
     * @Security("is_granted('ROLE_USER')")
     */
    public function modifyProfil(Request $request): Response
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
        if($licensed->getUser() != $this->getUser() && !$this->isGranted('ROLE_ADMIN')){

            throw new AccessDeniedHttpException();
        }

        $form = $this->createForm(ModifyLicensedType::class, $licensed);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            $this->addFlash('success', 'Licencié(e) modifié avec succès.');

            if($this->isGranted('ROLE_ADMIN')){

                return $this->redirectToRoute('licensed_data');
            } else{
                return $this->redirectToRoute('licensed');
            }
        }


        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire généré, avec $form->createView()
        return $this->render('security/modifyLicensed.html.twig', [
            'modifyLicensedForm' => $form->createView()
        ]);
    }

    /**
     *  Page servant à supprimer un licencié via son id passé dans l'URL
     *
     * @Route("/supprimer-licencie/{id}/", name="delete_licensed")
     * @Security("is_granted('ROLE_USER')")
     */
    public function licensedDelete(Licensed $licensed): Response
    {
            $em = $this->getDoctrine()->getManager();

            foreach($licensed->getPhones() as $phone){

                $em->remove($phone);

            }

            $em->remove($licensed);

            $em->flush();

            $this->addFlash('success', 'Licencié(e) supprimée avec succès.');

        return $this->redirectToRoute('licensed');

    }

    /**
     * Page d'ajout des numéros de téléphone
     *
     * @Route("/ajouter-telephone/{id}/", name="add_phone")
     * @Security("is_granted('ROLE_USER')")
     */
    public function addPhone(Licensed $licensed, Request $request): Response
    {
        if($licensed->getUser() != $this->getUser() && !$this->isGranted('ROLE_ADMIN')){

            throw new AccessDeniedHttpException();
        }

        // Création d'un nouvel objet de la classe Article, vide pour le moment
        $newPhone = new Phone();

        // Création d'un nouveau formulaire à partir de notre formulaire ArticleType et de notre nouvel article encore vide
        $form = $this->createForm(PhoneType::class, $newPhone);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $newPhone
                ->setLicensed($licensed)
            ;

            $em = $this->getDoctrine()->getManager();

            $em->persist($newPhone);

            $em->flush();

            $this->addFlash('success', 'Numéro de téléphone ajouté avec succès.');

            if($this->isGranted('ROLE_ADMIN')){

                return $this->redirectToRoute('licensed_data');
            } else{
                return $this->redirectToRoute('licensed');
            }
        }

        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire généré, avec $form->createView()
        return $this->render('main/addPhone.html.twig', [
            'addPhoneForm' => $form->createView()
        ]);
    }

}


