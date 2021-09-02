<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
        $this->load->library('form_validation');
    }

	public function index()
	{
        $result['event_data']=$this->Main_model->get_data('event_list',array('status'=>1));
       
		$this->load->view('add_event',$result);
	}
    public function insert_page_data()
	{	
        if($_POST['r_num'] !='' && $_POST['end_r'] !=''){
            
        $total_r=$_POST['r_num']*$_POST['end_r'];
        if($_POST['r_option']==="week"){
            $total_r=$_POST['r_num']*$_POST['end_r']*7;
            }
        $end_date=date('Y-m-d', strtotime($_POST['start_date']. ' + '.$total_r.' days'));
    }


        $this->form_validation->set_rules('event', 'event', 'required');
        $this->form_validation->set_rules('start_date', 'start_date', 'required');
        $this->form_validation->set_rules('r_num', 'r_num', 'required');
        $this->form_validation->set_rules('end_r', 'end_r', 'required');
        if($_POST['day_names'] != null && !empty($_POST['day_names'])){
        $this->form_validation->set_rules('day_names', 'day_names', 'required');
        }
        if($this->form_validation->run()){

        $data=array(
            'title'=>$_POST['event'],
            'start_date'=>$_POST['start_date'],
            'recurrence'=>$_POST['r_num'],
            'option_select'=>$_POST['r_option'],
            
            'end'=>$_POST['end_r'],
            'end_date'=>$end_date
        );
        if($_POST['day_names'] != null && !empty($_POST['day_names'])){
            $data['week']=json_encode($_POST['day_names']);
            }
        $result=$this->Main_model->insert_info('event_list',$data);
        
        return redirect('');
    }else{
        $this->index();
    }
    
	}
    public function delete_event($id="")
	{
		$result=$this->Main_model->delete('event_list',array('ID'=>$id));
        return redirect('');
	}

}
