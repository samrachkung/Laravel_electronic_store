<?php
// app/Helpers/IncomeHelper.php

if (!function_exists('format_currency')) {
    function format_currency($amount)
    {
        return '$' . number_format($amount, 2);
    }
}

if (!function_exists('getStatusColor')) {
    function getStatusColor($status)
    {
        return match ($status) {
            'new' => '#007bff',
            'processing' => '#17a2b8',
            'shipped' => '#ffc107',
            'delivered' => '#28a745',
            'canceled' => '#dc3545',
            default => '#6c757d',
        };
    }
    function getOrderStatusColor($status)
    {
        switch ($status) {
            case 'new':
                return 'info';
            case 'processing':
                return 'warning';
            case 'shipped':
                return 'primary';
            case 'delivered':
                return 'success';
            case 'canceled':
                return 'danger';
            default:
                return 'secondary';
        }
    }
}

