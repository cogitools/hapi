<?php
namespace Harvest\Model;

use Harvest\Exception\HarvestException;

/**
 * Result
 *
 * This file contains the class Result
 *
 */

/**
 * Harvest Result Object
 *
 * @property int code
 * @property array|mixed data
 *
 * @property string Server
 * @property string Date
 * @property string Content-Type
 * @property string Connection
 * @property string Status
 * @property string X-Powered-By
 * @property string ETag
 * @property string X-Served-From
 * @property string X-Runtime
 * @property string Content-Length
 * @property string Location
 * @property string Hint
 */
class Result
{

    /**
     * @var string response code
     */
    protected $_code = null;

    /**
     * @var array response data
     */
    protected $_data = null;

    /**
     * @var string response headers
     */
    protected $_headers = null;

    /**
     * Constructor initializes {@link $_code} {@link $_data}
     *
     * @param string $code    response code
     * @param array  $data    array of Quote Objects
     * @param array  $headers array of Header Response values
     */
    public function __construct($code = null, $data = null, $headers = null)
    {
        $this->_code = $code;
        $this->_data = $data;
        $this->_headers = $headers;
    }

    /**
     * magic method to return non public properties
     *
     * @see     get
     * @param  mixed $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->get( $property);
    }

    public function __call($name, $arguments)
    {
        return $this->get($name);
    }

    /**
     * Return the specified property
     *
     * @param  mixed $property The property to return
     * @return mixed
     * @throws HarvestException
     */
    public function get($property)
    {
        switch ($property) {
            case 'code':
                return $this->_code;
            break;
            case 'data':
                return $this->_data;
            break;
            case 'headers':
                return $this->_headers;
            break;
            default:
                if ( $this->_headers != null && array_key_exists($property, $this->_headers) ) {
                    return $this->_headers[$property];
                } else {
                    throw new HarvestException(sprintf('Unknown property %s::%s', get_class($this), $property));
                }
            break;
        }
    }

    /**
     * magic method to set non public properties
     *
     * @see    set
     * @param  mixed $property
     * @param  mixed $value
     * @return void
     */
    public function __set($property, $value)
    {
        $this->set( $property, $value );
    }

    /**
     * sets the specified property
     *
     * @param  mixed $property The property to set
     * @param  mixed $value value of property
     * @throws HarvestException
     */
    public function set($property, $value)
    {
        switch ($property) {
            case 'code':
                $this->_code = $value;
            break;
            case 'data':
                $this->_data = $value;
            break;
            case 'headers':
                $this->_headers = $value;
            break;
            default:
                throw new HarvestException(sprintf('Unknown property %s::%s', get_class($this), $property));
            break;
        }
    }

    /**
     * is request successful
     * @return boolean
     */
    public function isSuccess()
    {
        if ( "2" == substr( $this->_code, 0, 1 ) ) {
            return true;
        } else {
            return false;
        }
    }

}

