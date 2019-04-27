Ext.define('extTask.view.personnel.CityStore', {
	extend: 'Ext.data.Store',
	alias: 'store.citystore',
	autoLoad: true,
        autoSync: true,
	pageSize: 0,
	fields: [
		{name: 'id',  type: 'int', allowNull: true},
		'city'
	],
	proxy: {
		type: 'rest',
		url: '/api/city',
		reader: {
			type: 'json',
			rootProperty: 'payload'
		},
		writer: {
		    type: 'json'
		}
	}
});
