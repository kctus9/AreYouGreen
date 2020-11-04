<?php

namespace App\Controller;

use App\Entity\Questionnaire;
use App\Entity\Questions;
use App\Entity\Reponses;
use App\Entity\Utilisateurs;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionsRepository;
use App\Repository\UtilisateursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionnaireController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var QuestionnaireRepository
     */
    private $questionnaireRepository;
    /**
     * @var UtilisateursRepository
     */
    private $utilisateursRepository;
    /**
     * @var QuestionsRepository
     */
    private $questionsRepository;

    public function __construct(EntityManagerInterface $em, QuestionnaireRepository $questionnaireRepository, UtilisateursRepository $utilisateursRepository,
                                QuestionsRepository $questionsRepository)
    {
        $this->em = $em;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->utilisateursRepository = $utilisateursRepository;
        $this->questionsRepository = $questionsRepository;
    }


    /**
     * @Route("/questionnaire", name="start_questionnaire")
     */
    public function index(): Response
    {
        $questionnaires = $this->questionnaireRepository->findAll();
        $utilisateur = new Utilisateurs();

        $this->em->persist($utilisateur);
        $this->em->flush();

        return $this->render('questionnaire/index.html.twig', [
            'questionnaires' => $questionnaires,
            'utilisateur' => $utilisateur
        ]);
    }


    /**
     * @Route("/questionnaire/{idQuestionnaire}/question/{id}/utilisateur/{idUtilisateur}", name="question")
     * @ParamConverter("questionnaire", options={"mapping": {"idQuestionnaire" : "id"}})
     * @ParamConverter("question", options={"mapping": {"id" : "id"}})
     * @param Questionnaire $questionnaire
     * @param Questions $question
     * @param $idUtilisateur
     * @return Response
     */
    public function question(Questionnaire $questionnaire, Questions $question, $idUtilisateur): Response
    {
        $utilisateur = $this->utilisateursRepository->find($idUtilisateur);

        $this->em->persist($utilisateur->addQuestionnaire($questionnaire));
        $this->em->flush();


        return $this->render('questions/index.html.twig', [
            'question' => $question,
            'utilisateur' => $utilisateur,
            'questionnaire' => $questionnaire
        ]);
    }


    /**
     * @Route("/questionnaire/{idQuestionnaire}/question/{idQuestion}/reponse/{idReponse}/utilisateur/{idUtilisateur}", name="verifReponse")
     * @ParamConverter("questionnaire", options={"mapping": {"idQuestionnaire" : "id"}})
     * @ParamConverter("reponses", options={"mapping": {"idReponse" : "id"}})
     * @ParamConverter("utilisateurs", options={"mapping": {"idUtilisateur" : "id"}})
     * @ParamConverter("question", options={"mapping": {"idQuestion" : "id"}})
     * @param Questionnaire $questionnaire
     * @param Questions $question
     * @param Reponses $reponses
     * @param Utilisateurs $utilisateurs
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function verifReponseUtilisateur(Questionnaire $questionnaire,Questions $question, Reponses $reponses, Utilisateurs $utilisateurs)
    {

        $score = $utilisateurs->getScore() + $reponses->getScore();

        $utilisateurs->setScore($score);
        $this->em->flush();

        if ($this->questionsRepository->find($question->getId()+1) == NULL)
        {
            return $this->redirectToRoute('resultatsUtilisateur', [
                'idUtilisateur' => $utilisateurs->getId()
            ]);
        }

        return $this->redirectToRoute('question', [
            'idQuestionnaire' => $questionnaire->getId(),
            'id' => $question->getId()+1,
            'idUtilisateur'=>$utilisateurs->getId()
        ]);
    }


    /**
     * @Route("/questionnaire/resultatUtilisateurs/utilisateur/{idUtilisateur}", name="resultatsUtilisateur")
     * @ParamConverter("utilisateur", options={"mapping": {"idUtilisateur" : "id"}})
     * @param Utilisateurs $utilisateur
     * @return Response
     */
    public function finQuestionnaire(Utilisateurs $utilisateur)
    {
        return $this->render('questionnaire/resultatQuestionnaire.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

}
