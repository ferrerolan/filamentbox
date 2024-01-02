<?php

namespace App\Enums;

enum OrderStatusEnum : string {
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED = 'completed';
    case DECLINED = 'declined';
}