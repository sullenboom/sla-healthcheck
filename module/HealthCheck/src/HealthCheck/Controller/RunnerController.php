<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace HealthCheck\Controller;

use HealthCheck\Model;
use HealthCheck\NewRelic;
use HealthCheck\Runner;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model as ViewModel;
use Zend\View\Renderer;
use Zend\Json;
use Zend\Filter;

class RunnerController extends AbstractActionController
{
    const HTML = 'html';
    const JSON = 'json';
    const RICH = 'rich';
    const XML  = 'xml';

    public function serviceAction()
    {
        $serviceName = strtolower($this->params()->fromRoute('service'));
        $format = strtolower($this->params()->fromRoute('format'));
        $runChecks = $this->params()->fromQuery('run', true);

        try {
            $service = new Model\Service($serviceName);
        } catch (Model\Exception\BadModelCallException $e) {
            return $this->notFoundAction();
        }
        $this->_setNewRelic($service);

        $content = $this->_getContentView($service, $format, $runChecks);
        if ($format === self::JSON) {
            $data = $content->getVariables();
            unset($data->service);
            $view = new ViewModel\JsonModel($data);
            Json\Json::$useBuiltinEncoderDecoder = true;

        } else {
            $view = new ViewModel\ViewModel();
            $view->addChild($content, 'content');
            $view->service = $service;
            $view->format = $format;
        }
        return $view;
    }

    /**
     * @param Model\Service $service
     * @param string $format
     * @param boolean $runChecks
     * @return ViewModel\ViewModel
     */
    protected function _getContentView(Model\Service $service, $format = self::HTML, $runChecks = true)
    {
        // Create and set view template
        $view = new ViewModel\ViewModel();
        $view->setTemplate('format/' . $format);

        // Activate json encoder
        switch($format) {
            case self::JSON:
            case self::XML:
                $runChecks = true;
                break;
        }
        /**
         * TODO change here runner with service model parameter
         */
        $sites = $service->getSites();
        $domains  = $service->getDomains();
        $boolean = new Filter\Boolean(Filter\Boolean::TYPE_FALSE_STRING);
        if ($boolean->filter($runChecks)) {
            $sites = Runner\Html::run($service->getSites());
        }

        // Set view properties
        $view->service  = $service;
        $view->sites    = $sites;
        $view->domains  = $domains;
        return $view;
    }

    protected function _setNewRelic(Model\Service $service)
    {
        $appName = strtolower($service->getType() . '-' . $service->getName() . ' ' . $service->getVersion());
        $newRelic = new NewRelic\Handler();
        $newRelic->setName($appName);
        $service->setAppName($appName);
    }
}
