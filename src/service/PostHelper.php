<?php

class PostHelper implements EntityHelperInterface
{
    public function getStateClass($state): string
    {
        switch ($state) {
            case Constantes::POST_PENDING_STATUS:
            case Constantes::POST_STATUS_ARCHIVED:
                return 'user-status-orange';

            case Constantes::POST_STATUS_VALIDATED:
                return 'user-status-green';

            case Constantes::POST_STATUS_DELETED:
            default:
                return 'user-status-red';
        }
    }
}