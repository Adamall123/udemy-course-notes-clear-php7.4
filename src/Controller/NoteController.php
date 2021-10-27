<?php 

declare(strict_types=1);

namespace App\Controller;


use App\Exception\NotFoundException;

class NoteController extends AbstractController
{
    public function createAction(): void
    {
                if($this->request->hasPost()){
                $this->database->createNote([
                    'title' => $this->request->postParam('title'),
                    'description' => $this->request->postParam('description')
                ]);
                $this->redirect('/', ['before' => 'created']);
                }
        $this->view->render('create');
    }
    public function showAction(): void 
    { 
            $this->view->render(
            'show',
            ['note' => $this->getNote()]
            );
    }
    public function listAction(): void
    {
        $pageNumber = (int) $this->request->getParam('page', 1); 
        $pageSize = (int) $this->request->getParam('pagesize', self::PAGE_SIZE); 
        
        $sortBy = $this->request->getParam('sortby', 'title');
        $sortOrder = $this->request->getParam('sortorder', 'desc');
        
        $phrase = $this->request->getParam('phrase');

        if(!in_array($pageSize, [1, 5, 10, 25])){
            $pageSize = self::PAGE_SIZE;
        }
        
        if($phrase){
            $note = $this->database->searchNotes($phrase, $pageNumber, $pageSize, $sortBy,$sortOrder);
            $noteAmount = $this->database->getSearchCount($phrase);
        }else {
            $note = $this->database->getNotes($pageNumber, $pageSize, $sortBy,$sortOrder);
            $noteAmount = $this->database->getCountNotes();
        }

        
        
        $this->view->render(
            'list',
            [
                'page' => [                    
                    'number' => $pageNumber, 
                    'size' => $pageSize,
                    'pages' => (int) ceil($noteAmount/$pageSize)
                ],
                'phrase' => $phrase,
                 'sort' => [
                    'by' => $sortBy,
                    'order' => $sortOrder
                ],
                'notes' => $note,
                'before' => $this->request->getParam('before'),
                'error' =>  $this->request->getParam('error') 
            ]
            );
           
    }
    
    public function editAction(): void
    {
        if($this->request->isPost()){
            $noteId = (int) $this->request->postParam('id');
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];
            $this->database->editNote($noteId, $noteData);
            $this->redirect('/',['before' => 'edited']);
        }

        $this->view->render(
        'edit',
        ['note' => $this->getNote()]
        );
    }
    public function deleteAction(): void 
    {
        if($this->request->isPost()){
            $noteId = (int) $this->request->postParam('id');
            $this->database->deleteNote($noteId);
            $this->redirect('/', ['before' => 'deleted']);
        }
        $this->view->render(
            'delete',
            ['note' => $this->getNote()]
            );
        exit('delete');
    }

    private function getNote(): array
    {
        $noteId = (int) $this->request->getParam('id');
        if(!$noteId){
            $this->redirect('/', ['error' => 'missingNoteId']);
        }
        try{
            $note = $this->database->getNote($noteId);
        }catch(NotFoundException $e){
            header('Location: /?error=noteNotFound');
            exit;
        }
        return $note;
    }
}