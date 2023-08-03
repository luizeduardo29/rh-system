<?php

namespace App\Enums;

enum MaritalStatus: string
{
    case MARRIED = 'Casado(a)';
    case SINGLE = 'Solteiro(a)';
    case WIDOWER = 'Viuvo(a)';
    case SEPARATE = 'Separado(a)';
}
