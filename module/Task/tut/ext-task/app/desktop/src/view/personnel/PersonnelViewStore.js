Ext.define('extTask.view.personnel.PersonnelViewStore', {
	extend: 'Ext.data.Store',
	alias: 'store.personnelviewstore',
	autoLoad: true,
        autoSync: true,
	fields: [
		{name: 'id',  type: 'int', allowNull: true}, 'name', 'grade', 'city', 'city_id'
	],
	proxy: {
		type: 'rest',
		url: '/api/customer',
		reader: {
			type: 'json',
			rootProperty: 'data.items'
		},
		writer: {
		    type: 'json',
		    method: 'post'
		}

	}
});
