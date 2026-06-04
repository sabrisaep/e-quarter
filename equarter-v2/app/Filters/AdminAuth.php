<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null): RedirectResponse|null
    {

        // check login dulu
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        // check role admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tak perlu buat apa-apa disini
    }
}
