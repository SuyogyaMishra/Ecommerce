<?php

namespace App\Services\AdminServices;

use App\Models\AnnouncementModel;
use App\Models\AnnouncementTargetModel;
use App\Models\UserModel;
use App\Services\BaseService;
use App\Validation\AnnouncementValidation;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class AnnouncementService extends BaseService
{

    protected $announcementModel, $userModel, $userRepo, $annoucementTargetModel, $announcementValidation;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->announcementModel = new AnnouncementModel();
        $this->annoucementTargetModel = new AnnouncementTargetModel();
        $this->announcementValidation = new AnnouncementValidation();
    }

    public function store()
    {
        try {
            $validation =  $this->announcementValidation->validateAnnouncement();
            if (!$validation['status']) {
                return $this->validationError($validation);
            }
            $this->db->transBegin();
            $data = (array)$this->request->getJSON();
            $announcementId = $this->announcementModel->insert($data);
            $anncouncementTaarget = [];

            if ($data["target_type"] == "SPECIFIC_USER") {
                foreach ($data["target_ids"] as $id) {
                    $anncouncementTaarget = [
                        'id' => $announcementId,
                        'type' => $data["target_type"],
                        'target_id' => $id

                    ];
                    $this->annoucementTargetModel->insert($anncouncementTaarget);
                    $anncouncementTaarget = [];
                }
                $this->db->transComplete();
                if (!$this->db->transStatus()) {
                    $this->db->transRollback();
                    return $this->error('some error occured');
                }
                return $this->success('Announcement added sucessfully');
            }
            $anncouncementTaarget = $anncouncementTaarget = [
                'id' => $announcementId,
                'type' => $data["target_type"],
                'target_id' => null

            ];
            $this->annoucementTargetModel->insert($anncouncementTaarget);
            $anncouncementTaarget = [];
            $this->db->transComplete();
            if (!$this->db->transStatus()) {
                $this->db->transRollback();
                return $this->error('some error occured');
            }
            return $this->success('Announcement added sucessfully');
        } catch (\Exception $e) {
            $this->db->transRollback();
            customLog($e->getMessage() . $e->getLine());
            return $this->serverError("some error occured");
        }
    }

    public function getAnnouncement()
    {
        try {
            $limit = Service('request')->getGet('limit')??10;
            $keyword = Service('request')->getGet('search');
            $page=  Service('request')->getGet('page');
            $column= Service('request')->getGet('column');
            $direction = Service('request')->getGet('direction');
            $offset=($page-1)*$limit;
            $result = $this->announcementModel->allAnnouncement($limit,$offset,$keyword,$column,$direction);
            $totalPages = ceil($result['total'] / $limit);
            if (!$result) {
                return $this->error('can not find details');
            }
            return $this->success('found', ['data' => $result['data'],'page' => (int)$page,'totalPages' => $totalPages]);
        } catch (\Exception $e) {
            customLog($e->getMessage() . $e->getLine());
        }
    }
    public function update($id)
    {
        try {

            $validation =  $this->announcementValidation->validateAnnouncement();
            if (!$validation['status']) {
                return $this->validationError($validation);
            }

            $this->db->transBegin();

            $data = (array)$this->request->getJSON();

            $this->announcementModel->update($id, $data);

            $this->annoucementTargetModel->deleteByAnnouncementId($id);

            if ($data['target_type'] == 'SPECIFIC_USER') {

                foreach ($data['target_ids'] as $targetId) {

                    $this->annoucementTargetModel->insert([
                        'id' => $id,
                        'type' => $data['target_type'],
                        'target_id' => $targetId
                    ]);
                }
            } else {

                $this->annoucementTargetModel->insert([
                    'id' => $id,
                    'type' => $data['target_type'],
                    'target_id' => null
                ]);
            }

            $this->db->transComplete();

            if (!$this->db->transStatus()) {

                $this->db->transRollback();

                return $this->error('some error occured');
            }

            return $this->success('Announcement updated successfully');
        } catch (\Exception $e) {

            $this->db->transRollback();

            customLog($e->getMessage() . $e->getLine());
        }
    }

    public function delete($id)
    {
        try {
            $this->db->transBegin();
            $this->announcementModel->deleteById($id);
            $this->annoucementTargetModel->deleteByAnnouncementId($id);
            $this->db->transComplete();
            if (!$this->db->transStatus) {
                $this->db->transRollback();
                return $this->error('can not update');
            }
            return $this->success('user delted');
        } catch (\Exception $e) {
            customLog($e->getMessage() . $e->getLine());
            $this->db->transRollback();
        }
    }

    public function getUserAnnouncement()
    {
        $result = $this->annoucementTargetModel->getByUser();
        if (!$result) {
            return  $this->error('can not find announcemnt');
        }
        return $this->success('found', ['announcement' => $result]);
    }
    public function searchUsers()
    {
        try {
            $keyword = implode(',', $this->request->getGet());
            $users = $this->userModel->getSearchedUser($keyword);
            if (!$users) {
                return $this->error("No user Found");
            }
            return $this->success('user found', ['users' => $users]);
        } catch (\Exception $e) {
            customLog($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }
}
