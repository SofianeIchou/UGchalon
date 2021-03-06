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
use App\Entity\Article;
use App\Form\ArticleType;
use DateTime;
class MainController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $articleFound = $articleRepository->findOneBy([], ['publicationDate' => 'DESC'], 1);


        return $this->render('main/home.html.twig',[
            'article' => $articleFound
        ]);
    }

    /**
     * Page des disciplines
     *
    * @Route("/disciplines/", name="all_discipline")
    */
    public function disciplines(): Response
    {
        return $this->render('main/allDiscipline.html.twig');
    }

    /**
     * Page de gymnastique artistique masculine
     *
    * @Route("/disciplines/gam", name="discipline_gam")
    */
    public function disciplineGam(): Response
    {
        return $this->render('main/disciplineGam.html.twig');
    }

    /**
     * Page de baby gym
     *
    * @Route("/disciplines/babygym", name="discipline_baby_gym")
    */
    public function disciplineBabyGym(): Response
    {
        return $this->render('main/disciplineBabyGym.html.twig');
    }

    /**
     * Page de loisir
     *
    * @Route("/disciplines/loisir", name="discipline_hobbies")
    */
    public function disciplineHobbies(): Response
    {
        return $this->render('main/disciplineHobbies.html.twig');
    }

    /**
     * Page de tout les articles
     *
    * @Route("/tous-les-articles/", name="all_articles")
    */
    public function allArticles(): Response
    {

        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $articlesFound = $articleRepository->findBy([], ['publicationDate' => 'DESC']);


        return $this->render('main/allArticles.html.twig', [
            'articles' => $articlesFound
        ]) ;
    }

    /**
     * Page de l'article
     *
    * @Route("/article/{slug}", name="article")
    */
    public function article(Article $article, Request $request): Response
    {

        return $this->render('main/article.html.twig', [
            'article' => $article
        ]) ;
    }

    /**
     * Page d'ajout d'article
     *
    * @Route("/ajouter-un-article/", name="add_article")
    */
    public function addArticle(Request $request): Response
    {
        // Cr??ation d'un nouvel objet de la classe Article, vide pour le moment
        $newArticle = new Article();

        // Cr??ation d'un nouveau formulaire ?? partir de notre formulaire ArticleType et de notre nouvel article encore vide
        $form = $this->createForm(ArticleType::class, $newArticle);

        $form->handleRequest($request);


        // Pour savoir si le formulaire a ??t?? envoy??, on a acc??s ?? cette condition :
        if($form->isSubmitted() && $form->isValid()){

            $newArticle->setPublicationDate( new DateTime() );
            $newArticle->setAuthor( $this->getUser() );

            $em = $this->getDoctrine()->getManager();

            $em->persist($newArticle);

            $em->flush();

            $this->addFlash('success', 'L\'article a bien ??t?? cr????');

            return $this->redirectToRoute('all_articles');
        }

        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire g??n??r??, avec $form->createView()
        return $this->render('main/addArticle.html.twig', [
            'articleform' => $form->createView()
        ]);
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
     * Page d'ajout d'un licenci??
     *
     * @Route("/ajouter-licencie/", name="add_licensed")
     * @Security("is_granted('ROLE_USER')")
     */
    public function addLicensed(Request $request): Response
    {

        // Cr??ation d'un nouvel objet de la classe Licensed, vide pour le moment
        $newLicensed = new Licensed();

        // Cr??ation d'un nouveau formulaire ?? partir de notre formulaire LicensedType et de notre licenci?? encore vide
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

            $this->addFlash('success', 'Licenci??(e) bien ajout??(e).');

            return $this->redirectToRoute('licensed');

        }

        return $this->render('main/addLicensed.html.twig', [
            'licensedForm' => $form->createView()
        ]);
    }

    /**
     * Page d'affichage des infos. du ou des licenci??s de l'utilisateur
     *
     * @Route("/licencie/", name="licensed")
     * @Security("is_granted('ROLE_USER')")
     */
    public function licensed(): Response
    {
        return $this->render('main/licensed.html.twig');
    }

    /**
     * Page d'affichage des donn??es de tous les licenci??s du site
     *
     * @Route("/admin/licencie/", name="licensed_data")
     * @Security("is_granted('ROLE_ADMIN')")
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

            $this->addFlash('success', 'Profil modifi?? avec succ??s.');
            return $this->redirectToRoute('profil');
        }


        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire g??n??r??, avec $form->createView()
        return $this->render('security/modifyProfil.html.twig', [
            'modifyForm' => $form->createView()
        ]);
    }

    /**
     * Page de modification des licenci??s
     *
     * @Route("/modifier-licencie/{id}/", name="modify_licensed")
     * @Security("is_granted('ROLE_USER')")
     */
    public function modifyLicensed(Licensed $licensed, Request $request): Response
    {

        //TODO: V??rifier que le proprio du licenci?? est le m??me que la personne connect??
        if($licensed->getUser() != $this->getUser() && !$this->isGranted('ROLE_ADMIN')){

            throw new AccessDeniedHttpException();
        }

        $form = $this->createForm(ModifyLicensedType::class, $licensed);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            $this->addFlash('success', 'Licenci??(e) modifi??(e) avec succ??s.');

            if($this->isGranted('ROLE_ADMIN')){

                return $this->redirectToRoute('licensed_data');
            } else{
                return $this->redirectToRoute('licensed');
            }
        }


        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire g??n??r??, avec $form->createView()
        return $this->render('security/modifyLicensed.html.twig', [
            'modifyLicensedForm' => $form->createView()
        ]);
    }

    /**
     *  Page servant ?? supprimer un licenci?? via son id pass?? dans l'URL
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

            $this->addFlash('success', 'Licenci??(e) supprim??(e) avec succ??s.');

            if($this->isGranted('ROLE_ADMIN')){

                return $this->redirectToRoute('licensed_data');
            } else{
                return $this->redirectToRoute('licensed');
            }

    }

    /**
     * Page d'ajout des num??ros de t??l??phone
     *
     * @Route("/ajouter-telephone/{id}/", name="add_phone")
     * @Security("is_granted('ROLE_USER')")
     */
    public function addPhone(Licensed $licensed, Request $request): Response
    {
        if($licensed->getUser() != $this->getUser() && !$this->isGranted('ROLE_ADMIN')){

            throw new AccessDeniedHttpException();
        }

        // Cr??ation d'un nouvel objet de la classe Phone, vide pour le moment
        $newPhone = new Phone();

        // Cr??ation d'un nouveau formulaire ?? partir de notre formulaire PhoneType et de notre nouvel phone encore vide
        $form = $this->createForm(PhoneType::class, $newPhone);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $newPhone
                ->setLicensed($licensed)
            ;

            $em = $this->getDoctrine()->getManager();

            $em->persist($newPhone);

            $em->flush();

            $this->addFlash('success', 'Num??ro de t??l??phone ajout?? avec succ??s.');

            if($this->isGranted('ROLE_ADMIN')){

                return $this->redirectToRoute('licensed_data');
            } else{
                return $this->redirectToRoute('licensed');
            }
        }

        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire g??n??r??, avec $form->createView()
        return $this->render('main/addPhone.html.twig', [
            'addPhoneForm' => $form->createView()
        ]);
    }

    /**
     * Page des CGU
     *
     * @Route("/cgu/", name="cgu")
     * 
     */
    public function cgu(): Response
    {
        return $this->render('main/cgu.html.twig');
    }

}


