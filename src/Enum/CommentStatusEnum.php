<?php

namespace App\Enum;

enum CommentStatusEnum: string
{
    case PUBLIC = "public";
    case PENDING = "pending";
    case REJECTED = "rejected";
}
