<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case ATTEND = 'attend';
    case ABSENT = 'absent';
    case BREAK = 'break';
}
