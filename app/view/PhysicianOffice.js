/*
 * File: app/view/PhysicianOffice.js
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

Ext.define('SignaTouch.view.PhysicianOffice', {
    extend: 'Ext.window.Window',
    alias: 'widget.NewPhysicanOffice',

    requires: [
        'Ext.form.Panel',
        'Ext.form.FieldSet',
        'Ext.form.field.ComboBox',
        'Ext.button.Button'
    ],

    height: 374,
    hidden: false,
    id: 'PhysicianOfficeID',
    width: 697,
    title: 'Physician Office',
    hideShadowOnDeactivate: true,
    modal: true,

    layout: {
        type: 'vbox',
        align: 'stretch'
    },

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'form',
                    height: 493,
                    id: 'PopForm3',
                    width: 739,
                    layout: 'auto',
                    bodyPadding: 10,
                    bodyStyle: 'background-color:#a5cfff;',
                    title: '',
                    titleAlign: 'center',
                    items: [
                        {
                            xtype: 'fieldset',
                            height: 306,
                            width: 667,
                            title: '<font size="4">Physician Office</font>',
                            items: [
                                {
                                    xtype: 'container',
                                    itemId: 'NPI',
                                    margin: '7 0 7 0',
                                    items: [
                                        {
                                            xtype: 'textfield',
                                            id: 'txtPOPPhyNPIID',
                                            itemId: '',
                                            width: 300,
                                            fieldLabel: '<b>Physician NPI&nbsp;</b>',
                                            inputId: 'txtPOPPhyNPI',
                                            readOnly: true,
                                            allowBlank: false,
                                            enforceMaxLength: true,
                                            maxLength: 10,
                                            vtype: 'alphanum'
                                        }
                                    ]
                                },
                                {
                                    xtype: 'container',
                                    id: 'PopPhyName',
                                    itemId: 'Address1',
                                    margin: '7 0 7 0',
                                    layout: 'vbox',
                                    items: [
                                        {
                                            xtype: 'textfield',
                                            id: 'txtPOPPhyFnameID',
                                            itemId: '',
                                            width: 600,
                                            fieldLabel: '<b>First Name</b>',
                                            inputId: 'txtPOPPhyFname',
                                            readOnly: true,
                                            allowBlank: false
                                        },
                                        {
                                            xtype: 'textfield',
                                            id: 'txtPOPPhyLnameID',
                                            width: 600,
                                            fieldLabel: '<b>Last Name</b>',
                                            inputId: 'txtPOPPhyLname',
                                            readOnly: true
                                        }
                                    ]
                                },
                                {
                                    xtype: 'container',
                                    itemId: 'Address',
                                    margin: '7 0 7 0',
                                    layout: 'vbox',
                                    items: [
                                        {
                                            xtype: 'textfield',
                                            id: 'txtPOPPhyAddress1ID',
                                            itemId: '',
                                            width: 600,
                                            fieldLabel: '<b>Address1&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            inputId: 'txtPOPPhyAddress1',
                                            allowBlank: false
                                        },
                                        {
                                            xtype: 'textfield',
                                            id: 'txtPOPPhyAddress2ID',
                                            width: 600,
                                            fieldLabel: '<b>Address2</b>',
                                            inputId: 'txtPOPPhyAddress2'
                                        }
                                    ]
                                },
                                {
                                    xtype: 'container',
                                    itemId: 'Citystatezip',
                                    margin: '7 0 7 0',
                                    layout: {
                                        type: 'hbox',
                                        align: 'stretch'
                                    },
                                    items: [
                                        {
                                            xtype: 'textfield',
                                            id: 'txtPOPPhyCityID',
                                            itemId: '',
                                            width: 300,
                                            fieldLabel: '<b>City&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            msgTarget: 'side',
                                            inputId: 'txtPOPPhyCity',
                                            allowBlank: false,
                                            regex: /^[a-zA-Z\s]*$/,
                                            regexText: 'Please enter valid city'
                                        },
                                        {
                                            xtype: 'combobox',
                                            flex: 1,
                                            id: 'ddlPOPPhyStateID',
                                            maxWidth: 300,
                                            fieldLabel: '<b>&nbsp;&nbsp;&nbsp;State&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            value: [
                                                'AL'
                                            ],
                                            inputId: 'ddlPOPPhyState',
                                            allowBlank: false,
                                            regexText: '',
                                            editable: false,
                                            displayField: 'des',
                                            queryMode: 'local',
                                            store: 'States',
                                            valueField: 'id'
                                        }
                                    ]
                                },
                                {
                                    xtype: 'container',
                                    itemId: 'PhoneNo',
                                    margin: '7 0 7 0',
                                    layout: {
                                        type: 'hbox',
                                        align: 'stretch'
                                    },
                                    items: [
                                        {
                                            xtype: 'textfield',
                                            id: 'txtPOPPhyzipID',
                                            itemId: '',
                                            width: 300,
                                            fieldLabel: '<b>Zip&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            msgTarget: 'side',
                                            inputId: 'txtPOPPhyzip',
                                            allowBlank: false,
                                            enforceMaxLength: true,
                                            maxLength: 10,
                                            regex: /(^\d{5}$)|(^\d{5}-\d{4}$)/,
                                            regexText: 'Invalid Zip Code'
                                        }
                                    ]
                                },
                                {
                                    xtype: 'container',
                                    itemId: 'Button',
                                    margin: '7 0 7 0',
                                    maxWidth: 600,
                                    layout: {
                                        type: 'hbox',
                                        align: 'stretch',
                                        pack: 'end'
                                    },
                                    items: [
                                        {
                                            xtype: 'button',
                                            id: 'btnPOPPhyReset',
                                            itemId: '',
                                            margin: '0 10 0 0',
                                            padding: '',
                                            width: 92,
                                            text: 'Reset',
                                            listeners: {
                                                click: {
                                                    fn: me.onBtnPOPPhyCancelClick,
                                                    scope: me
                                                }
                                            }
                                        },
                                        {
                                            xtype: 'button',
                                            formBind: true,
                                            id: 'btnPOPPhySave',
                                            margin: '0 0 0 0',
                                            width: 92,
                                            text: 'Save',
                                            listeners: {
                                                click: {
                                                    fn: me.onBtnPOPPhySaveClick,
                                                    scope: me
                                                }
                                            }
                                        }
                                    ]
                                }
                            ]
                        }
                    ]
                }
            ],
            listeners: {
                show: {
                    fn: me.onPhysicianOfficeIDShow,
                    scope: me
                }
            }
        });

        me.callParent(arguments);
    },

    onBtnPOPPhyCancelClick: function(button, e, eOpts) {
        //Ext.getCmp('PopForm3').getForm().reset();
        Ext.getCmp('txtPOPPhyAddress1ID').reset();
        Ext.getCmp('txtPOPPhyAddress2ID').reset();
        Ext.getCmp('txtPOPPhyCityID').reset();
        Ext.getCmp('txtPOPPhyStateID').reset();
        Ext.getCmp('txtPOPPhyzipID').reset();
    },

    onBtnPOPPhySaveClick: function(button, e, eOpts) {
        var form = button.up('form');
                   //var header = button.up('headerPanel');
                       values = form.getValues();
                var user = localStorage.getItem('email');
                var successCallbackFacility = function(resp, ops) {

                    Ext.getCmp('FacilityNameText').setValue(Ext.JSON.decode(resp.responseText));
                };
                var failureCallbackFacility = function(resp, ops) {};
                // Success
                var successCallback = function(resp, ops) {
                    if(resp.responseText === 'true'){
                        Ext.getCmp('PhysicianOfficeID').setLoading(false,false);
                        Ext.Msg.alert("Office is created", 'Office created successfully');
                        Ext.getCmp('PhysicianOfficeID').destroy();
                        form.getForm().getFields().each(function(f){
                            f.originalValue=undefined;
                        });
                        form.getForm().reset();
                    }

                    else if(resp.responseText === '"exists"'){
                        Ext.Msg.alert("Office cannot be created", 'Office already exists');
                    }
                    else if(resp.responseText === '"domain_error"'){
                        Ext.Msg.alert("Office cannot be created", 'No such domain exists');
                    }
                    else if(resp.responseText === '"account_error"'){
                        Ext.Msg.alert("Office cannot be created", 'No such account exists');
                    }
                    else {
                        Ext.Msg.alert("Office cannot be created", 'Office cannot be created');
                    }
                };

                // Failure
                var failureCallback = function(resp, ops) {

                    // Show login failure error
                    //Ext.Msg.alert("Login Failure", 'Incorrect Username or Password');

                };
                Ext.Ajax.on('beforerequest', function(){

                                var pnl=Ext.getCmp('PhysicianOfficeID');
                                pnl.setLoading(true, true);
                        });


                        Ext.Ajax.on('requestcomplete', function(){

                              Ext.getCmp('PhysicianOfficeID').setLoading(false,false);
                              //Ext.getCmp('PhysicianOfficeID').close();

                        });

                // TODO: Login using server-side authentication service
                Ext.Ajax.request({url: "services/ZimbraPhysician.php?action=create_another_office&user="+user,
                        method: 'POST',
                        params: values,
                        success: successCallback,
                        failure: failureCallback
                 });
    },

    onPhysicianOfficeIDShow: function(component, eOpts) {
        var phy_npi = localStorage.getItem("physician_npi");
        var phy_fname = localStorage.getItem("physician_fname");
        var phy_lname = localStorage.getItem("physician_lname");



        var form =  Ext.getCmp('PopForm3');  // Physician Office form

        Ext.getCmp('PopForm3').getForm().setValues({
            txtPOPPhyNPI: phy_npi,
            txtPOPPhyFname: phy_fname,
            txtPOPPhyLname: phy_lname
        });

        localStorage.removeItem("physician_npi"); //remove
        localStorage.removeItem("physician_fname"); //remove
        localStorage.removeItem("physician_lname"); //remove
    }

});