<?php

namespace App\Infrastructure\Repositories;

use App\Exceptions\UserAlreadyExistsException;
use App\Models\User;
use App\Repositories\UserRepository;
use App\ValueObjects\Email;
use PDO;
use PDOException;

class PdoUserRepository implements UserRepository
{
    public function __construct(
        private PDO $pdo
    )
    {
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function save(User $user): void
    {

        $sql = "INSERT INTO users (id,name, email) VALUES (:id, :name, :email)";
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute([
                "id" => $user->getId(),
                "name" => $user->getName(),
                "email" => $user->getEmail(),
            ]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                throw new UserAlreadyExistsException('User already exists');
            }
            throw $e;
        }
    }

    public function findById(int $id): ?User
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data === false) {
            return null;
        }
        $email = new Email($data['email']);

        return new User(
            id: $data['id'],
            name: $data['name'],
            email: $email,
        );
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];

        foreach ($rows as $data) {
            $users[] = new User(
                id: $data['id'],
                name: $data['name'],
                email: new Email($data['email']),
            );
        }
        return $users;
    }
}