<?php

Class Router
{
    private $url;
    private $routes = [];

    //add constructor with $url
    public function __construct(string $url)
    {
        $this->url = trim($url, '/');
    }

    //add route to the routes array add post and get type
   
    public function add(string $regexRoute, string $controller, string $method, string $type)
    {
        $this->routes[] = [
            'route' => trim($regexRoute, '/'),
            'controller' => $controller,
            'method' => $method,
            'type' => $type
        ];
    }

    public function match()
    {
        foreach ($this->routes as $route) {
            $path = preg_replace('#:([\w]+)#', '([^/]+)', $route['route']);

            if(preg_match("#^$path$#i", $this->url, $matches) && $route['type'] == $_SERVER['REQUEST_METHOD']){
                include_once 'src/controller/' . $route['controller'] . '.php';
                $controller = new $route['controller'];

                array_shift($matches);
                $controller->{$route['method']}(...$matches);

                return;
            }
        }

        //add 404 error
        include_once 'src/view/404.php';
    }
}