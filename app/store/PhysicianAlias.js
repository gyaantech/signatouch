/*
 * File: app/store/PhysicianAlias.js
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

Ext.define('SignaTouch.store.PhysicianAlias', {
    extend: 'Ext.data.Store',

    requires: [
        'SignaTouch.model.Alias',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            defaultSortDirection: 'DESC',
            autoLoad: false,
            autoSync: true,
            model: 'SignaTouch.model.Alias',
            storeId: 'PhysicianAlias',
            data: [
                
            ],
            pageSize: 10,
            proxy: {
                type: 'ajax',
                url: 'services/ZimbraPhysicianAlias.php?action=ZimbraGetPhysicianAlias&NPI=1111111111',
                reader: {
                    type: 'json'
                }
            }
        }, cfg)]);
    }
});