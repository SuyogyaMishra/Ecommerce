<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\ProductService;
use App\Services\AdminServices\DashboardService;
use App\Services\JwtService;
use App\Services\AdminServices\UserDashboardService;


class AdminController extends BaseController
{
    protected  $jwtService, $AdminService, $userDashboardService;

    public function __construct()
    {
        helper('cookie');
        $this->jwtService = new JwtService();
        $this->AdminService = new DashboardService();
        $this->userDashboardService = new UserDashboardService();
    }

    public function dashboard()
    {
        $page = $this->request->getGet('page') ?? 1;
        $token = $this->request->getCookie('token');

        $decodedToken = $this->jwtService->decode($token);

        $users = $this->AdminService->showUsers($page);
        return $this->response->setJSON([
            'status' => true,
            'totalUsers' => $users['total'],
            'users' => $users['users'],
            'page' => $users['page'],
            'limit' => $users['limit'],
            'totalPages' => ceil($users['total'] / $users['limit']),
            'decodedToken' => $decodedToken
        ]);
    }


    public function userData()
    {
        $page = $this->request->getGet('page') ?? 1;
        $limit = $this->request->getGet('limit') ?? 10;
        $search = $this->request->getGet('search') ?? "";
        $token = $this->jwtService->decode($this->request->getCookie('token'));
        $result = $this->userDashboardService->usersdata($page, $limit);
        if ($result['status'] == false) {
            return [
                'status' => $result['status'],
                'message' => $result['message']
            ];
        }
        return successResponseArray(
            'Users fetched successfully',
            200,
            [
                'user' => $token,
                'users' => $result['users'],
                'totalUsers' => $result['totalUsers'],
                'adminUsers' => $result['adminUsers'],
                'activeUsers' => $result['activeUsers'],
                'totalPages' => $result['totalPages']
            ]
        );
    }
    public function getUsers($id)
    {
        $result = $this->userDashboardService->getUser($id);
        if ($result['status'] == false) {
            return [
                'status' => $result['status'],
                'message' => $result['message']
            ];
        }
        return successResponse($result['user']);
    }


    public function searchUsers($keyword)
    {
        $result = $this->userDashboardService->getUserBuName($keyword);
        if ($result['status'] == false) {
            return $this->response->setJSON(
                [
                    'status' => $result['status'],
                    'message' => $result['message']
                ]
            );
        }
        return $this->response->setJSON([
            'status' => true,
            'data' => $result['users']
        ]);
    }

    public function updateUser()
    {
        try {

            $data = $this->request->getJSON(true);
            $update = $this->userDashboardService->updateUsers($data);

            if (!$update) {

                return errorResponse("User cannot be updated", 500);
            }

            return successResponse([], "User updated successfully");
        } catch (\Exception $e) {

            log_message('error', $e->getMessage());

            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Internal server error'
            ]);
        }
    }


    public function deleteUser($id)
    {
        try {

            $delete = $this->userDashboardService->deleteUsers($id);

            if (!$delete) {

                return errorResponse(
                    'User cannot be deleted',
                    500
                );
            }

            return successResponse(
                [],
                'User deleted successfully'
            );
        } catch (\Exception $e) {

            log_message('error', $e->getMessage());

            return errorResponse(
                'Internal server error',
                500
            );
        }
    }
    public function products()
    {
        return view('Admin/AdminProduct');
    }

    public function orders(){
        return view('Admin/AdminOrder');
    }
}
