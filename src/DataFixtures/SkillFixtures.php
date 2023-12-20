<?php

namespace App\DataFixtures;

use App\Factory\SkillFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    /**
     * Charge les fixtures avec l'EntityManager fourni.
     *
     * @param ObjectManager $manager L'EntityManager utilisé pour persister les objets
     */
    public function load(ObjectManager $manager): void
    {
        $competences = [
            'Communication',
            'Travail d\'équipe',
            'Résolution de problèmes',
            'Leadership',
            'Adaptabilité',
            'Gestion du temps',
            'Créativité',
            'Esprit critique',
            'Prise de décision',
            'Compétences analytiques',
            'Attention aux détails',
            'Service client',
            'Gestion de projet',
            'Organisation',
            'Négociation',
            'Résolution de conflits',
            'Compétences techniques',
            'Analyse de données',
            'Codage/Programmation',
            'Réseautage',
            'Marketing numérique',
            'Analyse financière',
            'Prise de parole en public',
            'Compétences de présentation',
            'Vente',
            'Recherche',
            'Maîtrise d\'une langue étrangère',
            'Multitâche',
            'Intelligence émotionnelle',
            'Planification stratégique',
            'Gestion des risques',
            'Contrôle de la qualité',
            'Esprit d\'équipe',
            'Créativité',
            'Capacité d\'apprentissage rapide',
            'Pensée critique',
            'Éthique professionnelle',
            'Adaptation au changement',
            'Persévérance',
            'Diplomatie',
            'Innovation',
            'Prise d\'initiative',
            'Gestion du stress',
            'Autonomie',
            'Collaboration',
            'Facilité de communication orale',
            'Facilité de communication écrite',
            'Sens de l\'organisation',
            'Esprit d\'analyse',
            'Esprit de synthèse',
            'Sens des responsabilités',
            'Création artistique',
            'Esprit entrepreneurial',
            'Connaissance des nouvelles technologies',
            'Écoute active',
            'Évaluation des performances',
            'Planification d\'événements',
        ];

        for ($i = 0; $i < count($competences); ++$i) {
            SkillFactory::createOne([
                'libelle' => $competences[$i],
            ]);
        }
    }
}
