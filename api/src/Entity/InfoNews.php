<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InfoNewsRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InfoNewsRepository::class)]
#[ApiResource]
class InfoNews
{
     #[ORM\Id]
     #[ORM\GeneratedValue]
     #[ORM\Column(type:"integer")]
     #[ApiProperty(identifier:false)]
    private $id;

    /**
     * The entity "public" ID as UUID pour être utiliser dans l'api.
     */
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ApiProperty(identifier:true)]
    private $idInfoNews;

    /**
     * Description : texte simple : HTML = EVOL (#[ORM\Column(type: 'text')])
     */
    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    private $description;

    /**
     * Date de validité : (vide = no limite de temps)
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateValidite;

    /**
     * Text du Lien
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lienText;
    
    /**
     * URL du Lien (dans le code, si vide = pas afficher)
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private $lienURL;

    /**
     * Type de redirection du Lien (TargetBlank)
     */
    #[ORM\Column(type: 'boolean', nullable: true)]
    private $lienIsTargetBlank;

    /****************
     * Constructor
     ****************/
    public function __construct()
    {
        $this->idInfoNews = Uuid::uuid4();
    }

    /****************
     * Getters et Setters
     */
    public function getIdInfoNews(): UuidInterface
    {
        return $this->idInfoNews;
    }
    // No need, car l'UUID est générée et setté lors de l'appel au constructeur
    // public function setIdInfoNews($idInfoNews): self
    // {
    //     $this->idInfoNews = $idInfoNews;
    //     return $this;
    // }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateValidite(): ?\DateTimeInterface
    {
        return $this->dateValidite;
    }

    public function setDateValidite(\DateTimeInterface $dateValidite): self
    {
        $this->dateValidite = $dateValidite;

        return $this;
    }

    public function getLienText(): string
    {
        return $this->lienText;
    }

    public function setLienText(string $lienText): self
    {
        $this->lienText = $lienText;

        return $this;
    }

    public function getLienURL(): ?string
    {
        return $this->lienURL;
    }

    public function setLienURL(?string $lienURL): self
    {
        $this->lienURL = $lienURL;

        return $this;
    }

    public function isLienIsTargetBlank(): ?bool
    {
        return $this->lienIsTargetBlank;
    }

    public function setLienIsTargetBlank(?bool $lienIsTargetBlank): self
    {
        $this->lienIsTargetBlank = $lienIsTargetBlank;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
}
