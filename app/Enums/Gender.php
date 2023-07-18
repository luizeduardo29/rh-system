<?php

namespace App\Enums;

enum Gender: string
{
    case MEN = 'Homem';
    case WOMEN = 'Mulher';
    case NO_IDENTITY = 'Nao Informar';
}
