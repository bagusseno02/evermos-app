<?php
/**
 * @author <a href="mailto:bagus.seno39@gmail.com>seno</a>
 * Created on 25/02/21
 * Project evermos-service
 */

namespace App\Utilities\Exception;

/**
 * Class BaseException
 * @package App\Utilities\Exception
 */
class BaseException extends \Exception
{
    /**
     * @var mixed|string
     */
    protected $errorCode = "";
    /**
     * @var array
     */
    protected $errorMessage = [];

    /**
     * BaseException constructor.
     * @param $errorMessage
     * @param string $errorCode
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        $errorMessage,
        $errorCode = "EXCEPTION.001",
        $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct($errorMessage, $code, $previous);
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return mixed|string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return array
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}