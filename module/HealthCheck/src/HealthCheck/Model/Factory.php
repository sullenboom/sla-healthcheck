<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 25.08.14
 * Time: 16:56
 */

namespace HealthCheck\Model;

class Factory
{
    /**
     * Registered config file extensions.
     * key is extension, value is reader instance or plugin name
     *
     * @var array
     */
    protected static $extensions = array('json', 'xml');

    /**
     * @param $directoryName
     * @param string $modelName
     * @param bool $useRealPath
     * @return ModelList
     * @throws Exception\RuntimeException
     */
    static public function fromDirectory($directoryName, $modelName = 'HealthCheck\Model\Service', $useRealPath = false)
    {
        $useRealPath = (bool) $useRealPath;
        if ($useRealPath) {
            $path = $directoryName;
        } else {
            $pathsArray = array(
                ModelAbstract::getRootPath(),
                $directoryName
            );
            $path = implode(DIRECTORY_SEPARATOR, $pathsArray);
        }

        if (!is_dir($path)) {
            throw new Exception\RuntimeException(sprintf(
                'Directory "%s" (origin "%s") cannot be found relative to the working directory',
                $path,
                $directoryName
            ));
        }

        $files = array();
        foreach (scandir($path) as $item) {

            if (preg_match("/(^(([\.]){1,2})$|(\.(svn|git|md))|(Thumbs\.db|\.DS_STORE))$/iu", $item)) {
                continue;
            }
            if (!is_file($path . DIRECTORY_SEPARATOR . $item)) {
                continue;
            }
            $pathInfo = pathinfo($item);
            if (!in_array($pathInfo['extension'], self::$extensions, true)) {
                continue;
            }
            $files[] = $path . DIRECTORY_SEPARATOR . $item;
        }

        return new ModelList($files, $modelName, true);
    }
}