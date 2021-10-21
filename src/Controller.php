<?php 

declare(strict_types=1);

namespace App;

use App\Request;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use Throwable;

require_once("src/Database.php");
require_once("src/View.php");
require_once("src/Exception/ConfigurationException.php");

class Controller 
{
    private const DEFAULT_ACTION = 'list';
    private Request $request;
    private Database $database; 
    private View $view;
    private static array $configuration = []; 
    public static function initConfiguration(array $configuration): void 
    {
        self::$configuration = $configuration;
    }

    public function __construct(Request $request)
    {
        if(empty(self::$configuration['db'])){
            throw new ConfigurationException("Configuration error");
        }
        $this->database = new Database(self::$configuration['db']);   
        $this->request = $request;
        $this->view = new View();
    }
    
    public function run(): void 
    {
        switch($this->action()){
            case 'create':
                $page = 'create';

                if($this->request->hasPost()){
                $this->database->createNote([
                    'title' => $this->request->postParam('title'),
                    'description' => $this->request->postParam('description')
                ]);
                header('Location: /?before=created');
                exit;
                }
            break;
            case 'show':
                
                $page = 'show';
                // $data = $this->getRequestGet();
                // $noteId = (int) ($data['id'] ?? null);

                $noteId = (int) $this->request->getParam('id');
    
                if(!$noteId){
                    header('Location: /?error=missingNoteId');
                    exit;
                }
                try{
                    $note = $this->database->getNote($noteId);
                }catch(NotFoundException $e){
                    header('Location: /?error=noteNotFound');
                    exit;
                }
               
                $viewParams = [
                    'note' => $note
                ];
            break;
            default:
                $page = 'list';
                //$data = $this->getRequestGet();

                $viewParams = [
                    'notes' => $this->database->getNotes(),
                    'before' => $this->request->getParam('before'),
                    'error' =>  $this->request->getParam('error') 
                ];              
            break;
        }
        $this->view->render($page, $viewParams ?? []);
    }
   
    private function action(): string
    {
        return  $this->request->getParam('action',self::DEFAULT_ACTION); 
    }
}