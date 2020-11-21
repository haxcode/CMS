<?php

namespace App\User\Entity;

use App\User\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Ignore;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity(repositoryClass="App\User\Repository\UserRepository", repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface {

    /**
     * @Ignore()
     */
    protected string $salt;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email;
    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];
    /**
     * @OneToMany(targetEntity="App\User\Entity\AuthToken", mappedBy="userId")
     * @Ignore()
     * @ArrayCollection AuthToken
     */
    private array $apiTokens;
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Ignore()
     */
    private string $password;
    /**
     * @ORM\Column(type="string")
     *
     */
    private string $firstName;
    /**
     * @ORM\Column(type="string")
     */
    private string $lastName;

    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void {
        $this->roles = $roles;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string {
        return (string)$this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt() {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    /**
     * @return AuthToken[]
     */
    public function getApiTokens(): array {
        return $this->apiTokens;
    }

}
