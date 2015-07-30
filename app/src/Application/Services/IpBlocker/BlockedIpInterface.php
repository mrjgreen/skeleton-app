<?php namespace Application\Services\IpBlocker;

interface BlockedIpInterface
{
    public function loginAttempt();
    public function clearLoginAttempts();
    public function getLoginAttempts();
    public function isBanned();
    public function clearBan();
    public function ban();
    public function bannedAt();
}