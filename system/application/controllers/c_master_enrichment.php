<?php
/* 	
	GIOV Solution - Keep IT Simple
*/

//class of master_jual_produk
class C_master_enrichment extends Controller {

	//constructor
	function C_master_enrichment(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_enrichment', '', TRUE);
		
		
	}
	
	function get_info_pajak(){
		$result=$this->m_public_function->get_info_pajak();
		echo $result;
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_enrichment');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_jual_produk');
	}
	
	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$opsi_status=(isset($_POST['opsi_status']) ? @$_POST['opsi_status'] : @$_GET['opsi_status']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$group=(isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		$shift=(isset($_POST['shift']) ? @$_POST['shift'] : @$_GET['shift']);
		
		$data["jenis"]='Produk';
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}else if($periode=="tanggal"){
			$date = substr($tgl_awal,8,2);
			$month = substr($tgl_awal,5,2);
			$year = substr($tgl_awal,0,4);
			$tgl_awal_show = $date.'-'.$month.'-'.$year;
			
			$date_akhir = substr($tgl_akhir,8,2);
			$month_akhir = substr($tgl_akhir,5,2);
			$year_akhir = substr($tgl_akhir,0,4);
			$tgl_akhir_show = $date_akhir.'-'.$month_akhir.'-'.$year_akhir;
			
			//$tgl_awal_show = $tgl_awal;
			//$tgl_awal_show = date("d-m-Y", $tgl_awal);
			//$tgl_akhir_show = $tgl_akhir;
			//$tgl_akhir_show = date("d-m-Y", $tgl_akhir);
			$data["periode"]="Periode : ".$tgl_awal_show." s/d ".$tgl_akhir_show.", ";
		}

		$data["data_print"]=$this->m_master_enrichment->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$opsi_status,$group,$shift);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		if($opsi=='rekap'){
			$data["opsi"]='Rekap';
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_jual_tanggal.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_rekap_jual_customer.php",$data,TRUE);break;
				case "Voucher": $print_view=$this->load->view("main/p_rekap_jual_voucher.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_jual.php",$data,TRUE);break;
			}
			$print_file=fopen("print/report_jproduk.html","w");
			fwrite($print_file, $print_view);
			echo '1'; 
			
		}else if($opsi=='detail'){
			$data["opsi"]='Detail';
			if($group =='No Faktur BPOM'){
				$data["group"]='No Faktur BPOM';
			}else{
				$data["group"]='No Faktur';
			}
			if ($opsi_status=='semua') {	
					switch($group){
					case "Tanggal": $print_view=$this->load->view("main/p_detail_jual_tanggal.php",$data,TRUE);break;
					case "Tanggal 2 (PPN)": $print_view=$this->load->view("main/p_detail_jual_tanggal2.php",$data,TRUE);break;
					case "Customer": $print_view=$this->load->view("main/p_detail_jual_customer.php",$data,TRUE);break;
					case "Produk": $print_view=$this->load->view("main/p_detail_jual_produk.php",$data,TRUE);break;
					case "Sales": $print_view=$this->load->view("main/p_detail_jual_sales.php",$data,TRUE);break;
					case "Jenis Diskon": $print_view=$this->load->view("main/p_detail_jual_diskon.php",$data,TRUE);break;
					case "Group 1": $print_view=$this->load->view("main/p_detail_jual_group.php",$data,TRUE);break;
					case "No Faktur BPOM": $print_view=$this->load->view("main/p_detail_jual_semua.php",$data,TRUE);break;//tambah ini
					default: $print_view=$this->load->view("main/p_detail_jual_semua.php",$data,TRUE);break;
				} 
			} else if ($opsi_status=='tertutup') {
					switch($group){
					case "Tanggal": $print_view=$this->load->view("main/p_detail_jual_tanggal.php",$data,TRUE);break;
					case "Tanggal 2 (PPN)": $print_view=$this->load->view("main/p_detail_jual_tanggal2.php",$data,TRUE);break;
					case "Customer": $print_view=$this->load->view("main/p_detail_jual_customer.php",$data,TRUE);break;
					case "Produk": $print_view=$this->load->view("main/p_detail_jual_produk.php",$data,TRUE);break;
					case "Sales": $print_view=$this->load->view("main/p_detail_jual_sales.php",$data,TRUE);break;
					case "Jenis Diskon": $print_view=$this->load->view("main/p_detail_jual_diskon.php",$data,TRUE);break;
					case "No Faktur BPOM": $print_view=$this->load->view("main/p_detail_jual.php",$data,TRUE);break;//tambah ini
					default: $print_view=$this->load->view("main/p_detail_jual.php",$data,TRUE);break;
				}
			}
			
			
			$print_file=fopen("print/report_jproduk.html","w");
			fwrite($print_file, $print_view);
			fclose($print_file);
			echo '1'; 
		}
		else if($opsi=='nota_panjang'){
			$data["opsi"]='Nota Panjang';
			$data["group"]='No Faktur';
			switch($group){
				default: $print_view=$this->load->view("main/p_detail_jual.php",$data,TRUE);break;
			}
			$print_file=fopen("print/report_jproduk.html","w");
			fwrite($print_file, $print_view);
			fclose($print_file);
			echo '1'; 
			
		}
	}
	
	function get_supplier_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_enrichment->get_supplier_list($query,$start,$end);
		echo $result;
	}
	
	
	
	function get_bank_list(){
		$result=$this->m_public_function->get_bank_list();
		echo $result;
	}

	function get_transaction_setting(){
		$result=$this->m_master_enrichment->get_uang_pangkal_enrichment();
		echo $result;
	}
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_enrichment->get_customer_list($query,$start,$end);
		//Mestie ntik disini di mix, tampilkan student yang blom perna melakukan enrich registrasi.. gmn menurutmu?
		echo $result;
	}

	function get_class_lp_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_enrichment->get_class_lp_list($query,$start,$end);
		echo $result;
	}
	
	function get_enrichment_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$aktif = trim(@$_POST["aktif"]);
		$result = $this->m_master_enrichment->get_enrichment_list($query,$start,$end,$aktif);
		echo $result;
	}
	
	function get_satuan_list(){
		$result = $this->m_public_function->get_satuan_list();
		echo $result;
	}
	
	function get_satuan_bydjproduk_list(){
		$query = (integer) (isset($_POST['query']) ? $_POST['query'] : 0);
		$produk_id = (integer) (isset($_POST['produk_id']) ? $_POST['produk_id'] : 0);
		$result = $this->m_master_enrichment->get_satuan_bydjproduk_list($query,$produk_id);
		echo $result;
	}
	
	function get_kwitansi_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_kwitansi_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_cek_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_cek_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_card_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_card_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_transfer_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_transfer_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_tunai_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_tunai_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_voucher_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_voucher_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function  get_voucher_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_enrichment->get_voucher_list($query,$start,$end);
		echo $result;
	}
	
	function  get_kwitansi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		//$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		//$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$start=0;
		$end=10;
		$kwitansi_cust=trim(@$_POST["kwitansi_cust"]);
		$result=$this->m_public_function->get_kwitansi_list($query,$start,$end,$kwitansi_cust);
		echo $result;
	}
	
	function get_member_by_cust(){
		$member_cust = (integer) (isset($_POST['member_cust']) ? $_POST['member_cust'] : $_GET['member_cust']);
		$result=$this->m_public_function->get_member_by_cust($member_cust);
		echo $result;
	}
	
	function get_nik(){
		$karyawan_id = (integer) (isset($_POST['karyawan_id']) ? $_POST['karyawan_id'] : $_GET['karyawan_id']);
		$result=$this->m_public_function->get_auto_karyawan_sip($karyawan_id); //untuk mendapatkan nik karyawan
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_detail_enrichment_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_enrichment->detail_detail_enrichment_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_enrichment->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	function detail_detail_jual_produk_insert(){
		//POST variable here
		$denrich_id = $_POST['denrich_id']; // Get our array back and translate it :
		$array_denrich_id = json_decode(stripslashes($denrich_id));
		
		$dproduk_master=trim(@$_POST["dproduk_master"]);
		
		$denrich_subtot = $_POST['denrich_subtot']; // Get our array back and translate it :
		$array_denrich_subtot = json_decode(stripslashes($denrich_subtot));
		
		$denrich_jasa = $_POST['denrich_jasa']; // Get our array back and translate it :
		$array_denrich_jasa = json_decode(stripslashes($denrich_jasa));
		
		$denrich_satuan = $_POST['denrich_satuan']; // Get our array back and translate it :
		$array_denrich_satuan = json_decode(stripslashes($denrich_satuan));
		
		$denrich_jumlah = $_POST['denrich_jumlah']; // Get our array back and translate it :
		$array_denrich_jumlah = json_decode(stripslashes($denrich_jumlah));
		
		$denrich_harga = $_POST['denrich_harga']; // Get our array back and translate it :
		$array_denrich_price = json_decode(stripslashes($denrich_harga));
		
		$dproduk_subtotal_net = $_POST['dproduk_subtotal_net']; // Get our array back and translate it :
		$array_dproduk_subtotal_net = json_decode(stripslashes($dproduk_subtotal_net));
		
		$denrich_disc = $_POST['denrich_disc']; // Get our array back and translate it :
		$array_denrich_disc = json_decode(stripslashes($denrich_disc));
		
		$denrich_diskon_jenis = $_POST['denrich_diskon_jenis']; // Get our array back and translate it :
		$array_denrich_diskon_jenis = json_decode(stripslashes($denrich_diskon_jenis));
		
		$dproduk_sales = $_POST['dproduk_sales']; // Get our array back and translate it :
		$array_dproduk_sales = json_decode(stripslashes($dproduk_sales));
		
		$cetak_jproduk=trim(@$_POST['cetak_jproduk']);
		
		$result=$this->m_master_enrichment->detail_detail_jual_produk_insert($array_denrich_id ,$dproduk_master ,$array_denrich_subtot, $array_denrich_jasa ,$array_denrich_satuan ,$array_denrich_jumlah ,$array_denrich_price ,$array_dproduk_subtotal_net ,$array_denrich_disc ,$array_denrich_diskon_jenis ,$array_dproduk_sales ,$cetak_jproduk);
		echo $result;
	}
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->master_enrichment_list();
				break;
			case "UPDATE":
				$this->master_enrichment_update();
				break;
			case "CREATE":
				$this->master_enrichment_create();
				break;
			case "CEK":
				$this->master_enrichment_pengecekan();
				break;	
			case "DELETE":
				$this->master_enrichment_delete();
				break;
			case "SEARCH":
				$this->master_enrichment_search();
				break;
			case "PRINT":
				$this->master_enrichment_print();
				break;
			case "EXCEL":
				$this->master_jual_produk_export_excel();
				break;
			case "BATAL":
				$this->master_enrichment_batal();
				break;
            case "DDELETE":
				$this->detail_jual_produk_delete();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function master_enrichment_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_enrichment->master_enrichment_list($query,$start,$end);
		echo $result;
	}

	function get_allkaryawan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_enrichment->get_allkaryawan_list($query,$start,$end);
		echo $result;
	}
	
	function master_enrichment_pengecekan(){
	
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
	
		$result=$this->m_public_function->pengecekan_dokumen($tanggal_pengecekan);
		echo $result;
	}
	
	//function for update record
	function master_enrichment_update(){

		//POST variable here
		$cetak_enrichment=trim(@$_POST["cetak_enrichment"]);
		$enrich_id=trim(@$_POST["enrich_id"]);
		$jproduk_grooming=trim(@$_POST["jproduk_grooming"]);
		$jproduk_nobukti=trim(@$_POST["enrich_no"]);
		$jproduk_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jproduk_nobukti);
		$jproduk_nobukti=str_replace("'", '"',$jproduk_nobukti);
		$jproduk_nobukti_pajak=trim(@$_POST["jproduk_nobukti_pajak"]);
		$jproduk_nobukti_pajak=str_replace("/(<\/?)(p)([^>]*>)", "",$jproduk_nobukti_pajak);
		$jproduk_nobukti_pajak=str_replace("'", '"',$jproduk_nobukti_pajak);
		
		$jproduk_cust=trim(@$_POST["enrich_student"]);
		$enrich_tanggal=trim(@$_POST["enrich_tanggal"]);
		$jproduk_diskon=trim(@$_POST["jproduk_diskon"]);
		
		$enrich_stat_dok=trim(@$_POST["enrich_stat_dok"]);
		$enrich_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_stat_dok);
		$enrich_stat_dok=str_replace("'", '"',$enrich_stat_dok);
		
		$enrich_stat_time=trim(@$_POST["enrich_stat_time"]);
		$enrich_stat_time=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_stat_time);
		$enrich_stat_time=str_replace("'", '"',$enrich_stat_time);
		
		$enrich_cara=trim(@$_POST["enrich_cara"]);
		$enrich_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_cara);
		$enrich_cara=str_replace("'", '"',$enrich_cara);
		
		$enrich_cara2=trim(@$_POST["enrich_cara2"]);
		$enrich_cara2=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_cara2);
		$enrich_cara2=str_replace("'", '"',$enrich_cara2);
		
		$enrich_cara3=trim(@$_POST["enrich_cara3"]);
		$enrich_cara3=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_cara3);
		$enrich_cara3=str_replace("'", '"',$enrich_cara3);
		
		$enrich_note=trim(@$_POST["enrich_note"]);
		$enrich_note=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_note);
		$enrich_note=str_replace("'", '"',$enrich_note);
		
		$jproduk_ket_disk=trim(@$_POST["jproduk_ket_disk"]);
		$jproduk_ket_disk=str_replace("/(<\/?)(p)([^>]*>)", "",$jproduk_ket_disk);
		$jproduk_ket_disk=str_replace("'", '"',$jproduk_ket_disk);
		
		$enrich_cashback=trim($_POST["enrich_cashback"]);
		
		//tunai
		$enrich_tunai_nilai=trim($_POST["enrich_tunai_nilai"]);
		//tunai-2
		$enrich_tunai_nilai2=trim($_POST["enrich_tunai_nilai2"]);
		//tunai-3
		$enrich_tunai_nilai3=trim($_POST["enrich_tunai_nilai3"]);
		//voucher
		$enrich_voucher_no=trim($_POST["enrich_voucher_no"]);
		$enrich_voucher_cashback=trim($_POST["enrich_voucher_cashback"]);
		//voucher-2
		$enrich_voucher_no2=trim($_POST["enrich_voucher_no2"]);
		$enrich_voucher_cashback2=trim($_POST["enrich_voucher_cashback2"]);
		//voucher-3
		$enrich_voucher_no3=trim($_POST["enrich_voucher_no3"]);
		$enrich_voucher_cashback3=trim($_POST["enrich_voucher_cashback3"]);
		
		//bayar
		$enrich_total_bayar=trim($_POST["enrich_total_bayar"]);
		$enrich_subtotal=trim($_POST["enrich_subtotal"]);
		$enrich_total_biaya=trim($_POST["enrich_total_biaya"]);
		$enrich_kembalian=trim($_POST["enrich_kembalian"]);
		$enrich_hutang=trim($_POST["enrich_hutang"]);
		//card
		$enrich_card_nama=trim($_POST["enrich_card_nama"]);
		$enrich_card_edc=trim($_POST["enrich_card_edc"]);
		$enrich_card_no=trim($_POST["enrich_card_no"]);
		$enrich_card_nilai=trim($_POST["enrich_card_nilai"]);
		//card-2
		$enrich_card_nama2=trim($_POST["enrich_card_nama2"]);
		$enrich_card_edc2=trim($_POST["enrich_card_edc2"]);
		$enrich_card_no2=trim($_POST["enrich_card_no2"]);
		$enrich_card_nilai2=trim($_POST["enrich_card_nilai2"]);
		//card-3
		$enrich_card_nama3=trim($_POST["enrich_card_nama3"]);
		$enrich_card_edc3=trim($_POST["enrich_card_edc3"]);
		$enrich_card_no3=trim($_POST["enrich_card_no3"]);
		$enrich_card_nilai3=trim($_POST["enrich_card_nilai3"]);
		//kwitansi
		$enrich_kwitansi_no=trim($_POST["enrich_kwitansi_no"]);
		$enrich_kwitansi_nama=trim(@$_POST["enrich_kwitansi_nama"]);
		$enrich_kwitansi_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_kwitansi_nama);
		$enrich_kwitansi_nama=str_replace("'", '"',$enrich_kwitansi_nama);
		$enrich_kwitansi_nilai=trim($_POST["enrich_kwitansi_nilai"]);
		$enrich_kwitansi_id=trim($_POST["enrich_kwitansi_id"]);
		//kwitansi-2
		$enrich_kwitansi_no2=trim($_POST["enrich_kwitansi_no2"]);
		$enrich_kwitansi_nama2=trim(@$_POST["enrich_kwitansi_nama2"]);
		$enrich_kwitansi_nama2=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_kwitansi_nama2);
		$enrich_kwitansi_nama2=str_replace("'", '"',$enrich_kwitansi_nama2);
		$enrich_kwitansi_nilai2=trim($_POST["enrich_kwitansi_nilai2"]);
		$enrich_kwitansi_id2=trim($_POST["enrich_kwitansi_id2"]);
		//kwitansi-3
		$enrich_kwitansi_no3=trim($_POST["enrich_kwitansi_no3"]);
		$enrich_kwitansi_nama3=trim(@$_POST["enrich_kwitansi_nama3"]);
		$enrich_kwitansi_nama3=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_kwitansi_nama3);
		$enrich_kwitansi_nama3=str_replace("'", '"',$enrich_kwitansi_nama3);
		$enrich_kwitansi_nilai3=trim($_POST["enrich_kwitansi_nilai3"]);
		$enrich_kwitansi_id3=trim($_POST["enrich_kwitansi_id3"]);
		//cek
		$enrich_cek_nama=trim($_POST["enrich_cek_nama"]);
		$enrich_cek_no=trim($_POST["enrich_cek_no"]);
		$enrich_cek_valid=trim($_POST["enrich_cek_valid"]);
		$enrich_cek_bank=trim($_POST["enrich_cek_bank"]);
		$enrich_cek_nilai=trim($_POST["enrich_cek_nilai"]);
		//cek-2
		$enrich_cek_nama2=trim($_POST["enrich_cek_nama2"]);
		$enrich_cek_no2=trim($_POST["enrich_cek_no2"]);
		$enrich_cek_valid2=trim($_POST["enrich_cek_valid2"]);
		$enrich_cek_bank2=trim($_POST["enrich_cek_bank2"]);
		$enrich_cek_nilai2=trim($_POST["enrich_cek_nilai2"]);
		//cek-3
		$enrich_cek_nama3=trim($_POST["enrich_cek_nama3"]);
		$enrich_cek_no3=trim($_POST["enrich_cek_no3"]);
		$enrich_cek_valid3=trim($_POST["enrich_cek_valid3"]);
		$enrich_cek_bank3=trim($_POST["enrich_cek_bank3"]);
		$enrich_cek_nilai3=trim($_POST["enrich_cek_nilai3"]);
		//transfer
		$enrich_transfer_bank=trim($_POST["enrich_transfer_bank"]);
		$enrich_transfer_nama=trim($_POST["enrich_transfer_nama"]);
		$enrich_transfer_nilai=trim($_POST["enrich_transfer_nilai"]);
		//transfer-2
		$enrich_transfer_bank2=trim($_POST["enrich_transfer_bank2"]);
		$enrich_transfer_nama2=trim($_POST["enrich_transfer_nama2"]);
		$enrich_transfer_nilai2=trim($_POST["enrich_transfer_nilai2"]);
		//transfer-3
		$enrich_transfer_bank3=trim($_POST["enrich_transfer_bank3"]);
		$enrich_transfer_nama3=trim($_POST["enrich_transfer_nama3"]);
		$enrich_transfer_nilai3=trim($_POST["enrich_transfer_nilai3"]);
		
		//Data Detail Penjualan Produk
		$denrich_id = $_POST['denrich_id']; // Get our array back and translate it :
		$array_denrich_id = json_decode(stripslashes($denrich_id));
		
		$denrich_jasa = $_POST['denrich_jasa']; // Get our array back and translate it :
		$array_denrich_jasa = json_decode(stripslashes($denrich_jasa));
		
		$denrich_satuan = $_POST['denrich_satuan']; // Get our array back and translate it :
		$array_denrich_satuan = json_decode(stripslashes($denrich_satuan));
		
		$denrich_jumlah = $_POST['denrich_jumlah']; // Get our array back and translate it :
		$array_denrich_jumlah = json_decode(stripslashes($denrich_jumlah));
		
		$denrich_harga = $_POST['denrich_price']; // Get our array back and translate it :
		$array_denrich_price = json_decode(stripslashes($denrich_harga));
		
		$denrich_diskon_jenis = $_POST['denrich_diskon_jenis']; // Get our array back and translate it :
		$array_denrich_diskon_jenis = json_decode(stripslashes($denrich_diskon_jenis));
		
		$denrich_disc = $_POST['denrich_disc']; // Get our array back and translate it :
		$array_denrich_disc = json_decode(stripslashes($denrich_disc));
		
		$denrich_subtot = $_POST['denrich_subtot']; // Get our array back and translate it :
		$array_denrich_subtot = json_decode(stripslashes($denrich_subtot));
		
		$result = $this->m_master_enrichment->master_enrichment_update($enrich_id ,$jproduk_nobukti ,$jproduk_cust , $enrich_tanggal
																		 ,$enrich_stat_dok ,$enrich_stat_time ,$jproduk_diskon ,$enrich_cara ,$enrich_cara2
																		 ,$enrich_cara3 ,$enrich_note ,$enrich_cashback
																		 ,$enrich_tunai_nilai ,$enrich_tunai_nilai2 ,$enrich_tunai_nilai3
																		 ,$enrich_voucher_no ,$enrich_voucher_cashback ,$enrich_voucher_no2
																		 ,$enrich_voucher_cashback2 ,$enrich_voucher_no3
																		 ,$enrich_voucher_cashback3 ,$enrich_total_bayar ,$enrich_subtotal
																		 ,$enrich_total_biaya , $enrich_kembalian, $enrich_hutang ,$enrich_kwitansi_no
																		 ,$enrich_kwitansi_nama ,$enrich_kwitansi_nilai ,$enrich_kwitansi_no2
																		 ,$enrich_kwitansi_nama2 ,$enrich_kwitansi_nilai2 ,$enrich_kwitansi_no3
																		 ,$enrich_kwitansi_nama3 ,$enrich_kwitansi_nilai3 ,$enrich_card_nama
																		 ,$enrich_card_edc ,$enrich_card_no ,$enrich_card_nilai
																		 ,$enrich_card_nama2 ,$enrich_card_edc2 ,$enrich_card_no2
																		 ,$enrich_card_nilai2 ,$enrich_card_nama3 ,$enrich_card_edc3
																		 ,$enrich_card_no3 ,$enrich_card_nilai3 , $enrich_cek_nama
																		 ,$enrich_cek_no ,$enrich_cek_valid ,$enrich_cek_bank
																		 ,$enrich_cek_nilai ,$enrich_cek_nama2 ,$enrich_cek_no2
																		 ,$enrich_cek_valid2 ,$enrich_cek_bank2 ,$enrich_cek_nilai2
																		 ,$enrich_cek_nama3 ,$enrich_cek_no3 ,$enrich_cek_valid3
																		 ,$enrich_cek_bank3 ,$enrich_cek_nilai3 ,$enrich_transfer_bank
																		 ,$enrich_transfer_nama ,$enrich_transfer_nilai ,$enrich_transfer_bank2
																		 ,$enrich_transfer_nama2 ,$enrich_transfer_nilai2
																		 ,$enrich_transfer_bank3 ,$enrich_transfer_nama3 ,$enrich_transfer_nilai3
																		 ,$cetak_enrichment ,$jproduk_ket_disk
																		 ,$array_denrich_id ,$array_denrich_jasa ,$array_denrich_satuan
																		 ,$array_denrich_jumlah ,$array_denrich_price ,$array_denrich_diskon_jenis
																		 ,$array_denrich_disc ,$array_denrich_subtot, $jproduk_grooming, $enrich_kwitansi_id, $enrich_kwitansi_id2, $enrich_kwitansi_id3,$jproduk_nobukti_pajak);
		echo $result;
	}
	
	//function for create new record
	function master_enrichment_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$cetak_jproduk=trim(@$_POST["cetak_enrichment"]);
		$jproduk_grooming=trim(@$_POST["jproduk_grooming"]);
		$enrich_no=trim(@$_POST["enrich_no"]);
		$enrich_no=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_no);
		$enrich_no=str_replace("'", '"',$enrich_no);
		$enrich_student=trim(@$_POST["enrich_student"]);
		$enrich_tanggal=trim(@$_POST["enrich_tanggal"]);
		$enrich_class=trim(@$_POST["enrich_class"]);
		$enrich_cara=trim(@$_POST["enrich_cara"]);
		$enrich_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_cara);
		$enrich_cara=str_replace("'", '"',$enrich_cara);
		
		$enrich_cara2=trim(@$_POST["enrich_cara2"]);
		$enrich_cara2=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_cara2);
		$enrich_cara2=str_replace("'", '"',$enrich_cara2);
		
		$enrich_cara3=trim(@$_POST["enrich_cara3"]);
		$enrich_cara3=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_cara3);
		$enrich_cara3=str_replace("'", '"',$enrich_cara3);
		
		$enrich_stat_dok=trim(@$_POST["enrich_stat_dok"]);
		$enrich_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_stat_dok);
		$enrich_stat_dok=str_replace("'", '"',$enrich_stat_dok);
		
		$enrich_stat_time=trim(@$_POST["enrich_stat_time"]);
		$enrich_stat_time=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_stat_time);
		$enrich_stat_time=str_replace("'", '"',$enrich_stat_time);
		
		
		$enrich_note=trim(@$_POST["enrich_note"]);
		$enrich_note=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_note);
		$enrich_note=str_replace("'", '"',$enrich_note);
		
		$jproduk_ket_disk=trim(@$_POST["jproduk_ket_disk"]);
		$jproduk_ket_disk=str_replace("/(<\/?)(p)([^>]*>)", "",$jproduk_ket_disk);
		$jproduk_ket_disk=str_replace("'", '"',$jproduk_ket_disk);
		
		$enrich_cashback=trim($_POST["enrich_cashback"]);
		// $jproduk_voucher=trim($_POST["jproduk_voucher"]);
		//tunai
		$enrich_tunai_nilai=trim($_POST["enrich_tunai_nilai"]);
		//tunai-2
		$enrich_tunai_nilai2=trim($_POST["enrich_tunai_nilai2"]);
		//tunai-3
		$enrich_tunai_nilai3=trim($_POST["enrich_tunai_nilai3"]);
		//voucher
		$enrich_voucher_no=trim($_POST["enrich_voucher_no"]);
		$enrich_voucher_cashback=trim($_POST["enrich_voucher_cashback"]);
		//voucher-2
		$enrich_voucher_no2=trim($_POST["enrich_voucher_no2"]);
		$enrich_voucher_cashback2=trim($_POST["enrich_voucher_cashback2"]);
		//voucher-3
		$enrich_voucher_no3=trim($_POST["enrich_voucher_no3"]);
		$enrich_voucher_cashback3=trim($_POST["enrich_voucher_cashback3"]);
		//bayar
		$enrich_total_bayar=trim($_POST["enrich_total_bayar"]);
		$enrich_subtotal=trim($_POST["enrich_subtotal"]);
		$enrich_total_biaya=trim($_POST["enrich_total_biaya"]);
		$enrich_kembalian=trim($_POST["enrich_kembalian"]);
		$enrich_hutang=trim($_POST["enrich_hutang"]);
		//card
		$enrich_card_nama=trim($_POST["enrich_card_nama"]);
		$enrich_card_edc=trim($_POST["enrich_card_edc"]);
		$enrich_card_no=trim($_POST["enrich_card_no"]);
		$enrich_card_nilai=trim($_POST["enrich_card_nilai"]);
		//card-2
		$enrich_card_nama2=trim($_POST["enrich_card_nama2"]);
		$enrich_card_edc2=trim($_POST["enrich_card_edc2"]);
		$enrich_card_no2=trim($_POST["enrich_card_no2"]);
		$enrich_card_nilai2=trim($_POST["enrich_card_nilai2"]);
		//card-3
		$enrich_card_nama3=trim($_POST["enrich_card_nama3"]);
		$enrich_card_edc3=trim($_POST["enrich_card_edc3"]);
		$enrich_card_no3=trim($_POST["enrich_card_no3"]);
		$enrich_card_nilai3=trim($_POST["enrich_card_nilai3"]);
		//kwitansi
		$enrich_kwitansi_no=trim($_POST["enrich_kwitansi_no"]);
		$enrich_kwitansi_nama=trim(@$_POST["enrich_kwitansi_nama"]);
		$enrich_kwitansi_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_kwitansi_nama);
		$enrich_kwitansi_nama=str_replace("'", '"',$enrich_kwitansi_nama);
		$enrich_kwitansi_nilai=trim($_POST["enrich_kwitansi_nilai"]);
		$enrich_kwitansi_id=trim($_POST["enrich_kwitansi_id"]);
		//kwitansi-2
		$enrich_kwitansi_no2=trim($_POST["enrich_kwitansi_no2"]);
		$enrich_kwitansi_nama2=trim(@$_POST["enrich_kwitansi_nama2"]);
		$enrich_kwitansi_nama2=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_kwitansi_nama2);
		$enrich_kwitansi_nama2=str_replace("'", '"',$enrich_kwitansi_nama2);
		$enrich_kwitansi_nilai2=trim($_POST["enrich_kwitansi_nilai2"]);
		$enrich_kwitansi_id2=trim($_POST["enrich_kwitansi_id2"]);
		//kwitansi-3
		$enrich_kwitansi_no3=trim($_POST["enrich_kwitansi_no3"]);
		$enrich_kwitansi_nama3=trim(@$_POST["enrich_kwitansi_nama3"]);
		$enrich_kwitansi_nama3=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_kwitansi_nama3);
		$enrich_kwitansi_nama3=str_replace("'", '"',$enrich_kwitansi_nama3);
		$enrich_kwitansi_nilai3=trim($_POST["enrich_kwitansi_nilai3"]);
		$enrich_kwitansi_id3=trim($_POST["enrich_kwitansi_id3"]);
		//cek
		$enrich_cek_nama=trim($_POST["enrich_cek_nama"]);
		$enrich_cek_no=trim($_POST["enrich_cek_no"]);
		$enrich_cek_valid=trim($_POST["enrich_cek_valid"]);
		$enrich_cek_bank=trim($_POST["enrich_cek_bank"]);
		$enrich_cek_nilai=trim($_POST["enrich_cek_nilai"]);
		//cek-2
		$enrich_cek_nama2=trim($_POST["enrich_cek_nama2"]);
		$enrich_cek_no2=trim($_POST["enrich_cek_no2"]);
		$enrich_cek_valid2=trim($_POST["enrich_cek_valid2"]);
		$enrich_cek_bank2=trim($_POST["enrich_cek_bank2"]);
		$enrich_cek_nilai2=trim($_POST["enrich_cek_nilai2"]);
		//cek-3
		$enrich_cek_nama3=trim($_POST["enrich_cek_nama3"]);
		$enrich_cek_no3=trim($_POST["enrich_cek_no3"]);
		$enrich_cek_valid3=trim($_POST["enrich_cek_valid3"]);
		$enrich_cek_bank3=trim($_POST["enrich_cek_bank3"]);
		$enrich_cek_nilai3=trim($_POST["enrich_cek_nilai3"]);
		//transfer
		$enrich_transfer_bank=trim($_POST["enrich_transfer_bank"]);
		$enrich_transfer_nama=trim($_POST["enrich_transfer_nama"]);
		$enrich_transfer_nilai=trim($_POST["enrich_transfer_nilai"]);
		//transfer-2
		$enrich_transfer_bank2=trim($_POST["enrich_transfer_bank2"]);
		$enrich_transfer_nama2=trim($_POST["enrich_transfer_nama2"]);
		$enrich_transfer_nilai2=trim($_POST["enrich_transfer_nilai2"]);
		//transfer-3
		$enrich_transfer_bank3=trim($_POST["enrich_transfer_bank3"]);
		$enrich_transfer_nama3=trim($_POST["enrich_transfer_nama3"]);
		$enrich_transfer_nilai3=trim($_POST["enrich_transfer_nilai3"]);
		
		//Data Detail Penjualan Produk
		$denrich_id = $_POST['denrich_id']; // Get our array back and translate it :
		$array_denrich_id = json_decode(stripslashes($denrich_id));
		
		$denrich_jasa = $_POST['denrich_jasa']; // Get our array back and translate it :
		$array_denrich_jasa = json_decode(stripslashes($denrich_jasa));
		
		$denrich_satuan = $_POST['denrich_satuan']; // Get our array back and translate it :
		$array_denrich_satuan = json_decode(stripslashes($denrich_satuan));
		
		$denrich_jumlah = $_POST['denrich_jumlah']; // Get our array back and translate it :
		$array_denrich_jumlah = json_decode(stripslashes($denrich_jumlah));
		
		$denrich_price = $_POST['denrich_price']; // Get our array back and translate it :
		$array_denrich_price = json_decode(stripslashes($denrich_price));
		
		$denrich_diskon_jenis = $_POST['denrich_diskon_jenis']; // Get our array back and translate it :
		$array_denrich_diskon_jenis = json_decode(stripslashes($denrich_diskon_jenis));
		
		$denrich_disc = $_POST['denrich_disc']; // Get our array back and translate it :
		$array_denrich_disc = json_decode(stripslashes($denrich_disc));
		
		$denrich_subtot = $_POST['denrich_subtot']; // Get our array back and translate it :
		$array_denrich_subtot = json_decode(stripslashes($denrich_subtot));
		
		$result=$this->m_master_enrichment->master_enrichment_create($enrich_no ,$enrich_student ,$enrich_tanggal
																	   ,$enrich_stat_dok ,$enrich_stat_time ,$enrich_class ,$enrich_cara
																	   ,$enrich_cara2 ,$enrich_cara3 ,$enrich_note
																	   ,$enrich_cashback ,$enrich_tunai_nilai ,$enrich_tunai_nilai2
																	   ,$enrich_tunai_nilai3 , $enrich_voucher_no ,$enrich_voucher_cashback
																	   ,$enrich_voucher_no2 ,$enrich_voucher_cashback2 ,$enrich_voucher_no3
																	   ,$enrich_voucher_cashback3 ,$enrich_total_bayar ,$enrich_subtotal
																	   ,$enrich_total_biaya , $enrich_kembalian, $enrich_hutang ,$enrich_kwitansi_no
																	   ,$enrich_kwitansi_nama ,$enrich_kwitansi_nilai ,$enrich_kwitansi_no2
																	   ,$enrich_kwitansi_nama2 ,$enrich_kwitansi_nilai2 , $enrich_kwitansi_no3
																	   ,$enrich_kwitansi_nama3 ,$enrich_kwitansi_nilai3 , $enrich_card_nama
																	   ,$enrich_card_edc ,$enrich_card_no ,$enrich_card_nilai
																	   ,$enrich_card_nama2 ,$enrich_card_edc2 ,$enrich_card_no2
																	   ,$enrich_card_nilai2 ,$enrich_card_nama3 ,$enrich_card_edc3
																	   ,$enrich_card_no3 ,$enrich_card_nilai3 ,$enrich_cek_nama
																	   ,$enrich_cek_no ,$enrich_cek_valid ,$enrich_cek_bank
																	   ,$enrich_cek_nilai ,$enrich_cek_nama2 ,$enrich_cek_no2
																	   ,$enrich_cek_valid2 ,$enrich_cek_bank2 ,$enrich_cek_nilai2
																	   ,$enrich_cek_nama3 ,$enrich_cek_no3 ,$enrich_cek_valid3
																	   ,$enrich_cek_bank3 ,$enrich_cek_nilai3 , $enrich_transfer_bank
																	   ,$enrich_transfer_nama ,$enrich_transfer_nilai ,$enrich_transfer_bank2
																	   ,$enrich_transfer_nama2 ,$enrich_transfer_nilai2 , $enrich_transfer_bank3
																	   ,$enrich_transfer_nama3 ,$enrich_transfer_nilai3 , $cetak_jproduk
																	   ,$jproduk_ket_disk
																	   ,$array_denrich_id ,$array_denrich_jasa ,$array_denrich_satuan
																	   ,$array_denrich_jumlah ,$array_denrich_price ,$array_denrich_diskon_jenis
																	   ,$array_denrich_disc ,$array_denrich_subtot, /*$jproduk_grooming,*/ $enrich_kwitansi_id, $enrich_kwitansi_id2, $enrich_kwitansi_id3);
		echo $result;
	}

	//function for delete selected record
	function master_enrichment_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_enrichment->master_enrichment_delete($pkid);
		echo $result;
	}
    
    function detail_jual_produk_delete(){
        $denrich_id = trim(@$_POST["denrich_id"]); // Get our array back and translate it :
		$result=$this->m_master_enrichment->detail_jual_produk_delete($denrich_id);
		echo $result;
    }
	
	function master_enrichment_batal(){
		$jproduk_id=trim($_POST["jproduk_id"]);
		$enrich_tanggal=trim(@$_POST["enrich_tanggal"]);
		$result=$this->m_master_enrichment->master_enrichment_batal($jproduk_id, $enrich_tanggal);
		echo $result;
	}

	//function for advanced search
	function master_enrichment_search(){
		//POST varibale here
		$jproduk_nobukti=trim(@$_POST["jproduk_nobukti"]);
		$jproduk_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jproduk_nobukti);
		$jproduk_nobukti=str_replace("'", '"',$jproduk_nobukti);
		$jproduk_cust=trim(@$_POST["jproduk_cust"]);
		$enrich_tanggal=trim(@$_POST["enrich_tanggal"]);
		$enrich_tanggal_akhir=trim(@$_POST["enrich_tanggal_akhir"]);
		$jproduk_diskon=trim(@$_POST["jproduk_diskon"]);
		$enrich_cara=trim(@$_POST["enrich_cara"]);
		$enrich_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_cara);
		$enrich_cara=str_replace("'", '"',$enrich_cara);
		$enrich_note=trim(@$_POST["enrich_note"]);
		$enrich_note=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_note);
		$enrich_note=str_replace("'", '"',$enrich_note);
		$enrich_stat_dok=trim(@$_POST["enrich_stat_dok"]);
		$enrich_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_stat_dok);
		$enrich_stat_dok=str_replace("'", '"',$enrich_stat_dok);
		
		$jproduk_shift=trim(@$_POST["jproduk_shift"]);
		$jproduk_shift=str_replace("/(<\/?)(p)([^>]*>)", "",$jproduk_shift);
		$jproduk_shift=str_replace("'", '"',$jproduk_shift);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_enrichment->master_enrichment_search($jproduk_nobukti, $jproduk_cust, $enrich_tanggal, $enrich_tanggal_akhir, $jproduk_diskon, $enrich_cara, $enrich_note, $enrich_stat_dok, $jproduk_shift, $start, $end);
		echo $result;
	}


	function master_enrichment_print(){
  		//POST varibale here
		$jproduk_nobukti=trim(@$_POST["jproduk_nobukti"]);
		$jproduk_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jproduk_nobukti);
		$jproduk_nobukti=str_replace("'", '"',$jproduk_nobukti);
		$jproduk_cust=trim(@$_POST["jproduk_cust"]);
		$enrich_tanggal=trim(@$_POST["enrich_tanggal"]);
		$enrich_tanggal_akhir=trim(@$_POST["enrich_tanggal_akhir"]);
		$jproduk_diskon=trim(@$_POST["jproduk_diskon"]);
		$enrich_cara=trim(@$_POST["enrich_cara"]);
		$enrich_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_cara);
		$enrich_cara=str_replace("'", '"',$enrich_cara);
		$enrich_note=trim(@$_POST["enrich_note"]);
		$enrich_note=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_note);
		$enrich_note=str_replace("'", '"',$enrich_note);
		$enrich_stat_dok=trim(@$_POST["enrich_stat_dok"]);
		$enrich_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_stat_dok);
		$enrich_stat_dok=str_replace("'", '"',$enrich_stat_dok);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_master_enrichment->master_enrichment_print($jproduk_nobukti
																					,$jproduk_cust
																					,$enrich_tanggal
																					,$enrich_tanggal_akhir
																					,$jproduk_diskon
																					,$enrich_cara
																					,$enrich_note
																					,$enrich_stat_dok
																					,$option
																					,$filter);
		$print_view=$this->load->view("main/p_master_jual_produk.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/master_jual_produklist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function master_jual_produk_export_excel(){
		//POST varibale here
		$jproduk_nobukti=trim(@$_POST["jproduk_nobukti"]);
		$jproduk_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jproduk_nobukti);
		$jproduk_nobukti=str_replace("'", '"',$jproduk_nobukti);
		$jproduk_cust=trim(@$_POST["jproduk_cust"]);
		$enrich_tanggal=trim(@$_POST["enrich_tanggal"]);
		$enrich_tanggal_akhir=trim(@$_POST["enrich_tanggal_akhir"]);
		$jproduk_diskon=trim(@$_POST["jproduk_diskon"]);
		$enrich_cara=trim(@$_POST["enrich_cara"]);
		$enrich_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_cara);
		$enrich_cara=str_replace("'", '"',$enrich_cara);
		$enrich_note=trim(@$_POST["enrich_note"]);
		$enrich_note=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_note);
		$enrich_note=str_replace("'", '"',$enrich_note);
		$enrich_stat_dok=trim(@$_POST["enrich_stat_dok"]);
		$enrich_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$enrich_stat_dok);
		$enrich_stat_dok=str_replace("'", '"',$enrich_stat_dok);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_enrichment->master_jual_produk_export_excel($jproduk_nobukti
																			  ,$jproduk_cust
																			  ,$enrich_tanggal
																			  ,$enrich_tanggal_akhir
																			  ,$jproduk_diskon
																			  ,$enrich_cara
																			  ,$enrich_note
																			  ,$enrich_stat_dok
																			  ,$option
																			  ,$filter);
		$this->load->plugin('to_excel');
		to_excel($query,"master_jual_produk"); 
		echo '1';
			
	}
	
	function print_paper(){
  		//POST varibale here
		$jproduk_id=trim(@$_POST["jproduk_id"]);
		
		
		$result = $this->m_master_enrichment->print_paper($jproduk_id);
		$iklan = $this->m_master_enrichment->iklan();
		$rs=$result->row();
		$rsiklan=$iklan->row();
		$detail_jproduk=$result->result();
		
		$array_cara_bayar = $this->m_master_enrichment->get_cara_bayar($jproduk_id);
		
		$cara_bayar=$this->m_master_enrichment->cara_bayar($jproduk_id);
		$cara_bayar2=$this->m_master_enrichment->cara_bayar2($jproduk_id);
		$cara_bayar3=$this->m_master_enrichment->cara_bayar3($jproduk_id);
		
		$data['jproduk_nobukti']=$rs->jproduk_nobukti;
		$data['enrich_tanggal']=date('d-m-Y', strtotime($rs->enrich_tanggal));
		$data['jproduk_jam']=$rs->jproduk_jam;
		$data['jproduk_karyawan']=$rs->jproduk_karyawan;
		$data['jproduk_karyawan_no']=$rs->jproduk_karyawan_no;
		$data['cust_no']=$rs->cust_no;
		$data['cust_nama']=$rs->cust_nama;
		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		$data['cust_alamat']=$rs->cust_alamat;
		$data['jumlah_subtotal']=ubah_rupiah($rs->jumlah_subtotal);
		//$data['jumlah_tunai']=ubah_rupiah($rs->jtunai_nilai);
		$data['jumlah_bayar']=$rs->enrich_total_bayar;
		$data['enrich_kembalian']=$rs->enrich_kembalian;
		$data['jproduk_diskon']=$rs->jproduk_diskon;
		$data['enrich_cashback']=$rs->enrich_cashback;
		//$data['jproduk_creator']=$rs->jproduk_creator;
		//$data['enrich_total_biayabiaya']=$rs->enrich_total_biayabiaya;
		$data['detail_jproduk']=$detail_jproduk;
		
		if($cara_bayar!==NULL){
			$data['cara_bayar1']=$cara_bayar->enrich_cara;
			$data['nilai_bayar1']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar1']="";
			$data['nilai_bayar1']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->enrich_cara2;
			$data['nilai_bayar2']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['nilai_bayar2']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->enrich_cara3;
			$data['nilai_bayar3']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['nilai_bayar3']="";
		}
		
		/*if(count($array_cara_bayar)){
			$data['cara_bayar1']='';
			$data['nilai_bayar1']='';
			
			$data['cara_bayar2']='';
			$data['nilai_bayar2']='';
			
			$data['cara_bayar3']='';
			$data['nilai_bayar3']='';
			
			$i=1;
			foreach($array_cara_bayar as $row){
				if($row->cek > 0){
					$data['cara_bayar'.$i]='cek/giro';
					$data['nilai_bayar'.$i]=$row->cek;
				}else if($row->card > 0){
					$data['cara_bayar'.$i]='card';
					$data['nilai_bayar'.$i]=$row->card;
				}else if($row->kuitansi > 0){
					$data['cara_bayar'.$i]='kuitansi';
					$data['nilai_bayar'.$i]=$row->kuitansi;
				}else if($row->transfer > 0){
					$data['cara_bayar'.$i]='transfer';
					$data['nilai_bayar'.$i]=$row->transfer;
				}else if($row->tunai > 0){
					$data['cara_bayar'.$i]='tunai';
					$data['nilai_bayar'.$i]=$row->tunai;
				}
				$i++;
			}
		}*/
		
		$viewdata=$this->load->view("main/jproduk_formcetak",$data,TRUE);
		$file = fopen("jproduk_paper.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	function print_paper2(){
  		//POST varibale here
		$jproduk_id=trim(@$_POST["jproduk_id"]);
		
		
		$result = $this->m_master_enrichment->print_paper2($jproduk_id);
		$iklan = $this->m_master_enrichment->iklan();
		$rs=$result->row();
		$rsiklan=$iklan->row();
		$detail_jproduk=$result->result();
		
		$array_cara_bayar = $this->m_master_enrichment->get_cara_bayar($jproduk_id);
		
		$cara_bayar=$this->m_master_enrichment->cara_bayar($jproduk_id);
		$cara_bayar2=$this->m_master_enrichment->cara_bayar2($jproduk_id);
		$cara_bayar3=$this->m_master_enrichment->cara_bayar3($jproduk_id);
		
		$data['jproduk_nobukti']=$rs->jproduk_nobukti;
		$data['jproduk_nobukti_pajak']=$rs->jproduk_nobukti_pajak;
		$data['enrich_tanggal']=date('d-m-Y', strtotime($rs->enrich_tanggal));
		$data['jproduk_jam']=$rs->jproduk_jam;
		$data['jproduk_karyawan']=$rs->jproduk_karyawan;
		$data['jproduk_karyawan_no']=$rs->jproduk_karyawan_no;
		$data['cust_no']=$rs->cust_no;
		$data['cust_nama']=$rs->cust_nama;
		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		$data['cust_alamat']=$rs->cust_alamat;
		$data['jumlah_subtotal']=ubah_rupiah($rs->jumlah_subtotal);
		//$data['jumlah_tunai']=ubah_rupiah($rs->jtunai_nilai);
		$data['jumlah_bayar']=$rs->enrich_total_bayar;
		$data['jproduk_diskon']=$rs->jproduk_diskon;
		$data['enrich_cashback']=$rs->enrich_cashback;
		//$data['jproduk_creator']=$rs->jproduk_creator;
		//$data['enrich_total_biayabiaya']=$rs->enrich_total_biayabiaya;
		$data['detail_jproduk']=$detail_jproduk;
		
		if($cara_bayar!==NULL){
			$data['cara_bayar1']=$cara_bayar->enrich_cara;
			$data['nilai_bayar1']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar1']="";
			$data['nilai_bayar1']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->enrich_cara2;
			$data['nilai_bayar2']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['nilai_bayar2']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->enrich_cara3;
			$data['nilai_bayar3']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['nilai_bayar3']="";
		}

		$viewdata=$this->load->view("main/jproduk_formcetak2",$data,TRUE);
		$file = fopen("jproduk_paper2.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	function print_only(){
  		//POST varibale here
		$jproduk_id=trim(@$_POST["jproduk_id"]);
		
		$result = $this->m_master_enrichment->print_paper($jproduk_id);
		$iklan = $this->m_master_enrichment->iklan();
		$rs=$result->row();
		$rsiklan=$iklan->row();
		$detail_jproduk=$result->result();
		
		$array_cara_bayar = $this->m_master_enrichment->get_cara_bayar($jproduk_id);
		
		$cara_bayar=$this->m_master_enrichment->cara_bayar($jproduk_id);
		$cara_bayar2=$this->m_master_enrichment->cara_bayar2($jproduk_id);
		$cara_bayar3=$this->m_master_enrichment->cara_bayar3($jproduk_id);
		
		$data['jproduk_nobukti']=$rs->jproduk_nobukti;
		$data['jproduk_jam']=$rs->jproduk_jam;
		$data['jproduk_karyawan']=$rs->jproduk_karyawan;
		$data['jproduk_karyawan_no']=$rs->jproduk_karyawan_no;
		$data['enrich_tanggal']=date('d-m-Y', strtotime($rs->enrich_tanggal));
		$data['cust_no']=$rs->cust_no;
		$data['cust_nama']=$rs->cust_nama;
		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		$data['cust_alamat']=$rs->cust_alamat;
		$data['jumlah_subtotal']=ubah_rupiah($rs->jumlah_subtotal);
		$data['jumlah_bayar']=$rs->enrich_total_bayar;
		$data['jproduk_diskon']=$rs->jproduk_diskon;
		$data['enrich_cashback']=$rs->enrich_cashback;
		$data['enrich_kembalian']=$rs->enrich_kembalian;
		$data['detail_jproduk']=$detail_jproduk;
		
		if($cara_bayar!==NULL){
			$data['cara_bayar1']=$cara_bayar->enrich_cara;
			$data['nilai_bayar1']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar1']="";
			$data['bayar_nilai1']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->enrich_cara2;
			$data['nilai_bayar2']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['nilai_bayar2']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->enrich_cara3;
			$data['nilai_bayar3']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['nilai_bayar3']="";
		}
			
		$viewdata=$this->load->view("main/jproduk_formcetak_printonly",$data,TRUE);
		$file = fopen("jproduk_paper.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
		function print_only2(){
  		//POST varibale here
		$jproduk_id=trim(@$_POST["jproduk_id"]);
		
		$result = $this->m_master_enrichment->print_paper2($jproduk_id);
		$iklan = $this->m_master_enrichment->iklan();
		$rs=$result->row();
		$rsiklan=$iklan->row();
		$detail_jproduk=$result->result();
		
		$array_cara_bayar = $this->m_master_enrichment->get_cara_bayar($jproduk_id);
		
		$cara_bayar=$this->m_master_enrichment->cara_bayar($jproduk_id);
		$cara_bayar2=$this->m_master_enrichment->cara_bayar2($jproduk_id);
		$cara_bayar3=$this->m_master_enrichment->cara_bayar3($jproduk_id);
		
		$data['jproduk_nobukti']=$rs->jproduk_nobukti;
		$data['jproduk_nobukti_pajak']=$rs->jproduk_nobukti_pajak;
		$data['jproduk_jam']=$rs->jproduk_jam;
		$data['jproduk_karyawan']=$rs->jproduk_karyawan;
		$data['jproduk_karyawan_no']=$rs->jproduk_karyawan_no;
		$data['enrich_tanggal']=date('d-m-Y', strtotime($rs->enrich_tanggal));
		$data['cust_no']=$rs->cust_no;
		$data['cust_nama']=$rs->cust_nama;
		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		$data['cust_alamat']=$rs->cust_alamat;
		$data['jumlah_subtotal']=ubah_rupiah($rs->jumlah_subtotal);
		$data['jumlah_bayar']=$rs->enrich_total_bayar;
		$data['jproduk_diskon']=$rs->jproduk_diskon;
		$data['enrich_cashback']=$rs->enrich_cashback;
		$data['detail_jproduk']=$detail_jproduk;
		
		if($cara_bayar!==NULL){
			$data['cara_bayar1']=$cara_bayar->enrich_cara;
			$data['nilai_bayar1']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar1']="";
			$data['bayar_nilai1']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->enrich_cara2;
			$data['nilai_bayar2']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['nilai_bayar2']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->enrich_cara3;
			$data['nilai_bayar3']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['nilai_bayar3']="";
		}
			
		$viewdata=$this->load->view("main/jproduk_formcetak_printonly2",$data,TRUE);
		$file = fopen("jproduk_paper2.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	// Encodes a SQL array into a JSON formated string
	function JEncode($arr){
		if (version_compare(PHP_VERSION,"5.2","<"))
		{    
			require_once("./JSON.php"); //if php<5.2 need JSON class
			$json = new Services_JSON();//instantiate new json object
			$data=$json->encode($arr);  //encode the data in json format
		} else {
			$data = json_encode($arr);  //encode the data in json format
		}
		return $data;
	}
	
	// Decode a SQL array into a JSON formated string
	function JDecode($arr){
		if (version_compare(PHP_VERSION,"5.2","<"))
		{    
			require_once("./JSON.php"); //if php<5.2 need JSON class
			$json = new Services_JSON();//instantiate new json object
			$data=$json->decode($arr);  //decode the data in json format
		} else {
			$data = json_decode($arr);  //decode the data in json format
		}
		return $data;
	}
	
	// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
	function codeDate ($date) {
	  $tab = explode ("-", $date);
	  $r = $tab[1]."/".$tab[2]."/".$tab[0];
	  return $r;
	}
	
}
?>