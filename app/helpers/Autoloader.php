<?php

/**
 * @param string $className class name
 * @throws Exception
 */
function __autoload($className)
{
    $matches = array();
    $matchesCount = preg_match_all("/.*([A-Z].*)/", $className, $matches);
    if ($matchesCount == 1)
    {
        // Find the directory.
        $dirName = APP_DIR . strtolower($matches[1][0]) . 's';
        if (is_dir($dirName))
        {
            $fileName = "$dirName/$className.php";
            if (is_readable($fileName))
            {
                require($fileName);
            }
            else
            {
                throw new Exception(sprintf(_("Unable to load class %s because there is no %s file."), $className, $fileName));
            }
        }
        else
        {
            throw new Exception(sprintf(_("Unable to load class %s because there is no %s directory."), $className, $dirName));
        }
    }
}
