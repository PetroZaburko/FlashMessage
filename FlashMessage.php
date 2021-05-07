<?php


class FlashMessage
{
    const INFO    = 'i';
    const SUCCESS = 's';
    const WARNING = 'w';
    const DANGER   = 'd';

    const DEFAULT_TYPE = self::INFO;

    protected $messageTypes = [
        self::INFO    => 'info',
        self::SUCCESS => 'success',
        self::WARNING => 'warning',
        self::DANGER   => 'danger'
    ];

    protected $messageCssClass = 'alert';

    protected $cssClassTypes = [
        self::INFO    => 'alert-info',
        self::SUCCESS => 'alert-success',
        self::WARNING => 'alert-warning',
        self::DANGER   => 'alert-danger',
    ];

    protected $messageWrapper = "<div class=\"%s\" role=\"alert\">%s</div>";


    public function __construct()
    {
        if (!array_key_exists('flash_messages', $_SESSION)) {
            $_SESSION['flash_messages'] = [];
        }
    }

    /**
     * Add an info message
     * @param string $message     the message text
     * @return object
     */
    public function info(string $message) {
        return $this->add($message, self::INFO);
    }

    /**
     * Add a success message
     * @param string $message     the message text
     * @return object
     */
    public function success(string $message) {
        return $this->add($message, self::SUCCESS);
    }

    /**
     * Add a warning message
     * @param string $message     the message text
     * @return object
     */
    public function warning(string $message) {
        return $this->add($message, self::WARNING);
    }

    /**
     * Add a danger message
     * @param string $message     the message text
     * @return object
     */
    public function danger(string $message) {
        return $this->add($message, self::DANGER);
    }

    /**
     * Add a flash message to the session data
     * @param string $message       the message text
     * @param string$type           the message type
     * @return object
     */
    protected function add($message, $type) {
        if(!array_key_exists($type, $this->messageTypes)) {
            $type = self::DEFAULT_TYPE;
        }
        if(!array_key_exists($type, $_SESSION['flash_messages'])) {
            $_SESSION['flash_messages'][$type] = $message;
        }
        return $this;
    }

    /**
     * Display flash messages
     * @param array|null $types     (null) print all of the message types
     *                              (array) print the given message types
     * @return string
     */
    public function display(array $types = null) {
        if(is_null($types) || empty($types)) {
            $types = array_keys($this->messageTypes);
        }
        else {
            $keys = [];
            foreach ($types as $type) {
                if($key = array_search($type, $this->messageTypes)) {
                    array_push($keys, $key);
                }
            }
            $types = $keys;
        }
        $result = '';
        foreach ($types as $type) {
            if(array_key_exists($type, $_SESSION['flash_messages'])) {
                $message = $this->formatMessage($_SESSION['flash_messages'][$type], $type);
                $result .= $message;
                $this->clear($type);
            }
        }
        echo $result;
    }

    /**
     * Format a message
     * @param string $message       data message
     * @param string $type          message type
     * @return string
     */
    protected function formatMessage($message, $type) {
        $cssClass = $this->messageCssClass . ' ' .  $this->cssClassTypes[$type];
        return sprintf($this->messageWrapper, $cssClass, $message);
    }

    /**
     * Clear message from session data
     * @param string $type          message type
     * @return object
     */
    protected function clear(string $type) {
            unset($_SESSION['flash_messages'][$type]);
        return $this;
    }

    /**
     * Set general CSS class for message types
     * @param string $messageCssClass CSS class to use
     * @return object
     */
    public function setMessageCssClass(string $messageCssClass = '') {
        $this->messageCssClass = $messageCssClass;
        return $this;
    }

    /**
     * Set CSS class for one type
     * @param string $type          message type
     * @param string $class         CSS class
     * @return object
     */
    public function setCssClass(string $type, string $class) {
        $this->cssClassTypes[substr($type, 0,1)] = $class;
        return $this;
    }
}