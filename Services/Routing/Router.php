<?php
declare(strict_types=1);

namespace Services\Routing;

class Router
{   
    private const DEFAULT_PATH = 'homePage';
    private array $routes = [];
    private string $action;
    public string $path;
    
    public function __construct()
    {
        $this->setPath();
    }
    
    //Define the url base on the variable GET
    private function setPath(): void //retourne pas de valeurs
    {
        $this->path = $_GET['url'] ?? self::DEFAULT_PATH;
    }
    
    //Create the table of the router
    public function addRoute(string $path, string $action): void
    {
        array_push($this->routes, [$path => $action]);
    }
    
    //Find the url in the table, return the name of the controller or Null
    public function checkRoad(): ?string
    {
        $action = null;
        
        foreach($this->routes as $road){
            if(array_key_exists($this->path, $road)){
                $action = $road[$this->path];
            }
        }
        
        return $action;
    }
    
    //launch the router
    public function launch(): void
    {
        $action = $this->checkRoad();
        
        if($action) {
            $this->run($action);
        } else {
            $this->errorPage();
        }
    }
    
    //launch the controller
    private function run(string $controller)
    {
        ob_start();
        require_once '../Src/Controllers/'.$controller.'.php';
        $content = ob_get_clean();  
        require_once '../Views/layout.phtml';
    }
    
    //Error status 404
    private function errorPage(): void
    {

        header('HTTP/1.1 404 not found');
        
        ob_start();
        require_once '../Src/Controllers/'.'404.php';
        $content = ob_get_clean();  
        require_once '../Views/layout.phtml';

        exit();

    }
}