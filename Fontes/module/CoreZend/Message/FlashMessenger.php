<?php

namespace CoreZend\Message;

use Zend\Mvc\Controller\Plugin\FlashMessenger as FlashMessengerZend;

trait FlashMessenger
{
    protected static $flashMessenger;

    public function setMessagemInfo($strMessage)
    {
        return $this->addMessageGeneric($strMessage, FlashMessengerZend::NAMESPACE_INFO);
    }

    public function setMessageSuccess($strMessage)
    {
        return $this->addMessageGeneric($strMessage, FlashMessengerZend::NAMESPACE_SUCCESS);
    }

    public function setMessageWarning($strMessage)
    {
        return $this->addMessageGeneric($strMessage, FlashMessengerZend::NAMESPACE_WARNING);
    }

    public function setMessageError($strMessage)
    {
        return $this->addMessageGeneric($strMessage, 'danger');
    }

    protected function getFlashMessenger()
    {
        if (!is_object(self::$flashMessenger)) {
            self::$flashMessenger = new FlashMessengerZend();
        }
        return self::$flashMessenger;
    }

    protected function addMessageGeneric($strMessage, $strTypeMessage = FlashMessengerZend::NAMESPACE_DEFAULT)
    {
        $arrMessage = [];
        if ($this->getFlashMessenger()->getMessages()) {
            $arrMessage = end($this->getFlashMessenger()->getMessages());
        }
        $arrMessage[$strTypeMessage][] = $strMessage;
        $this->getFlashMessenger()->addMessage($arrMessage);
        return $this->getFlashMessenger();
    }
}
