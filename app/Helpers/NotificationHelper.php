<?php

if (!function_exists('getNotificationIcon')) {
    /**
     * Get the corresponding icon class for a notification type.
     *
     * @param string $type
     * @return string
     */
    function getNotificationIcon($type)
    {
        $icons = [
            'info' => 'fas fa-info-circle',
            'success' => 'fas fa-check-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'error' => 'fas fa-times-circle',
            'event' => 'fas fa-calendar-alt',
            'contribution' => 'fas fa-hand-holding-usd',
            'system' => 'fas fa-cog',
        ];

        return $icons[$type] ?? 'fas fa-bell';
    }
}
