/*
 * File: app/store/SectionA1GridBind.js
 *
 * This file was generated by Sencha Architect version 3.0.4.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 4.2.x library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 4.2.x. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

Ext.define('SignaTouch.store.SectionA1GridBind', {
    extend: 'Ext.data.Store',

    requires: [
        'SignaTouch.model.SectionA1GridBind',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            defaultSortDirection: 'DESC',
            autoLoad: true,
            batchUpdateMode: 'complete',
            model: 'SignaTouch.model.SectionA1GridBind',
            remoteFilter: true,
            storeId: 'SectionA1GridBind',
            pageSize: 10,
            proxy: {
                type: 'ajax',
                url: 'services/SectionA.php?action=get_SectionA1GridBind',
                reader: {
                    type: 'json',
                    root: 'data'
                }
            }
        }, cfg)]);
    }
});