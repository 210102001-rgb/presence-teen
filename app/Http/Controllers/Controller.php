<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function isAdmin(): bool
    {
        return auth()->check() && auth()->user()->role === 'super_admin';
    }
}
