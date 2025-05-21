@props(['type' => 'success', 'message'])

@php
$classes = [
    'success' => 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200',
    'error' => 'bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-200',
    'warning' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-800 dark:text-yellow-200',
    'info' => 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-200'
][$type];

$role = auth()->user()->role;
$layoutPrefix = $role === 'admin' ? 'admin' : 'member';
@endphp

@include("layouts.{$layoutPrefix}.notification", [
    'type' => $type,
    'message' => $message,
    'classes' => $classes
])
