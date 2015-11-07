<?php

/**
 * Class RouterHelper
 *
 * Routing.
 */
class RouterHelper
{
    /**
     * Default controller name.
     *
     * @var string
     */
    protected $defaultController = 'SiteController';

    /**
     * Default action name.
     *
     * @var string
     */
    protected $defaultAction = 'actionIndex';

    protected $config;
    protected $parts;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Get controller name.
     *
     * @return string
     */
    protected function getController()
    {
        $controller = $this->defaultController;
        if (!empty($this->parts[0]))
        {
            $controller = ucfirst($this->parts[0]) . 'Controller';
        }
        return $controller;
    }

    /**
     * Get action name.
     *
     * @return string
     */
    protected function getAction()
    {
        $action = $this->defaultAction;
        if (!empty($this->parts[1]))
        {
            $action = 'action' . ucfirst($this->parts[1]);
        }
        return $action;
    }

    public function run()
    {
        $controller = $this->defaultController;
        $action = $this->defaultAction;

        if (isset($_REQUEST['route']))
        {
            $route = trim($_REQUEST['route'], '/\\');
            $this->parts = explode('/', $route);

            $controller = $this->getController();
            $action = $this->getAction();
        }

        if (!is_readable(APP_DIR . "controllers/$controller.php"))
        {
            // No such page.
            $controller = 'SiteController';
            $action = 'action404';
        }
        elseif (!is_callable(array($controller, 'action' . ucfirst($action))))
        {
            $action = 'actionIndex';
        }

        (new $controller($this->config))->$action();
    }
}
