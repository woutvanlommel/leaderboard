<?php

namespace App\Enums;

enum GameStatus: string
{
    case Scheduled = 'scheduled';
    case Active = 'active';
    case Finished = 'finished';
}
