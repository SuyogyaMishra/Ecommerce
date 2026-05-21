<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Services\AdminServices\AnnouncementService;

class AnnouncementController extends BaseController
{
    protected $AnnouncementService;

    public function __construct(){
        $this->AnnouncementService = new AnnouncementService();
    }
    
    public function index()
    {
        return view('Admin/AdminAnnouncement');
    }
    public function store(){
      return  $this->AnnouncementService->store();
    }
    public function getAnnoucement(){
       return   $this->AnnouncementService->getAnnouncement();
    }
    public function update($id){

        return $this->AnnouncementService->update($id);
    }
    public function delete($id){
       return $this->AnnouncementService->delete($id);
    }
    public function getUserAnnouncement(){
        return $this->AnnouncementService->getUserAnnouncement();
    }
    public function searchUsers(){
         return $this->AnnouncementService->searchUsers();
    }
}
