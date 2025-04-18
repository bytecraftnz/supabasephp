<?php
namespace Bytecraftnz\SupabasePhp;


enum GenerateLinkType: string
{
    case SIGNUP = 'signup';
    case MAGICLINK = 'magiclink';
    case INVITE = 'invite';
    case RECOVERY = 'recovery';
    case EMAIL_CHANGE_CURRENT = 'email_change_current';
    case EMAIL_CHANGE_NEW = 'email_change_new';
    case PHONE_CHANGE = 'phone_change';
}
