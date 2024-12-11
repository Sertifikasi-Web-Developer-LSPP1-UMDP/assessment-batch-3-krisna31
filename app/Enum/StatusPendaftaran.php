<?php

namespace App\Enum;

enum StatusPendaftaran: String
{
    case BARU = 'BARU';
    case PENDING = 'PENDING';
    case LOLOS = 'LOLOS';
    case TOLAK = 'TOLAK';
}
