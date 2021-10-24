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
        $this->view->render(
            'list',
            [
                'notes' => $this->database->getNotes(),
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
        $note = $this->getNote();
        dump($note);
        exit('delete');
    }

    final private function getNote(): array
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