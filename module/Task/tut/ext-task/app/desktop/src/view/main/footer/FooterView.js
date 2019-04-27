Ext.define('extTask.view.main.footer.FooterView', {
	extend: 'Ext.Toolbar',
	xtype: 'footerview',
	cls: 'footerview',

	items: [
		{ xtype: 'button',
		  text: 'Save',
                  handler: function (itm) {
                     console.log(itm.parent); }
                },
		{
			xtype: 'container',
			cls: 'footerviewtext',
			dock: 'right',
      html: '&copy; Ext JS version: ' + Ext.versions.extjs.version
			//bind: { html: '{name} footer' }
		}
	]
});
