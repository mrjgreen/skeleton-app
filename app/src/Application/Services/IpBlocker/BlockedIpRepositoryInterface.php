<?php namespace Application\Services\IpBlocker;

interface BlockedIpRepositoryInterface {

    /**
     * @param $ipAddress
     * @return BlockedIpInterface
     */
    public function findByIp($ipAddress);

    /**
     * @param $ipAddress
     * @return BlockedIpInterface
     */
    public function insertIp($ipAddress);
}