<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 25.08.14
 * Time: 16:56
 */

namespace HealthCheck\Model;

use Zend\Config;

class ModelList extends Config\Config
{
    /**
     * Name from the model class.
     *
     * @var string
     */
    protected $modelName = null;

    /**
     * @param array $array
     * @param string $modelName
     */
    public function __construct(array $array, $modelName = 'HealthCheck\Model\Service', $useRealPath = false)
    {
        $this->modelName = (string) $modelName;
        if (!class_exists($modelName)) {
            throw new Exception\BadModelCallException(sprintf(
                'Model class "%s"',
                $modelName
            ));
        }

        $data = array();
        foreach ($array as $serviceFilename) {
            /**
             * TODO Caching
             */
            $model = new $this->modelName($serviceFilename, $useRealPath);

            if (is_object($model) && method_exists($model, 'getName')) {
                $data[$model->getName()] = $model;
            } else {
                throw new Exception\BadModelCallException('Model class requires method "getName"');
            }
        }
        parent::__construct($data);
        if ($this->count() === 0) {
            throw new Exception\UnexpectedValueException(sprintf(
                'Could not create any instance of "%s"',
                $this->modelName
            ));
        }
    }

    /**
     * @return Config
     */
    public function getNameList()
    {
        $array = array();
        foreach ($this->toArray() as $model) {
            $array[$model->getName()]['name'] = $model->getName();
        }
        return $array;
    }
}