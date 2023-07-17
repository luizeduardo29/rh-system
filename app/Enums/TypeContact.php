<?php

namespace App\Enums;

enum TypeContact: string
{
    case SITE = 'Site';
    case RESIDENCE = 'Residence';
    case LINKEDIN = 'Linkedin';
    case EMAIL = 'Email';
    case TELEPHONE =  'Telephone';
}
