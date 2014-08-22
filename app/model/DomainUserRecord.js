/*
 * File: app/model/DomainUserRecord.js
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

Ext.define('SignaTouch.model.DomainUserRecord', {
    extend: 'Ext.data.Model',

    requires: [
        'Ext.data.Field'
    ],

    fields: [
        {
            name: 'displayName'
        },
        {
            name: 'Type',
            type: 'auto'
        },
        {
            name: 'Company'
        },
        {
            name: 'JobTitle'
        },
        {
            name: 'Phone'
        },
        {
            name: 'City'
        },
        {
            name: 'Zip'
        },
        {
            name: 'State'
        },
        {
            name: 'email'
        }
    ]
});