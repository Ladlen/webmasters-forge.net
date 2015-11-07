<?php

class SiteController extends ControllerController
{
    public function __construct($config)
    {
        parent::__construct($config);
    }

    public function actionIndex()
    {
        #$this->render($this->getViewsPath() . 'index.php', ['model' => $model->rows, 'cities' => $cities->rows]);
        $this->render($this->getViewsPath() . 'index.php');
    }


}