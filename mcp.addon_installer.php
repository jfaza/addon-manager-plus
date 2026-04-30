<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use ExpressionEngine\Service\Addon\Mcp;

class Addon_installer_mcp extends Mcp
{
    protected $addon_name = 'addon_installer';
}
