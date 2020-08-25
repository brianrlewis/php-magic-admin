<?php

namespace AdminSDK\Exceptions;

class ServiceException extends MagicAdminSDKException
{
    public function __construct(string $additionalMessage = null)
    {
        $message = 'A service error occurred while communicating with the Magic API';
        if ($additionalMessage) {
            $message .= " (Message: $additionalMessage)";
        }

        parent::__construct($message);
    }
}
