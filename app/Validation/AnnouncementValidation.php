<?php

namespace App\Validation;
use App\Constants\Literals;

class AnnouncementValidation extends BaseValidation
{
    public  function validateAnnouncement()
    {
        return $this->validateJson(

            [

                'title' => 'required|min_length[3]|max_length[150]',
                'message' => 'required|min_length[5]|max_length[1000]',
                'status' => 'required|in_list[0,1]',
                'start_at' => 'required|valid_date[Y-m-d\TH:i]|future_date',
                'end_at' => 'required|valid_date[Y-m-d\TH:i]|greater_than_start[start_at]',
                'target_type' => 'required|in_list[' .Literals::ALL_USERS . ',' . Literals::SPECIFIC_USER .
                ']'

            ]

        );
    }
}