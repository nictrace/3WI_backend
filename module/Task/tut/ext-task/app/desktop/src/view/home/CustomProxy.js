Ext.define('extTask.view.home.CustomProxy', {
  extend: 'Ext.data.proxy.Rest',
  alias: 'proxy.customproxy',
  constructor: function(config) {
    this.addEvents('authError', 'validationError', 'serverError');
    return this.callParent(arguments);
  },
  processResponse: function(success, operation, request, response, callback, scope) {
    if (response.status !== 200) {
      this.handleError(response);
    }
    return this.callParent(arguments);
  },
  handleError: function(response) {
    switch (response.status) {
      case 400:
        return this.fireEvent('validationError', response);
      case 401:
        return this.fireEvent('authError', true);
      case 403:
        return this.fireEvent('authError', false);
      case 500:
        return this.fireEvent('serverError', response);
      default:
        return this.fireEvent('serverError', response);
    }
  }
});
