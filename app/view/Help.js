/*
 * File: app/view/Help.js
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

Ext.define('SignaTouch.view.Help', {
    extend: 'Ext.window.Window',
    alias: 'widget.HelpWindow',

    requires: [
        'Ext.container.Container'
    ],

    height: 280,
    hidden: false,
    id: 'mywindow',
    itemId: '',
    width: 705,
    bodyStyle: 'background-color:#a5cfff;',
    title: 'About CMS-484',
    hideShadowOnDeactivate: true,
    modal: true,

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'container',
                    html: '<ul style="list-style:none;text-align: center;padding-top: 25px;/* border: 1px solid red; */padding-right: 45px;">\r\n<li><img src="resources/images/SignaTouch.png"></li>\r\n<li><font size="5"><b>High Efficiency Signature Capture System<b></b></b></font></li><b><b>\r\n<li><b>Version : </b> 2.2</li>\r\n<li><b>© 2014 SignaTouch Corporation - All Rights Reserved</b></li>\r\n</b></b></ul>'
                }
            ]
        });

        me.callParent(arguments);
    }

});