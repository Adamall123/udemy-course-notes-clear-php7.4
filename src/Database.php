<?php 

declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use PDO;
use PDOException;
use Throwable;

class Database
{

    private PDO $conn;

    public function __construct(array $config)
    {
        try{
            
            $this->validateConfig($config);
            $this->createConnection($config);
            //dump($this->conn);
        }catch(PDOException $e){
            throw new StorageException("Connection error");
        }
       
    }

    public function createNote(array $data): void
    {
        try{
            dump($data);
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $created = $this->conn->quote(date('Y-m-d H:i:s'));
            $query = "
                INSERT INTO notes(title, description, created)
                 VALUES($title, $description, $created)
                 ";
            $this->conn->exec($query);

        }catch(Throwable $e){
            throw new StorageException("The new not has not beed created", 400);
            dump($e);
            exit;
        }
    }
    public function getNotes(): array
    {
        try{
            $query = "SELECT id,title ,created FROM notes";
            $result = $this->conn->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
            // foreach($result as $row) {
            //     $notes[] = $row;
            // }
        }catch(Throwable $e){
            throw new StorageException("The data has not been get.", 400, $e);
        }
        
    }
    public function getNote(int $id): array 
    {
        try{
            $query = "SELECT * FROM notes WHERE id=$id";
            $result = $this->conn->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);   
        }catch(Throwable $e){
            throw new StorageException("The note has noot been get", 400);
        }
        if(!$note) {
            throw new NotFoundException("Notatka o id: $id nie istnieje");
        }
        return $note;
    }
    private function createConnection(array $config): void 
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO(
            $dsn,
            $config['user'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
    ); 
    }

    private function validateConfig(array $config): void
    {
        if(
            empty($config['database'])
            || empty($config['host'])
            || empty($config['user'])
            //|| empty($config['password'])
        ) {
            echo $config['password'];
            throw new ConfigurationException('Storage configuration error');
        }
    }
}