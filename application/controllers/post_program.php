<?php
class Post_program extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_program');
        $this->load->library('upload');
	}
	function index(){
		$this->load->view('v_post_news');
	}

	function simpan_post(){
		$config['upload_path'] = './assets/images/'; //path folder
	    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
	    $config['encrypt_name'] = TRUE; //nama yang terupload nantinya

	    $this->upload->initialize($config);
	    if(!empty($_FILES['filefoto']['name'])){
	        if ($this->upload->do_upload('filefoto')){
	        	$gbr = $this->upload->data();
	            //Compress Image
	            $config['image_library']='gd2';
	            $config['source_image']='./assets/images/'.$gbr['file_name'];
	            $config['create_thumb']= FALSE;
	            $config['maintain_ratio']= FALSE;
	            $config['quality']= '60%';
	            $config['width']= 710;
	            $config['height']= 420;
	            $config['new_image']= './assets/images/'.$gbr['file_name'];
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();

	            $gambar=$gbr['file_name'];
                $jdl=$this->input->post('judul');
                $program=$this->input->post('program');

				$this->m_program->simpan_program($jdl,$program,$gambar);
				redirect('Admin1/berhasil');

		}else{
			redirect('post_program');
	    }
	                 
	    }else{
			redirect('post_program');
		}
				
	}

	function lists(){
		$x['data']=$this->m_program->get_all_program();
		$this->load->view('v_post_list',$x);
	}

	function view(){
		$kode=$this->uri->segment(3);
		$x['data']=$this->m_program->get_program_by_kode($kode);
		$this->load->view('viewbengkulu',$x);
	}

}