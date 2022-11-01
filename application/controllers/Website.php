<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Website extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_admin', 'ADM', TRUE);
		$this->load->model('M_config', 'CONF', TRUE);
	}

	public function index()
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user']		= $this->session->userdata('admin_user');
			$data['admin']					= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			$data['dashboard_info']			= TRUE;
			$data['breadcrumb']				= 'Dashboard';
			$data['dashboard']				= 'admin/dashboard/statistik';
			$data['boxmenu']				= 'admin/boxmenu/setting';
			$data['menu_terpilih']			= '1';
			$data['submenu_terpilih']		= '';
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("login");
		}
	}

	//IDENTITAS
	public function identitas($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user']		= $this->session->userdata('admin_user');
			$data['admin']					= $this->ADM->get_admin('', $where_admin);
			if ($data['admin']->admin_level_kode == 1) {
				$data['web']					= $this->ADM->identitaswebsite();
				@date_default_timezone_set('Asia/Jakarta');
				$data['dashboard_info']			= FALSE;
				$data['breadcrumb']				= 'System Identity';
				$data['content']				= 'admin/content/website/identitas';
				$data['menu_terpilih']			= '1';
				$data['submenu_terpilih']		= '105';
				$data['action']					= (empty($filter1)) ? 'view' : $filter1;
				$data['validate']				= array(
					'identitas_website' => 'Website Name',
					'identitas_deskripsi' => 'Description',
					'identitas_keyword' => 'Keyword',
					'identitas_notelp' => 'Telephone No',
					'identitas_email' => 'Email',
					'identitas_fb' => 'Facebook',
					'identitas_tw' => 'Twitter',
					'identitas_yb' => 'Youtube',
					'identitas_favicon' => 'Favicon'
				);
				if ($data['action'] == 'view') {
					$data['berdasarkan']		= array('identitas_website' => 'System Identity');
					$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'identitas_website';
					$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
					$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
					$data['batas']				= 10;
					$data['page']				= ($data['halaman'] - 1) * $data['batas'];
					$like_identitas[$data['cari']]	= $data['q'];
					$data['jml_data']			= $this->ADM->count_all_identitas('', $like_identitas);
					$data['jml_halaman']		= ceil($data['jml_data'] / $data['batas']);
				} elseif ($data['action'] == 'tambah') {
					$data['onload']						= 'identitas_website';
					$data['identitas_website']			= ($this->input->post('identitas_website')) ? $this->input->post('identitas_website') : '';
					$data['identitas_deskripsi']		= ($this->input->post('identitas_deskripsi')) ? $this->input->post('identitas_deskripsi') : '';
					$data['identitas_keyword']			= ($this->input->post('identitas_keyword')) ? $this->input->post('identitas_keyword') : '';
					$data['identitas_email']				= ($this->input->post('identitas_email')) ? $this->input->post('identitas_email') : '';
					$data['identitas_fb']				= ($this->input->post('identitas_fb')) ? $this->input->post('identitas_fb') : '';
					$data['identitas_tw']				= ($this->input->post('identitas_tw')) ? $this->input->post('identitas_tw') : '';
					$data['identitas_gp']				= ($this->input->post('identitas_gb')) ? $this->input->post('identitas_gp') : '';
					$data['identitas_yb']				= ($this->input->post('identitas_yb')) ? $this->input->post('identitas_yb') : '';
					$data['identitas_favicon']			= ($this->input->post('identitas_favicon')) ? $this->input->post('identitas_favicon') : '';
					$data['identitas_created']				= ($this->input->post('identitas_created')) ? $this->input->post('identitas_created') : '';
					$data['identitas_updated']			= ($this->input->post('identitas_updated')) ? $this->input->post('identitas_updated') : '';
					$simpan								=  $this->input->post('simpan');
					if ($simpan) {
						$insert['identitas_website']	= validasi_sql($data['identitas_website']);
						$insert['identitas_deskripsi']	= validasi_sql($data['identitas_deskripsi']);
						$insert['identitas_keyword']	= validasi_sql($data['identitas_keyword']);
						$insert['identitas_notelp']		= validasi_sql($data['identitas_notelp']);
						$insert['identitas_email']		= validasi_sql($data['identitas_email']);
						$insert['identitas_fb']			= validasi_sql($data['identitas_fb']);
						$insert['identitas_tw']			= validasi_sql($data['identitas_tw']);
						$insert['identitas_gp']			= validasi_sql($data['identitas_gp']);
						$insert['identitas_yb']			= validasi_sql($data['identitas_yb']);
						$insert['identitas_favicon']	= validasi_sql($data['identitas_favicon']);
						$this->ADM->insert_identitas($insert);
						$this->session->set_flashdata('success', 'Identity data has been successfully added!,');
						redirect("website/identitas/edit/1");
					}
				} elseif ($data['action'] == 'edit') {
					$data['ckeditor']			= $this->ckeditor('identitas_deskripsi');
					$data['onload']					= 'identitas_website';
					$where_identitas['identitas_id']	= $filter2;
					$identitas						= $this->ADM->get_identitas('', $where_identitas);
					$data['identitas_id']			= ($this->input->post('identitas_id')) ? $this->input->post('identitas_id') : $identitas->identitas_id;
					$data['identitas_website']		= ($this->input->post('identitas_website')) ? $this->input->post('identitas_website') : $identitas->identitas_website;
					$data['identitas_deskripsi']	= ($this->input->post('identitas_deskripsi')) ? $this->input->post('identitas_deskripsi') : $identitas->identitas_deskripsi;
					$data['identitas_keyword']		= ($this->input->post('identitas_keyword')) ? $this->input->post('identitas_keyword') : $identitas->identitas_keyword;
					$data['identitas_alamat']		= ($this->input->post('identitas_alamat')) ? $this->input->post('identitas_alamat') : $identitas->identitas_alamat;
					$data['identitas_notelp']		= ($this->input->post('identitas_notelp')) ? $this->input->post('identitas_notelp') : $identitas->identitas_notelp;
					$data['identitas_email']		= ($this->input->post('identitas_email')) ? $this->input->post('identitas_email') : $identitas->identitas_email;
					$data['identitas_fb']			= ($this->input->post('identitas_fb')) ? $this->input->post('identitas_fb') : $identitas->identitas_fb;
					$data['identitas_tw']			= ($this->input->post('identitas_tw')) ? $this->input->post('identitas_tw') : $identitas->identitas_tw;
					$data['identitas_gp']			= ($this->input->post('identitas_gp')) ? $this->input->post('identitas_gp') : $identitas->identitas_gp;
					$data['identitas_yb']			= ($this->input->post('identitas_yb')) ? $this->input->post('identitas_yb') : $identitas->identitas_yb;
					$data['identitas_favicon']		= ($this->input->post('identitas_favicon')) ? $this->input->post('identitas_favicon') : $identitas->identitas_favicon;
					$data['identitas_created']				= ($this->input->post('identitas_created')) ? $this->input->post('identitas_created') : $identitas->identitas_created;
					$data['identitas_updated']			= ($this->input->post('identitas_updated')) ? $this->input->post('identitas_updated') : $identitas->identitas_updated;
					$simpan							= $this->input->post('simpan');
					if ($simpan) {
						$config['upload_path']          = './assets/';
						$config['allowed_types']        = 'png|jpg|jpeg';
						$config['encrypt_name'] 		= TRUE;
						$config['max_size']             = 11000;
						$config['max_width']            = 4096;
						$config['max_height']           = 2048;

						$this->upload->initialize($config);

						$data['identitas_favicon']	= $gambar;
						$where_edit['identitas_id']				= validasi_sql($data['identitas_id']);
						$edit['identitas_website']				= validasi_sql($data['identitas_website']);
						$edit['identitas_deskripsi']			= validasi_sql($data['identitas_deskripsi']);
						$edit['identitas_keyword']				= validasi_sql($data['identitas_keyword']);
						$edit['identitas_alamat']				= validasi_sql($data['identitas_alamat']);
						$edit['identitas_notelp']				= validasi_sql($data['identitas_notelp']);
						$edit['identitas_email']				= validasi_sql($data['identitas_email']);
						$edit['identitas_fb']					= validasi_sql($data['identitas_fb']);
						$edit['identitas_tw']					= validasi_sql($data['identitas_tw']);
						$edit['identitas_gp']					= validasi_sql($data['identitas_gp']);
						$edit['identitas_yb']					= validasi_sql($data['identitas_yb']);
						if ($this->upload->do_upload('identitas_favicon')) {
							@unlink('./assets/' . $row->identitas_favicon);

							$data = array('upload_data' => $this->upload->data());
							$edit['identitas_favicon'] 	= $this->upload->data('file_name');
						}

						$this->ADM->update_identitas($where_edit, $edit);
						$this->session->set_flashdata('success', 'Identity data has been successfully edited!,');
						redirect("website/identitas/edit/1");
					}
				} elseif ($data['action'] == 'hapus') {
					$where_delete['identitas_id']		= validasi_sql($filter2);
					$this->ADM->delete_identitas($where_delete);
					$this->session->set_flashdata('success', 'Identity data has been successfully deleted!,');
					redirect("website/identitas/edit/1");
				}

				$this->load->vars($data);
				$this->load->view('admin/home');
			} else {
				redirect("admin");
			}
		} else {
			redirect("login");
		}
	}



	//IDENTITAS
	public function stock($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user']		= $this->session->userdata('admin_user');
			$data['admin']					= $this->ADM->get_admin('', $where_admin);
			if ($data['admin']->admin_level_kode == 1) {
				$data['web']					= $this->ADM->identitaswebsite();
				@date_default_timezone_set('Asia/Jakarta');
				$data['dashboard_info']			= FALSE;
				$data['breadcrumb']				= 'Livestock Notification';
				$data['content']				= 'admin/content/website/stock';
				$data['menu_terpilih']			= '1';
				$data['submenu_terpilih']		= '105';
				$data['action']					= (empty($filter1)) ? 'view' : $filter1;
				if ($data['action'] == 'view') {
				} elseif ($data['action'] == 'tambah') {
				} elseif ($data['action'] == 'edit') {
					$data['onload']					= 'limitstock_id';
					$where_limitstock['limitstock_id']	= $filter2;
					$limitstock						= $this->ADM->get_limitstock('', $where_limitstock);
					$data['limitstock_id']			= ($this->input->post('limitstock_id')) ? $this->input->post('limitstock_id') : $limitstock->limitstock_id;
					$data['stock']		= ($this->input->post('stock')) ? $this->input->post('stock') : $limitstock->stock;
					$data['limitstock_created']				= ($this->input->post('limitstock_created')) ? $this->input->post('limitstock_created') : $limitstock->limitstock_created;
					$data['limitstock_updated']			= ($this->input->post('limitstock_updated')) ? $this->input->post('limitstock_updated') : $limitstock->limitstock_updated;
					$simpan							= $this->input->post('simpan');
					if ($simpan) {
						$where_edit['limitstock_id']				= validasi_sql($data['limitstock_id']);
						$edit['stock']				= validasi_sql($data['stock']);
						$this->ADM->update_limitstock($where_edit, $edit);
						$this->session->set_flashdata('success', 'Stock Notification Data has been successfully edited!,');
						redirect("website/stock/edit/1");
					}
				} elseif ($data['action'] == 'hapus') {
				}

				$this->load->vars($data);
				$this->load->view('admin/home');
			} else {
				redirect("admin");
			}
		} else {
			redirect("login");
		}
	}

	//Limit feeds
	public function feedlimit($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user']		= $this->session->userdata('admin_user');
			$data['admin']					= $this->ADM->get_admin('', $where_admin);
			if ($data['admin']->admin_level_kode == 1) {
				$data['web']					= $this->ADM->identitaswebsite();
				@date_default_timezone_set('Asia/Jakarta');
				$data['dashboard_info']			= FALSE;
				$data['breadcrumb']				= 'Feeds Notification';
				$data['content']				= 'admin/content/website/feedlimit';
				$data['menu_terpilih']			= '1';
				$data['submenu_terpilih']		= '105';
				$data['action']					= (empty($filter1)) ? 'view' : $filter1;
				if ($data['action'] == 'view') {
				} elseif ($data['action'] == 'tambah') {
				} elseif ($data['action'] == 'edit') {
					$data['onload']					= 'limitfeed_id';
					$where_limitfeed['limitfeed_id']	= $filter2;
					$limitfeed						= $this->ADM->get_limitfeed('', $where_limitfeed);
					$data['limitfeed_id']			= ($this->input->post('limitfeed_id')) ? $this->input->post('limitfeed_id') : $limitfeed->limitfeed_id;
					$data['feeds']		= ($this->input->post('feeds')) ? $this->input->post('feeds') : $limitfeed->feeds;
					$data['limitfeed_created']				= ($this->input->post('limitfeed_created')) ? $this->input->post('limitfeed_created') : $limitfeed->limitfeed_created;
					$data['limitfeed_updated']			= ($this->input->post('limitfeed_updated')) ? $this->input->post('limitfeed_updated') : $limitfeed->limitfeed_updated;
					$simpan							= $this->input->post('simpan');
					if ($simpan) {
						$where_edit['limitfeed_id']				= validasi_sql($data['limitfeeds_id']);
						$edit['feeds']				= validasi_sql($data['feeds']);
						$this->ADM->update_limitfeed($where_edit, $edit);
						$this->session->set_flashdata('success', 'Feeds Notification Data has been successfully edited!,');
						redirect("website/feedlimit/edit/1");
					}
				} elseif ($data['action'] == 'hapus') {
				}

				$this->load->vars($data);
				$this->load->view('admin/home');
			} else {
				redirect("admin");
			}
		} else {
			redirect("login");
		}
	}

	//FUNCTION MASTER BARANG
	public function barang($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Livestocks';
			$data['content'] 			= 'admin/content/website/barang';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'nama_barang' => 'Name',
				'merek' => 'Category', 'temperature' => 'Temperature'
			);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('nama_barang' => 'NAME', 'merek' => 'CATEGORY', 'temperature' => 'TEMPERATURE');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'nama_barang';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_barang[$data['cari']]	= $data['q'];
				$data['jml_data']			= $this->ADM->count_all_barang('', $like_barang);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			} elseif ($data['action'] == 'tambah') {
				if ($data['admin']->admin_level_kode == 1 || $data['admin']->admin_level_kode == 2) {
					$data['onload']				= 'barang';
					$data['nama_barang']	= ($this->input->post('nama_barang')) ? $this->input->post('nama_barang') : '';
					$data['merek']	= ($this->input->post('merek')) ? $this->input->post('merek') : '';
					$data['temperature']	= ($this->input->post('temperature')) ? $this->input->post('temperature') : '';
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$insert['nama_barang']			= validasi_sql($data['nama_barang']);
						$insert['merek']			= validasi_sql($data['merek']);
						$insert['temperature']			= validasi_sql($data['temperature']);
						$insert['stock']			= 0;
						$this->ADM->insert_barang($insert);
						$this->session->set_flashdata('success', 'New Livestock has been successfully added!,');
						redirect("website/barang");
					}
				} else {
					redirect("website/barang");
				}
			} elseif ($data['action'] == 'edit') {
				if ($data['admin']->admin_level_kode == 1 || $data['admin']->admin_level_kode == 2) {
					$data['onload']				= 'nama_barang';
					$where_barang['id_barang']	= $filter2;
					$barang				= $this->ADM->get_barang('*', $where_barang);
					$data['id_barang']	= ($this->input->post('id_barang')) ? $this->input->post('id_barang') : $barang->id_barang;
					$data['nama_barang']	= ($this->input->post('nama_barang')) ? $this->input->post('nama_barang') : $barang->nama_barang;
					$data['merek']	= ($this->input->post('merek')) ? $this->input->post('merek') : $barang->merek;
					$data['temperature']	= ($this->input->post('temperature')) ? $this->input->post('temperature') : $barang->temperature;
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$where_edit['id_barang']	= $data['id_barang'];
						$edit['nama_barang']	= $data['nama_barang'];
						$edit['merek']	= $data['merek'];
						$edit['temperature']	= $data['temperature'];
						$this->ADM->update_barang($where_edit, $edit);
						$this->session->set_flashdata('success', 'Livestock has been edited successfully!,');
						redirect("website/barang");
					}
				} else {
					redirect("website/barang");
				}
			} elseif ($data['action'] == 'hapus') {
				if ($data['admin']->admin_level_kode == 1 || $data['admin']->admin_level_kode == 2) {
					$where_delete['id_barang']		= validasi_sql($filter2);
					$this->ADM->delete_barang($where_delete);
					$this->session->set_flashdata('success', 'Livestock has been successfully removed!,');
					redirect("website/barang");
				} else {
					redirect("website/barang");
				}
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}
	// Function for feeds
	public function feeds($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Livestock Feeds';
			$data['content'] 			= 'admin/content/website/feeds';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'nama_feeds' => 'Name'
				);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('nama_feeds' => 'NAME');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'nama_feeds';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_feeds[$data['cari']]	= $data['q'];
				$data['jml_data']			= $this->ADM->count_all_feeds('', $like_feeds);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			} elseif ($data['action'] == 'tambah') {
				if ($data['admin']->admin_level_kode == 1 || $data['admin']->admin_level_kode == 2) {
					$data['onload']				= 'feeds';
					$data['nama_feeds']	= ($this->input->post('nama_feeds')) ? $this->input->post('nama_feeds') : '';
					$data['id_barang']	= ($this->input->post('id_barang')) ? $this->input->post('id_barang') : '';
					$data['jumlah']	= ($this->input->post('jumlah')) ? $this->input->post('jumlah') : '';
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$insert['nama_feeds']			= validasi_sql($data['nama_feeds']);
						$insert['jumlah']			= validasi_sql($data['id_barang']);
						$insert['id_barang']	= validasi_sql($data['id_barang']);
						$this->ADM->insert_feeds($insert);
						$this->session->set_flashdata('success', 'New feeds has been successfully added!,');
						redirect("website/feeds");
					}
				} else {
					redirect("website/feeds");
				}
			} elseif ($data['action'] == 'edit') {
				if ($data['admin']->admin_level_kode == 1 || $data['admin']->admin_level_kode == 2) {
					$data['onload']				= 'nama_feeds';
					$where_feeds['id_feeds']	= $filter2;
					$feeds				= $this->ADM->get_feeds('*', $where_feeds);
					$data['id_feeds']	= ($this->input->post('id_feeds')) ? $this->input->post('id_feeds') : $feeds->id_feeds;
					$data['nama_feeds']	= ($this->input->post('nama_feeds')) ? $this->input->post('nama_feeds') : $feeds->nama_feeds;
					$data['jumlah']	= ($this->input->post('jumlah')) ? $this->input->post('jumlah') : $feeds->jumlah;
					$data['id_barang']	= ($this->input->post('id_barang')) ? $this->input->post('id_barang') : $feeds->id_barang;
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$where_edit['id_feeds']	= $data['id_feeds'];
						$edit['nama_feeds']	= $data['nama_feeds'];
						$edit['jumlah']	= $data['jumlah'];
						$edit['id_barang'] = $data['id_barang'];
						$this->ADM->update_feeds($where_edit, $edit);
						$this->session->set_flashdata('success', 'Feeds has been edited successfully!,');
						redirect("website/feeds");
					}
				} else {
					redirect("website/feeds");
				}
			} elseif ($data['action'] == 'hapus') {
				if ($data['admin']->admin_level_kode == 1 || $data['admin']->admin_level_kode == 2) {
					$where_delete['id_feeds']		= validasi_sql($filter2);
					$this->ADM->delete_feeds($where_delete);
					$this->session->set_flashdata('success', 'Feeds has been successfully removed!,');
					redirect("website/feeds");
				} else {
					redirect("website/feeds");
				}
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}

	//FUNCTION Feeding Livestocks
	public function feeding($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Used Feeds';
			$data['content'] 			= 'admin/content/website/feeding';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'id_barang' => 'livestock', 'id_feeds' => "feeds_name"
			);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('id_barang' => 'LIVESTOCK', 'id_feeds' => 'FEED NAME');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'id_barang';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_feeding[$data['cari']]	= $data['q'];
				$data['jml_data']			= $this->ADM->count_all_feeding('', $like_feeding);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			} elseif ($data['action'] == 'tambah') {
				if ($data['admin']->admin_level_kode == 1 || $data['admin']->admin_level_kode == 2) {
					$data['onload']				= 'feeding';
					$data['id_barang']	= ($this->input->post('id_barang')) ? $this->input->post('id_barang') : '';
					$data['id_feeds']	= ($this->input->post('id_feeds')) ? $this->input->post('id_feeds') : '';
					$data['jumlah']	= ($this->input->post('jumlah')) ? $this->input->post('jumlah') : '';
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$where_barang['id_barang']	= $data['id_barang'];
						
						$where_feeds['id_feeds']	= $data['id_feeds'];;
						$feeds	= $this->ADM->get_feeds('*', $where_feeds);

						if ($feeds->jumlah >= $data['jumlah']) {
							$insert['id_barang']			= validasi_sql($data['id_barang']);
							$insert['id_feeds']			= validasi_sql($data['id_feeds']);
							$insert['jumlah']				= validasi_sql($data['jumlah']);
							$insert['admin_user']			= $this->session->userdata('admin_user');
							$this->ADM->insert_feeding($insert);


							$where_edit['id_feeds']	= $data['id_feeds'];
							$edit['jumlah']	= $feeds->jumlah - $data['jumlah'];
							$this->ADM->update_feeds($where_edit, $edit);

							
							$this->session->set_flashdata('success', 'New livestock feeding has been successfully added!');
							redirect("website/feeding");
						} else {
							$this->session->set_flashdata('error', 'Insufficient feeds!');
							redirect("website/feeding");
						}
					}
				} else {
					redirect("website/feeding");
				}
			} elseif ($data['action'] == 'hapus') {
				$where_delete['id_feeding']		= validasi_sql($filter2);
				$this->ADM->delete_feeding($where_delete);
				$this->session->set_flashdata('success', 'Outgoing Livejumlahs has been successfully removed!');
				redirect("website/feeding");
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}

	//FUNCTION MASTER SUPPLIER
	public function supplier($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Supplier';
			$data['content'] 			= 'admin/content/website/supplier';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'nama_supplier' => 'Name'
			);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('nama_supplier' => 'NAME', 'alamat_supplier' => 'ADDRESS', 'notelp_supplier' => 'NO TELP');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'nama_supplier';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_supplier[$data['cari']]	= $data['q'];
				$data['jml_data']			= $this->ADM->count_all_supplier('', $like_supplier);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			} elseif ($data['action'] == 'tambah') {
				if ($data['admin']->admin_level_kode == 1) {
					$data['onload']				= 'supplier';
					$data['nama_supplier']	= ($this->input->post('nama_supplier')) ? $this->input->post('nama_supplier') : '';
					$data['alamat_supplier']	= ($this->input->post('alamat_supplier')) ? $this->input->post('alamat_supplier') : '';
					$data['notelp_supplier']	= ($this->input->post('notelp_supplier')) ? $this->input->post('notelp_supplier') : '';
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$insert['nama_supplier']			= validasi_sql($data['nama_supplier']);
						$insert['alamat_supplier']			= validasi_sql($data['alamat_supplier']);
						$insert['notelp_supplier']			= validasi_sql($data['notelp_supplier']);
						$this->ADM->insert_supplier($insert);
						$this->session->set_flashdata('success', 'New supplier has been added successfully,');
						redirect("website/supplier");
					}
				} else {
					redirect("website/supplier");
				}
			} elseif ($data['action'] == 'edit') {
				if ($data['admin']->admin_level_kode == 1) {
					$data['onload']				= 'nama_supplier';
					$where_supplier['id_supplier']	= $filter2;
					$supplier				= $this->ADM->get_supplier('*', $where_supplier);
					$data['id_supplier']	= ($this->input->post('id_supplier')) ? $this->input->post('id_supplier') : $supplier->id_supplier;
					$data['nama_supplier']	= ($this->input->post('nama_supplier')) ? $this->input->post('nama_supplier') : $supplier->nama_supplier;
					$data['alamat_supplier']	= ($this->input->post('alamat_supplier')) ? $this->input->post('alamat_supplier') : $supplier->alamat_supplier;
					$data['notelp_supplier']	= ($this->input->post('notelp_supplier')) ? $this->input->post('notelp_supplier') : $supplier->notelp_supplier;
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$where_edit['id_supplier']	= $data['id_supplier'];
						$edit['nama_supplier']	= $data['nama_supplier'];
						$edit['alamat_supplier']	= $data['alamat_supplier'];
						$edit['notelp_supplier']	= $data['notelp_supplier'];
						$this->ADM->update_supplier($where_edit, $edit);
						$this->session->set_flashdata('success', 'Supplier has been successfully edited!,');
						redirect("website/supplier");
					}
				} else {
					redirect("website/supplier");
				}
			} elseif ($data['action'] == 'hapus') {
				if ($data['admin']->admin_level_kode == 1) {
					$where_delete['id_supplier']		= validasi_sql($filter2);
					$this->ADM->delete_supplier($where_delete);
					$this->session->set_flashdata('success', 'The supplier has been successfully removed!,');
					redirect("website/supplier");
				} else {
					redirect("website/supplier");
				}
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}

	//FUNCTION MASTER CUSTOMER
	public function customer($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Distributors';
			$data['content'] 			= 'admin/content/website/customer';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'nama_customer' => 'Name'
			);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('nama_customer' => 'NAME', 'alamat_customer' => 'ADDRESS', 'notelp_customerr' => 'NO TELP');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'nama_customer';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_customer[$data['cari']]	= $data['q'];
				$data['jml_data']			= $this->ADM->count_all_customer('', $like_customer);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			} elseif ($data['action'] == 'tambah') {
				if ($data['admin']->admin_level_kode == 1) {
					$data['onload']				= 'customer';
					$data['nama_customer']	= ($this->input->post('nama_customer')) ? $this->input->post('nama_customer') : '';
					$data['alamat_customer']	= ($this->input->post('alamat_customer')) ? $this->input->post('alamat_customer') : '';
					$data['notelp_customer']	= ($this->input->post('notelp_customer')) ? $this->input->post('notelp_customer') : '';
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$insert['nama_customer']			= validasi_sql($data['nama_customer']);
						$insert['alamat_customer']			= validasi_sql($data['alamat_customer']);
						$insert['notelp_customer']			= validasi_sql($data['notelp_customer']);
						$this->ADM->insert_customer($insert);
						$this->session->set_flashdata('success', 'New customer has been added successfully!,');
						redirect("website/customer");
					}
				} else {
					redirect("website/customer");
				}
			} elseif ($data['action'] == 'edit') {
				if ($data['admin']->admin_level_kode == 1) {
					$data['onload']				= 'nama_customer';
					$where_customer['id_customer']	= $filter2;
					$customer				= $this->ADM->get_customer('*', $where_customer);
					$data['id_customer']	= ($this->input->post('id_customer')) ? $this->input->post('id_customer') : $customer->id_customer;
					$data['nama_customer']	= ($this->input->post('nama_customer')) ? $this->input->post('nama_customer') : $customer->nama_customer;
					$data['alamat_customer']	= ($this->input->post('alamat_customer')) ? $this->input->post('alamat_customer') : $customer->alamat_customer;
					$data['notelp_customer']	= ($this->input->post('notelp_customer')) ? $this->input->post('notelp_customer') : $customer->notelp_customer;
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$where_edit['id_customer']	= $data['id_customer'];
						$edit['nama_customer']	= $data['nama_customer'];
						$edit['alamat_customer']	= $data['alamat_customer'];
						$edit['notelp_customer']	= $data['notelp_customer'];
						$this->ADM->update_customer($where_edit, $edit);
						$this->session->set_flashdata('success', 'Customer has been successfully edited!,');
						redirect("website/customer");
					}
				} else {
					redirect("website/customer");
				}
			} elseif ($data['action'] == 'hapus') {
				if ($data['admin']->admin_level_kode == 1) {
					$where_delete['id_customer']		= validasi_sql($filter2);
					$this->ADM->delete_customer($where_delete);
					$this->session->set_flashdata('success', 'The customer has been successfully deleted!,');
					redirect("website/customer");
				} else {
					redirect("website/customer");
				}
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}

	//FUNCTION TRANSACTION Incoming jumlahs
	public function masuk($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Incoming Livestocks';
			$data['content'] 			= 'admin/content/website/masuk';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'id_barang' => 'Animal name'
			);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('id_barang' => 'ANIMAL NAME');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'id_barang';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_transaksi[$data['cari']]	= $data['q'];
				$where_transaksi['status_pergerakan'] 	= 1;
				$data['jml_data']			= $this->ADM->count_all_transaksi($where_transaksi, $like_transaksi);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			} elseif ($data['action'] == 'tambah') {
				if ($data['admin']->admin_level_kode == 1 || $data['admin']->admin_level_kode == 2) {
					$data['onload']				= 'supplier';
					$data['id_barang']	= ($this->input->post('id_barang')) ? $this->input->post('id_barang') : '';
					$data['id_supplier']	= ($this->input->post('id_supplier')) ? $this->input->post('id_supplier') : '';
					$data['jumlah']	= ($this->input->post('jumlah')) ? $this->input->post('jumlah') : '';
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$insert['id_barang']			= validasi_sql($data['id_barang']);
						$insert['id_supplier']			= validasi_sql($data['id_supplier']);
						$insert['jumlah']				= validasi_sql($data['jumlah']);
						$insert['admin_user']			= $this->session->userdata('admin_user');
						$insert['status_pergerakan']	= 1;
						$this->ADM->insert_transaksi($insert);

						$where_barang['id_barang']	= $data['id_barang'];
						$barang	= $this->ADM->get_barang('*', $where_barang);

						$where_edit['id_barang']	= $data['id_barang'];
						$edit['stock']	= $barang->stock + $data['jumlah'];
						$this->ADM->update_barang($where_edit, $edit);

						$this->session->set_flashdata('success', 'New Incoming Livestocks has been added successfully!,');
						redirect("website/masuk");
					}
				} else {
					redirect("website/masuk");
				}
			} elseif ($data['action'] == 'hapus') {
				$where_delete['id_transaksi']		= validasi_sql($filter2);
				$this->ADM->delete_transaksi($where_delete);
				$this->session->set_flashdata('success', 'Incoming Livestocks has been successfully removed!,');
				redirect("website/masuk");
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}

	//FUNCTION Stocks TRANSACTION OUT
	public function keluar($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Outgoing Livestocks';
			$data['content'] 			= 'admin/content/website/keluar';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'id_barang' => 'Animal name'
			);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('id_barang' => 'ANIMAL NAME');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'id_barang';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_transaksi[$data['cari']]	= $data['q'];
				$where_transaksi['status_pergerakan'] 	= 2;
				$data['jml_data']			= $this->ADM->count_all_transaksi($where_transaksi, $like_transaksi);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			} elseif ($data['action'] == 'tambah') {
				if ($data['admin']->admin_level_kode == 1 || $data['admin']->admin_level_kode == 2) {
					$data['onload']				= 'supplier';
					$data['id_barang']	= ($this->input->post('id_barang')) ? $this->input->post('id_barang') : '';
					$data['id_customer']	= ($this->input->post('id_customer')) ? $this->input->post('id_customer') : '';
					$data['jumlah']	= ($this->input->post('jumlah')) ? $this->input->post('jumlah') : '';
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$where_barang['id_barang']	= $data['id_barang'];
						$barang	= $this->ADM->get_barang('*', $where_barang);

						$where_limitstock['limitstock_id']	= 1;
						$limitstock	= $this->ADM->get_limitstock('*', $where_limitstock);

						if ($barang->stock >= $data['jumlah']) {
							$insert['id_barang']			= validasi_sql($data['id_barang']);
							$insert['id_customer']			= validasi_sql($data['id_customer']);
							$insert['jumlah']				= validasi_sql($data['jumlah']);
							$insert['admin_user']			= $this->session->userdata('admin_user');
							$insert['status_pergerakan']	= 2;
							$this->ADM->insert_transaksi($insert);


							$where_edit['id_barang']	= $data['id_barang'];
							$edit['stock']	= $barang->stock - $data['jumlah'];
							$this->ADM->update_barang($where_edit, $edit);

							if ($barang->stock <= $limitstock->stock) {
								$message = "Livestock with name " . $barang->nama_barang . " less than the minimum stock limit";
								$user_id = 4444;
								$url = "https://www.wms.ngodings.com";
								$headings = "LMS - Livestock Warning";
								$img = "https://www.wms.ngodings.com/assets/3691adaa4a69024b73dc5c1ddb3c43ea.png";


								$content = array(
									"en" => "$message"
								);
								$headings = array(
									"en" => "$headings"
								);
								$fields = array(
									'app_id' => "13219ce1-3c03-40bb-9043-13325e84a94c",
									'filters' => array(array("field" => "tag", "key" => "user_id", "relation" => "=", "value" => "$user_id")),
									'url' => $url,
									'contents' => $content,
									'chrome_web_icon' => $img,
									'headings' => $headings
								);
								$fields = json_encode($fields);
								print("\nJSON sent:\n");
								print($fields);
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
								curl_setopt($ch, CURLOPT_HTTPHEADER, array(
									'Content-Type: application/json; charset=utf-8',
									'Authorization: Basic ZTE1NzBjY2MtMTE1YS00NjA0LTllNzctNTJjNTZmZGU0YmFm'
								));
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
								curl_setopt($ch, CURLOPT_HEADER, FALSE);
								curl_setopt($ch, CURLOPT_POST, TRUE);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
								$response = curl_exec($ch);
								curl_close($ch);
							}

							$this->session->set_flashdata('success', 'New Exit Livestocks has been successfully added!');
							redirect("website/keluar");
						} else {
							$this->session->set_flashdata('error', 'Insufficient livestock!');
							redirect("website/keluar");
						}
					}
				} else {
					redirect("website/keluar");
				}
			} elseif ($data['action'] == 'hapus') {
				$where_delete['id_transaksi']		= validasi_sql($filter2);
				$this->ADM->delete_transaksi($where_delete);
				$this->session->set_flashdata('success', 'Outgoing Livestocks has been successfully removed!');
				redirect("website/keluar");
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}
	
	//FUNCTION TRANSACTION ADJUSTMENT
	public function penyesuaian($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Adjustment';
			$data['content'] 			= 'admin/content/website/penyesuaian';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'id_barang' => 'Animal name'
			);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('id_barang' => 'ANIMAL NAME');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'id_barang';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_transaksi[$data['cari']]	= $data['q'];
				$data['jml_data']			= $this->ADM->count_all_transaksi('', $like_transaksi);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			} elseif ($data['action'] == 'hapus') {
				$where_delete['id_transaksi']		= validasi_sql($filter2);
				$this->ADM->delete_transaksi($where_delete);
				$this->session->set_flashdata('success', 'Livestocks has been successfully deleted!');
				redirect("website/penyesuaian");
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}

	//FUNCTION livestock death recorded
	public function sick($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Quarantined Livestocks';
			$data['content'] 			= 'admin/content/website/sick';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'id_barang' => 'Animal name'
			);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('id_barang' => 'ANIMAL NAME');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'id_barang';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_damaged[$data['cari']]	= $data['q'];
				$where_damaged['status_pergerakan'] 	= 2;
				$data['jml_data']			= $this->ADM->count_all_damaged($where_damaged, $like_damaged);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			} elseif ($data['action'] == 'tambah') {
				if ($data['admin']->admin_level_kode == 1 || $data['admin']->admin_level_kode == 2) {
					$data['onload']				= 'supplier';
					$data['id_barang']	= ($this->input->post('id_barang')) ? $this->input->post('id_barang') : '';
					$data['reason']	= ($this->input->post('reason')) ? $this->input->post('reason') : '';
					$data['jumlah']	= ($this->input->post('jumlah')) ? $this->input->post('jumlah') : '';
					$data['comment']	= ($this->input->post('comment')) ? $this->input->post('comment') : '';
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$where_barang['id_barang']	= $data['id_barang'];
						$barang	= $this->ADM->get_barang('*', $where_barang);

						$where_limitstock['limitstock_id']	= 1;
						$limitstock	= $this->ADM->get_limitstock('*', $where_limitstock);

						if ($barang->stock >= $data['jumlah']) {
							$insert['id_barang']			= validasi_sql($data['id_barang']);
							$insert['reason']			= validasi_sql($data['reason']);
							$insert['comment']			= validasi_sql($data['comment']);
							$insert['jumlah']				= validasi_sql($data['jumlah']);
							$insert['admin_user']			= $this->session->userdata('admin_user');
							$insert['status_pergerakan']	= 2;
							$this->ADM->insert_damaged($insert);


							$where_edit['id_barang']	= $data['id_barang'];
							$edit['stock']	= $barang->stock - $data['jumlah'];
							$this->ADM->update_barang($where_edit, $edit);

							if ($barang->stock <= $limitstock->stock) {
								$message = "Livestock with name " . $barang->nama_barang . " less than the minimum livestock limit";
								$user_id = 4444;
								$url = "https://www.wms.ngodings.com";
								$headings = "LMS - Livestock Warning";
								$img = "https://www.wms.ngodings.com/assets/3691adaa4a69024b73dc5c1ddb3c43ea.png";


								$content = array(
									"en" => "$message"
								);
								$headings = array(
									"en" => "$headings"
								);
								$fields = array(
									'app_id' => "13219ce1-3c03-40bb-9043-13325e84a94c",
									'filters' => array(array("field" => "tag", "key" => "user_id", "relation" => "=", "value" => "$user_id")),
									'url' => $url,
									'contents' => $content,
									'chrome_web_icon' => $img,
									'headings' => $headings
								);
								$fields = json_encode($fields);
								print("\nJSON sent:\n");
								print($fields);
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
								curl_setopt($ch, CURLOPT_HTTPHEADER, array(
									'Content-Type: application/json; charset=utf-8',
									'Authorization: Basic ZTE1NzBjY2MtMTE1YS00NjA0LTllNzctNTJjNTZmZGU0YmFm'
								));
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
								curl_setopt($ch, CURLOPT_HEADER, FALSE);
								curl_setopt($ch, CURLOPT_POST, TRUE);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
								$response = curl_exec($ch);
								curl_close($ch);
							}

							$this->session->set_flashdata('success', 'Nenly Quarantined livestock has been successfully added!'.$edit['stock']);
							redirect("website/sick");
						} else {
							$this->session->set_flashdata('error', 'Insufficient livestock!');
							redirect("website/sick");
						}
					}
				} else {
					redirect("website/sick");
				}
			} elseif ($data['action'] == 'edit') {
				if ($data['admin']->admin_level_kode == 1 || $data['admin']->admin_level_kode == 2) {
					$data['onload']				= 'nama_damaged';
					$where_damaged['id_damaged']	= $filter2;
					$damaged				= $this->ADM->get_damaged('*', $where_damaged);
					$data['id_damaged']	= ($this->input->post('id_damaged')) ? $this->input->post('id_damaged') : $damaged->id_damaged;
					$data['id_barang']	= ($this->input->post('id_barang')) ? $this->input->post('id_barang') : $damaged->id_barang;
					$data['returned']	= ($this->input->post('returned')) ? $this->input->post('returned') : $damaged->returned;
					$data['returnedo']	= $damaged->returned;
					$data['jumlah']	= ($this->input->post('jumlah')) ? $this->input->post('jumlah') : $damaged->jumlah;
					$data['comment_returned']	= ($this->input->post('comment_returned')) ? $this->input->post('comment_returned') : $damaged->comment_returned;
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$where_barang['id_barang'] = $data['id_barang'];
						$barang = $this->ADM->get_barang('*', $where_barang);
						$e_barang['stock'] = $barang->stock + $data['returned'];
						$where_edit['id_damaged']	= $data['id_damaged'];
						$edit['returned']	= $data['returned'] + $data['returnedo'];
						$edit['jumlah']	= $data['jumlah'] - $data['returned'];
						$edit['comment_returned']	= $data['comment_returned'];
						$this->ADM->update_damaged($where_edit, $edit);
						$this->ADM->update_barang($where_barang, $e_barang);
						$this->session->set_flashdata('success', $data["returned"].' Livestocks has been returned successfully!,');
						redirect("website/sick");
					}
				} else {
					redirect("website/sick");
				}
			} elseif ($data['action'] == 'hapus') {
				$where_delete['id_damaged']		= validasi_sql($filter2);
				$this->ADM->delete_damaged($where_delete);
				$this->session->set_flashdata('success', 'Quarantined livestock has been successfully removed!');
				redirect("website/sick");
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}
	//FUNCTION livestock death recorded
	public function dead($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Dead Livestocks';
			$data['content'] 			= 'admin/content/website/dead';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'id_barang' => 'Animal name'
			);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('id_barang' => 'ANIMAL NAME');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'id_barang';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_damaged[$data['cari']]	= $data['q'];
				$where_damaged['status_pergerakan'] 	= 1;
				$data['jml_data']			= $this->ADM->count_all_damaged($where_damaged, $like_damaged);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			} elseif ($data['action'] == 'tambah') {
				if ($data['admin']->admin_level_kode == 1 || $data['admin']->admin_level_kode == 2) {
					$data['onload']				= 'supplier';
					$data['id_barang']	= ($this->input->post('id_barang')) ? $this->input->post('id_barang') : '';
					$data['reason']	= ($this->input->post('reason')) ? $this->input->post('reason') : '';
					$data['jumlah']	= ($this->input->post('jumlah')) ? $this->input->post('jumlah') : '';
					$data['comment']	= ($this->input->post('comment')) ? $this->input->post('comment') : '';
					$simpan						= $this->input->post('simpan');
					if ($simpan) {
						$where_barang['id_barang']	= $data['id_barang'];
						$barang	= $this->ADM->get_barang('*', $where_barang);

						$where_limitstock['limitstock_id']	= 1;
						$limitstock	= $this->ADM->get_limitstock('*', $where_limitstock);

						if ($barang->stock >= $data['jumlah']) {
							$insert['id_barang']			= validasi_sql($data['id_barang']);
							$insert['reason']			= validasi_sql($data['reason']);
							$insert['comment']			= validasi_sql($data['comment']);
							$insert['jumlah']				= validasi_sql($data['jumlah']);
							$insert['admin_user']			= $this->session->userdata('admin_user');
							$insert['status_pergerakan']	= 1;
							$this->ADM->insert_damaged($insert);


							$where_edit['id_barang']	= $data['id_barang'];
							$edit['stock']	= $barang->stock - $data['jumlah'];
							$this->ADM->update_barang($where_edit, $edit);

							if ($barang->stock <= $limitstock->stock) {
								$message = "Livestock with name " . $barang->nama_barang . " less than the minimum livestock limit";
								$user_id = 4444;
								$url = "https://www.wms.ngodings.com";
								$headings = "LMS - Livestock Warning";
								$img = "https://www.wms.ngodings.com/assets/3691adaa4a69024b73dc5c1ddb3c43ea.png";


								$content = array(
									"en" => "$message"
								);
								$headings = array(
									"en" => "$headings"
								);
								$fields = array(
									'app_id' => "13219ce1-3c03-40bb-9043-13325e84a94c",
									'filters' => array(array("field" => "tag", "key" => "user_id", "relation" => "=", "value" => "$user_id")),
									'url' => $url,
									'contents' => $content,
									'chrome_web_icon' => $img,
									'headings' => $headings
								);
								$fields = json_encode($fields);
								print("\nJSON sent:\n");
								print($fields);
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
								curl_setopt($ch, CURLOPT_HTTPHEADER, array(
									'Content-Type: application/json; charset=utf-8',
									'Authorization: Basic ZTE1NzBjY2MtMTE1YS00NjA0LTllNzctNTJjNTZmZGU0YmFm'
								));
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
								curl_setopt($ch, CURLOPT_HEADER, FALSE);
								curl_setopt($ch, CURLOPT_POST, TRUE);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
								$response = curl_exec($ch);
								curl_close($ch);
							}

							$this->session->set_flashdata('success', 'New dead livestock has been successfully added!');
							redirect("website/dead");
						} else {
							$this->session->set_flashdata('error', 'Insufficient livestock!');
							redirect("website/dead");
						}
					}
				} else {
					redirect("website/dead");
				}
			} elseif ($data['action'] == 'hapus') {
				$where_delete['id_damaged']		= validasi_sql($filter2);
				$this->ADM->delete_damaged($where_delete);
				$this->session->set_flashdata('success', 'Dead livestock has been successfully removed!');
				redirect("website/dead");
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}

	//FUNCTION INCOMING Stocks REPORT
	public function laporanmasuk($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Incoming Livestocks Report';
			$data['content'] 			= 'admin/content/website/laporanmasuk';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'id_barang' => 'Animal name'
			);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('id_barang' => 'ANIMAL NAME');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'id_barang';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_transaksi[$data['cari']]	= $data['q'];
				$where_transaksi['status_pergerakan'] 	= 1;
				$data['jml_data']			= $this->ADM->count_all_transaksi($where_transaksi, $like_transaksi);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}

	public function laporanmasukpdf()
	{
		$web					= $this->ADM->identitaswebsite();
		$where_admin['admin_user']		= $this->session->userdata('admin_user');
		$data['admin']					= $this->ADM->get_admin('', $where_admin);
		$data['title'] = 'Print PDF of Incoming Livestocks';
		$where_transaksi['status_pergerakan'] 	= 1;
		$data['jml_data']			= $this->ADM->count_all_transaksi($where_transaksi, '');
		// echo PDF_HEADER_LOGO;exit;
		$this->load->view('admin/content/website/pdf/laporanmasuk', $data);
		$html = $this->output->get_output();
		// set document information
		$this->tcpdf->SetCreator(PDF_CREATOR);
		$this->tcpdf->SetAuthor('-----');
		$this->tcpdf->SetTitle('Incoming Livestocks');
		$this->tcpdf->SetSubject('Incoming Livestock');

		$this->tcpdf->SetHeaderData('', 33.33, $web->identitas_deskripsi, "");
		$this->tcpdf->AddPage();
		$this->tcpdf->writeHTML($html, true, false, true, false, '');
		$this->tcpdf->LastPage();
		$this->tcpdf->Output('Incoming_livestocks_Report.pdf', 'I');
	}

	//FUNCTION EXIT Stocks REPORT
	public function laporankeluar($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Outgoing Livestocks Report';
			$data['content'] 			= 'admin/content/website/laporankeluar';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'id_barang' => 'Animal name'
			);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('id_barang' => 'ANIMAL NAME');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'id_barang';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_transaksi[$data['cari']]	= $data['q'];
				$where_transaksi['status_pergerakan'] 	= 2;
				$data['jml_data']			= $this->ADM->count_all_transaksi($where_transaksi, $like_transaksi);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}

	public function laporankeluarpdf()
	{
		$where_admin['admin_user']		= $this->session->userdata('admin_user');
		$data['admin']					= $this->ADM->get_admin('', $where_admin);
		$this->load->library('dompdf_gen');
		$data['title'] = 'Cetak PDF Barang Keluar';
		$where_transaksi['status_pergerakan'] 	= 2;
		$data['jml_data']			= $this->ADM->count_all_transaksi($where_transaksi, '');

		$this->load->view('admin/content/website/pdf/laporankeluar', $data);
		$paper_size  = 'A4'; //paper size
		$orientation = 'landscape'; //tipe format kertas
		$html = $this->output->get_output();
		$web = $this->ADM->identitaswebsite();

		$this->tcpdf->SetCreator(PDF_CREATOR);
		$this->tcpdf->SetAuthor('-----');
		$this->tcpdf->SetTitle('Outgoing Livestocks');
		$this->tcpdf->SetSubject('Outgoing Livestock');

		$this->tcpdf->SetHeaderData('', 33.33, $web->identitas_deskripsi, "");
		$this->tcpdf->AddPage();
		$this->tcpdf->writeHTML($html, true, false, true, false, '');
		$this->tcpdf->LastPage();
		$this->tcpdf->Output('Outgoing_livestocks_Report.pdf', 'I');
	}

	//FUNCTION LAPORAN PENYESUAIAN
	public function laporanpenyesuaian($filter1 = '', $filter2 = '', $filter3 = '')
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$where_admin['admin_user'] 	= $this->session->userdata('admin_user');
			$data['admin'] 				= $this->ADM->get_admin('', $where_admin);
			$data['web']					= $this->ADM->identitaswebsite();
			@date_default_timezone_set('Asia/Jakarta');
			$data['dashboard_info']		= FALSE;
			$data['breadcrumb']				= 'Report Adjustment';
			$data['content'] 			= 'admin/content/website/laporanpenyesuaian';
			$data['menu_terpilih']		= '1';
			$data['submenu_terpilih']	= '13';
			$data['action']				= (empty($filter1)) ? 'view' : $filter1;
			$data['validate']			= array(
				'id_barang' => 'Animal name'
			);
			if ($data['action'] == 'view') {
				$data['berdasarkan']		= array('id_barang' => 'ANIMAL NAME');
				$data['cari']				= ($this->input->post('cari')) ? $this->input->post('cari') : 'id_barang';
				$data['q']					= ($this->input->post('q')) ? $this->input->post('q') : '';
				$data['halaman']			= (empty($filter2)) ? 1 : $filter2;
				$data['batas']				= 10;
				$data['page']				= ($data['halaman'] - 1) * $data['batas'];
				$like_transaksi[$data['cari']]	= $data['q'];
				$where_transaksi['status_pergerakan'] 	= 2;
				$data['jml_data']			= $this->ADM->count_all_transaksi($where_transaksi, $like_transaksi);
				$data['jml_halaman'] 		= ceil($data['jml_data'] / $data['batas']);
			}
			$this->load->vars($data);
			$this->load->view('admin/home');
		} else {
			redirect("wp_login");
		}
	}

	public function laporanpenyesuaianpdf()
	{
		$where_admin['admin_user']		= $this->session->userdata('admin_user');
		$data['admin']					= $this->ADM->get_admin('', $where_admin);
		$this->load->library('dompdf_gen');
		$data['title'] = 'Print PDF of Incoming & Outgoing Livestocks';
		$data['jml_data']			= $this->ADM->count_all_transaksi('', '');
		$this->load->view('admin/content/website/pdf/laporanpenyesuaian', $data);
		$html = $this->output->get_output();
		// exit;

		$web = $this->ADM->identitaswebsite();

		$this->tcpdf->SetCreator(PDF_CREATOR);
		$this->tcpdf->SetAuthor('-----');
		$this->tcpdf->SetTitle('In an d Out Livestocks');
		$this->tcpdf->SetSubject('In an d Out Livestock');

		$this->tcpdf->SetHeaderData('', 33.33, $web->identitas_deskripsi, "");
		$this->tcpdf->AddPage();
		$this->tcpdf->writeHTML($html, true, false, true, false, '');
		$this->tcpdf->LastPage();
		$this->tcpdf->Output('in&outStocks.pdf', 'I');
	}

	//CKEDITOR
	private function ckeditor($text)
	{
		return '
		<script type="text/javascript" src="' . base_url() . 'editor/ckeditor.js"></script>
		<script type="text/javascript">
		var editor = CKEDITOR.replace("' . $text . '",
		{
			filebrowserBrowseUrl 	  : "' . base_url() . 'finder/ckfinder.html",
			filebrowserImageBrowseUrl : "' . base_url() . 'finder/ckfinder.html?Type=Images",
			filebrowserFlashBrowseUrl : "' . base_url() . 'finder/ckfinder.html?Type=Flash",
			filebrowserUploadUrl 	  : "' . base_url() . 'finder/core/connector/php/connector.php?command=QuickUpload&type=Files",
			filebrowserImageUploadUrl : "' . base_url() . 'finder/core/connector/php/connector.php?command=QuickUpload&type=Images",
			filebrowserFlashUploadUrl : "' . base_url() . 'finder/core/connector/php/connector.php?command=QuickUpload&type=Flash",
			filebrowserWindowWidth    : 900,
			filebrowserWindowHeight   : 700,
			toolbarStartupExpanded 	  : false,
			height					  : 400	
		}
		);
	</script>';
	}

	public function getInfo($id =''){
			$this->db->where('id',$id);
 $query=$this->db->get('feeds');
 print_r(json_encode($query->result()));
	}
}
