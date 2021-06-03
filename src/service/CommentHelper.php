<?php


class CommentHelper implements EntityHelperInterface
{
    public function getStateClass($state): string
    {
        switch ($state) {
            case Constantes::COM_PENDING_STATUS:
            case Constantes::COM_STATUS_DELETED:
                return 'user-status-red';

            case Constantes::COM_STATUS_VALIDATED:
                return 'user-status-green';

            case Constantes::COM_STATUS_ARCHIVED:
                return 'user-status-orange';
        }
    }
}