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
        proxy: {
                type: 'rest',
                url: '/api/city',
                reader: {
                        type: 'json',
                },
                writer: {
                    type: 'json',
                    method: 'post'
                }
        }
});
