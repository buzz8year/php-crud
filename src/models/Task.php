<?php

namespace models;

use db\PDOFactory;


class Task 
{
    const STATUS_COMPLETED = 2;
    const SORT_DEFAULT = 'id';

    protected $id;
    protected $name;
    protected $text;
    protected $status;
    protected $user_email;
    protected $edited;

    private $task;

    public static $slice = array();


    // NOTE: Soft Dependency Injection method(... , \PDO $pdo = null) /
    // down here in this class is used for future unit testing purposes
    public static function populateSlice(string $orderBy, int $limit, int $offset, \PDO $pdo = null) : void
    {
        if (!isset($pdo)) 
        {
            $pdo = PDOFactory::readInstance();
        }

        // WARNING: As to hardcoded $orderBy, - table and column /
        // names CANNOT be replaced by parameters, in PDO 
        // NOTE: Double quotes 
        $handle = $pdo->prepare("
            SELECT id, user_email, name, text, status, edited 
            FROM `task` 
            ORDER BY $orderBy 
            LIMIT :slice_limit 
            OFFSET :slice_offset
        ");

        $handle->execute(
            array(
                'slice_limit' => $limit,
                'slice_offset' => $offset,
            )
        );

        while ($object = $handle->fetchObject('\models\Task')) 
        {
            self::$slice[(int)$object->getId()] = $object;
        }

    }


    public static function getSlice(string $orderBy = null, int $limit, int $offset)
    {
        self::populateSlice($orderBy, $limit, $offset);

        return self::$slice;
    }


    public static function get(int $id, \PDO $pdo = null) : Task
    {
        if (!isset($pdo)) 
        {
            $pdo = PDOFactory::readInstance();
        }

        $handle = $pdo->prepare('
            SELECT id, user_email, name, text, status, edited 
            FROM `task` 
            WHERE id = :id
        ');

        $handle->execute(
            array(
                ':id' => $id
            )
        );


        if ($handle->rowCount() !== 1) 
        {
            self::$slice[(int)$id] = new self;
        } 
        else 
        {
            self::$slice[(int)$id] = $handle->fetchObject('\models\Task');
        }


        return self::$slice[(int)$id];

    }


    public static function countAll(\PDO $pdo = null)
    {
        if (!isset($pdo)) 
        {
            $pdo = PDOFactory::readInstance();
        }

        $handle = $pdo->prepare('SELECT count(*) FROM `task`');
        $handle->execute();

        return $handle->fetchColumn();  
    }


   public function create(array $data, \PDO $pdo = null) : bool
    {
        if (empty($data)) 
        {
            return false;
        }

        else
        {
            if (empty($pdo)) 
            {
                $pdo = PDOFactory::readInstance();
            }

            $handle = $pdo->prepare('
                INSERT INTO `task` 
                (
                    user_email,
                    status,
                    edited,
                    name,
                    text
                ) 
                VALUES 
                (
                    :user_email,
                    :status,
                    :edited,
                    :name,
                    :text
                ) 
            ');

            // NOTE: As to :text, - htmlentities() or none of its siblings 
            // is not used to write to text value, for the convience of parsing 
            // xss-potential injection attempts and trials, chiefly on big portions of data.

            // JUSTIFY: Instead, htmlspecialchars() or one of its siblings 
            // is obligatory on rendering xss-potential data in client browser.
            return $handle->execute(
                array(
                    ':edited'       => 0,
                    ':status'       => 1,
                    ':name'         => $data['task_name'],
                    ':user_email'   => $data['task_usermail'],
                    ':text'         => $data['task_text'],
                )
            );

        }

    }


    public function update(array $data, \PDO $pdo = null) : bool
    {
        if (empty($data)) 
        {
            return false;
        }

        else
        {
            if (empty($pdo)) 
            {
                $pdo = PDOFactory::readInstance();
            }

            $handle = $pdo->prepare('
                UPDATE `task` SET
                    user_email = :user_email,
                    status = :status,
                    edited = :edited,
                    name = :name,
                    text = :text
                WHERE id = :id
            ');

            if ( empty( $data['task_text'] ) ) 
            {
                $edited = $this->getEdited();
            }
            else
            {
                $edited = $data['task_text'] === $this->getText() ? 0 : 1;
            }

            // NOTE: As to :text, - htmlentities() or none of its siblings 
            // is not used to write to text value, for the convience of parsing 
            // xss-potential injection attempts and trials, chiefly on big portions of data.

            // JUSTIFY: Instead, htmlspecialchars() or one of its siblings 
            // is obligatory on rendering xss-potential data in client browser.

            return $handle->execute(
                array(
                    ':id'           => $data['task_id'] ?? $this->getId(),
                    ':name'         => $data['task_name'] ?? $this->getName(),
                    ':user_email'   => $data['task_usermail'] ?? $this->getUserEmail(),
                    ':status'       => $data['task_status'] ?? $this->getStatus(),
                    ':text'         => $data['task_text'] ?? $this->getText(),
                    ':edited'       => $edited,
                )
            );

        }

    }


    // EXPLAIN: Setters and getters
    public function getId() : ?int
    {
        return $this->id;
    }

    public function setId(int $id) : Task
    {
        $this->id = $id;
        return $this;
    }


    public function getName() : ?string
    {
        return $this->name;
    }

    public function setName(string $name) : Task
    {
        $this->name = $name;
        return $this;
    }


    public function getUserEmail() : ?string
    {
        return $this->user_email;
    }

    public function setUserEmail(string $user_email) : Task
    {
        $this->user_email = $user_email;
        return $this;
    }

    public function getText() : ?string
    {
        return $this->text;
    }

    public function setText(string $text) : Task
    {
        $this->text = $text;
        return $this;
    }

    public function getStatus() : ?int
    {
        return $this->status;
    }

    public function setStatus(int $status) : Task
    {
        $this->status = $status;
        return $this;
    }

    public function getEdited() : ?int
    {
        return $this->edited;
    }

    public function setEdited(int $edited) : Task
    {
        $this->edited = $edited;
        return $this;
    }

}
