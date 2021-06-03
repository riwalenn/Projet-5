<?php


class UserHelper
{
    /**
     * @throws Exception
     */
    public function generateToken($length = 32): string
    {
        $token = random_bytes($length);
        return bin2hex($token);
    }

    public function getStateClass($state): string
    {
        switch ($state) {
            case Constantes::USER_PENDING_STATUS:
            case Constantes::USER_STATUS_DELETED:
                return 'user-status-red';

            case Constantes::USER_PENDING_STATUS_MODO:
                return 'user-status-orange';

            case Constantes::USER_STATUS_VALIDATED:
                return 'user-status-green';
        }
    }
}