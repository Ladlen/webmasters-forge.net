<?php

#require_once(APP_DIR . 'controllers/ControllerController.php');
#require_once(APP_DIR . 'models/User.php');
#require_once(APP_DIR . 'models/City.php');
#require_once(APP_DIR . 'helpers/prepareJSON.php');

class UserController extends Controller
{
    public function __construct($config)
    {
        parent::__construct($config);
    }

    public function actionIndex()
    {
        $model = User::GetAllUsers();
        $cities = City::GetAllCities();
        $this->render(APP_DIR . 'views/User.php', ['model' => $model->rows, 'cities' => $cities->rows]);
    }

    public function actionUpdate()
    {
        $ret = ['success' => false];

        $_REQUEST['value'] = trim($_REQUEST['value']);

        $model = new User();
        $win1251Value = mb_convert_encoding($_REQUEST['value'], DOCUMENT_ENCODING, 'UTF-8');

        if ($errors = $model->verifyUserInfo([$_REQUEST['name'] => $win1251Value]))
        {
            $ret = ['success' => false, 'messages' => $errors];
        }
        else
        {
            if ($model->updateUser($_REQUEST['id'], $_REQUEST['name'], $win1251Value))
            {
                $ret = ['success' => true, 'value' => $_REQUEST['value']];
            }
        }

        echo prepareJSON::jsonEncode($ret);
        exit;
    }

    public function actionCreateNewUser()
    {
        $ret = ['success' => false];

        $_REQUEST['name'] = trim($_REQUEST['name']);

        $model = new User();
        $win1251Name = mb_convert_encoding($_REQUEST['name'], DOCUMENT_ENCODING, 'UTF-8');

        if ($errors = $model->verifyUserInfo(['name' => $win1251Name, 'age' => $_REQUEST['age']]))
        {
            $ret = ['success' => false, 'messages' => $errors];
        }
        elseif ($model->createUser($win1251Name, $_REQUEST['age'], $_REQUEST['city']))
        {
            $ret['success'] = true;
        }

        echo prepareJSON::jsonEncode($ret);
        exit;
    }
}