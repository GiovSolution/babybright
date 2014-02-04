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
var lesplan_DataStore;
var lesplan_ColumnModel;
var lesplan_ListEditorGrid;
var lesplan_createForm;
var lesplan_createWindow;
var anamnesa_searchForm;
var lesplan_searchWindow;
var anamnesa_SelectedRow;
var anamnesa_ContextMenu;
//for detail data
var anamnesa_problem_DataStor;
var lesplan_detailListEditorGrid;
var lesplan_detail_ColumnModel;
var anamnesa_problem_proxy;
var anamnesa_problem_writer;
var lesplan_detail_reader;
var editor_lesplan_detail;

//declare konstant
var post2db = '';
var msg = '';
var lesplan_pageS=15;
var today = new Date().format('d-m-Y');

/* declare variable here for Field*/
var lesplan_idField;
var lesplan_codeField;
var lesplan_themeField;
var lesplan_sub_themeField;
var lesplan_character_impField;
var lesplan_custField;
var lesplan_tanggalField;
var lesplan_classField;
var lesplan_teacherField;
var lesplan_languageField;
var lesplan_special_actField;
var lesplan_bibleField;
var anam_alergiField;
var anam_obatalergiField;
var anam_efekobatalergiField;
var lesplan_weekField;
var lesplan_dayField;
var lesplan_agreementField;
var lesplan_language_subjectField;
var lesplan_special_subjectField;
var lesplan_bible_subjectField;
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
var dt= new Date();

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
			url: 'index.php?c=c_master_lesson_plan&m=get_action',
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
						lesplan_DataStore.commitChanges();
						lesplan_DataStore.reload();
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
	function lesplan_create(){
	
		if(is_lr_form_valid()){	
		var lesplan_id_create_pk=null; 
		var lesplan_tanggal_create_date=""; 
		var lesplan_class_create=null; 
		var lesplan_teacher_create=null; 
		var lesplan_theme_create=null; 
		var lesplan_sub_theme_create=null; 
		var lesplan_character_imp_create=null; 
		var lesplan_week_create=null; 
		var lesplan_day_create=null; 
		var lesplan_agreement_create=null; 

		if(lesplan_idField.getValue()!== null){lesplan_id_create_pk = lesplan_idField.getValue();}else{lr_id_create_pk=get_pk_id();} 
		if(lesplan_tanggalField.getValue()!== ""){lesplan_tanggal_create_date = lesplan_tanggalField.getValue().format('Y-m-d');} 
		if(lesplan_classField.getValue()!== ""){lesplan_class_create = lesplan_classField.getValue();} 
		if(lesplan_teacherField.getValue()!== ""){lesplan_teacher_create = lesplan_teacherField.getValue();} 
		if(lesplan_themeField.getValue()!== ""){lesplan_theme_create = lesplan_themeField.getValue();} 
		if(lesplan_sub_themeField.getValue()!== ""){lesplan_sub_theme_create = lesplan_sub_themeField.getValue();} 
		if(lesplan_character_impField.getValue()!== ""){lesplan_character_imp_create = lesplan_character_impField.getValue();} 
		if(lesplan_weekField.getValue()!== null){lesplan_week_create = lesplan_weekField.getValue();} 
		if(lesplan_dayField.getValue()!== null){lesplan_day_create = lesplan_dayField.getValue();} 
		if(lesplan_agreementField.getValue()!== null){lesplan_agreement_create = lesplan_agreementField.getValue();} 
		
		// penambahan detail lesson report
		var dlesplan_id = [];
        var dlesplan_master = [];
        var dlesplan_subject = [];
        var dlesplan_time_start = [];
        var dlesplan_time_end = [];
        var dlesplan_act = [];
        var dlesplan_materials = [];
        var dlesplan_desc = [];
       
        if(lesplan_detail_DataStore.getCount()>0){
            for(i=0; i<lesplan_detail_DataStore.getCount();i++){
                if(lesplan_detail_DataStore.getAt(i).data.dlr_subject!==""
				   && lesplan_detail_DataStore.getAt(i).data.dlr_report!==""){
                    
                  	dlesplan_id.push(lesplan_detail_DataStore.getAt(i).data.dlesplan_id);
                   	dlesplan_subject.push(lesplan_detail_DataStore.getAt(i).data.dlesplan_subject);
                   	dlesplan_time_start.push(lesplan_detail_DataStore.getAt(i).data.dlesplan_time_start);
                   	dlesplan_time_end.push(lesplan_detail_DataStore.getAt(i).data.dlesplan_time_end);
                   	dlesplan_act.push(lesplan_detail_DataStore.getAt(i).data.dlesplan_act);
                   	dlesplan_materials.push(lesplan_detail_DataStore.getAt(i).data.dlesplan_materials);
                   	dlesplan_desc.push(lesplan_detail_DataStore.getAt(i).data.dlesplan_desc);
                }
            }
			
			var encoded_array_dlesplan_id = Ext.encode(dlesplan_id);
			var encoded_array_dlesplan_time_start = Ext.encode(dlesplan_time_start);
			var encoded_array_dlesplan_time_end = Ext.encode(dlesplan_time_end);
			var encoded_array_dlesplan_act = Ext.encode(dlesplan_act);
			var encoded_array_dlesplan_materials = Ext.encode(dlesplan_materials);
			var encoded_array_dlesplan_desc = Ext.encode(dlesplan_desc);
			var encoded_array_dlesplan_subject = Ext.encode(dlesplan_subject);
			
		}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_lesson_plan&m=get_action',
			params: {
				task: post2db,
				lesplan_id				: lesplan_id_create_pk,
				lesplan_tanggal			: lesplan_tanggal_create_date, 		
				lesplan_class			: lesplan_class_create, 		
				lesplan_teacher			: lesplan_teacher_create, 		
				lesplan_theme			: lesplan_theme_create, 		
				lesplan_sub_theme		: lesplan_sub_theme_create, 		
				lesplan_character_imp	: lesplan_character_imp_create, 		
				lesplan_week			: lesplan_week_create, 
				lesplan_day				: lesplan_day_create,
				lesplan_agreement		: lesplan_agreement_create,

				// detail lr 
				dlesplan_id				: encoded_array_dlesplan_id, 
				dlesplan_time_start		: encoded_array_dlesplan_time_start, 
				dlesplan_time_end		: encoded_array_dlesplan_time_end, 
				dlesplan_act			: encoded_array_dlesplan_act, 
				dlesplan_materials		: encoded_array_dlesplan_materials, 
				dlesplan_desc			: encoded_array_dlesplan_desc, 
				dlesplan_master			: eval(get_pk_id()),
				dlesplan_subject		: encoded_array_dlesplan_subject, 
			}, 
			success: function(response){             
								
				var result=eval(response.responseText);
				if(result!==0){
						//anamnesa_problem_insert(result)
						lesplan_DataStore.reload();
						Ext.MessageBox.alert(post2db+' OK','Lesson Plan Data is Already Saved');
						lesplan_createWindow.hide();
				}else{
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Lesson Plan Data can not be Saved',
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
			return lesplan_ListEditorGrid.getSelectionModel().getSelected().get('lesplan_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function anamnesa_reset_form(){
		lesplan_idField.reset();
		lesplan_idField.setValue(null);
		lesplan_codeField.reset();
		lesplan_codeField.setValue(null);
		lesplan_themeField.reset();
		lesplan_themeField.setValue(null);
		lesplan_sub_themeField.reset();
		lesplan_sub_themeField.setValue(null);		
		lesplan_character_impField.reset();
		lesplan_character_impField.setValue(null);
		lesplan_custField.reset();
		lesplan_custField.setValue(null);
		lesplan_tanggalField.reset();
		lesplan_tanggalField.setValue(dt.format('Y-m-d'));
		lesplan_classField.reset();
		lesplan_classField.setValue(null);
		lesplan_teacherField.reset();
		lesplan_teacherField.setValue(null);
		lesplan_languageField.reset();
		lesplan_languageField.setValue(null);
		lesplan_special_actField.reset();
		lesplan_special_actField.setValue(null);
		lesplan_bibleField.reset();
		lesplan_bibleField.setValue(null);
		lesplan_weekField.reset();
		lesplan_weekField.setValue(null);
		lesplan_dayField.reset();
		lesplan_dayField.setValue(null);
		lesplan_agreementField.reset();
		lesplan_agreementField.setValue('Unknown');
		lesplan_language_subjectField.reset();
		lesplan_language_subjectField.setValue(null);
		lesplan_special_subjectField.reset();
		lesplan_special_subjectField.setValue(null);
		lesplan_bible_subjectField.reset();
		lesplan_bible_subjectField.setValue(null);
		lesplan_detail_DataStore.load({params : {master_id : -1}});
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function lesplan_set_form(){
		lesplan_idField.setValue(lesplan_ListEditorGrid.getSelectionModel().getSelected().get('lesplan_id'));
		lesplan_codeField.setValue(lesplan_ListEditorGrid.getSelectionModel().getSelected().get('lesplan_code'));
		lesplan_themeField.setValue(lesplan_ListEditorGrid.getSelectionModel().getSelected().get('lesplan_theme'));
		lesplan_classField.setValue(lesplan_ListEditorGrid.getSelectionModel().getSelected().get('lesplan_class_name'));
		lesplan_teacherField.setValue(lesplan_ListEditorGrid.getSelectionModel().getSelected().get('lesplan_teacher_name'));
		lesplan_sub_themeField.setValue(lesplan_ListEditorGrid.getSelectionModel().getSelected().get('lesplan_sub_theme'));
		lesplan_character_impField.setValue(lesplan_ListEditorGrid.getSelectionModel().getSelected().get('lesplan_character_imp'));
		lesplan_tanggalField.setValue(lesplan_ListEditorGrid.getSelectionModel().getSelected().get('lesplan_tanggal'));
		lesplan_weekField.setValue(lesplan_ListEditorGrid.getSelectionModel().getSelected().get('lesplan_week'));
		lesplan_dayField.setValue(lesplan_ListEditorGrid.getSelectionModel().getSelected().get('lesplan_day'));
		lesplan_agreementField.setValue(lesplan_ListEditorGrid.getSelectionModel().getSelected().get('lesplan_agreement'));
		lesplan_detail_DataStore.load({params : {master_id : get_pk_id() }});
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_lr_form_valid(){
		return (lesplan_tanggalField.isValid() );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!lesplan_createWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			anamnesa_reset_form();
			
			lesplan_createWindow.show();
		} else {
			lesplan_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function anamnesa_confirm_delete(){
		// only one anamnesa is selected here
		if(lesplan_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', anamnesa_delete);
		} else if(lesplan_ListEditorGrid.selModel.getCount() > 1){
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
	function lesplan_confirm_update(){
		/* only one record is selected here */
		//cbo_dlr_subjectDataStore.load();	
		if(lesplan_ListEditorGrid.selModel.getCount() == 1) {
			
			post2db='UPDATE';
			msg='updated';
			lesplan_set_form();
			lesplan_createWindow.show();
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
			var selections = lesplan_ListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< lesplan_ListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.lr_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_master_lesson_plan&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							lesplan_DataStore.reload();
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
	lesplan_DataStore = new Ext.data.Store({
		id: 'lesplan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lesson_plan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: lesplan_pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'lesplan_id'
		},[
			{name: 'lesplan_id', type: 'int', mapping: 'lesplan_id'}, 
			{name: 'lesplan_code', type: 'string', mapping: 'lesplan_code'}, 
			{name: 'lesplan_theme', type: 'string', mapping: 'lesplan_theme'}, 
			{name: 'lesplan_class', type: 'int', mapping: 'lesplan_class'}, 
			{name: 'lesplan_class_name', type: 'string', mapping: 'class_name'}, 
			{name: 'lesplan_teacher', type: 'int', mapping: 'lesplan_teacher'}, 
			{name: 'lesplan_teacher_name', type: 'string', mapping: 'karyawan_nama'}, 
			{name: 'lesplan_sub_theme', type: 'string', mapping: 'lesplan_sub_theme'}, 
			{name: 'lesplan_character_imp', type: 'string', mapping: 'lesplan_character_imp'}, 
			{name: 'lesplan_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'lesplan_tanggal'}, 
			{name: 'lesplan_week', type: 'int', mapping: 'lesplan_week'}, 
			{name: 'lesplan_day', type: 'int', mapping: 'lesplan_day'}, 
			{name: 'lesplan_agreement', type: 'string', mapping: 'lesplan_agreement'}, 
			{name: 'lesplan_creator', type: 'string', mapping: 'lesplan_creator'}, 
			{name: 'lesplan_date_create', type: 'date', dateFormat: 'Y-m-d', mapping: 'lesplan_date_create'}, 
			{name: 'lesplan_update', type: 'string', mapping: 'lesplan_update'}, 
			{name: 'lesplan_date_update', type: 'date', dateFormat: 'Y-m-d', mapping: 'lesplan_date_update'}, 
			{name: 'lesplan_revised', type: 'int', mapping: 'lesplan_revised'} 
		]),
		sortInfo:{field: 'lesplan_id', direction: "DESC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	lesplan_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'lesplan_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'Lesson Plan Code',
			dataIndex: 'lesplan_code',
			width: 150,
			sortable: true
		},
		{
			header: 'Theme',
			dataIndex: 'lesplan_theme',
			width: 150,
			sortable: true
		},
		{
			header: 'Sub Theme',
			dataIndex: 'lesplan_sub_theme',
			width: 150,
			sortable: true
		}, 
		{
			header: 'Character Imp',
			dataIndex: 'lesplan_character_imp',
			width: 150,
			sortable: true
		}, 
		{
			header: 'Tanggal',
			dataIndex: 'lesplan_tanggal',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d')
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_LESSONPLAN'))){ ?>
			,
			editor: new Ext.form.DateField({
				allowBlank: false,
				format: 'Y-m-d'
			})
			<?php } ?>
		},
		{
			header: 'Week',
			dataIndex: 'lesplan_week',
			width: 150,
			sortable: true
		},
		{
			header: 'Day',
			dataIndex: 'lesplan_day',
			width: 150,
			sortable: true
		},
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
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_LESSONPLAN'))){ ?>
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
			<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_LESSONPLAN'))){ ?>
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
			<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_LESSONPLAN'))){ ?>
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
			dataIndex: 'lesplan_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'lesplan_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'lesplan_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'lesplan_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'lesplan_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	lesplan_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	lesplan_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lesplan_ListEditorGrid',
		el: 'fp_lesson_plan',
		title: 'Lesson Plan List',
		autoHeight: true,
		store: lesplan_DataStore, // DataStore
		cm: lesplan_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			lesplan_pageSize: lesplan_pageS,
			store: lesplan_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_LESSONPLAN'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_LESSONPLAN'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: lesplan_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_LESSONPLAN'))){ ?>
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
			store: lesplan_DataStore,
			params: {start: 0, limit: lesplan_pageS},
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
	lesplan_ListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	anamnesa_ContextMenu = new Ext.menu.Menu({
		id: 'anamnesa_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_LESSONPLAN'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: anamnesa_editContextMenu 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_LESSONPLAN'))){ ?>
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
		lesplan_ListEditorGrid.startEditing(anamnesa_SelectedRow,1);
  	}
	/* End of Function */
  	
	lesplan_ListEditorGrid.addListener('rowcontextmenu', onanamnesa_ListEditGridContextMenu);
	lesplan_DataStore.load({params: {start: 0, limit: lesplan_pageS}});	// load DataStore
	lesplan_ListEditorGrid.on('afteredit', anamnesa_update); // inLine Editing Record
	
	cust_lesplan_DataStore = new Ext.data.Store({
		id: 'cust_lesplan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_action',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: lesplan_pageS},
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
	
	class_DataStore = new Ext.data.Store({
		id: 'class_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lesson_plan&m=get_class',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: lesplan_pageS},
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
	
	teacher_DataStore = new Ext.data.Store({
		id: 'teacher_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lesson_plan&m=get_teacher',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: lesplan_pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'karyawan_id'
		},[
			{name: 'teacher_id', type: 'int', mapping: 'karyawan_id'},
			{name: 'teacher_name', type: 'string', mapping: 'karyawan_nama'}
		]),
		sortInfo:{field: 'teacher_name', direction: "ASC"}
	});


	var customer_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br /></span>',
			'Tgl Lahir: {cust_tgllahir:date("j M Y")}',
            /*'{cust_alamat} | {cust_telprumah}',*/
        '</div></tpl>'
    );
	
	var class_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{class_name}</b><br /></span>',
            'Time Start : {class_time_start}',' | Time End : {class_time_end}',
        '</div></tpl>'
    );

	var teacher_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{teacher_name}</b><br /></span>',
            // 'Time Start : {class_time_start}',' | Time End : {class_time_end}',
        '</div></tpl>'
    );
	
	/* Identify  lr_id Field */
	lesplan_idField= new Ext.form.NumberField({
		id: 'lesplan_idField',
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
	lesplan_custField= new Ext.form.ComboBox({
		id: 'lesplan_custField',
		fieldLabel: 'Customer',
		store: cust_lesplan_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        lesplan_pageSize:10,
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
	lesplan_tanggalField= new Ext.form.DateField({
		id: 'lesplan_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
		allowBlank: false
	});
	/* Identify lesplan_classField Field */
	lesplan_classField= new Ext.form.ComboBox({
		id: 'lesplan_classField',
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
		anchor: '90%',
		allowBlank: false
	});

	/* Identify lesplan_teacherField Field */
	lesplan_teacherField= new Ext.form.ComboBox({
		id: 'lesplan_teacherField',
		fieldLabel: 'Teacher',
		store: teacher_DataStore,
		mode: 'remote',
		displayField:'teacher_name',
		valueField: 'teacher_id',
        typeAhead: false,
        loadingText: 'Searching...',
        lesplan_pageSize:10,
        hideTrigger:false,
        tpl: teacher_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '90%',
		allowBlank: false
	});

	/* Identify  anam_pengobatan Field */
	lesplan_codeField= new Ext.form.TextField({
		id: 'lesplan_codeField',
		fieldLabel: 'Lesson Plan Code',
		readOnly: true,
		emptyText: '(Auto)',
		anchor: '90%'
	});
	lesplan_themeField= new Ext.form.TextField({
		id: 'lesplan_themeField',
		fieldLabel: 'Theme',
		readOnly: false,
		anchor: '90%'
	});
	lesplan_sub_themeField= new Ext.form.TextField({
		id: 'lesplan_sub_themeField',
		fieldLabel: 'Sub Theme',
		readOnly: false,
		anchor: '90%'
	});
	lesplan_character_impField= new Ext.form.TextField({
		id: 'lesplan_character_impField',
		fieldLabel: 'Character Imp',
		readOnly: false,
		anchor: '90%'
	});
	/* Identify  anam_pengobatan Field */
	lesplan_languageField= new Ext.form.TextArea({
		id: 'lesplan_languageField',
		fieldLabel: 'Report',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  anam_perawatan Field */
	lesplan_special_actField= new Ext.form.TextArea({
		id: 'lesplan_special_actField',
		fieldLabel: 'Report',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  anam_terapi Field */
	lesplan_bibleField= new Ext.form.TextArea({
		id: 'lesplan_bibleField',
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
	lesplan_weekField= new Ext.form.ComboBox({
		id: 'lesplan_weekField',
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
	/* Identify  lesplan_dayField Field */
	lesplan_dayField= new Ext.form.ComboBox({
		id: 'lesplan_dayField',
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
	/* Identify  lesplan_agreementField Field */
	lesplan_agreementField= new Ext.form.ComboBox({
		id: 'lesplan_agreementField',
		fieldLabel: 'Coord. Agreement',
		store:new Ext.data.SimpleStore({
			fields:['lr_agreement_value', 'lr_agreement_display'],
			data:[['Agreed','Agreed'],['Disagreed','Disagreed'],['Unknown','Unknown']]
		}),
		mode: 'local',
		<?php if($_SESSION[SESSION_GROUPID]=='1'){ ?>
			readOnly : false,
		<? } else { ?>
			readOnly : true,
		<? } ?>
		displayField: 'lr_agreement_display',
		valueField: 'lr_agreement_value',
		anchor: '90%',
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  lesplan_language_subjectField Field */
	lesplan_language_subjectField= new Ext.form.TextField({
		id: 'lesplan_language_subjectField',
		fieldLabel: 'Language Subject',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  lesplan_special_subjectField Field */
	lesplan_special_subjectField= new Ext.form.TextField({
		id: 'lesplan_special_subjectField',
		fieldLabel: 'Special Act Subject',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  lesplan_bible_subjectField Field */
	lesplan_bible_subjectField= new Ext.form.TextField({
		id: 'lesplan_bible_subjectField',
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
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [lesplan_tanggalField, lesplan_codeField, lesplan_themeField, lesplan_sub_themeField, lesplan_classField/*, lesplan_language_subjectField, lesplan_languageField , lesplan_special_subjectField, lesplan_special_actField , lesplan_bible_subjectField, lesplan_bibleField*/] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [lesplan_character_impField, lesplan_teacherField, lesplan_weekField , lesplan_dayField , lesplan_agreementField] 
			}
			
			]
	
	});
	
		
	/*Detail Declaration */
		
	// Function for json reader of detail
	var lesplan_detail_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
		{name: 'dlesplan_id', type: 'int', mapping: 'dlesplan_id'}, 
		{name: 'dlesplan_master', type: 'int', mapping: 'dlesplan_master'}, 
		{name: 'dlesplan_subject', type: 'string', mapping: 'dlesplan_subject'},
		{name: 'dlesplan_time_start', type: 'string', mapping: 'dlesplan_time_start'},
		{name: 'dlesplan_time_end', type: 'string', mapping: 'dlesplan_time_end'},
		{name: 'dlesplan_act', type: 'string', mapping: 'dlesplan_act'},
		{name: 'dlesplan_materials', type: 'string', mapping: 'dlesplan_materials'},
		{name: 'dlesplan_desc', type: 'string', mapping: 'dlesplan_description'}
	]);
	//eof
	
	//function for json writer of detail
	var anamnesa_problem_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	lesplan_detail_DataStore = new Ext.data.Store({
		id: 'lesplan_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lesson_plan&m=detail_lesson_plan_list', 
			method: 'POST'
		}),
		reader: lesplan_detail_reader,
		baseParams:{start: 0, limit: lesplan_pageS},
		sortInfo:{field: 'dlesplan_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_lesplan_detail= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof

	var lesplan_time_start= new Ext.form.ComboBox({
		id: 'lesplan_time_start',
		store:new Ext.data.SimpleStore({
			fields:['lesplan_time_start_value', 'lesplan_time_start_display'],
			data:[
					['08:00','08:00'],
					['08:10','08:10'],
					['08:20','08:20'],
					['08:30','08:30'],
					['08:45','08:45'],
					['09:15','09:15'],
					['10:00','10:00'],
					['10:10','10:10'],
					['10:20','10:20'],
					['10:30','10:30'],
					['10:45','10:45'],
					['11:15','11:15']
				]
		}),
		mode: 'local',
		displayField: 'lesplan_time_start_display',
		valueField: 'lesplan_time_start_value',
		width: 60,
		triggerAction: 'all'	
	});

	var lesplan_time_end= new Ext.form.ComboBox({
		id: 'lesplan_time_end',
		store:new Ext.data.SimpleStore({
			fields:['lesplan_time_end_value', 'lesplan_time_end_display'],
			data:[
					['08:10','08:10'],
					['08:20','08:20'],
					['08:30','08:30'],
					['08:45','08:45'],
					['09:15','09:15'],
					['09:30','09:30'],
					['10:10','10:10'],
					['10:20','10:20'],
					['10:30','10:30'],
					['10:45','10:45'],
					['11:15','11:15'],
					['11:30','11:30']
				]
		}),
		mode: 'local',
		displayField: 'lesplan_time_end_display',
		valueField: 'lesplan_time_end_value',
		width: 60,
		triggerAction: 'all'	
	});
	
	//declaration of detail coloumn model
	lesplan_detail_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: 'Objective',
			dataIndex: 'dlesplan_subject',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextArea({
				maxLength: 500
          	})
			
		},
		{
			header: 'Time Start',
			dataIndex: 'dlesplan_time_start',
			width: 75,
			sortable: true,
			editor: lesplan_time_start
		},
		{
			header: 'Time End',
			dataIndex: 'dlesplan_time_end',
			width: 75,
			sortable: true,
			editor: lesplan_time_end
		},
		{
			header: 'Activity',
			dataIndex: 'dlesplan_act',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextArea({
				maxLength: 500
          	})
		},
		{
			header: 'Teaching Aids / Materials',
			dataIndex: 'dlesplan_materials',
			width: 200,
			sortable: true,
			editor: new Ext.form.TextArea({
				maxLength: 500
          	})
		},
		{
			header: 'Description',
			dataIndex: 'dlesplan_desc',
			width: 300,
			sortable: true,
			editor: new Ext.form.TextArea({
				maxLength: 500
          	})
		}]
	);
	lesplan_detail_ColumnModel.defaultSortable= true;
	//eof
	
	
	
	//declaration of detail list editor grid
	lesplan_detailListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lesplan_detailListEditorGrid',
		el: 'fp_lesson_plan_problem',
		title: 'Detail Lesson Plan',
		height: 250,
		width: 1000,
		autoScroll: true,
		store: lesplan_detail_DataStore, // DataStore
		colModel: lesplan_detail_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_lesplan_detail],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		/*
		bbar: new Ext.PagingToolbar({
			lesplan_pageSize: lesplan_pageS,
			store: lesplan_detail_DataStore,
			displayInfo: true
		})
		*/
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_LESSONPLAN'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: lesplan_detail_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: lr_detail_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	
	//function of detail add
	function lesplan_detail_add(){
		var edit_lesplan_detail= new lesplan_detailListEditorGrid.store.recordType({
			dlesplan_id				:'',		
			dlesplan_master			:'',		
			dlesplan_subject		:'',		
			dlesplan_time_start		:'',		
			dlesplan_time_end		:'',		
			dlesplan_act			:'',		
			dlesplan_materials		:'',		
			dlesplan_desc			:'',		
		});
		editor_lesplan_detail.stopEditing();
		lesplan_detail_DataStore.insert(0, edit_lesplan_detail);
		lesplan_detailListEditorGrid.getView().refresh();
		lesplan_detailListEditorGrid.getSelectionModel().selectRow(0);
		editor_lesplan_detail.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_anamnesa_problem(){
		lesplan_detail_DataStore.commitChanges();
		lesplan_detailListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function anamnesa_problem_insert(pkid){
		/*for(i=0;i<lesplan_detail_DataStore.getCount();i++){
			anamnesa_problem_record=lesplan_detail_DataStore.getAt(i);
			Ext.Ajax.request({
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_master_lesson_plan&m=detail_anamnesa_problem_insert',
				params:{
				panam_id	: anamnesa_problem_record.data.panam_id, 
				panam_master	: eval(lesplan_idField.getValue()), 
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
		
        
        if(lesplan_detail_DataStore.getCount()>0){
            for(i=0; i<lesplan_detail_DataStore.getCount();i++){
                if(lesplan_detail_DataStore.getAt(i).data.panam_problem!==""
				   && lesplan_detail_DataStore.getAt(i).data.panam_lamaproblem!==""){
                    
                  	panam_id.push(lesplan_detail_DataStore.getAt(i).data.panam_id);
					panam_problem.push(lesplan_detail_DataStore.getAt(i).data.panam_problem);
                   	panam_lamaproblem.push(lesplan_detail_DataStore.getAt(i).data.panam_lamaproblem);
					panam_aksiproblem.push(lesplan_detail_DataStore.getAt(i).data.panam_aksiproblem);
					panam_aksiket.push(lesplan_detail_DataStore.getAt(i).data.panam_aksiket);
                }
            }
			
			var encoded_array_panam_id = Ext.encode(panam_id);
			var encoded_array_panam_problem = Ext.encode(panam_problem);
			var encoded_array_panam_lamaproblem = Ext.encode(panam_lamaproblem);
			var encoded_array_panam_aksiproblem = Ext.encode(panam_aksiproblem);
			var encoded_array_panam_aksiket = Ext.encode(panam_aksiket);
				
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_lesson_plan&m=detail_anamnesa_problem_insert',
				params:{
					panam_id		: encoded_array_panam_id,
					panam_master	: pkid, 
					panam_problem	: encoded_array_panam_problem,
					panam_lamaproblem	: encoded_array_panam_lamaproblem,
					panam_aksiproblem	: encoded_array_panam_aksiproblem,
					panam_aksiket	: encoded_array_panam_aksiket
				},
				success:function(response){
					lesplan_DataStore.reload()
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
		if(lesplan_detailListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', anamnesa_problem_delete);
		} else if(lesplan_detailListEditorGrid.selModel.getCount() > 1){
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
			var s = lesplan_detailListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				lesplan_detail_DataStore.remove(r);
			}
		}  
	}
	//eof
	
	//event on update of detail data store
	lesplan_detail_DataStore.on('update', refresh_anamnesa_problem);
	
	/* Function for retrieve create Window Panel*/ 
	lesplan_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 1000,        
		items: [anamnesa_masterGroup,lesplan_detailListEditorGrid],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_LESSONPLAN'))){ ?>
			{
				text: 'Save and Close',
				handler: lesplan_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					lesplan_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	lesplan_createWindow= new Ext.Window({
		id: 'lesplan_createWindow',
		title: post2db+'Lesson Plan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_lesson_plan_create',
		items: lesplan_createForm
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
		lesplan_DataStore.baseParams = {
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
		lesplan_DataStore.reload({params: {start: 0, limit: lesplan_pageS}});
	}
		
	/* Function for reset search result */
	function anamnesa_reset_search(){
		// reset the store parameters
		lesplan_DataStore.baseParams = { task: 'LIST', start: 0, limit: lesplan_pageS };
		lesplan_DataStore.reload({params: {start: 0, limit: lesplan_pageS}});
		lesplan_searchWindow.close();
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
		store: cust_lesplan_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        lesplan_pageSize:10,
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
		store: class_DataStore,
		mode: 'remote',
		displayField:'lesplan_code',
		valueField: 'lesplan_id',
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
					lesplan_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	lesplan_searchWindow = new Ext.Window({
		title: 'Lesson Plan Search',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_lesson_plan_search',
		items: anamnesa_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!lesplan_searchWindow.isVisible()){
			lesplan_searchWindow.show();
		} else {
			lesplan_searchWindow.toFront();
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
		if(lesplan_DataStore.baseParams.query!==null){searchquery = lesplan_DataStore.baseParams.query;}
		if(lesplan_DataStore.baseParams.lr_cust!==null){anam_cust_print = lesplan_DataStore.baseParams.lr_cust;}
		if(lesplan_DataStore.baseParams.lr_tanggal!==""){anam_tanggal_print_date = lesplan_DataStore.baseParams.lr_tanggal;}
		if(lesplan_DataStore.baseParams.anam_petugas!==null){anam_petugas_print = lesplan_DataStore.baseParams.anam_petugas;}
		if(lesplan_DataStore.baseParams.anam_pengobatan!==null){anam_pengobatan_print = lesplan_DataStore.baseParams.anam_pengobatan;}
		if(lesplan_DataStore.baseParams.anam_perawatan!==null){anam_perawatan_print = lesplan_DataStore.baseParams.anam_perawatan;}
		if(lesplan_DataStore.baseParams.anam_terapi!==null){anam_terapi_print = lesplan_DataStore.baseParams.anam_terapi;}
		if(lesplan_DataStore.baseParams.anam_alergi!==null){anam_alergi_print = lesplan_DataStore.baseParams.anam_alergi;}
		if(lesplan_DataStore.baseParams.anam_obatalergi!==null){anam_obatalergi_print = lesplan_DataStore.baseParams.anam_obatalergi;}
		if(lesplan_DataStore.baseParams.anam_efekobatalergi!==null){anam_efekobatalergi_print = lesplan_DataStore.baseParams.anam_efekobatalergi;}
		if(lesplan_DataStore.baseParams.anam_hamil!==null){anam_hamil_print = lesplan_DataStore.baseParams.anam_hamil;}
		if(lesplan_DataStore.baseParams.anam_kb!==null){anam_kb_print = lesplan_DataStore.baseParams.anam_kb;}
		if(lesplan_DataStore.baseParams.anam_harapan!==null){anam_harapan_print = lesplan_DataStore.baseParams.anam_harapan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_lesson_plan&m=get_action',
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
		  	currentlisting: lesplan_DataStore.baseParams.task // this tells us if we are searching or not
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
		if(lesplan_DataStore.baseParams.query!==null){searchquery = lesplan_DataStore.baseParams.query;}
		if(lesplan_DataStore.baseParams.lr_cust!==null){anam_cust_2excel = lesplan_DataStore.baseParams.lr_cust;}
		if(lesplan_DataStore.baseParams.lr_tanggal!==""){anam_tanggal_2excel_date = lesplan_DataStore.baseParams.lr_tanggal;}
		if(lesplan_DataStore.baseParams.anam_petugas!==null){anam_petugas_2excel = lesplan_DataStore.baseParams.anam_petugas;}
		if(lesplan_DataStore.baseParams.anam_pengobatan!==null){anam_pengobatan_2excel = lesplan_DataStore.baseParams.anam_pengobatan;}
		if(lesplan_DataStore.baseParams.anam_perawatan!==null){anam_perawatan_2excel = lesplan_DataStore.baseParams.anam_perawatan;}
		if(lesplan_DataStore.baseParams.anam_terapi!==null){anam_terapi_2excel = lesplan_DataStore.baseParams.anam_terapi;}
		if(lesplan_DataStore.baseParams.anam_alergi!==null){anam_alergi_2excel = lesplan_DataStore.baseParams.anam_alergi;}
		if(lesplan_DataStore.baseParams.anam_obatalergi!==null){anam_obatalergi_2excel = lesplan_DataStore.baseParams.anam_obatalergi;}
		if(lesplan_DataStore.baseParams.anam_efekobatalergi!==null){anam_efekobatalergi_2excel = lesplan_DataStore.baseParams.anam_efekobatalergi;}
		if(lesplan_DataStore.baseParams.anam_hamil!==null){anam_hamil_2excel = lesplan_DataStore.baseParams.anam_hamil;}
		if(lesplan_DataStore.baseParams.anam_kb!==null){anam_kb_2excel = lesplan_DataStore.baseParams.anam_kb;}
		if(lesplan_DataStore.baseParams.anam_harapan!==null){anam_harapan_2excel = lesplan_DataStore.baseParams.anam_harapan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_lesson_plan&m=get_action',
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
		  	currentlisting: lesplan_DataStore.baseParams.task // this tells us if we are searching or not
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

	function pertamax(){
		lesplan_tanggalField.setValue(dt.format('Y-m-d'));
	}
	pertamax();
	
	// EVENT
	/*
	lesplan_dayField.on('select', function(){
			cbo_dlr_subjectDataStore.load({params: {
				day: lesplan_dayField.getValue(),
				week: lesplan_weekField.getValue(),
				lesson_plan: lesplan_classField.getValue()
				}
			});
	});
	*/

	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_lesson_plan"></div>
         <div id="fp_lesson_plan_problem"></div>
		<div id="elwindow_lesson_plan_create"></div>
        <div id="elwindow_lesson_plan_search"></div>
    </div>
</div>
</body>