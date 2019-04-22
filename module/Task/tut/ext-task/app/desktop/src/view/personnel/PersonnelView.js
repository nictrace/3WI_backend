// возможно тут надо define панель и в нее добавить items
Ext.define('extTask.view.personnel.PersonnelView',{
	extend: 'Ext.grid.Grid',
	xtype: 'personnelview',
	cls: 'personnelview',
	requires: [],
	controller: {type: 'personnelviewcontroller'},
//	viewModel: {type: 'personnelviewmodel'},
	store: {type: 'personnelviewstore'},
	columns: [
		{xtype:'rownumberer', text: 'Id',dataIndex: 'id'},
		{text: 'Name',dataIndex: 'name', width: 230,cell: {userCls: 'bold'}, editable: true},
		{
			editor: {
				xtype: 'combobox',
				store: {fields: ['grade'], data:[{'grade': 'среднее'},{'grade': 'бакалавр'},{'grade': 'магистр'},{'grade': 'ученая степень'},{'grade': 'несколько высших'}]},
				displayField: 'grade',
				valueField: 'grade'
			},
			text: 'Degree',
			dataIndex: 'grade',
			width: 100,
			sortable: false,
			editable: true,
		},
		{text: 'City', dataIndex: 'city', editable: false}
	],
	plugins: {
            grideditable: {
                triggerEvent: 'childdoubletap',
                enableDeleteButton: false,
                formConfig: null,
                defaultFormConfig: {
                    xtype: 'formpanel',
                    scrollable: true,
                    items: [{
                        xtype: 'fieldset'
                    }]
                },
                toolbarConfig: {
                    xtype: 'titlebar',
                    docked: 'top',
                    items: [{
                        xtype: 'button',
//                        ui: 'decline',
                        text: 'Cancel',
                        align: 'left',
                        action: 'cancel'
                    }, {
                        xtype: 'button',
//                        ui: 'confirm',
                        text: 'Save',
                        align: 'right',
                        action: 'submit'
                    }]
                }
            }
        }
});
