<?php


namespace app\modules\controllers;


use yii\web\Controller;

class BasickController extends Controller
{
    const METHOD_GET = 1;
    const METHOD_POST = 2;

    /**
     * @return bool|mixed
     * @throws \Exception
     */
    public function isPost()
    {
        return \Yii::$app->request->isPost;
    }

    public function post($key = null, $default_value = null)
    {
        if (class_exists('\Yii', false)) {
            return \Yii::$app->request->post($key, $default_value);
        }

        return isset($_POST[$key]) ? $_POST[$key] : $default_value;
    }

    /**
     * @param string $type
     * @param string $message
     */
    public function setFlash($type = 'success', $message = '')
    {
        \Yii::$app->session->setFlash($type, $message);
    }

    /**
     * @param      $key
     * @param null $default_value
     * @param null $max_value
     *
     * @return int|null
     */
    public function getInt($key, $default_value = null, $max_value = null)
    {
        return $this->getParamInt($key, self::METHOD_GET, $default_value, $max_value);
    }

    /**
     * @param string $key
     * @param int $source
     * @param mixed|null $default_value
     * @param null|int $max_value максимальное значение
     *
     * @return int|null
     */
    protected function getParamInt($key, $source = self::METHOD_GET, $default_value = null, $max_value = null)
    {
        $value = $this->getParam($key, $source);
        if (!is_numeric($value)) {
            return $default_value;
        }
        $value_int = (int)$this->getParam($key, $source);

        if (is_numeric($max_value) && $value_int > $max_value) {
            return $max_value;
        }

        return $value_int;
    }

    /**
     * @param string $key
     * @param int $source
     * @param mixed|null $default_value
     *
     * @return mixed|null
     */
    protected function getParam($key, $source = self::METHOD_GET, $default_value = null)
    {
        if ($source == self::METHOD_GET) {
            return $this->get($key, $default_value);
        }

        return $this->post($key, $default_value);
    }

    public function get($key = null, $default_value = null)
    {
        if (class_exists('\Yii', false)) {
            return \Yii::$app->request->get($key, $default_value);
        }

        return isset($_GET[$key]) ? $_GET[$key] : $default_value;
    }
}