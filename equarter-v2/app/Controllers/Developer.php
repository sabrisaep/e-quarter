<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Developer extends BaseController
{
    public function index(): string
    {
        $output = '';

        if (isset($_POST['git_pull'])) {
            $output = shell_exec('git pull 2>&1');
        }

        if (isset($_POST['migrate'])) {
            $output = shell_exec('php spark migrate 2>&1');
        }

        return view('developer/index', ['output' => $output]);
    }

}
