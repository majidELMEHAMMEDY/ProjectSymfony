<?php

namespace App\DataFixtures;

use App\Entity\Consultation;
use App\Entity\Patient;
use App\Entity\Randezvou;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');

        for($p=0 ; $p<10; $p++){
            $patient = new Patient();
            $patient->setPrenom($faker->firstName())
                    ->setNom($faker->lastName)
                    ->setTelephone($faker->phoneNumber)
                    ->setEmail($faker->email)
                    ->setAdresse($faker->secondaryAddress)
                    ->setDateNaissance($faker->dateTimeBetween("-300 months"))
                    ->setSexe($faker->randomElement(["Male","female"]));
            $manager->persist($patient);
            // for($c=0;$c<1;$c++){
            //     $consult = new Consultation();
            //     $consult->setType($faker->randomElement(["L'évaluation de santé préalable","L'évaluation de santé périodique","L'examen de reprise du travail","La visite préalable à la reprise du travail","La consultation spontanée","La protection de la maternité"]))
            //     ->setDuree($faker->randomElement(["2 heures","1 heure","3 heures","4 heures"]))
            //         ->setPrix($faker->randomNumber(3));
            //         $manager->persist($consult);
            // }
            // for($r=0;$r<=1 ; $r++){
            //     $rdv = new Randezvou();
            //     $rdv->setDate($faker->dateTimeBetween("-6 months"))
            //         ->setHeuredebut($faker->datetime("H:i:s"))
            //         ->setHeurefin($faker->datetime("H:i:s"))
            //         ->setPatient($patient)
            //         ->setConsultation($consult);
            //     $manager->persist($rdv);
            // }
        }   
        $manager->flush();
    }
}
