<?php

namespace App\Services\AdminServices;


use App\Services\BaseService;
use App\Vendors\Models\VendorDocs;
use App\Vendors\Models\VendorsModel;
use App\Vendors\Repositories\VendorRepository;

class VendorService extends BaseService
{

    protected $vendorRepo, $vendorModel, $vendorDocsModel;

    public function __construct()
    {
        parent::__construct();
        $this->vendorRepo = VendorRepository::getInstance();
        $this->vendorModel = new VendorsModel();
        $this->vendorDocsModel = new VendorDocs();
    }
    public function vendorData()
    {

        try {
            $data = $this->request->getGet();
            $totalVendor = $this->vendorModel->getTotalVendor();
            $kycPending = $this->vendorModel->totalKycPending();
            $kycRequested = $this->vendorModel->totalRequestedKyc();
            $offset = (int) ($data['page'] - 1) * $data['limit'];


            if ($data['table'] === "vendors") {
                $vendors = $this->vendorModel->getDashboardVendors($offset, $data['limit'], $data['sortDirection'], $data['sortColumn'], $data['keyword']);
                $totalPages = ceil($totalVendor / $data['limit']);
            }
            if ($data['table'] === "kyc") {
                $pendingKyc = $this->vendorModel->getRequestedVendors($offset, $data['limit'], $data['sortDirection'], $data['sortColumn'], $data['keyword']);
                $totalPages = ceil($kycRequested / $data['limit']);
            }

            return $this->success('fetched', [
                'totalVendors' => $totalVendor,
                'kycPending' => $kycPending,
                'kycRequested' => $kycRequested,
                'vendors' => $vendors ?? null,
                'pendingKyc' => $pendingKyc ?? null,
                'totalPages' => $totalPages ?? 1
            ]);
        } catch (\Exception $e) {
            customLog($e->getLine() . $e->getMessage());
        }
    }


    public function updateVendor()
    {
        $data = $this->request->getRawInput();
        $status = $this->vendorModel->updateVendor($data);
        if (!$status) {
            return $this->error('something went wrong');
        }
        return $this->success('User Updated  successfully');
    }

    public function deleteVendor()
    {
        $id = $this->request->getRawInput();
        $status = $this->vendorModel->deleteVendor($id);
        if (!$status) {
            return $this->error('Can not delete Vendor');
        }
        return $this->success('Vendor Deleted Successfully');
    }


    public function kycDetails()
    {
        $id = $this->request->getGet();
        $data = $this->vendorDocsModel->getKycDetails($id);
        return $this->success('', ['data' => $data]);
    }

    public function updateKyc()
    {
        try {
            $data = $this->request->getRawInput();
            if ($data['status'] === "2") {
                $this->db->transStart();
                $this->vendorDocsModel->VerifyKyc($this->user['id'], $data["vendor_id"]);
                $this->vendorModel->chnageStatusByAdmin($data["vendor_id"], $this->user['id'], '2');
                $this->db->transComplete();

                if (!$this->db->transStatus()) {
                    $this->db->transRollback();
                    $this->error('Some error occured while updating kyc');
                }
                return $this->success("updated successfully");
            }
                if(!empty($data['remark'])){
                    return $this->error('To Reject Kyc Remarks is Must');
                }
            
                die;
                $this->db->transStart();
                
                $this->vendorDocsModel->RejectKyc($this->user['id'], $data["vendor_id"]);
                $this->vendorModel->chnageStatusByAdmin($data["vendor_id"], $this->user['id'], '2');
                $this->db->transComplete();

                if (!$this->db->transStatus()) {
                    $this->db->transRollback();
                    $this->error('Some error occured while updating kyc');
                }
                return $this->success("updated successfully");

        } catch (\Exception $e) {
            $this->db->transRollback();
            customLog($e->getMessage());
            return $this->error($e->getMessage());
        }
    }
}
