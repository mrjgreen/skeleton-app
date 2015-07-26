<?php namespace Application\Services;

use Closure;
use Swift_Mailer;
use Swift_Message;
use Psr\Log\LoggerInterface;

/**
 * Class Mailer
 *
 * A thin convenience wrapper around swift mail
 *
 * @package Application\Services
 */
class Mailer
{
    /**
     * The Swift Mailer instance.
     *
     * @var \Swift_Mailer
     */
    protected $swift;

    /**
     * The global from address and name.
     *
     * @var array
     */
    protected $from;

    /**
     * The log writer instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Indicates if the actual sending is disabled.
     *
     * @var bool
     */
    protected $pretending = false;

    /**
     * Array of failed recipients.
     *
     * @var array
     */
    protected $failedRecipients = array();

    /**
     * @param Swift_Mailer $swift
     * @param LoggerInterface $logger
     *
     * Create a new Mailer instance.
     */
    public function __construct(Swift_Mailer $swift, LoggerInterface $logger = null)
    {
        $this->swift = $swift;

        if($logger) $this->setLogger($logger);
    }

    /**
     * Set the global from address and name.
     *
     * @param  string $address
     * @param  string $name
     * @return void
     */
    public function alwaysFrom($address, $name = null)
    {
        $this->from = compact('address', 'name');
    }

    /**
     * Send a new message when only a plain part.
     *
     * @param  string $text
     * @param  mixed  $callback
     * @return int
     */
    public function plain($text, $callback)
    {
        $this->send(null, $text, $callback);
    }

    /**
     * Send a new html/text message using.
     *
     * @param  string   $html
     * @param  string   $text
     * @param  \Closure $callback
     * @return void
     */
    public function send($html, $text, Closure $callback)
    {
        $message = $this->createMessage();

        $this->callMessageBuilder($callback, $message);

        // Once we have retrieved the view content for the e-mail we will set the body
        // of this message using the HTML type, which will provide a simple wrapper
        // to creating view based emails that are able to receive arrays of data.
        $this->addContent($message, $html, $text);

        $this->sendSwiftMessage($message);
    }

    /**
     * Add the content to a given message.
     *
     * @param  \Swift_Message $message
     * @param  string         $html
     * @param  string         $plain
     * @return void
     */
    protected function addContent(Swift_Message $message, $html, $plain)
    {
        if (isset($html)) {
            $message->setBody($html, 'text/html');
        }

        if (isset($plain)) {
            $message->addPart($plain, 'text/plain');
        }
    }

    /**
     * Send a Swift Message instance.
     *
     * @param  \Swift_Message $message
     * @return void
     */
    protected function sendSwiftMessage(Swift_Message $message)
    {
        if (! $this->pretending) {
            $this->swift->send($message, $this->failedRecipients);
        }

        if (isset($this->logger)) {
            $this->logMessage($message);
        }
    }

    /**
     * Log that a message was sent.
     *
     * @param  \Swift_Message $message
     * @return void
     */
    protected function logMessage(Swift_Message $message)
    {
        $emails = json_encode($message->getTo());

        $action = $this->isPretending() ? 'Pretending to send' : 'Sent';

        $this->logger->info("$action mail message to: {$emails}");
    }

    /**
     * Call the provided message builder.
     *
     * @param  \Closure       $callback
     * @param  \Swift_Message $message
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    protected function callMessageBuilder(Closure $callback, Swift_Message $message)
    {
        return $callback($message);
    }

    /**
     * Create a new message instance.
     *
     * @return \Swift_Message
     */
    protected function createMessage()
    {
        $message = new Swift_Message();

        // If a global from address has been specified we will set it on every message
        // instances so the developer does not have to repeat themselves every time
        // they create a new message. We will just go ahead and push the address.
        if (isset($this->from['address'])) {
            $message->setFrom($this->from['address'], $this->from['name']);
        }

        return $message;
    }

    /**
     * Tell the mailer to not really send messages.
     *
     * @param  bool $value
     * @return void
     */
    public function pretend($value = true)
    {
        $this->pretending = $value;
    }

    /**
     * Check if the mailer is pretending to send messages.
     *
     * @return bool
     */
    public function isPretending()
    {
        return $this->pretending;
    }

    /**
     * Get the Swift Mailer instance.
     *
     * @return \Swift_Mailer
     */
    public function getSwiftMailer()
    {
        return $this->swift;
    }

    /**
     * Get the array of failed recipients.
     *
     * @return array
     */
    public function failures()
    {
        return $this->failedRecipients;
    }

    /**
     * Set the Swift Mailer instance.
     *
     * @param  \Swift_Mailer $swift
     * @return void
     */
    public function setSwiftMailer(Swift_Mailer $swift)
    {
        $this->swift = $swift;
    }

    /**
     * Set the log writer instance.
     *
     * @param  \Psr\Log\LoggerInterface $logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }
}
