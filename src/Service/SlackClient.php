<?php
/**
 * Created by PhpStorm.
 * User: boonkuaeboonsutta
 * Date: 7/9/2018 AD
 * Time: 08:28
 */

namespace App\Service;


use Nexy\Slack\Client;
use App\Helper\LoggerTrait;


class SlackClient
{
    use LoggerTrait;

    private $slack;
    public function __construct(Client $slack)
    {

        $this->slack = $slack;
    }

    public function sendMessage(string $from, string $message)
    {
        $this->logInfo('Beaming a message to Slack! LoggerTrait', [
            'message' => $message
        ]);

        $message = $this->slack->createMessage()
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($message.' ... LoggerTrait');

        $this->slack->sendMessage($message);

    }

}