<?php

namespace App\Http\Controllers;

use App\Utils\ReturnsDefaults;
use App\Utils\ValidateBack;

abstract class Controller
{
    use ValidateBack, ReturnsDefaults;
}
