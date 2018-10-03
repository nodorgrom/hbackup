<?php 
class Router {
  private $routes; // хранение маршрутов ЗДЕСЬ ( это свойство класса )

  // тут читаем и запоминаем роуты
  public function __construct() {
    // /www/backuper/config/routes.php
    $routesPath = ROOT . '/config/routes.php';
    // prrr('routespath: (где хранятся наши маршруты)', $routesPath);

    $this->routes = include $routesPath;
    // prrr('routes: (все маршруты в виде массива) ',$this->routes);
  }


  /*
  @ Возвращает строку запроса
  */
  private function getURI() {
    if (!empty($_SERVER['REQUEST_URI'])) {
      return $uri = trim($_SERVER['REQUEST_URI'], '/');
    }  
  }



  public function run() {

    // получение строки пользовательского запроса
    // $uri = /hosts/2
    $uri = $this->getURI();

    // проверка в файле routes
    foreach ($this->routes as $uriPattern => $path) {
      // prrr('routes.php (найденный маршрут)', 'uriPattern: routes['. $uriPattern .'] => ' . $path . ' (path)');



      if (preg_match("~$uriPattern~", $uri)) {
        $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
        // prrr('internalRoute: (полный путь) ', $internalRoute);


        // action. Ключи массива $this->routes ['hosts'], ['test']
        // разбиваем строку hosts/view/3 на ключ -> значение по знаку - " / "
        $segments = explode('/', $internalRoute);
        // prrr('segments: (разбиваем на сегменты) ', $segments);

        /*
          hosts/view/3
          
          Array
          (
              [0] => hosts    ---- array_shift() ---- вырезаем из $segments
              [1] => view
              [2] => 3
          )
          
          Контроллер который будет обрабатывать: [0] => hosts
          $controllerName = HostsController
        */
        $controllerName = ucfirst(array_shift($segments)) . 'Controller';
        
        /*
          а теперь то же самое делаем с:
          Array
          (
              [0] => view    ---- array_shift() ---- вырезаем из $segments
              [1] => 3
          )

          $actionName = actionView
        */
        $actionName = 'action' . ucfirst(array_shift($segments));

        /*
          тут осталась цифра (или что-то еще в будущем)
        */
        $parameters = $segments;


        /*
          подключение класса-КОНТРОЛЛЕРА
          $controllerFile = /www/backuper/controllers/HostsController.php
          $controllerName = HostsController
        */
        $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

        /*
          если такой файл существует, то подключаем его: /www/backuper/controllers/HostsController.php
        */
        if (file_exists($controllerFile)) {
          include_once $controllerFile;
        }

        /*
           Создать объект (экземпляр класса), вызвать МЕТОД (ACTION)
           $controllerName = HostsController
        */
        $controllerObject = new $controllerName;
        /*
          Тут подставляются, в качестве переменных, КОНТРОЛЛЕР->МЕТОД
          которые получали выше

          $controllerObject ---- экземпляр класса HostsController ( $controllerObject = new HostsController; )
          $actionName       ---- метод класса HostsController
          
          +++                                    +++
          + ИТОГО: $controllerObject::actionList() +
          +++                                    +++
        */
        // $result = $controllerObject->$actionName($parameters);
        $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

        // prrr('<br>result: ', $result);

        if ($result != null) {
          break;
        }
      }
    } // endforeach;

  }

}