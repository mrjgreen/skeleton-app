<?php namespace Application\Repository;

use Application\Entity\BlacklistedIp;
use Application\Services\IpBlocker\BlockedIpRepositoryInterface;
use Database\Connection;


class IpBlacklistRepository extends RepositoryAbstract implements BlockedIpRepositoryInterface
{
    public function __construct(Connection $dbConnection)
    {
        parent::__construct($dbConnection, 'ip_blacklist', null, 'ipn');
    }

    /**
     * @param $rowId
     * @param array $row
     * @return BlacklistedIp
     */
    protected function getFindIntoObject($rowId, array $row)
    {
        return new BlacklistedIp($this);
    }

    /**
     * @param $ipAddress
     * @return BlacklistedIp|bool
     */
    public function insertIp($ipAddress)
    {
        $this->insert(array(
            'ipn'           => ip2long($ipAddress),
            'ip_address'    => $ipAddress
        ));

        return $this->findByIp($ipAddress);
    }

    /**
     * @param $ipAddress
     * @return BlacklistedIp|bool
     */
    public function findByIp($ipAddress)
    {
        try
        {
            return $this->find(ip2long($ipAddress));
        }
        catch(EntityNotFoundException $e) {}

        return false;
    }
}
