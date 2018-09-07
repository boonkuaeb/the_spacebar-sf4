<?php
/**
 * Created by PhpStorm.
 * User: boonkuaeboonsutta
 * Date: 7/9/2018 AD
 * Time: 08:41
 */

namespace App\Helper;

use Psr\Log\LoggerInterface;

trait LoggerTrait
{
    /**
     * @var LoggerInterface|null
     */
    private $logger;
    /**
     * @required
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    private function logInfo(string $message, array $context = [])
    {
        if ($this->logger) {
            $this->logger->info($message, $context);
        }
    }
}