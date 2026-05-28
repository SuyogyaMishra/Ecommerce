<?php

namespace App\Vendors\Services;

use App\Vendors\Kyc\KycVerification;
use App\Vendors\Validation\VendorValidation;

use App\Vendors\Models\VendorDocs;

use App\Vendors\Models\VendorsModel;

class KycService extends BaseService
{

    protected $kycVerify, $vendorVelidation,$vendorDocs,$vendorModel;

    public function __construct()
    {
        parent::__construct();
        $this->kycVerify = new KycVerification();
        $this->vendorVelidation = new VendorValidation();
        $this->vendorDocs = new VendorDocs();
        $this->vendorModel = new VendorsModel();
    }

    public function adddocs()
    {
        $docs = ['aadhaar' => 6108250267033];
        $this->kycVerify->addDocs($docs);
        $status = $this->kycVerify->validate();
    }
    public function submitKyc()
    {

        $data = $this->request->getPost();
        $docs = [$data['document_name'] => $data["document_number"]];
        $this->kycVerify->addDocs($docs);
        $status =  $this->kycVerify->validate();
        if (!$status) {
            $error = $this->kycVerify->getErrors();
            return $this->validationError($error);
        }

        $aadhaarFile = $this->request->getFile('aadhaarcard');

        if (!$aadhaarFile || !$aadhaarFile->isValid()) {

            return $this->validationError(['aadhaarcard'=>'Aadhar Card is required']);
        }

        $fileName = $aadhaarFile->getRandomName();

        $aadhaarFile->move( ROOTPATH . 'public/uploads/kyc',$fileName);

        $filePath ='uploads/kyc/' . $fileName;


        $document['name']=$data['document_name'];
        $document['number']=$data['document_number'];
        $document['v_id'] = $this->user['id'];
        $document['url'] = $filePath;









        $this->db->transStart();
         $this->vendorDocs->addDocs($document);
        
         $this->vendorModel->changeKycStatus($this->user['id'],'1');

         if(!$this->db->transStatus()){
            $this->db->transRollback();
             return $this->error('Some problem occured');
         }
        

      $this->db->transComplete();
      return $this->success('Kyc details send for review');
        
    }
}
