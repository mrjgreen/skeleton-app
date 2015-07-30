<?php namespace Application\Services\IpBlocker;

use Application\Repository\IpBlacklistRepository;

class IpBlocker {

    const BAN_PERIOD_MINUTES_DEFAULT = 1;

    const BAN_THRESHOLD_DEFAULT = 5;

    private $banPeriodMinutes;

    private $banThreshold;

    /**
     * @var IpBlacklistRepository
     */
    private $repository;

    /**
     * @var
     */
    private $ipAddress;

    /**
     * @param $ipAddress
     * @param IpBlacklistRepository $repository
     * @param int $banThreshold
     * @param int $banPeriodMinutes
     */
    public function __construct(
        $ipAddress,
        IpBlacklistRepository $repository,
        $banThreshold = self::BAN_THRESHOLD_DEFAULT,
        $banPeriodMinutes = self::BAN_PERIOD_MINUTES_DEFAULT)
    {
        $this->repository = $repository;

        $this->ipAddress = $ipAddress;

        $this->banPeriodMinutes = $banPeriodMinutes;

        $this->banThreshold = $banThreshold;
    }

    /**
     *
     */
    public function loginFailure()
    {
        if(!$ipEntity = $this->repository->findByIp($this->ipAddress))
        {
            $ipEntity = $this->repository->insertIp($this->ipAddress);
        }

        $ipEntity->loginAttempt();

        if(($ipEntity->getLoginAttempts()) >= $this->banThreshold)
        {
            $ipEntity->ban();
        }
    }

    /**
     *
     */
    public function loginSuccess()
    {
        if($ipEntity = $this->repository->findByIp($this->ipAddress))
        {
            $ipEntity->clearLoginAttempts();
        }
    }

    /**
     *
     * @return bool
     */
    public function isBanned()
    {
        if(!$ipEntity = $this->repository->findByIp($this->ipAddress))
        {
            return false;
        }


        if(($banned = $ipEntity->isBanned()) && $this->checkBanExpiry($ipEntity->bannedAt()))
        {
            $ipEntity->clearLoginAttempts();

            $ipEntity->clearBan();

            return false;
        }

        return $banned;
    }

    /**
     * @param $bannedAt
     * @return bool
     */
    private function checkBanExpiry($bannedAt)
    {
        if(!$bannedAt instanceof \DateTime)
        {
            $bannedAt = new \DateTime($bannedAt);
        }

        $banStart = sprintf("- %d minutes", $this->banPeriodMinutes);

        return $bannedAt < new \DateTime($banStart);
    }
}