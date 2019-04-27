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
			rootProperty: 'data',

			transform: function (response) {
			for (i = 0; i < response.data.length; i++) {
			    if (response.data[i].city_id !== null) {
				if (response.data[i].city_id.indexOf(',') > -1) {
				    var a = response.data[i].city_id.split(',');
				    response.data[i].city_id = a;
				}
			    }
			}
			return response;
		    }
		},
		writer: {
		    type: 'json',
		    method: 'post'
		}

	}
});
