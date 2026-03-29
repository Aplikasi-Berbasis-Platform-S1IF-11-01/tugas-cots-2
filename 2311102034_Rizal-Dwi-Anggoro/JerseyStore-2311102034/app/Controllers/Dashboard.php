<?php

namespace App\Controllers;

use App\Models\JerseyModel;

/**
 * Dashboard Controller — CI4
 */
class Dashboard extends BaseController
{
    public function index(): string
    {
        $model = new JerseyModel();

        $data = [
            'title'          => 'Dashboard',
            'activeMenu'     => 'dashboard',
            'totalJersey'    => $model->countAll(),
            'totalAktif'     => $model->countAktif(),
            'totalStok'      => $model->totalStok(),
            'ligaStats'      => $model->getLigaStats(),
            'jerseysTerbaru' => $model->orderBy('id', 'DESC')->findAll(6),
        ];

        return view('layouts/header', $data)
             . view('dashboard/index', $data)
             . view('layouts/footer');
    }
}
