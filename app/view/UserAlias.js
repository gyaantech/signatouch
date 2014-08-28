/*
 * File: app/view/UserAlias.js
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

Ext.define('SignaTouch.view.UserAlias', {
    extend: 'Ext.window.Window',
    alias: 'widget.Alias',

    requires: [
        'Ext.form.field.Display'
    ],

    height: 250,
    width: 400,
    title: 'View Alias',
    modal: true,

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'displayfield',
                    id: 'AliasID',
                    labelSeparator: '&nbsp;'
                }
            ],
            listeners: {
                show: {
                    fn: me.onWindowShow,
                    scope: me
                }
            }
        });

        me.callParent(arguments);
    },

    onWindowShow: function(component, eOpts) {
        Ext.getCmp('AliasID').setValue(localStorage.getItem("physician_alias"));

        localStorage.removeItem("physician_alias"); //remove

    }

});