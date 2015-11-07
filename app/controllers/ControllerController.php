<?php

abstract class ControllerController
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    protected function renderPhpFile($file, $params = [])
    {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require($file);

        return ob_get_clean();
    }

    protected function render($file, $params = [])
    {
        $scripts = '';
        $content = $this->renderPhpFile($file, $params);
        require(APP_DIR . 'views/layouts/main.php');
    }

    protected function getViewsPath()
    {
        $className = get_class($this);
        $folderName = substr($className, 0, -strlen('Controller'));
        return APP_DIR . "views/$folderName/";
    }

    abstract function actionIndex();
}