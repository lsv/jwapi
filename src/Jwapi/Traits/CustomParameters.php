<?php
/**
 * Created by PhpStorm.
 * User: lsv
 * Date: 2/15/14
 * Time: 6:03 AM
 */

namespace Jwapi\Traits;

trait CustomParameters
{

    /**
     * Custom parameters
     * @var array
     */
    private $customParameters = array();

    /**
     * (optional)
     * User defined parameter
     *
     * name can contain letters, numbers and punctuation characters ‘.’, ‘_’, ‘-‘
     * name cannot start with a number or punctuation character
     * name cannot contain spaces
     *
     * @param string $key
     * @param string $value
     *                      @return $this
     *
     * @throws \Exception
     */
    public function addCustomParameter($key, $value)
    {
        $m1 = ! preg_match('#^[^a-zA-Z]{1}#', $key, $matches);
        $m2 = ! preg_match('#([^a-zA-Z0-9\._-])#', $key, $matches);

        if (! $m1 || ! $m2) {
            throw new \Exception('Custom parameter name cant start with (. 0-9), and may only contain (._- a-Z 0-9)');
        }

        $this->customParameters[$key] = $value;

        return $this;
    }

    /**
     * (optional)
     * User defined parameter
     *
     * @see addCustomParameter
     *
     * @param array $parameters
     *                          @return $this
     */
    public function setCustomParameters(array $parameters)
    {
        foreach ($parameters as $k => $v) {
            $this->addCustomParameter($k, $v);
        }

        return $this;
    }

    /**
     * {@inherit}
     */
    protected function beforeCustomParameters()
    {
        if ($this->customParameters) {
            foreach ($this->customParameters as $k => $v) {
                $this->setGet(urlencode('custom.' . $k), $v);
            }
        }
    }

}
