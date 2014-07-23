/*
 * File: app/store/SectionBGridBind.js
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

Ext.define('SignaTouch.store.SectionBGridBind', {
    extend: 'Ext.data.Store',

    requires: [
        'SignaTouch.model.SectionBGridBind',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            defaultSortDirection: 'DESC',
            autoLoad: true,
            model: 'SignaTouch.model.SectionBGridBind',
            storeId: 'SectionBGridBind',
            pageSize: 10,
            proxy: {
                type: 'ajax',
                url: 'services/SectionB.php?action=get_SectionBGridBind',
                reader: {
                    type: 'json',
                    root: 'data'
                }
            }
        }, cfg)]);
    }
});