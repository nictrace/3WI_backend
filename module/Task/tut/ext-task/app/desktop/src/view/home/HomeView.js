Ext.define('extTask.view.home.LolGrid',{
	extend: 'Ext.grid.Grid',
	xtype: 'homeview',
	cls: 'homeview',
	controller: {type: 'homeviewcontroller'},
	viewModel: {type: 'homeviewmodel'},
        columns: [
                {text: 'Id', dataIndex: 'id', hidden: true},
                {text: 'City', dataIndex: 'city', width: 230, cell: {userCls: 'bold'}, editable: true, autoSizeColumn: true}
	],
	store: {type: 'lolstore'},
        plugins: {
            grideditable: {
                triggerEvent: 'childdoubletap',
                enableDeleteButton: false,
                formConfig: null
	    },
	    pagingtoolbar: true
	},

	items: [
	   {xtype: 'button', text: 'New', handler: function(){ Ext.Msg.prompt("ExtTask", "Please enter city:", function (btnText, sInput) {
            	if (btnText === 'ok') {
			var st = Ext.getStore('tbData');
                	st.add({id: null, city: sInput});
			//st.reload();
            	}
	     }, this);

		}
	   }
	]
});
