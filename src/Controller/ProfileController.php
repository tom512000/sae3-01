<?php

namespace App\Controller;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfileController extends AbstractController
{
    /**
     * Affiche la page de profil de l'utilisateur.
     *
     * @return Response La réponse HTTP de la page de profil
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/profil', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }

    /**
     * Modifie les informations du profil de l'utilisateur.
     *
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités Doctrine
     * @param User                   $user          L'utilisateur actuel (@CurrentUser)
     * @param Request                $request       La requête HTTP
     * @param SluggerInterface       $slugger       Le service de génération de slug Symfony
     *
     * @return Response La réponse HTTP de la page de modification de profil
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/profil/modif', name: 'app_profile_modif')]
    public function modif(EntityManagerInterface $entityManager, #[CurrentUser] User $user, Request $request, SluggerInterface $slugger, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $cvFile */
            $cvFile = $form->get('cv')->getData();
            if ($cvFile) {
                $originalFilename = pathinfo($cvFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$cvFile->guessExtension();

                try {
                    $cvFile->move($this->getParameter('PDF_files'), $newFilename);
                } catch (FileException) {
                }

                $user->setCv($newFilename);
            }

            /** @var UploadedFile $motiFile */
            $motiFile = $form->get('lettreMotiv')->getData();
            if ($motiFile) {
                $originalFilename = pathinfo($motiFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$motiFile->guessExtension();

                try {
                    $motiFile->move($this->getParameter('PDF_files'), $newFilename);
                } catch (FileException) {
                }

                $user->setLettreMotiv($newFilename);
            }

            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $entityManager->flush();

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profil/modif.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Crée un nouvel utilisateur avec les informations fournies.
     *
     * @param Request          $request La requête HTTP
     * @param SluggerInterface $slugger Le service de génération de slug Symfony
     *
     * @return Response La réponse HTTP de la page de création d'utilisateur
     */
    #[Route('/newUser', name: 'app_profile_new')]
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $cvFile */
            $cvFile = $form->get('cv')->getData();
            if ($cvFile) {
                $originalFilename = pathinfo($cvFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$cvFile->guessExtension();

                try {
                    $cvFile->move($this->getParameter('PDF_files'), $newFilename);
                } catch (FileException) {
                }

                $user->setCv($newFilename);
            }

            /** @var UploadedFile $motiFile */
            $motiFile = $form->get('lettreMotiv')->getData();
            if ($motiFile) {
                $originalFilename = pathinfo($motiFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$motiFile->guessExtension();

                try {
                    $motiFile->move($this->getParameter('PDF_files'), $newFilename);
                } catch (FileException) {
                }

                $user->setLettreMotiv($newFilename);
            }

            UserFactory::createOne([
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'dateNais' => $user->getDateNais(),
                'phone' => $user->getPhone(),
                'cv' => $user->getCv(),
                'lettreMotiv' => $user->getLettreMotiv(),
            ]);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('profil/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/profil/delete', name: 'app_profile_delete')]
    public function delete(Security $security, EntityManagerInterface $entityManager, #[CurrentUser] User $user, Request $request): Response
    {
        $form = $this->createForm(FormType::class);
        $form->add('Delete', SubmitType::class, [
            'label' => 'Supprimer',
        ]);
        $form->add('Cancel', SubmitType::class, [
            'label' => 'Annuler',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && ($form->getClickedButton() === $form->get('Delete'))) {
            $qb = $entityManager->createQueryBuilder()->delete('App:Inscrire', 'i')->where('i.User = ?1')->setParameter(1, $user);
            $query = $qb->getQuery();
            $query->execute();
            $entityManager->remove($user);
            $entityManager->flush();
            $security->logout(false);

            return $this->redirectToRoute('app_home');
        } elseif ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profil/delete.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
