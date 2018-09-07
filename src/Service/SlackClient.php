<?php
/**
 * Created by PhpStorm.
 * User: boonkuaeboonsutta
 * Date: 7/9/2018 AD
 * Time: 08:28
 */

namespace App\Service;


use Nexy\Slack\Client;
use Psr\Log\LoggerInterface;

class SlackClient
{
    private $slack;

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    public function __construct(Client $slack)
    {

        $this->slack = $slack;
    }

    /**
     * @required
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function sendMessage(string $from, string $message)
    {
        if ($this->logger) {
            $this->logger->info('Beaming a message to Slack! 5555');
        }
        $message = $this->slack->createMessage()
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($message);
        $this->slack->sendMessage($message);

    }

}