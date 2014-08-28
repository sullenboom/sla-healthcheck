<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 26.08.14
 * Time: 10:30
 */

namespace HealthCheck\Model;

use Zend\Config;
use Zend\View\Model as ViewModel;

abstract class ModelAbstract implements ModelInterface
{
    /**
     * Configuration root path
     *
     * @var null|string
     */
    protected static $rootPath = 'data';

    /**
     * Configuration model path
     *
     * @var null|string
     */
    protected $modelPath = null;

    /**
     * Configuration model extension
     *
     * @var null|Config
     */
    protected $extension = 'json';

    /**
     * Model configuration
     *
     * @var null|Config
     * @throws Exception\InvalidArgumentException
     * @throws Exception\RuntimeException
     */
    protected $data = null;

    /**
     * @param array|null|\Traversable $filename
     * @param bool $useRealPath
     */
    public function __construct($filename, $useRealPath = false)
    {
        $useRealPath = (bool) $useRealPath;
        $pathInfo = pathinfo($filename);

        if (!isset($pathInfo['extension'])) {
            $filename .= '.' . $this->extension;
        }

        if ($useRealPath) {
            $configFileName = $filename;
        } else {
            $pathsArray = array(
                self::getRootPath(),
                $this->modelPath,
                $filename
            );
            $configFileName = implode(DIRECTORY_SEPARATOR, $pathsArray);
        }
        try {
            $config = Config\Factory::fromFile($configFileName);
            $this->data = new Config\Config($config, true);
        } catch (Config\Exception\RuntimeException $e) {
            throw new Exception\BadModelCallException(
                sprintf('Could not create an instance of "%s"', __CLASS__), $e->getCode(), $e
            );
        }
    }

    public function getVersion()
	{
        return $this->data->version;
    }

    public function getType()
	{
        return $this->data->type;
    }

    public function getName()
	{
        return $this->data->name;
    }

    public function setAppName($name) {
        $this->data->appName = $name;
    }

    public function getAppName() {
        return $this->data->appName;
    }

    /**
     * @return Service\Html
     */
    public function getList()
    {
        throw new Exception\RuntimeException('Have to be implemented');
    }

    /**
     * @param sting $path
     */
    static public function setRootPath($path)
	{
        self::$rootPath = $path;
    }

    /**
     * @return null|string
     */
    static public function getRootPath()
	{
        return self::$rootPath;
    }
} 