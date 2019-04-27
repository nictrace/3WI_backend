Ext.define('extTask.view.home.LolStore', {
        extend: 'Ext.data.Store',
        alias: 'store.lolstore',
	storeId: 'tbData',
        autoLoad: true,
        autoSync: true,
	pageSize: 12,
        fields: [
                {name: 'id',  type: 'int', allowNull: true}, 'city'
        ],
        proxy: { //type: 'customproxy',
                type: 'rest',
                url: '/api/city',
                reader: {
                    type: 'json',
		    rootProperty: 'payload',
		    messageProperty: 'message'
                },
                writer: {
                    type: 'json',
                    method: 'post',
		    listeners: {
			exception: {
			    fn: function(u,d){ console.log('exception'); console.log(u); }
			}
		    }
                }
        },
	listeners: {
		'add': function(store, records, index, eOpts){ console.log('adding...'); console.log(records); }
	}

});
