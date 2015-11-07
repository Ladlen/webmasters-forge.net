<?php

class ControllerController
{
    protected $config;

    protected $parts;

    public function __construct($config)
    {
        $this->config = $config;

        $controller = 'site';   // Default controller.
        $action = 'index';      // Default action.

        if (isset($_REQUEST['route']))
        {
            $route = trim($_REQUEST['route'], '/\\');
            $this->parts = explode('/', $route);
            if (!empty($this->parts[0]))
            {
                $controller = $this->parts[0];
            }
            if (!empty($this->parts[1]))
            {
                $action = $this->parts[1];
            }
        }

        #if (is_dir(APP_DIR . )


        $actionName = isset($_REQUEST['route']) ? $_REQUEST['route'] : 'index';
        $functionName = 'action' . ucfirst($actionName);
        if(is_callable($this, $functionName))
        {
            $this->$functionName();
        }
    }

    protected function renderPhpFile($file, $params = [])
    {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require($file);

        return ob_get_clean();
    }

    protected function render($file, $params)
    {
        $scripts = '';
        $content = $this->renderPhpFile($file, $params);
        require(APP_DIR . 'views/layout.php');
    }
}