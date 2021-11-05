<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class MediaFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $medias = [
            'Movie' => "Un film est une œuvre du cinéma ou de l'audiovisuel, qu'elle soit produite ou reproduite sur support argentique ou sur tout autre support existant (vidéo, numérique). Ce terme (qui vient de l'anglais film qui signifie « couche », « voile ») est employé par métonymie, en référence à la pellicule chargée dans un magasin de caméra argentique, destinée aux prises de vues cinématographiques.",
            'Comics' => "Une bande dessinée (dénomination communément abrégée en BD ou en bédé) est une forme d'expression artistique, souvent désignée comme le « neuvième art », utilisant une juxtaposition de dessins (ou d'autres types d'images fixes, mais pas uniquement photographiques), articulés en séquences narratives et le plus souvent accompagnés de textes (narrations, dialogues, onomatopées).",
            'Book' => "Un livre est un document écrit formant unité et conçu comme tel, composé de pages reliées les unes aux autres. Il a pour fonction d'être un support de l'écriture, permettant la diffusion et la conservation de textes de nature variée.",
            'Video Game' => "Un jeu vidéo est un jeu électronique doté d'une interface utilisateur permettant une interaction humaine ludique en générant un retour visuel sur un dispositif vidéo. Le joueur de jeu vidéo dispose de périphériques pour agir sur le jeu et percevoir les conséquences de ses actes sur un environnement virtuel.",
            'Series' => "Une série télévisée, abrégé en série, ou familièrement série télé, aussi appelée télésérie au Canada, est une œuvre télévisuelle qui se déroule en plusieurs parties d'une durée généralement équivalente, appelées « épisodes ». Le lien entre les épisodes peut être l’histoire, les personnages ou le thème de la série."
        ];

        foreach ($medias as $name => $description) {
            $media = (new Media())
                ->setName($name)
                ->setDescription($description);

            $manager->persist($media);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
