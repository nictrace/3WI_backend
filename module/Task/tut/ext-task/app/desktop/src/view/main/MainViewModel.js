Ext.define('extTask.view.main.MainViewModel', {
	extend: 'Ext.app.ViewModel',
	alias: 'viewmodel.mainviewmodel',
	data: {
		name: 'extTask',
		navCollapsed:       false,
		navview_max_width:    300,
		navview_min_width:     44,
		topview_height:        75,
		bottomview_height:     50,
		headerview_height:     50,
		footerview_height:     50,
		detailCollapsed:     true,
		detailview_width:      10,
		detailview_max_width: 300,
		detailview_min_width:   0,

	},
	formulas: {
		navview_width: function(get) {
			return get('navCollapsed') ? get('navview_min_width') : get('navview_max_width');
		},
		detailview_width: function(get) {
			return get('detailCollapsed') ? get('detailview_min_width') : get('detailview_max_width');
		}
	},
	stores: {
		menu: {
			"type": "tree",
			"root": {
				"expanded": true,
				"children": [
          				{ "text": "Cities", "iconCls": "x-fa fa-home", "xtype": "homeview", "leaf": true },
					{ "text": "Customers", "iconCls": "x-fa fa-address-card", "xtype": "personnelview","leaf": true },
					/*{ "text": "Grades","iconCls": "x-fa fa-university", "leaf": true, "xtype": "gradeview"},*/
					//add new items on the next line (from sencha-node generate viewpackage)

				]
			}
		}
	}
});
