<?php namespace Application\Entity;

use Application\Services\IpBlocker\BlockedIpInterface;
use Database\Query\Expression;

class BlacklistedIp extends EntityAbstract implements BlockedIpInterface
{
    /**
     * @return mixed|null
     */
    public function getLoginAttempts()
    {
        return $this->get('attempts');
    }

    /**
     * @return bool
     */
    public function isBanned()
    {
        return $this->bannedAt() !== null;
    }

    /**
     * @return mixed|null
     */
    public function bannedAt()
    {
        return $this->get('banned_at');
    }

    /**
     * We choose to remove the log to avoid a build of IPNs in the blacklist table.
     *
     * To keep an audit log, we could instead reset the "attempts" column to zero
     */
    public function clearLoginAttempts()
    {
        $this->delete();
    }

    /**
     *
     */
    public function loginAttempt()
    {
        $this->entityData['attempts']++;

        $this->update(array('attempts' => new Expression('attempts + 1')))->save();
    }

    /**
     * No need to do anything in here as we actually delete the record in clearLoginAttempts which is called
     * both on ban cleared and on successful login.
     *
     * If the record was not deleted, we would need to clear the "ban" column by setting to zero
     *
     * @see clearLoginAttempts
     */
    public function clearBan()
    {

    }

    /**
     *
     */
    public function ban()
    {
        $this->update(array('banned_at' => new \DateTime()))->save();
    }
}
