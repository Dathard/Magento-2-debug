<?php

namespace App\Model\Framework\App;

use App\Model\Framework\App\ObjectManager\Singleton;

class Request extends Singleton
{
    /**#@+
     * @const string METHOD constant names
     */
    const METHOD_OPTIONS  = 'OPTIONS';
    const METHOD_GET      = 'GET';
    const METHOD_HEAD     = 'HEAD';
    const METHOD_POST     = 'POST';
    const METHOD_PUT      = 'PUT';
    const METHOD_DELETE   = 'DELETE';
    const METHOD_TRACE    = 'TRACE';
    const METHOD_CONNECT  = 'CONNECT';
    const METHOD_PATCH    = 'PATCH';
    const METHOD_PROPFIND = 'PROPFIND';
    /**#@-*/

    private static $instances = [];

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var null|array
     */
    private $queryParams = null;

    /**
     * @var null|array
     */
    private $postParams = null;

    /**
     * @var null|string
     */
    private $uri = null;

    /**
     * @var null|string
     */
    private $method = null;

    /**
     * Return the method for this request
     *
     * @return string
     */
    public function getMethod()
    {
        if ($this->method === null) {
            $this->method = $_SERVER['REQUEST_METHOD'];
        }

        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        if (empty($this->uri) && !empty($_SERVER['REQUEST_URI']))
        {
            $this->uri = trim($_SERVER['REQUEST_URI'], '/');
        }

        return $this->uri;
    }

    /**
     * Get an action parameter
     *
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed
     */
    public function getParam($key, $default = null)
    {
        $key = (string) $key;

        if (isset($this->params[$key])) {
            return $this->params[$key];
        } elseif (isset($this->queryParams[$key])) {
            return $this->queryParams[$key];
        } elseif (isset($this->postParams[$key])) {
            return $this->postParams[$key];
        }
        return $default;
    }

    /**
     * Set an action parameter
     *
     * A $value of null will unset the $key if it exists
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setParam($key, $value)
    {
        $key = (string) $key;
        if ((null === $value) && isset($this->params[$key])) {
            unset($this->params[$key]);
        } elseif (null !== $value) {
            $this->params[$key] = $value;
        }
        return $this;
    }

    /**
     * Get all action parameters
     *
     * @return array
     */
    public function getParams()
    {
        $params = $this->params;
        if ($value = (array)$this->getQuery()) {
            $params += $value;
        }
        if ($value = (array)$this->getPost()) {
            $params += $value;
        }
        return $params;
    }

    /**
     * Set action parameters en masse; does not overwrite
     *
     * Null values will unset the associated key.
     *
     * @param array $array
     * @return $this
     */
    public function setParams(array $array)
    {
        foreach ($array as $key => $value) {
            $this->setParam($key, $value);
        }
        return $this;
    }

    /**
     * Unset all user parameters
     *
     * @return $this
     */
    public function clearParams()
    {
        $this->params = [];
        return $this;
    }

    /**
     * @param string|null $name Parameter name to retrieve, or null to get the whole container.
     * @param mixed|null $default Default value to use when the parameter is missing.
     * @return mixed
     */
    public function getQuery($name = null, $default = null)
    {
        if ($this->queryParams === null) {
            $this->queryParams = $_GET;
        }

        if ($name === null) {
            return $this->queryParams;
        }

        return $this->queryParams[$name] ?: $default;
    }

    /**
     * @param string $key
     * @param string|null $value
     * @return $this
     */
    public function setQuery($key, $value = null)
    {
        if (is_string($key) && strlen($key) > 0) {
            $this->queryParams[$key] = $value;
        }

        return $this;
    }

    /**
     * @param string|null $name Parameter name to retrieve, or null to get the whole container.
     * @param mixed|null $default Default value to use when the parameter is missing.
     * @return mixed
     */
    public function getPost($name = null, $default = null)
    {
        if ($this->postParams === null) {
            $this->postParams = $_POST;
        }

        if ($name === null) {
            return $this->postParams;
        }

        return $this->postParams[$name] ?: $default;
    }

    /**
     * @param string $key
     * @param string|null $value
     * @return $this
     */
    public function setPost($key, $value = null)
    {
        if (is_string($key) && strlen($key) > 0) {
            $this->postParams[$key] = $value;
        }

        return $this;
    }

    /**
     * Retrieve GET parameters
     *
     * @param null $name
     * @param null $default
     * @return mixed
     */
    public function getQueryValue($name = null, $default = null):array
    {
        return $this->getQuery($name, $default);;
    }

    /**
     * Set GET parameters
     *
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setQueryValue($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->setQuery($key, $value);
            }
            return $this;
        }

        $this->getQuery($name, $value);
        return $this;
    }

    /**
     * Retrieve POST parameters
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getPostValue($name = null, $default = null)
    {
        return $this->getPost($name, $default);
    }

    /**
     * Set POST parameters
     *
     * @param string|array $name
     * @param mixed $value
     * @return $this
     */
    public function setPostValue($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->setPost($key, $value);
            }
            return $this;
        }

        $this->getPost($name, $value);
        return $this;
    }

    /**
     * Is this an OPTIONS method request?
     *
     * @return bool
     */
    public function isOptions():bool
    {
        if ($this->method === null) {
            $this->getMethod();
        }

        return ($this->method === self::METHOD_OPTIONS);
    }

    /**
     * Is this a PROPFIND method request?
     *
     * @return bool
     */
    public function isPropFind():bool
    {
        if ($this->method === null) {
            $this->getMethod();
        }

        return ($this->method === self::METHOD_PROPFIND);
    }

    /**
     * Is this a GET method request?
     *
     * @return bool
     */
    public function isGet():bool
    {
        if ($this->method === null) {
            $this->getMethod();
        }

        return ($this->method === self::METHOD_GET);
    }

    /**
     * Is this a HEAD method request?
     *
     * @return bool
     */
    public function isHead()
    {
        if ($this->method === null) {
            $this->getMethod();
        }

        return ($this->method === self::METHOD_HEAD);
    }

    /**
     * Is this a POST method request?
     *
     * @return bool
     */
    public function isPost()
    {
        if ($this->method === null) {
            $this->getMethod();
        }

        return ($this->method === self::METHOD_POST);
    }

    /**
     * Is this a PUT method request?
     *
     * @return bool
     */
    public function isPut()
    {
        if ($this->method === null) {
            $this->getMethod();
        }

        return ($this->method === self::METHOD_PUT);
    }

    /**
     * Is this a DELETE method request?
     *
     * @return bool
     */
    public function isDelete()
    {
        if ($this->method === null) {
            $this->getMethod();
        }

        return ($this->method === self::METHOD_DELETE);
    }

    /**
     * Is this a TRACE method request?
     *
     * @return bool
     */
    public function isTrace()
    {
        if ($this->method === null) {
            $this->getMethod();
        }

        return ($this->method === self::METHOD_TRACE);
    }

    /**
     * Is this a CONNECT method request?
     *
     * @return bool
     */
    public function isConnect()
    {
        if ($this->method === null) {
            $this->getMethod();
        }

        return ($this->method === self::METHOD_CONNECT);
    }

    /**
     * Is this a PATCH method request?
     *
     * @return bool
     */
    public function isPatch()
    {
        if ($this->method === null) {
            $this->getMethod();
        }

        return ($this->method === self::METHOD_PATCH);
    }
}