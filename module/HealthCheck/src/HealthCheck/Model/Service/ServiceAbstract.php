<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 26.08.14
 * Time: 17:51
 */

namespace HealthCheck\Model\Service;

use Zend\Config;

abstract class ServiceAbstract
    extends Config\Config
    implements ServiceInterface
{
    protected $child  = false;

    public function __construct(array $array, $isChild = false)
    {
        $this->allowModifications = true;
        $this->child = (bool) $isChild;

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->data[$key] = new static($value, true);
            } else {
                $this->data[$key] = $value;
            }

            $this->count++;
        }
        $this->data['type'] = strtolower(str_replace(__NAMESPACE__ . '\\', '', get_class($this)));
        $this->data['status'] = null;
    }

    public function isChild()
    {
        return $this->child;
    }

    public function getType()
    {
        return $this->get('type');
    }

    public function getName()
    {
        return $this->get('name');
    }

    public function setStatus($status, $onlyIfWorse = false)
    {
        $status = (int) $status;

        if (!$onlyIfWorse || !isset($this->status) || $this->status < $status) {
            $this->__set('status', $status);
        }
        return $this;
    }

    public function getStatus()
    {
        return $this->get('status');
    }

    /**
     * Merge an array with this Config.
     *
     * For duplicate keys, the following will be performed:
     * - Nested Configs will be recursively merged.
     * - Items in $merge with INTEGER keys will be appended.
     * - Items in $merge with STRING keys will overwrite current values.
     *
     * @param  array $merge
     * @return ServiceAbstract
     */
    public function mergeArray(array $array)
    {
        return $this->merge(new Config\Config($array));
    }
}