<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller {
    public function doUpload()
    {
        $this->load->library('CSVParser');
        $this->load->library('form_validation');

        if (isset($_POST['over'])) {
            if ($_POST['over'] == 'true')
                $this->deleteOldRecords();
        }

        if (!isset($_FILES['file']['tmp_name']))
        {
            echo 'No file uploaded!';
            return;
        }
        try {
            $CSVObject = new CSVParser($_FILES['file']['tmp_name']);
            $CSVObject->setDelimiter("\t");
        } catch (Exception $e) {
            die ($e->getMessage()."\n");
        }

        $rowsTotalCount = 0;
        $badTotalCount = 0;
        while ($dataCSV = $CSVObject->getRow())
        {
            if (!is_numeric($dataCSV[1]))
                continue;
            $rowsTotalCount++;
            $data = array(
                'label'=>$dataCSV[0],
                'cd_no'=>$dataCSV[1],
                'track_title'=>$dataCSV[2],
                'track_num'=>$dataCSV[3],
                'track_desc'=>$dataCSV[4],
                'composers'=>$dataCSV[5]
            );

            $this->form_validation->set_rules('label', '', 'trim|required');
            $this->form_validation->set_rules('cd_no', '', 'trim|numeric');
            $this->form_validation->set_rules('track_title', '', 'trim|required');
            $this->form_validation->set_rules('track_num', '', 'trim|numeric');

            $this->form_validation->set_data($data);
            if ($this->form_validation->run() == FALSE)
            {
                echo 'Error in row: '.$rowsTotalCount.'<br>';
                $badTotalCount++;
            }
            else
            {
                $this->createRecord($data);
            }

        }
        echo 'Done! '.($rowsTotalCount-$badTotalCount).' rows imported! ('.$badTotalCount.' errors)';
    }
    public function deleteOldRecords()
    {
        $this->load->database();
        $this->db->empty_table('csv');
    }
    public function createRecord($data)
    {
        $this->load->database();
        $this->db->insert('csv', $data);
    }
    public function num_check($str)
    {
        if (!is_numeric($str) || $str<=0)
        {
            $this->form_validation->set_message('username_check', 'The {field} field must be positive number');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}