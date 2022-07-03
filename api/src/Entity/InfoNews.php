<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entity - InfoNews : "Rappels" pour la page de News
 */
#[ApiResource(mercure: true)]
#[ORM\Entity]
class InfoNews
{
    /**
     * The entity ID
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $idInfoNews = null;

    /**
     * Description : texte simple : HTML = EVOL (#[ORM\Column(type: 'text')])
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    public string $description = '';
    
    /**
     * Date de validité : (vide = no limite de temps)
     */
    #[ORM\Column(type: "datetime")]
    #[Assert\NotBlank]
    public ?\DateTime $dateValidite = null;
    
    /**
     * Text du Lien
     */
    #[ORM\Column]
    public string $lienText = 'Lien';

    /**
     * URL du Lien (dans le code, si vide = pas afficher)
     */
    #[ORM\Column]
    public string $lienURL = '';

    /**
     * Type de redirection du Lien (TargetBlank)
     */
    #[ORM\Column]
    public bool $lienIsTargetBlank = false;


    public function getIdInfoNews(): ?int
    {
        return $this->idInfoNews;
    }
}
