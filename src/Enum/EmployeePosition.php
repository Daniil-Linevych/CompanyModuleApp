<?php

namespace App\Enum;

enum EmployeePosition: string
{
    case DEVELOPER = 'developer';
    case MANAGER = 'manager';
    case QA = 'qa';
    case DESIGNER = 'designer';
}
