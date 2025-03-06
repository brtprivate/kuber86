<?php
class UserCategory_model extends MY_Model
{

    // public function AllTableMasterList()
    // {
    //     $this->db->from('tbl_user_category');
    //     $this->db->where('isDeleted', false);
    //     $this->db->order_by('id', 'desc');
    //     $Query = $this->db->get();
    //     return $Query->result();
    // }

    public function AllTableMasterList($startDate = null, $endDate = null)
{
    $this->db->from('tbl_user_category');
    $this->db->where('isDeleted', false);

    
    // Add date filtering conditions if start date and end date are provided
    if ($startDate !== null && $endDate !== null) {
        $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
        $endDate = date('Y-m-d 23:59:00', strtotime($endDate));
        $this->db->where('added_date >=', $startDate);
        $this->db->where('added_date <=', $endDate);
    }

    $this->db->order_by('id', 'desc');
    $query = $this->db->get();
    return $query->result();
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
            ->get('tbl_user_category');
        return $Query->row();
    }
    
    public function AddTableMaster($data)
    {
        $this->db->insert('tbl_user_category', $data);
        return $this->db->insert_id();
    }

    public function Delete($id)
    {
        $data = [
            'isDeleted' => TRUE,
            'updated_date' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id', $id);
        $this->db->update('tbl_user_category', $data);
        return $this->db->last_query();
    }

    public function UpdateTableMaster($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_user_category', $data);
        return $this->db->last_query();
    }

    public function CheckDuplicate($name)
    {
        $this->db->select('id');
        $this->db->from('tbl_user_category');
        $this->db->where(['name'=>$name,'isDeleted'=>0]);
        return $num_results = $this->db->count_all_results();
    }
}