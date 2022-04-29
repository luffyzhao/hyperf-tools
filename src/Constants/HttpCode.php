<?php

namespace LHyperfTools\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;
/**
 * @Constants
 */
class HttpCode
{
    /**
     * @Message("Server Success！")
     */
    const OK = 200;
    /**
     * @Message("Server Error！")
     */
    const BAD_REQUEST = 500;
    /**
     * @Message("Server Error！")
     */
    const UNPROCESSABLE_ENTITY = 401;
}