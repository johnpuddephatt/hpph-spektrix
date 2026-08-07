<?php

namespace App\Actions;

enum SubscribeOutcome
{
    /** A new Spektrix customer record was created. */
    case Created;

    /** The address already belonged to a customer, whose record was updated. */
    case Updated;

    /** Spektrix rejected the request. Details are in the log, not shown to visitors. */
    case Failed;

    public function successful(): bool
    {
        return $this !== self::Failed;
    }
}
