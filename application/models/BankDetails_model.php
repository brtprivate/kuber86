<?php
class BankDetails_model extends MY_Model
{

    public function AllBankDetails()
    {

        $startDate = $this->input->get('start_date');
        $endDate = $this->input->get('end_date');

        $this->db->select('tbl_users_bank_details.*,tbl_users.name as user_name');
        $this->db->from('tbl_users_bank_details');
        $this->db->join('tbl_users', 'tbl_users.id=tbl_users_bank_details.user_id');
        $this->db->where('tbl_users_bank_details.isDeleted', false);
        
        if(!empty($startDate)) {
            $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
            $endDate = date('Y-m-d 23:59:59', strtotime($endDate));
            $this->db->where('tbl_users_bank_details.added_date >=', $startDate);
            $this->db->where('tbl_users_bank_details.added_date <=', $endDate);
        }else {
            $startDate = date('Y-m-d 00:00:00');
            $endDate = date('Y-m-d 23:59:59');
            $this->db->where('tbl_users_bank_details.added_date >=', $startDate);
            $this->db->where('tbl_users_bank_details.added_date <=', $endDate);
        }
        $this->db->order_by('tbl_users_bank_details.id', 'DESC');
        $Query = $this->db->get();
        return $Query->result();
    }

    public function AllCards()
    {
        $this->db->from('tbl_cards');
        $Query = $this->db->get();
        return $Query->result();
    }

    public function getHistory()
    {
        $this->db->select('tbl_ludo.*,tbl_users.name');
        $this->db->from('tbl_ludo');
        $this->db->join('tbl_users', 'tbl_users.id=tbl_ludo.winner_id');
        $this->db->order_by('tbl_ludo.id', 'DESC');
        $this->db->limit(10);
        $Query = $this->db->get();
        return $Query->result();
    }


    public function ViewTableMaster($id)
    {
        $Query = $this->db->where('isDeleted', False)
            ->where('id', $id)
            ->get('tbl_robot_cards');
        return $Query->row();
    }
    
    public function AddTableMaster($data)
    {
        $this->db->insert('tbl_robot_cards', $data);
        return $this->db->insert_id();
    }

    public function ChangeStatus($id)
    {
        $data = [
            'status' => $this->input->post('status'),
            'updated_date' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id', $id);
        $this->db->update('tbl_users_kyc', $data);
        return $this->db->last_query();
    }

    public function UpdateTableMaster($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_users_kyc', $data);
        return $this->db->last_query();
    }

    public function CheckDuplicate($name)
    {
        $this->db->select('id');
        $this->db->from('tbl_robot_cards');
        $this->db->where(['name'=>$name,'isDeleted'=>0]);
        return $num_results = $this->db->count_all_results();
    }
}