<?php

namespace App\Validation;

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
                'end_at' => 'required|valid_date[Y-m-d\TH:i]|greater_than_start[start_at]'

            ],

            [

                'start_at' => [

                    'future_date' => 'Start date cannot be backdated'

                ],

                'end_at' => [

                    'greater_than_start' => 'End date must be greater than start date'

                ]

            ]

        );
    }
}