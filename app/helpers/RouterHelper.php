<?php

/**
 * Class RouterHelper
 *
 * Routing.
 */
class RouterHelper
{
    /**
     * URL parts for default page.
     * @var array
     */
    protected $pageDefault = ['controller' => 'site', 'action' => 'index'];

    /**
     * URL parts for empty page.
     * @var array
     */
    protected $page404 = ['controller' => 'site', 'action' => '404'];

    /**
     * Url parts.
     * @var array|null
     */
    protected $parts;

    /**
     * Configuration.
     * @var array
     */
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Create controller name.
     *
     * @param string $controllerPart url part of the controller
     * @return string controller name
     */
    protected function getControllerName($controllerPart)
    {
        $controller = $this->pageDefault['controller'];
        if (!empty($controllerPart))
        {
            $controller = ucfirst($controllerPart) . 'Controller';
        }
        return $controller;
    }

    /**
     * Create action name.
     *
     * @param string $actionName url part of the action
     * @return string action name
     */
    protected function getActionName($actionName)
    {
        $action = $this->pageDefault['action'];
        if (!empty($actionName))
        {
            $action = 'action' . ucfirst($actionName);
        }
        return $action;
    }

    /**
     * Analyse URL then evoke controller action.
     */
    public function run()
    {
        $controllerName = $this->getControllerName($this->pageDefault['controller']);
        $actionName = $this->getActionName($this->pageDefault['action']);

        if (isset($_REQUEST['route']))
        {
            $route = trim($_REQUEST['route'], '/\\');
            $this->parts = explode('/', $route);

            if (isset($this->parts[0]))
            {
                $controllerName = $this->getControllerName($this->parts[0]);
            }
            if (isset($this->parts[1]))
            {
                $actionName = $this->getActionName($this->parts[1]);
            }
        }

        if (!is_readable(APP_DIR . "controllers/$controllerName.php"))
        {
            // No such page.
            $controllerName = $this->getControllerName($this->page404['controller']);
            $actionName = $this->getActionName($this->page404['action']);
        }
        elseif (!is_callable(array($controllerName, 'action' . ucfirst($actionName))))
        {
            // No action in the controller.
            $actionName = $this->getActionName('index');
        }

        (new $controllerName($this->config))->$actionName($this->parts);
    }
}
