<?php

namespace App\Enum;

enum MessageStatus: string
{
    // additional status, for when the message is just created.
    case CREATED = 'created';
    case SENT = 'sent';
    case READ = 'read';
}
