<?php

namespace App\Enums;

enum TypeContact: string
{
    case WEBSITE = 'WebSite';
    case RESIDENCE = 'Residencia';
    case LINKEDIN = 'Linkedin';
    case EMAIL = 'Email';
    case TELEPHONE =  'Telefone';
}
