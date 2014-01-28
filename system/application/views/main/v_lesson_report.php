<?
/*
		GIOV Solution - Keep IT Simple
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<style type="text/css">
        p { width:650px; }
		.search-item {
			font:normal 11px tahoma, arial, helvetica, sans-serif;
			padding:3px 10px 3px 10px;
			border:1px solid #fff;
			border-bottom:1px solid #eeeeee;
			white-space:normal;
			color:#555;
		}
		.search-item h3 {
			display:block;
			font:inherit;
			font-weight:bold;
			color:#222;
		}
		
		.search-item h3 span {
			float: right;
			font-weight:normal;
			margin:0 0 5px 5px;
			width:100px;
			display:block;
			clear:none;
		}
    </style>
<script>
/* declare function */		
var lr_DataStore;
var anamnesa_ColumnModel;
var lr_ListEditorGrid;
var lr_createForm;
var lr_createWindow;
var anamnesa_searchForm;
var lr_searchWindow;
var anamnesa_SelectedRow;
var anamnesa_ContextMenu;
//for detail data
var anamnesa_problem_DataStor;
var lr_detailListEditorGrid;
var lr_planListEditorGrid;
var lr_detail_ColumnModel;
var anamnesa_problem_proxy;
var anamnesa_problem_writer;
var lr_detail_reader;
var editor_lr_detail;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var lr_idField;
var lr_codeField;
var lr_periodField;
var lr_themeField;
var lr_subthemeField;
var lr_ldField;
var lr_sedField;
var lr_pdField;
var lr_cbField;
var lr_mField;
var lr_custField;
var lr_tanggalField;
var lr_classField;
var lr_lesson_planField;
var lr_languageField;
var lr_special_actField;
var lr_bibleField;
var anam_alergiField;
var anam_obatalergiField;
var anam_efekobatalergiField;
var lr_weekField;
var lr_dayField;
var lr_language_subjectField;
var lr_special_subjectField;
var lr_bible_subjectField;
var anam_harapanField;
var anam_idSearchField;
var anam_custSearchField;
var anam_tanggalSearchField;
var anam_petugasSearchField;
var anam_pengobatanSearchField;
var anam_perawatanSearchField;
var anam_terapiSearchField;
var anam_alergiSearchField;
var anam_obatalergiSearchField;
var anam_efekobatalergiSearchField;
var anam_hamilSearchField;
var anam_kbSearchField;
var anam_harapanSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
	
	Ext.util.Format.comboRenderer = function(combo){
  	    return function(value){
  	        var record = combo.findRecord(combo.valueField, value);
  	        return record ? record.get(combo.displayField) : combo.valueNotFoundText;
  	    }
  	}
  
  	/* Function for Saving inLine Editing */
	function anamnesa_update(oGrid_event){
		var anam_id_update_pk="";
		var anam_cust_update=null;
		var anam_tanggal_update_date="";
		var anam_petugas_update=null;
		var anam_pengobatan_update=null;
		var anam_perawatan_update=null;
		var anam_terapi_update=null;
		var anam_alergi_update=null;
		var anam_obatalergi_update=null;
		var anam_efekobatalergi_update=null;
		var anam_hamil_update=null;
		var anam_kb_update=null;
		var anam_harapan_update=null;

		anam_id_update_pk = oGrid_event.record.data.lr_id;
		if(oGrid_event.record.data.lr_cust!== null){anam_cust_update = oGrid_event.record.data.lr_cust;}
	 	if(oGrid_event.record.data.lr_tanggal!== ""){anam_tanggal_update_date =oGrid_event.record.data.lr_tanggal.format('Y-m-d');}
		if(oGrid_event.record.data.anam_petugas!== null){anam_petugas_update = oGrid_event.record.data.anam_petugas;}
		if(oGrid_event.record.data.anam_pengobatan!== null){anam_pengobatan_update = oGrid_event.record.data.anam_pengobatan;}
		if(oGrid_event.record.data.anam_perawatan!== null){anam_perawatan_update = oGrid_event.record.data.anam_perawatan;}
		if(oGrid_event.record.data.anam_terapi!== null){anam_terapi_update = oGrid_event.record.data.anam_terapi;}
		if(oGrid_event.record.data.anam_alergi!== null){anam_alergi_update = oGrid_event.record.data.anam_alergi;}
		if(oGrid_event.record.data.anam_obatalergi!== null){anam_obatalergi_update = oGrid_event.record.data.anam_obatalergi;}
		if(oGrid_event.record.data.anam_efekobatalergi!== null){anam_efekobatalergi_update = oGrid_event.record.data.anam_efekobatalergi;}
		if(oGrid_event.record.data.anam_hamil!== null){anam_hamil_update = oGrid_event.record.data.anam_hamil;}
		if(oGrid_event.record.data.anam_kb!== null){anam_kb_update = oGrid_event.record.data.anam_kb;}
		if(oGrid_event.record.data.anam_harapan!== null){anam_harapan_update = oGrid_event.record.data.anam_harapan;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_lesson_report&m=get_action',
			params: {
				task: "UPDATE",
				lr_id	: anam_id_update_pk, 
				lr_cust	:anam_cust_update,  
				lr_tanggal	: anam_tanggal_update_date, 
				anam_petugas	:anam_petugas_update,  
				anam_pengobatan	:anam_pengobatan_update,  
				anam_perawatan	:anam_perawatan_update,  
				anam_terapi	:anam_terapi_update,  
				anam_alergi	:anam_alergi_update,  
				anam_obatalergi	:anam_obatalergi_update,  
				anam_efekobatalergi	:anam_efekobatalergi_update,  
				anam_hamil	:anam_hamil_update,  
				anam_kb	:anam_kb_update,  
				anam_harapan	:anam_harapan_update  
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						lr_DataStore.commitChanges();
						lr_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Anamnesa tidak bisa disimpan.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
						break;
				}
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
				   title: 'Error',
				   msg: 'Tidak bisa terhubung dengan database server',
				   buttons: Ext.MessageBox.OK,
				   animEl: 'database',
				   icon: Ext.MessageBox.ERROR
				});	
			}									    
		});   
	}
  	/* End of Function */
  
  	/* Function for add data, open window create form */
	function lr_create(){
	
		if(is_lr_form_valid()){	
		var lr_id_create_pk=null; 
		var lr_tanggal_create_date=""; 
		var lr_class_create=null; 
		var lr_period_create=null; 
		var lr_theme_create=null; 
		var lr_subtheme_create=null; 
		var lr_ld_create=null; 
		var lr_sed_create=null; 
		var lr_pd_create=null; 
		var lr_cb_create=null; 
		var lr_m_create=null; 

		if(lr_idField.getValue()!== null){lr_id_create_pk = lr_idField.getValue();}else{lr_id_create_pk=get_pk_id();} 
		if(lr_tanggalField.getValue()!== ""){lr_tanggal_create_date = lr_tanggalField.getValue().format('Y-m-d');} 
		if(lr_classField.getValue()!== null){lr_class_create = lr_classField.getValue();} 
		if(lr_periodField.getValue()!== null){lr_period_create = lr_periodField.getValue();} 
		if(lr_themeField.getValue()!== null){lr_theme_create = lr_themeField.getValue();} 
		if(lr_subthemeField.getValue()!== null){lr_subtheme_create = lr_subthemeField.getValue();} 
		if(lr_ldField.getValue()!== null){lr_ld_create = lr_ldField.getValue();} 
		if(lr_sedField.getValue()!== null){lr_sed_create = lr_sedField.getValue();} 
		if(lr_pdField.getValue()!== null){lr_pd_create = lr_pdField.getValue();} 
		if(lr_cbField.getValue()!== null){lr_cb_create = lr_cbField.getValue();} 
		if(lr_mField.getValue()!== null){lr_m_create = lr_mField.getValue();} 
		
		// penambahan detail lesson report
		var dlr_id = [];
        var dlr_master = [];
        var dlr_student = [];
        var dlr_report_ld = [];
        var dlr_report_sed = [];
        var dlr_report_pd = [];
        var dlr_report_cb = [];
        var dlr_report_m = [];
		
        if(lr_detail_DataStore.getCount()>0){
            for(i=0; i<lr_detail_DataStore.getCount();i++){
                if(lr_detail_DataStore.getAt(i).data.dlr_student!==""){
                    
                	if(lr_detail_DataStore.getAt(i).data.dlr_id==undefined ||
					   lr_detail_DataStore.getAt(i).data.dlr_id==''){
						lr_detail_DataStore.getAt(i).data.dlr_id=0;
					}

					if(lr_detail_DataStore.getAt(i).data.dlr_report_ld==undefined ||
					   lr_detail_DataStore.getAt(i).data.dlr_report_ld==''){
						lr_detail_DataStore.getAt(i).data.dlr_report_ld='';
					}

					if(lr_detail_DataStore.getAt(i).data.dlr_report_sed==undefined ||
					   lr_detail_DataStore.getAt(i).data.dlr_report_sed==''){
						lr_detail_DataStore.getAt(i).data.dlr_report_sed='';
					}

					if(lr_detail_DataStore.getAt(i).data.dlr_report_pd==undefined ||
					   lr_detail_DataStore.getAt(i).data.dlr_report_pd==''){
						lr_detail_DataStore.getAt(i).data.dlr_report_pd='';
					}

					if(lr_detail_DataStore.getAt(i).data.dlr_report_cb==undefined ||
					   lr_detail_DataStore.getAt(i).data.dlr_report_cb==''){
						lr_detail_DataStore.getAt(i).data.dlr_report_cb='';
					}

					if(lr_detail_DataStore.getAt(i).data.dlr_report_m==undefined ||
					   lr_detail_DataStore.getAt(i).data.dlr_report_m==''){
						lr_detail_DataStore.getAt(i).data.dlr_report_m='';
					}

                  	dlr_id.push(lr_detail_DataStore.getAt(i).data.dlr_id);
                   	dlr_student.push(lr_detail_DataStore.getAt(i).data.dlr_student);
					dlr_report_ld.push(lr_detail_DataStore.getAt(i).data.dlr_report_ld);
					dlr_report_sed.push(lr_detail_DataStore.getAt(i).data.dlr_report_sed);
					dlr_report_pd.push(lr_detail_DataStore.getAt(i).data.dlr_report_pd);
					dlr_report_cb.push(lr_detail_DataStore.getAt(i).data.dlr_report_cb);
					dlr_report_m.push(lr_detail_DataStore.getAt(i).data.dlr_report_m);
                }
            }
			
			var encoded_array_dlr_id = Ext.encode(dlr_id);
			var encoded_array_dlr_student = Ext.encode(dlr_student);
			var encoded_array_dlr_report_ld = Ext.encode(dlr_report_ld);
			var encoded_array_dlr_report_sed = Ext.encode(dlr_report_sed);
			var encoded_array_dlr_report_pd = Ext.encode(dlr_report_pd);
			var encoded_array_dlr_report_cb = Ext.encode(dlr_report_cb);
			var encoded_array_dlr_report_m = Ext.encode(dlr_report_m);
			
		}
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_lesson_report&m=get_action',
			params: {
				task: post2db,
				lr_id				: lr_id_create_pk, 
				lr_tanggal			: lr_tanggal_create_date,			
				lr_class			: lr_class_create, 
				lr_period			: lr_period_create, 
				lr_theme			: lr_theme_create, 
				lr_subtheme			: lr_subtheme_create, 
				lr_ld				: lr_ld_create, 
				lr_sed				: lr_sed_create, 
				lr_pd				: lr_pd_create, 
				lr_cb				: lr_cb_create, 
				lr_m				: lr_m_create, 

				// detail lr 
				dlr_id					: encoded_array_dlr_id, 
				dlr_master				: eval(get_pk_id()),
				dlr_student				: encoded_array_dlr_student, 
				dlr_report_ld			: encoded_array_dlr_report_ld,
				dlr_report_sed			: encoded_array_dlr_report_sed,
				dlr_report_pd			: encoded_array_dlr_report_pd,
				dlr_report_cb			: encoded_array_dlr_report_cb,
				dlr_report_m			: encoded_array_dlr_report_m
			}, 
			success: function(response){             
								
				var result=eval(response.responseText);
				if(result!==0){
						//anamnesa_problem_insert(result)
						lr_DataStore.reload();
						Ext.MessageBox.alert(post2db+' OK','Lesson Report Data is Already Saved');
						lr_createWindow.hide();
				}else{
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Lesson Report Data can not be Saved',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
				} 
				
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
					   title: 'Error',
					   msg: 'No Connection to Server',
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
				});	
			}                      
		});
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Form is not Valid!.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function anamnesa_reset_form(){
		lr_idField.reset();
		lr_idField.setValue(null);
		lr_codeField.reset();
		lr_codeField.setValue(null);
		lr_classField.reset();
		lr_classField.setValue(null);
		lr_periodField.reset();
		lr_periodField.setValue(null);
		lr_themeField.reset();
		lr_themeField.setValue(null);
		lr_subthemeField.reset();
		lr_subthemeField.setValue(null);
		lr_ldField.reset();
		lr_ldField.setValue(null);
		lr_sedField.reset();
		lr_sedField.setValue(null);
		lr_pdField.reset();
		lr_pdField.setValue(null);
		lr_cbField.reset();
		lr_cbField.setValue(null);
		lr_mField.reset();
		lr_mField.setValue(null);
		lr_tanggalField.reset();
		lr_tanggalField.setValue(null);
		cbo_student_detailDataStore.setBaseParam('task','list');
		cbo_student_detailDataStore.load();
		lr_detail_DataStore.load({params : {master_id : -1}});
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function lr_set_form(){
		lr_idField.setValue(lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_id'));
		lr_codeField.setValue(lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_code'));
		lr_classField.setValue(lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_class_name'));
		lr_periodField.setValue(lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_period'));
		lr_themeField.setValue(lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_theme'));
		lr_subthemeField.setValue(lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_subtheme'));
		lr_ldField.setValue(lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_ld'));
		lr_sedField.setValue(lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_sed'));
		lr_pdField.setValue(lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_pd'));
		lr_cbField.setValue(lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_cb'));
		lr_mField.setValue(lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_m'));
		lr_tanggalField.setValue(lr_ListEditorGrid.getSelectionModel().getSelected().get('lr_tanggal'));
		cbo_student_detailDataStore.load();
		lr_detail_DataStore.load({params : {master_id : get_pk_id() }});
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_lr_form_valid(){
		return (lr_tanggalField.isValid() );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!lr_createWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			anamnesa_reset_form();
			
			lr_createWindow.show();
		} else {
			lr_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function anamnesa_confirm_delete(){
		// only one anamnesa is selected here
		if(lr_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', anamnesa_delete);
		} else if(lr_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', anamnesa_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada yang dipilih untuk dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function lr_confirm_update(){
		/* only one record is selected here */
		//cbo_dlr_subjectDataStore.load();	
		if(lr_ListEditorGrid.selModel.getCount() == 1) {
			
			post2db='UPDATE';
			msg='updated';
			lr_set_form();
			lr_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'No Data Selected',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function anamnesa_delete(btn){
		if(btn=='yes'){
			var selections = lr_ListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< lr_ListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.lr_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_lesson_report&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							lr_DataStore.reload();
							break;
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Tidak bisa menghapus data yang diplih',
								buttons: Ext.MessageBox.OK,
								animEl: 'save',
								icon: Ext.MessageBox.WARNING
							});
							break;
					}
				},
				failure: function(response){
					var result=response.responseText;
					Ext.MessageBox.show({
					   title: 'Error',
					   msg: 'Tidak bisa terhubung dengan database server',
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
					});	
				}
			});
		}  
	}
  	/* End of Function */
  
	/* Function for Retrieve DataStore */
	lr_DataStore = new Ext.data.Store({
		id: 'lr_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lesson_report&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'lr_id'
		},[
			{name: 'lr_id', type: 'int', mapping: 'lr_id'}, 
			{name: 'lr_code', type: 'string', mapping: 'lr_code'}, 
			{name: 'lr_class', type: 'int', mapping: 'lr_class'}, 
			{name: 'lr_class_name', type: 'string', mapping: 'class_name'}, 
			{name: 'lr_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'lr_tanggal'}, 
			{name: 'lr_period', type: 'string', mapping: 'lr_period'}, 
			{name: 'lr_theme', type: 'string', mapping: 'lr_theme'}, 
			{name: 'lr_subtheme', type: 'string', mapping: 'lr_subtheme'}, 
			{name: 'lr_ld', type: 'string', mapping: 'lr_ld'}, 
			{name: 'lr_sed', type: 'string', mapping: 'lr_sed'}, 
			{name: 'lr_pd', type: 'string', mapping: 'lr_pd'}, 
			{name: 'lr_cb', type: 'string', mapping: 'lr_cb'}, 
			{name: 'lr_m', type: 'string', mapping: 'lr_m'}, 
			{name: 'lr_creator', type: 'string', mapping: 'lr_creator'}, 
			{name: 'lr_date_create', type: 'date', dateFormat: 'Y-m-d', mapping: 'lr_date_create'}, 
			{name: 'lr_update', type: 'string', mapping: 'lr_update'}, 
			{name: 'lr_date_update', type: 'date', dateFormat: 'Y-m-d', mapping: 'lr_date_update'}, 
			{name: 'lr_revised', type: 'int', mapping: 'lr_revised'} 
		]),
		sortInfo:{field: 'lr_id', direction: "DESC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	anamnesa_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'lr_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'LR Code',
			dataIndex: 'lr_code',
			width: 150,
			sortable: true
		},
		{
			header: 'Class',
			dataIndex: 'lr_class_name',
			width: 150,
			sortable: true
		},
		{
			header: 'Period',
			dataIndex: 'lr_period',
			width: 150,
			sortable: true
		},
		{
			header: 'Theme',
			dataIndex: 'lr_theme',
			width: 150,
			sortable: true
		},{
			header: 'Sub Theme',
			dataIndex: 'lr_subtheme',
			width: 150,
			sortable: true
		},
		/*
		{
			header: 'Customer',
			dataIndex: 'lr_cust_nama',
			width: 150,
			sortable: true,
			readOnly: true
		},
		*/ 
		{
			header: 'Tanggal',
			dataIndex: 'lr_tanggal',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d')
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_LESSONREPORT'))){ ?>
			,
			editor: new Ext.form.DateField({
				allowBlank: false,
				format: 'Y-m-d'
			})
			<?php } ?>
		},
		/* 
		{
			header: 'Lesson Plan',
			dataIndex: 'lr_lesson_plan_code',
			width: 150,
			sortable: true,
			readOnly: true
		},

		{
			header: 'Week',
			dataIndex: 'lr_week',
			width: 150,
			sortable: true
		},
		{
			header: 'Day',
			dataIndex: 'lr_day',
			width: 150,
			sortable: true
		},
		*/

		/*
		{
			header: 'Language',
			dataIndex: 'lr_language',
			width: 150,
			sortable: true
		},
		{
			header: 'Special Art',
			dataIndex: 'lr_special',
			width: 150,
			sortable: true
		},
				{
			header: 'Bible/Character/Mandarin',
			dataIndex: 'lr_bible',
			width: 150,
			sortable: true
		},
		*/
		/*
		{
			header: 'Alergi',
			dataIndex: 'anam_alergi',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_LESSONREPORT'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
			<?php } ?>
		}, 
		{
			header: 'Alergi thd Obat',
			dataIndex: 'anam_obatalergi',
			width: 150,
			sortable: true
			<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_LESSONREPORT'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
			<?php } ?>
		}, 
		{
			header: 'Hamil ?',
			dataIndex: 'anam_hamil',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_LESSONREPORT'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['anam_hamil_value', 'anam_hamil_display'],
					data: [['Y','Y'],['T','T']]
					}),
				mode: 'local',
               	displayField: 'anam_hamil_display',
               	valueField: 'anam_hamil_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		}, 
		*/
		{
			header: 'Creator',
			dataIndex: 'anam_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'anam_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'anam_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'anam_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'anam_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	anamnesa_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	lr_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lr_ListEditorGrid',
		el: 'fp_lesson_report',
		title: 'Lesson Report List',
		autoHeight: true,
		store: lr_DataStore, // DataStore
		cm: anamnesa_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: lr_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_LESSONREPORT'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_LESSONREPORT'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: lr_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_LESSONREPORT'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: anamnesa_confirm_delete   // Confirm before deleting
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: lr_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: anamnesa_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: anamnesa_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: anamnesa_print  
		}
		]
	});
	lr_ListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	anamnesa_ContextMenu = new Ext.menu.Menu({
		id: 'anamnesa_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_LESSONREPORT'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: anamnesa_editContextMenu 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_LESSONREPORT'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: anamnesa_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: anamnesa_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: anamnesa_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onanamnesa_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		anamnesa_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		anamnesa_SelectedRow=rowIndex;
		anamnesa_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function anamnesa_editContextMenu(){
		lr_ListEditorGrid.startEditing(anamnesa_SelectedRow,1);
  	}
	/* End of Function */
  	
	lr_ListEditorGrid.addListener('rowcontextmenu', onanamnesa_ListEditGridContextMenu);
	lr_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	lr_ListEditorGrid.on('afteredit', anamnesa_update); // inLine Editing Record
	
	cust_lr_DataStore = new Ext.data.Store({
		id: 'cust_lr_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_action',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	
	lesson_plan_DataStore = new Ext.data.Store({
		id: 'lesson_plan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lesson_report&m=get_petugas',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'lesplan_id'
		},[
			{name: 'lesplan_id', type: 'int', mapping: 'lesplan_id'},
			{name: 'lesplan_code', type: 'string', mapping: 'lesplan_code'},
			{name: 'lesplan_theme', type: 'string', mapping: 'lesplan_theme'},
			{name: 'lesplan_subtheme', type: 'string', mapping: 'lesplan_subtheme'}
		]),
		sortInfo:{field: 'lesplan_code', direction: "ASC"}
	});

	class_DataStore = new Ext.data.Store({
		id: 'class_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lesson_report&m=get_class',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'class_id'
		},[
			{name: 'class_id', type: 'int', mapping: 'class_id'},
			{name: 'class_name', type: 'string', mapping: 'class_name'},
			{name: 'class_teacher1', type: 'string', mapping: 'class_teacher1'},
			{name: 'class_teacher2', type: 'string', mapping: 'class_teacher2'},
			{name: 'class_teacher3', type: 'string', mapping: 'class_teacher3'},
			{name: 'class_time_start', type: 'string', mapping: 'class_time_start'},
			{name: 'class_time_end', type: 'string', mapping: 'class_time_end'},
		]),
		sortInfo:{field: 'class_name', direction: "ASC"}
	});

	var lr_classstudent_detail_DataStore=new Ext.data.Store({
		id: 'lr_classstudent_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lesson_report&m=get_student_by_class_id',
			method: 'POST'
		}),
		baseParams:{task: "LIST"},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dlr_student'
		},[
			{name: 'dlr_student', type: 'int', mapping: 'cust_id'},
		]),
		sortInfo:{field: 'dlr_student', direction: "ASC"}
	});

	var class_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{class_name}</b><br /></span>',
            'Time Start : {class_time_start}',' | Time End : {class_time_end}',
        '</div></tpl>'
    );
	
	var customer_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br /></span>',
			'Tgl Lahir: {cust_tgllahir:date("j M Y")}',
            /*'{cust_alamat} | {cust_telprumah}',*/
        '</div></tpl>'
    );
	
	var lesson_plan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{lesplan_code}</b><br /></span>',
            'Theme : {lesplan_theme}',' | Sub Theme : {lesplan_subtheme}',
        '</div></tpl>'
    );
	
	// load subject
	
	cbo_dlr_subjectDataStore = new Ext.data.Store({
		id: 'cbo_dlr_subjectDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lesson_report&m=get_subject_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 30 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
			{name: 'drl_subject_display', type: 'string', mapping: 'dlesplan_subject'},
			{name: 'drl_schedule_kode', type: 'string', mapping: 'lesplan_code'}
		]),
		sortInfo:{field: 'drl_subject_display', direction: "ASC"}
	});
	var subject_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{drl_schedule_kode}| <b>{drl_subject_display}</b>',
		'</div></tpl>'
    );
	
	var combo_subject=new Ext.form.ComboBox({
			store: cbo_dlr_subjectDataStore,
			mode: 'local',
			displayField: 'drl_subject_display',
			valueField: 'drl_subject_display',
			typeAhead: false,
			loadingText: 'Searching...',
			pageSize:pageS,
			hideTrigger:false,
			tpl: subject_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			listClass: 'x-combo-list-small',
			anchor: '95%'
	});
	
	// eof load subject

	/* Identify lr_classField Field */
	lr_classField= new Ext.form.ComboBox({
		id: 'lr_classField',
		fieldLabel: 'Class',
		store: class_DataStore,
		mode: 'remote',
		displayField:'class_name',
		valueField: 'class_id',
        typeAhead: false,
        loadingText: 'Searching...',
        lesplan_pageSize:10,
        hideTrigger:false,
        tpl: class_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%',
		allowBlank: false
	});
	
	/* Identify  lr_id Field */
	lr_idField= new Ext.form.NumberField({
		id: 'lr_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	
	
	/* Identify  lr_cust Field */
	lr_custField= new Ext.form.ComboBox({
		id: 'lr_custField',
		fieldLabel: 'Customer',
		store: cust_lr_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%',
		allowBlank: false
	});
	
	/* Identify  lr_tanggal Field */
	lr_tanggalField= new Ext.form.DateField({
		id: 'lr_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d',
		allowBlank: false
	});
	/* Identify  anam_petugas Field */
	lr_lesson_planField= new Ext.form.ComboBox({
		id: 'lr_lesson_planField',
		fieldLabel: 'Lesson Plan',
		store: lesson_plan_DataStore,
		mode: 'remote',
		displayField:'lesplan_code',
		valueField: 'lesplan_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: lesson_plan_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%',
		allowBlank: false
	});
	/* Identify  anam_pengobatan Field */
	lr_codeField= new Ext.form.TextField({
		id: 'lr_codeField',
		fieldLabel: 'LR Code',
		readOnly: true,
		emptyText: '(Auto)',
		anchor: '95%'
	});
	
	lr_periodField= new Ext.form.TextField({
		id: 'lr_periodField',
		fieldLabel: 'Period',
		anchor: '95%'
	});

	lr_themeField= new Ext.form.TextField({
		id: 'lr_themeField',
		fieldLabel: 'Theme',
		anchor: '95%'
	});

	lr_subthemeField= new Ext.form.TextField({
		id: 'lr_subthemeField',
		fieldLabel: 'Sub Theme',
		anchor: '95%'
	});

	lr_ldField= new Ext.form.TextArea({
		id: 'lr_ldField',
		fieldLabel: 'Language Development',
		maxLength: 500,
		height: 40,
		anchor: '95%'
	});
	lr_sedField= new Ext.form.TextArea({
		id: 'lr_sedField',
		fieldLabel: 'Social & Emotional Development',
		maxLength: 500,
		height: 40,
		anchor: '95%'
	});
	lr_pdField= new Ext.form.TextArea({
		id: 'lr_pdField',
		fieldLabel: 'Physical Development',
		maxLength: 500,
		height: 40,
		anchor: '95%'
	});
	lr_cbField= new Ext.form.TextArea({
		id: 'lr_cbField',
		fieldLabel: 'Bible / Character Building',
		maxLength: 500,
		height: 40,
		anchor: '95%'
	});
	lr_mField= new Ext.form.TextArea({
		id: 'lr_mField',
		fieldLabel: 'Mandarin',
		maxLength: 500,
		height: 40,
		anchor: '95%'
	});
	/* Identify  anam_pengobatan Field */
	lr_languageField= new Ext.form.TextArea({
		id: 'lr_languageField',
		fieldLabel: 'Report',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  anam_perawatan Field */
	lr_special_actField= new Ext.form.TextArea({
		id: 'lr_special_actField',
		fieldLabel: 'Report',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  anam_terapi Field */
	lr_bibleField= new Ext.form.TextArea({
		id: 'lr_bibleField',
		fieldLabel: 'Report',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  anam_alergi Field */
	anam_alergiField= new Ext.form.TextArea({
		id: 'anam_alergiField',
		fieldLabel: 'Alergi',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  anam_obatalergi Field */
	anam_obatalergiField= new Ext.form.TextArea({
		id: 'anam_obatalergiField',
		fieldLabel: 'Alergi terhadap obat',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  anam_efekobatalergi Field */
	anam_efekobatalergiField= new Ext.form.TextArea({
		id: 'anam_efekobatalergiField',
		fieldLabel: 'Efek alergi terhadap obat',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  anam_hamil Field */
	lr_weekField= new Ext.form.ComboBox({
		id: 'lr_weekField',
		fieldLabel: 'Week',
		store:new Ext.data.SimpleStore({
			fields:['lr_week_value', 'lr_week_display'],
			data:[['1','1'],['2','2'],['3','3'],['4','4']]
		}),
		mode: 'local',
		displayField: 'lr_week_display',
		valueField: 'lr_week_value',
		//anchor: '95%',
		width: 60,
		triggerAction: 'all'	
	});
	/* Identify  anam_hamil Field */
	lr_dayField= new Ext.form.ComboBox({
		id: 'lr_dayField',
		fieldLabel: 'Day',
		store:new Ext.data.SimpleStore({
			fields:['lr_day_value', 'lr_day_display'],
			data:[['1','1'],['2','2']]
		}),
		mode: 'local',
		displayField: 'lr_day_display',
		valueField: 'lr_day_value',
		//anchor: '95%',
		width: 60,
		triggerAction: 'all'	
	});
	/* Identify  lr_language_subjectField Field */
	lr_language_subjectField= new Ext.form.TextField({
		id: 'lr_language_subjectField',
		fieldLabel: 'Language Subject',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  lr_special_subjectField Field */
	lr_special_subjectField= new Ext.form.TextField({
		id: 'lr_special_subjectField',
		fieldLabel: 'Special Act Subject',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  lr_bible_subjectField Field */
	lr_bible_subjectField= new Ext.form.TextField({
		id: 'lr_bible_subjectField',
		fieldLabel: 'Bible / Character / Mandarin Subject',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  anam_harapan Field */
	anam_harapanField= new Ext.form.TextArea({
		id: 'anam_harapanField',
		fieldLabel: 'Harapan',
		maxLength: 500,
		anchor: '95%'
	});
  	/*Fieldset Master*/
	anamnesa_masterGroup = new Ext.form.FieldSet({
		autoHeight: true,
		collapsible: false,
		layout:'column',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [lr_codeField, lr_tanggalField,lr_periodField,lr_themeField,lr_subthemeField, lr_classField] 
			}
			]
	
	});

	/*Fieldset Master*/
	/*
	student_masterGroup = new Ext.form.FieldSet({
		autoHeight: true,
		collapsible: false,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [lr_codeField, lr_tanggalField] 
			}
			]
	
	});
	*/
	
		
	/*Detail Declaration */
		
	// Function for json reader of detail
	var lr_detail_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
		{name: 'dlr_id', type: 'int', mapping: 'dlr_id'}, 
		{name: 'dlr_master', type: 'int', mapping: 'dlr_master'}, 
		{name: 'dlr_student', type: 'int', mapping: 'dlr_student'}, 
		{name: 'dlr_report_ld', type: 'string', mapping: 'dlr_report_ld'},
		{name: 'dlr_report_sed', type: 'string', mapping: 'dlr_report_sed'},
		{name: 'dlr_report_pd', type: 'string', mapping: 'dlr_report_pd'},
		{name: 'dlr_report_cb', type: 'string', mapping: 'dlr_report_cb'},
		{name: 'dlr_report_m', type: 'string', mapping: 'dlr_report_m'}
	]);
	//eof
	
	//function for json writer of detail
	var anamnesa_problem_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	lr_detail_DataStore = new Ext.data.Store({
		id: 'lr_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lesson_report&m=detail_lr', 
			method: 'POST'
		}),
		reader: lr_detail_reader,
		baseParams:{start: 0, limit: pageS},
		sortInfo:{field: 'dlr_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_lr_detail= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof

	/*=== cbo_student_detailDataStore ==> mengambil "Detail Produk" dari detailList Modul Order Pembelian ===*/
	cbo_student_detailDataStore = new Ext.data.Store({
		id: 'cbo_student_detailDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lesson_report&m=get_student_list',
			method: 'POST'
		}),
		baseParams: {task: 'list', start:0,limit:pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'student_id'
		},[
			{name: 'student_id', type: 'int', mapping: 'cust_id'},
			{name: 'student_nama', type: 'string', mapping: 'cust_nama'},

		]),
		sortInfo:{field: 'student_nama', direction: "ASC"}
	});
	/*======= END cbo_student_detailDataStore =======*/

	var student_detail_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{student_nama}</b></span>',
        '</div></tpl>'
    );

	var combo_student=new Ext.form.ComboBox({
			store: cbo_student_detailDataStore,
			typeAhead: false,
			mode : 'remote',
			displayField: 'student_nama',
			valueField: 'student_id',
			lazyRender: false,
			disabled : false,
			pageSize: pageS,
			tpl: student_detail_tpl,
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			listClass: 'x-combo-list-small',
			anchor: '95%'
	});
	
	//declaration of detail coloumn model
	lr_detail_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: 'Student',
			dataIndex: 'dlr_student',
			width: 150,
			sortable: true,
			editor: combo_student,
			renderer: Ext.util.Format.comboRenderer(combo_student)
		},
		{
			header: 'Report LD',
			dataIndex: 'dlr_report_ld',
			width: 75,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		},
		{
			header: 'Report SED',
			dataIndex: 'dlr_report_sed',
			width: 75,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		},
		{
			header: 'Report PD',
			dataIndex: 'dlr_report_pd',
			width: 75,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		},
		{
			header: 'Report B/CB',
			dataIndex: 'dlr_report_cb',
			width: 75,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		},
		{
			header: 'Report M',
			dataIndex: 'dlr_report_m',
			width: 75,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		}]
	);
	lr_detail_ColumnModel.defaultSortable= true;
	//eof
	
	
	
	//declaration of detail list editor grid
	lr_detailListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lr_detailListEditorGrid',
		el: 'fp_lesson_report_problem',
		title: 'Student Appraisal',
		height: 250,
		width: 690,
		autoScroll: true,
		store: lr_detail_DataStore, // DataStore
		colModel: lr_detail_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_lr_detail],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		/*
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: lr_detail_DataStore,
			displayInfo: true
		})
		*/
		/*
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_LESSONREPORT'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: lr_detail_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: lr_detail_confirm_delete
		}
		]
		<?php } ?>
		*/
	});
	//eof
	
	
	//function of detail add
	function lr_detail_add(){
		var edit_lr_detail= new lr_detailListEditorGrid.store.recordType({
			dlr_id				:0,		
			dlr_master			:0,		
			dlr_subject			:0,		
			dlr_report			:''		
		});
		editor_lr_detail.stopEditing();
		lr_detail_DataStore.insert(0, edit_lr_detail);
		lr_detailListEditorGrid.getView().refresh();
		lr_detailListEditorGrid.getSelectionModel().selectRow(0);
		editor_lr_detail.startEditing(0);
	}

	//function for editor of detail
	var editor_lr_plan= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	//declaration of detail coloumn model
	lr_plan_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: 'LD',
			dataIndex: 'dlr_subject',
			width: 150,
			editable: true,
			//sortable: true,
			editor: new Ext.form.TextArea({
				maxLength: 500
          	})
		},
		{
			header: 'SED',
			dataIndex: 'dlr_report',
			width: 150,
			//sortable: true,
			editor: new Ext.form.TextArea({
				maxLength: 500
          	})
		},
		{
			header: 'PD',
			dataIndex: 'dlr_report',
			width: 150,
			//sortable: true,
			editor: new Ext.form.TextArea({
				maxLength: 500
          	})
		},
		{
			header: 'B/CB',
			dataIndex: 'dlr_report',
			width: 150,
			//sortable: true,
			editor: new Ext.form.TextArea({
				maxLength: 500
          	})
		},
		{
			header: 'M',
			dataIndex: 'dlr_report',
			width: 150,
			//sortable: true,
			editor: new Ext.form.TextArea({
				maxLength: 500
          	})
		}]
	);
	lr_plan_ColumnModel.defaultSortable= true;
	//eof

	//declaration of detail list editor grid
	lr_planListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lr_planListEditorGrid',
		el: 'fp_lesson_report_plan',
		title: 'Lesson Plan',
		height: 80,
		width: 690,
		autoScroll: true,
		store: lr_detail_DataStore, // DataStore
		colModel: lr_plan_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_lr_plan],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true},
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: lr_detail_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: lr_detail_confirm_delete
		}
		]

	});
	//eof
	
	//function for refresh detail
	function refresh_anamnesa_problem(){
		lr_detail_DataStore.commitChanges();
		lr_detailListEditorGrid.getView().refresh();
		//lr_planListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function anamnesa_problem_insert(pkid){
		/*for(i=0;i<lr_detail_DataStore.getCount();i++){
			anamnesa_problem_record=lr_detail_DataStore.getAt(i);
			Ext.Ajax.request({
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_lesson_report&m=detail_anamnesa_problem_insert',
				params:{
				panam_id	: anamnesa_problem_record.data.panam_id, 
				panam_master	: eval(lr_idField.getValue()), 
				panam_problem	: anamnesa_problem_record.data.panam_problem, 
				panam_lamaproblem	: anamnesa_problem_record.data.panam_lamaproblem, 
				panam_aksiproblem	: anamnesa_problem_record.data.panam_aksiproblem, 
				panam_aksiket	: anamnesa_problem_record.data.panam_aksiket 
				
				}
			});
		}*/
		
		var panam_id = [];
        var panam_problem = [];
        var panam_lamaproblem = [];
        var panam_aksiproblem = [];
        var panam_aksiket = [];
		
        
        if(lr_detail_DataStore.getCount()>0){
            for(i=0; i<lr_detail_DataStore.getCount();i++){
                if(lr_detail_DataStore.getAt(i).data.panam_problem!==""
				   && lr_detail_DataStore.getAt(i).data.panam_lamaproblem!==""){
                    
                  	panam_id.push(lr_detail_DataStore.getAt(i).data.panam_id);
					panam_problem.push(lr_detail_DataStore.getAt(i).data.panam_problem);
                   	panam_lamaproblem.push(lr_detail_DataStore.getAt(i).data.panam_lamaproblem);
					panam_aksiproblem.push(lr_detail_DataStore.getAt(i).data.panam_aksiproblem);
					panam_aksiket.push(lr_detail_DataStore.getAt(i).data.panam_aksiket);
                }
            }
			
			var encoded_array_panam_id = Ext.encode(panam_id);
			var encoded_array_panam_problem = Ext.encode(panam_problem);
			var encoded_array_panam_lamaproblem = Ext.encode(panam_lamaproblem);
			var encoded_array_panam_aksiproblem = Ext.encode(panam_aksiproblem);
			var encoded_array_panam_aksiket = Ext.encode(panam_aksiket);
				
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_lesson_report&m=detail_anamnesa_problem_insert',
				params:{
					panam_id		: encoded_array_panam_id,
					panam_master	: pkid, 
					panam_problem	: encoded_array_panam_problem,
					panam_lamaproblem	: encoded_array_panam_lamaproblem,
					panam_aksiproblem	: encoded_array_panam_aksiproblem,
					panam_aksiket	: encoded_array_panam_aksiket
				},
				success:function(response){
					lr_DataStore.reload()
				},
				failure: function(response){
					Ext.MessageBox.hide();
					var result=response.responseText;
					Ext.MessageBox.show({
					   title: 'Error',
					   msg: 'Tidak bisa terhubung dengan database server',
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
					});	
				}
			});
					
        }
		
	}
	//eof
	
	
	/* Function for Delete Confirm of detail */
	function lr_detail_confirm_delete(){
		// only one record is selected here
		if(lr_detailListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', anamnesa_problem_delete);
		} else if(lr_detailListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', anamnesa_problem_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada yang dipilih untuk dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function anamnesa_problem_delete(btn){
		if(btn=='yes'){
			var s = lr_detailListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				lr_detail_DataStore.remove(r);
			}
		}  
	}
	//eof

	// FUNCTION PRINT
	function print_only(){
		cetak_jproduk=1;		
		var jproduk_id_for_cetak = 0;
		if(lr_idField.getValue()!== null){
			jproduk_id_for_cetak = lr_idField.getValue();
		}
		if(cetak_jproduk==1){
			jproduk_cetak_print_only(jproduk_id_for_cetak);
			cetak_jproduk=0;
		}
		
	}

	function jproduk_cetak_print_only(master_id){ 
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_lesson_report&m=print_only',
			params: { jproduk_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./report_cetak.html','Print Report','height=480,width=1340,resizable=1,scrollbars=0, menubar=0');
					//jproduk_btn_cancel();
					break;
				default:
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Unable to print the grid!',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
					break;
				}  
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
				   title: 'Error',
				   msg: 'Could not connect to the database. retry later.',
				   buttons: Ext.MessageBox.OK,
				   animEl: 'database',
				   icon: Ext.MessageBox.ERROR
				});		
			} 	                     
		});
	}	
	// EOF FUNCTION PRINT
	
	//event on update of detail data store
	lr_detail_DataStore.on('update', refresh_anamnesa_problem);
	
	/* Function for retrieve create Window Panel*/ 
	lr_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 700,        
		items: [anamnesa_masterGroup,/*lr_planListEditorGrid,*/lr_ldField, lr_sedField, lr_pdField, lr_cbField, lr_mField,lr_detailListEditorGrid],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_LESSONREPORT'))){ ?>
			{
				text: 'Print Only',
				ref: '../PrintOnlyButton',
				handler: print_only
			},
			{
				xtype:'spacer',
				width: 350
			},
			{
				text: 'Save and Close',
				handler: lr_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					lr_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	lr_createWindow= new Ext.Window({
		id: 'lr_createWindow',
		title: post2db+'Lesson Report',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_lesson_report_create',
		items: lr_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function anamnesa_list_search(){
		// render according to a SQL date format.
		var anam_id_search=null;
		var anam_cust_search=null;
		var anam_tanggal_search_date="";
		var anam_petugas_search=null;
		var anam_pengobatan_search=null;
		var anam_perawatan_search=null;
		var anam_terapi_search=null;
		var anam_alergi_search=null;
		var anam_obatalergi_search=null;
		var anam_efekobatalergi_search=null;
		var anam_hamil_search=null;
		var anam_kb_search=null;
		var anam_harapan_search=null;

		if(anam_idSearchField.getValue()!==null){anam_id_search=anam_idSearchField.getValue();}
		if(anam_custSearchField.getValue()!==null){anam_cust_search=anam_custSearchField.getValue();}
		if(anam_tanggalSearchField.getValue()!==""){anam_tanggal_search_date=anam_tanggalSearchField.getValue().format('Y-m-d');}
		if(anam_petugasSearchField.getValue()!==null){anam_petugas_search=anam_petugasSearchField.getValue();}
		if(anam_pengobatanSearchField.getValue()!==null){anam_pengobatan_search=anam_pengobatanSearchField.getValue();}
		if(anam_perawatanSearchField.getValue()!==null){anam_perawatan_search=anam_perawatanSearchField.getValue();}
		if(anam_terapiSearchField.getValue()!==null){anam_terapi_search=anam_terapiSearchField.getValue();}
		if(anam_alergiSearchField.getValue()!==null){anam_alergi_search=anam_alergiSearchField.getValue();}
		if(anam_obatalergiSearchField.getValue()!==null){anam_obatalergi_search=anam_obatalergiSearchField.getValue();}
		if(anam_efekobatalergiSearchField.getValue()!==null){anam_efekobatalergi_search=anam_efekobatalergiSearchField.getValue();}
		if(anam_hamilSearchField.getValue()!==null){anam_hamil_search=anam_hamilSearchField.getValue();}
		if(anam_kbSearchField.getValue()!==null){anam_kb_search=anam_kbSearchField.getValue();}
		if(anam_harapanSearchField.getValue()!==null){anam_harapan_search=anam_harapanSearchField.getValue();}
		// change the store parameters
		lr_DataStore.baseParams = {
			task: 'SEARCH',
			lr_id	:	anam_id_search, 
			lr_cust	:	anam_cust_search, 
			lr_tanggal	:	anam_tanggal_search_date, 
			anam_petugas	:	anam_petugas_search, 
			anam_pengobatan	:	anam_pengobatan_search, 
			anam_perawatan	:	anam_perawatan_search, 
			anam_terapi	:	anam_terapi_search, 
			anam_alergi	:	anam_alergi_search, 
			anam_obatalergi	:	anam_obatalergi_search, 
			anam_efekobatalergi	:	anam_efekobatalergi_search, 
			anam_hamil	:	anam_hamil_search, 
			anam_kb	:	anam_kb_search, 
			anam_harapan	:	anam_harapan_search
		};
		// Cause the datastore to do another query : 
		lr_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function anamnesa_reset_search(){
		// reset the store parameters
		lr_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		lr_DataStore.reload({params: {start: 0, limit: pageS}});
		lr_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  lr_id Search Field */
	anam_idSearchField= new Ext.form.NumberField({
		id: 'anam_idSearchField',
		fieldLabel: 'Anam Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  lr_cust Search Field */
	anam_custSearchField= new Ext.form.ComboBox({
		id: 'anam_custSearchField',
		store: cust_lr_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	
	});
	/* Identify  lr_tanggal Search Field */
	anam_tanggalSearchField= new Ext.form.DateField({
		id: 'anam_tanggalSearchField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d'
	
	});
	/* Identify  anam_petugas Search Field */
	anam_petugasSearchField= new Ext.form.ComboBox({
		id: 'anam_petugasSearchField',
		fieldLabel: 'Lesson Plan',
		store: lesson_plan_DataStore,
		mode: 'remote',
		displayField:'lesplan_code',
		valueField: 'lesplan_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: lesson_plan_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	
	});
	/* Identify  anam_pengobatan Search Field */
	anam_pengobatanSearchField= new Ext.form.TextField({
		id: 'anam_pengobatanSearchField',
		fieldLabel: 'Pengobatan',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  anam_perawatan Search Field */
	anam_perawatanSearchField= new Ext.form.TextField({
		id: 'anam_perawatanSearchField',
		fieldLabel: 'Perawatan',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  anam_terapi Search Field */
	anam_terapiSearchField= new Ext.form.TextField({
		id: 'anam_terapiSearchField',
		fieldLabel: 'Terapi',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  anam_alergi Search Field */
	anam_alergiSearchField= new Ext.form.TextField({
		id: 'anam_alergiSearchField',
		fieldLabel: 'Alergi',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  anam_obatalergi Search Field */
	anam_obatalergiSearchField= new Ext.form.TextField({
		id: 'anam_obatalergiSearchField',
		fieldLabel: 'Alergi terhadap Obat',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  anam_efekobatalergi Search Field */
	anam_efekobatalergiSearchField= new Ext.form.TextField({
		id: 'anam_efekobatalergiSearchField',
		fieldLabel: 'Efek Alergi',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  anam_hamil Search Field */
	anam_hamilSearchField= new Ext.form.ComboBox({
		id: 'anam_hamilSearchField',
		fieldLabel: 'Hamil',
		store:new Ext.data.SimpleStore({
			fields:['value', 'anam_hamil'],
			data:[['Y','Y'],['T','T']]
		}),
		mode: 'local',
		displayField: 'anam_hamil',
		valueField: 'value',
		//anchor: '95%',
		width: 60,
		triggerAction: 'all'	 
	
	});
	/* Identify  anam_kb Search Field */
	anam_kbSearchField= new Ext.form.TextField({
		id: 'anam_kbSearchField',
		fieldLabel: 'KB yang digunakan',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  anam_harapan Search Field */
	anam_harapanSearchField= new Ext.form.TextField({
		id: 'anam_harapanSearchField',
		fieldLabel: 'Harapan',
		maxLength: 500,
		anchor: '95%'
	
	});
    
	/* Function for retrieve search Form Panel */
	anamnesa_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 600,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [anam_tanggalSearchField, anam_petugasSearchField, anam_custSearchField, anam_hamilSearchField, anam_pengobatanSearchField,
						anam_perawatanSearchField, anam_terapiSearchField] 
			}
 
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [anam_alergiSearchField, anam_obatalergiSearchField, anam_efekobatalergiSearchField, 
						anam_kbSearchField, anam_harapanSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: anamnesa_list_search
			},{
				text: 'Close',
				handler: function(){
					lr_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	lr_searchWindow = new Ext.Window({
		title: 'Lesson Report Search',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_lesson_report_search',
		items: anamnesa_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!lr_searchWindow.isVisible()){
			lr_searchWindow.show();
		} else {
			lr_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function anamnesa_print(){
		var searchquery = "";
		var anam_cust_print=null;
		var anam_tanggal_print_date="";
		var anam_petugas_print=null;
		var anam_pengobatan_print=null;
		var anam_perawatan_print=null;
		var anam_terapi_print=null;
		var anam_alergi_print=null;
		var anam_obatalergi_print=null;
		var anam_efekobatalergi_print=null;
		var anam_hamil_print=null;
		var anam_kb_print=null;
		var anam_harapan_print=null;
		var win;              
		// check if we do have some search data...
		if(lr_DataStore.baseParams.query!==null){searchquery = lr_DataStore.baseParams.query;}
		if(lr_DataStore.baseParams.lr_cust!==null){anam_cust_print = lr_DataStore.baseParams.lr_cust;}
		if(lr_DataStore.baseParams.lr_tanggal!==""){anam_tanggal_print_date = lr_DataStore.baseParams.lr_tanggal;}
		if(lr_DataStore.baseParams.anam_petugas!==null){anam_petugas_print = lr_DataStore.baseParams.anam_petugas;}
		if(lr_DataStore.baseParams.anam_pengobatan!==null){anam_pengobatan_print = lr_DataStore.baseParams.anam_pengobatan;}
		if(lr_DataStore.baseParams.anam_perawatan!==null){anam_perawatan_print = lr_DataStore.baseParams.anam_perawatan;}
		if(lr_DataStore.baseParams.anam_terapi!==null){anam_terapi_print = lr_DataStore.baseParams.anam_terapi;}
		if(lr_DataStore.baseParams.anam_alergi!==null){anam_alergi_print = lr_DataStore.baseParams.anam_alergi;}
		if(lr_DataStore.baseParams.anam_obatalergi!==null){anam_obatalergi_print = lr_DataStore.baseParams.anam_obatalergi;}
		if(lr_DataStore.baseParams.anam_efekobatalergi!==null){anam_efekobatalergi_print = lr_DataStore.baseParams.anam_efekobatalergi;}
		if(lr_DataStore.baseParams.anam_hamil!==null){anam_hamil_print = lr_DataStore.baseParams.anam_hamil;}
		if(lr_DataStore.baseParams.anam_kb!==null){anam_kb_print = lr_DataStore.baseParams.anam_kb;}
		if(lr_DataStore.baseParams.anam_harapan!==null){anam_harapan_print = lr_DataStore.baseParams.anam_harapan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lesson_report&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			lr_cust : anam_cust_print,
		  	lr_tanggal : anam_tanggal_print_date, 
			anam_petugas : anam_petugas_print,
			anam_pengobatan : anam_pengobatan_print,
			anam_perawatan : anam_perawatan_print,
			anam_terapi : anam_terapi_print,
			anam_alergi : anam_alergi_print,
			anam_obatalergi : anam_obatalergi_print,
			anam_efekobatalergi : anam_efekobatalergi_print,
			anam_hamil : anam_hamil_print,
			anam_kb : anam_kb_print,
			anam_harapan : anam_harapan_print,
		  	currentlisting: lr_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./anamnesalist.html','anamnesalist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Cannot print the data!',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
				break;
		  	}  
		},
		failure: function(response){
		  	var result=response.responseText;
			Ext.MessageBox.show({
			   title: 'Error',
			   msg: 'Tidak bisa terhubung dengan database server',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});		
		} 	                     
		});
	}
	/* Enf Function */
	
	/* Function for print Export to Excel Grid */
	function anamnesa_export_excel(){
		var searchquery = "";
		var anam_cust_2excel=null;
		var anam_tanggal_2excel_date="";
		var anam_petugas_2excel=null;
		var anam_pengobatan_2excel=null;
		var anam_perawatan_2excel=null;
		var anam_terapi_2excel=null;
		var anam_alergi_2excel=null;
		var anam_obatalergi_2excel=null;
		var anam_efekobatalergi_2excel=null;
		var anam_hamil_2excel=null;
		var anam_kb_2excel=null;
		var anam_harapan_2excel=null;
		var win;              
		// check if we do have some search data...
		if(lr_DataStore.baseParams.query!==null){searchquery = lr_DataStore.baseParams.query;}
		if(lr_DataStore.baseParams.lr_cust!==null){anam_cust_2excel = lr_DataStore.baseParams.lr_cust;}
		if(lr_DataStore.baseParams.lr_tanggal!==""){anam_tanggal_2excel_date = lr_DataStore.baseParams.lr_tanggal;}
		if(lr_DataStore.baseParams.anam_petugas!==null){anam_petugas_2excel = lr_DataStore.baseParams.anam_petugas;}
		if(lr_DataStore.baseParams.anam_pengobatan!==null){anam_pengobatan_2excel = lr_DataStore.baseParams.anam_pengobatan;}
		if(lr_DataStore.baseParams.anam_perawatan!==null){anam_perawatan_2excel = lr_DataStore.baseParams.anam_perawatan;}
		if(lr_DataStore.baseParams.anam_terapi!==null){anam_terapi_2excel = lr_DataStore.baseParams.anam_terapi;}
		if(lr_DataStore.baseParams.anam_alergi!==null){anam_alergi_2excel = lr_DataStore.baseParams.anam_alergi;}
		if(lr_DataStore.baseParams.anam_obatalergi!==null){anam_obatalergi_2excel = lr_DataStore.baseParams.anam_obatalergi;}
		if(lr_DataStore.baseParams.anam_efekobatalergi!==null){anam_efekobatalergi_2excel = lr_DataStore.baseParams.anam_efekobatalergi;}
		if(lr_DataStore.baseParams.anam_hamil!==null){anam_hamil_2excel = lr_DataStore.baseParams.anam_hamil;}
		if(lr_DataStore.baseParams.anam_kb!==null){anam_kb_2excel = lr_DataStore.baseParams.anam_kb;}
		if(lr_DataStore.baseParams.anam_harapan!==null){anam_harapan_2excel = lr_DataStore.baseParams.anam_harapan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lesson_report&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			lr_cust : anam_cust_2excel,
		  	lr_tanggal : anam_tanggal_2excel_date, 
			anam_petugas : anam_petugas_2excel,
			anam_pengobatan : anam_pengobatan_2excel,
			anam_perawatan : anam_perawatan_2excel,
			anam_terapi : anam_terapi_2excel,
			anam_alergi : anam_alergi_2excel,
			anam_obatalergi : anam_obatalergi_2excel,
			anam_efekobatalergi : anam_efekobatalergi_2excel,
			anam_hamil : anam_hamil_2excel,
			anam_kb : anam_kb_2excel,
			anam_harapan : anam_harapan_2excel,
		  	currentlisting: lr_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.location=('./export2excel.php');
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Tidak bisa meng-export data ke dalam format excel!',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
				break;
		  	}  
		},
		failure: function(response){
		  	var result=response.responseText;
			Ext.MessageBox.show({
			   title: 'Error',
			   msg: 'Tidak bisa terhubung dengan database server',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});    
		} 	                     
		});
	}
	/*End of Function */
	
	// EVENT
	lr_classField.on("select",function(){
	//	alert('masuk');
	
			var j=class_DataStore.findExact('class_id',lr_classField.getValue());
		
			lr_classstudent_detail_DataStore.load({
				params:{orderid: lr_classField.getValue()},
				callback: function(r,opt,success){
					if(success==true){
						cbo_student_detailDataStore.setBaseParam('task','order');
						cbo_student_detailDataStore.setBaseParam('class_id',lr_classField.getValue());
						cbo_student_detailDataStore.load({
							callback: function(r,opt,success){
								if(success==true){

									lr_detail_DataStore.removeAll();
									for(i=0;i<lr_classstudent_detail_DataStore.getCount();i++){
											var detail_order_record=lr_classstudent_detail_DataStore.getAt(i);
											lr_detail_DataStore.insert(i,detail_order_record);
									}
								}
								
							}
						});
					}
				}
			});
			lr_detail_DataStore.commitChanges();
			//detail_terima_beli_total();
		
		});
		
	});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_lesson_report"></div>
         <div id="fp_lesson_report_problem"></div>
        	<div id="elwindow_lesson_report_create"></div>
        <div id="elwindow_lesson_report_search"></div>
    </div>
</div>
</body>