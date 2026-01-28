<?php

namespace App\Controllers;

use App\Models\RecordsModel;

class DeleteRecords extends BaseController
{
    protected $recordsModel;

    public function __construct()
    {
        $this->recordsModel = new RecordsModel();
    }

    public function delete_records($id = null)
    {
        $model = $this->recordsModel;

        if (!$id || !$model->find($id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Record not found.'
            ]);
        }

        $model->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Record deleted successfully.'
        ]);
    }
}
