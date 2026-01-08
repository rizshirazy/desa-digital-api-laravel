<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Interfaces\DashboardRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private DashboardRepositoryInterface $dashboardRepository;

    public function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function index()
    {
        try {
            $data = $this->dashboardRepository->getDashboardData();
            return ResponseHelper::JsonResponse(true, 'Dashboard data berhasil didapatkan', $data, 200);
        } catch (Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
