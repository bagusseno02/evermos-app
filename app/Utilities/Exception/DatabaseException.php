<?php
/**
 * @author <a href="mailto:bagus.seno39@gmail.com>seno</a>
 * Created on 25/02/21
 * Project evermos-service
 */

namespace App\Utilities\Exception;

/**
 * Class DatabaseException
 * @package App\Utilities\Exception
 */
class DatabaseException extends BaseException
{

    /**
     * DatabaseException constructor.
     * @param $errorMessage
     * @param string $errorCode
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        $errorMessage,
        $errorCode = "DB.0001",
        $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct($errorMessage, $errorCode, $code, $previous);
    }

}