<?php

class SiteController extends ControllerController
{
    /**
     * Default page title.
     *
     * @var string
     */
    public $title;

    public function __construct($config)
    {
        parent::__construct($config);
        $this->title = _('Sign in/Sign up');
    }

    public function actionIndex()
    {
        #$this->render($this->getViewsPath() . 'index.php', ['model' => $model->rows, 'cities' => $cities->rows]);
        $this->render('index');
    }


}