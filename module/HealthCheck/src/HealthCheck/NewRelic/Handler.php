<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 28.08.14
 * Time: 13:41
 */

namespace HealthCheck\NewRelic;


class Handler
{
    /**
     * Name of the New Relic application that will receive logs from this handler.
     *
     * @var string
     */
    protected $name = null;

    /**
     * {@inheritDoc}
     *
     * @param string $name
     */
    public function __construct($name = null)
    {
        if (!empty($name) && is_scalar($name)) {
            $this->setName($this->name);
        }
    }

    /**
     * Checks whether the NewRelic extension is enabled in the system.
     *
     * @return bool
     */
    protected function isEnabled()
    {
        return extension_loaded('newrelic');
    }

    /**
     * Sets the NewRelic application that should receive this log.
     *
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        if ($this->isEnabled()) {
            newrelic_set_appname($name);

        } else {
            ini_set('newrelic.appname', $name);
        }
        $this->name = $name;
        return $this;
    }

    /**
     * Returns the name
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param array $record
     * @throws Exception\RuntimeException
     */
    public function write(array $record)
    {
        if (!$this->isEnabled()) {
            throw new Exception\RuntimeException('The newrelic PHP extension is required to use the NewRelicHandler');
        }

        if ($name = $this->getName($record['context'])) {
            $this->setName($name);
        }

        if (isset($record['context']['exception']) && $record['context']['exception'] instanceof \Exception) {
            newrelic_notice_error($record['message'], $record['context']['exception']);
            unset($record['context']['exception']);
        } else {
            newrelic_notice_error($record['message']);
        }

        foreach ($record['context'] as $key => $parameter) {
            newrelic_add_custom_parameter($key, $parameter);
        }
    }
} 