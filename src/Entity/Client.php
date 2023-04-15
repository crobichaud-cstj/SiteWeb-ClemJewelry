<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name:'clients')]
#[UniqueEntity(fields: ['email'], message: 'Il y à déjà un compte liée à ce couriel')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'idClient')]
    private ?int $idClient = null;


    #[ORM\Column(length:150, unique:true)]
    #[Assert\Email(message:"Votre adresse courriel: {{ value }} est invalide")]
    private ?string $email = null;

    #[ORM\Column(name:'lastName')]
    #[Assert\Length(min:2, minMessage:"Votre nom doit contenir {{ limit }} caractères minimum")]
    #[Assert\Length(max:75, maxMessage:"Votre nom doit contenir {{ limit }} caractères maximum")]
    private ?string $lastName = null;

    #[ORM\Column(name:'firstName')]
    #[Assert\Length(min:2, minMessage:"Votre prénom doit contenir {{ limit }} caractères minimum")]
    #[Assert\Length(max:75, maxMessage:"Votre prénom doit contenir {{ limit }} caractères maximum")]
    private ?string $firstName = null;

        /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;



    #[ORM\Column()]
    #[Assert\Length(min:5, minMessage:"L'adresse  doit contenir {{ limit }} caractères minimum")]
    #[Assert\Length(max:100, maxMessage:"L'adresse doit contenir {{ limit }} caractères maximum")]
    private ?string $address = null;

    #[ORM\Column()]
    #[Assert\Length(min:3, minMessage:"La ville doit contenir {{ limit }} caractères minimum")]
    #[Assert\Length(max:30, maxMessage:"La ville doit contenir {{ limit }} caractères maximum")]
    private ?string $city = null;

    #[ORM\Column(name: 'codePostal', length:6)]
    #[Assert\Regex(pattern:"/^[ABCEGHJ-NPRSTVXY]\d[ABCEGHJ-NPRSTV-Z][ -]?\d[ABCEGHJ-NPRSTV-Z]\d$/i", message:"Code postal invalide. Format: A1A 1A1 (lettres D-F-I-O-Q-U interdites et W et Z interdites en première position)" )]
    private ?string $zipCode = null;

    #[ORM\Column(length:2)]
    private ?string $province = null;

    #[ORM\Column(length:20)]
    #[Assert\Regex(pattern:"/^[0-9]{10}$/", message:"Votre téléphone doit contenir 10 chiffres" )]
    private ?string $phone = null;



    #[ORM\Column]
    private array $roles = [];

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(string $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }


    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->idClient;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
