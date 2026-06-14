<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class KeraniAuth implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null): RedirectResponse|null
    {
        // check login dulu
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        // check role kerani
        if (session()->get('role') !== 'kerani') {
            return redirect()->to('/');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tak perlu buat apa-apa
    }
}
