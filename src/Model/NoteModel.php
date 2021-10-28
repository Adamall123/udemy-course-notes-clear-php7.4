<?php 

declare(strict_types=1);

namespace App\Model;


use App\Exception\StorageException;
use App\Exception\NotFoundException;

use PDO;
use Throwable;

class NoteModel extends AbstractModel
{

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

    public function editNote(int $id, array $data): void 
    {
        try{
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);

            $query = "
                UPDATE notes 
                SET title = $title, description = $description
                WHERE id = $id
            ";

            $this->conn->exec($query);

        }catch(Throwable $e){
            throw new StorageException('Nie udało się zedytować notatki.',400);
        }
    }
    public function getCountNotes(): int
    {
        try{
            $query = "SELECT count(*) FROM notes";
            $result = $this->conn->query($query);
            $amountOfNotes =  $result->fetch(PDO::FETCH_BOTH);
            if($amountOfNotes === false){
                throw new StorageException("Błąd przy próbie pobrania ilości notatek", 400);
            }
            return (int) $amountOfNotes[0];
        }catch(Throwable $e){
            throw new StorageException("Nie udao się pobrać informacji o liczbe notatek", 400, $e);
        }
        
    }
    public function searchNotes(
        string $phrase, 
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder
    ): array
    {
        return $this->findBy($phrase, $pageNumber, $pageSize, $sortBy, $sortOrder);
    }
    public function getSearchCount(string $phrase): int 
    {
        $phrase = $this->conn->quote('%' . $phrase . '%', PDO::PARAM_STR);
        try{
            $query = "SELECT count(*) FROM notes WHERE title LIKE($phrase)";
            $result = $this->conn->query($query);
            $amountOfNotes =  $result->fetch(PDO::FETCH_BOTH);
            if($amountOfNotes === false){
                throw new StorageException("Błąd przy próbie pobrania ilości notatek", 400);
            }
            return (int) $amountOfNotes[0];
        }catch(Throwable $e){
            throw new StorageException("Nie udao się pobrać informacji o liczbe notatek", 400, $e);
        }
    }
    public function getNotes(
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder
    ): array
    {
        return $this->findBy(null, $pageNumber, $pageSize, $sortBy, $sortOrder);
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
    public function deleteNote(int $id): void
    {
        try{
            $query = "DELETE FROM notes WHERE id=$id LIMIT 1";
            $this->conn->exec($query);
        }catch(Throwable $e){
            throw new StorageException('Nie udało się usunąć notatki', 400);
        }
    }
    private function findBy(
        ?string $phrase, 
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder
    ): array
    {
        try{
            $limit = $pageSize; 
            $offset = ($pageNumber - 1) * $pageSize;
            if(!in_array($sortBy, ['created', 'title'])){
                $sortBy = 'title';
            }
            if(!in_array($sortOrder, ['asc', 'desc'])){
                $sortOrder = 'desc';
            }
            $wherePart = '';
            if($phrase){
                $phrase = $this->conn->quote('%' . $phrase . '%', PDO::PARAM_STR);
                $wherePart = "WHERE title LIKE ($phrase)";
            }
            $query = "SELECT id,title ,created 
                      FROM notes
                      $wherePart
                      ORDER BY $sortBy $sortOrder
                      LIMIT $offset, $limit
                      ";
            
            $result = $this->conn->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Throwable $e){
            throw new StorageException("The data has not been get.", 400, $e);
        }
    }
}