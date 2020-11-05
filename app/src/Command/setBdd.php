<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Questionnaire;
use App\Entity\ThematiqueQuestion;
use App\Entity\Questions;
use App\Entity\Reponses;

class setBdd extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:set-Bdd';
    private $em;

    public function __construct(EntityManagerInterface $em) 
    {
        $this->em = $em;

        parent::__construct();
    }
    
    

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Permet d\'importer la base de donnée')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('Cette commande permet d\'importer la base de donnée à la premiere mise en prod');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dataJson = file_get_contents('../data-fixture/add_data.json');
        $data = json_decode($dataJson, true);

        $output->writeln('Lancement du remplissage des colonnes');
        $output->writeln('Questionaires :');

        foreach($data["Questionnaires"] as $questionnaire) {
            
            $newQuestionnaire = new Questionnaire;

            $newQuestionnaire->setTitre($questionnaire["titre"]);
            
            $this->em->persist($newQuestionnaire);           
            $this->em->flush();

            $output->writeln($newQuestionnaire->getTitre());
        
        }

        $output->writeln('ThematiqueQuestion :');

        foreach($data["ThematiqueQuestions"] as $thematiqueQuestion) {
            
            $newThematiqueQuestion = new ThematiqueQuestion;

            $newThematiqueQuestion->setIntitule($thematiqueQuestion["intitule"]);
            
            $this->em->persist($newThematiqueQuestion);           
            $this->em->flush();

            $output->writeln($newThematiqueQuestion->getIntitule());
        
        }

        $output->writeln('Question :');

        foreach($data["Questions"] as $question) {
            
            $newQuestion = new Questions;

            $newQuestion->setIntitule($question["intitule"]);
            $newQuestion->setQuestionnaire($this->em->getRepository(Questionnaire::class)->findOneBy(['id' => $question["questionnaire"]]));
            $newQuestion->setThematiqueQuestion($this->em->getRepository(ThematiqueQuestion::class)->findOneBy(['id' => $question["thematiqueQuestion"]]));
            
            $this->em->persist($newQuestion);           
            $this->em->flush();

            $output->writeln($newQuestion->getIntitule() . " " . $newQuestion->getQuestionnaire()->getTitre() . " " . $newQuestion->getThematiqueQuestion()->getIntitule());
        
        }

        $output->writeln('Reponse :');

        foreach($data["Reponses"] as $reponse) {
            
            $newReponse = new Reponses;

            $newReponse->setIntitule($reponse["intitule"]);
            $newReponse->setQuestions($this->em->getRepository(Questions::class)->findOneBy(['id' => $reponse["questions"]]));
            $newReponse->setScore($reponse["score"]);
            
            $this->em->persist($newReponse);           
            $this->em->flush();

            $output->writeln($newReponse->getIntitule() . " " . $newReponse->getQuestions()->getIntitule() . " " . $newReponse->getScore());
        
        }
        
        $output->writeln('Fin');
        return 0;

    }
}