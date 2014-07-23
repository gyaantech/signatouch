/*
 * File: app/view/PopupHICN.js
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

Ext.define('SignaTouch.view.PopupHICN', {
    extend: 'Ext.window.Window',
    alias: 'widget.HICN',

    requires: [
        'Ext.form.Panel',
        'Ext.form.FieldSet',
        'Ext.form.field.Date',
        'Ext.form.field.ComboBox',
        'Ext.button.Button'
    ],

    height: 380,
    hidden: false,
    id: 'POPHICN',
    itemId: 'mywindow',
    width: 665,
    title: 'New Patient /  HICN',
    hideShadowOnDeactivate: true,
    modal: true,

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'form',
                    id: 'patientPopForm1',
                    layout: 'auto',
                    bodyPadding: 10,
                    bodyStyle: 'background-color:#a5cfff;',
                    title: '',
                    titleAlign: 'center',
                    items: [
                        {
                            xtype: 'fieldset',
                            style: 'border-style:solid;\r\nborder-color:#000000;',
                            width: 633,
                            title: '<font size="4">New Patient /  HICN</font>',
                            items: [
                                {
                                    xtype: 'container',
                                    itemId: 'HICN',
                                    margin: '7 0 7 0',
                                    items: [
                                        {
                                            xtype: 'textfield',
                                            itemId: 'txtPOPHICN',
                                            width: 300,
                                            fieldLabel: '<b>HICN&nbsp;<span style="color:#D94E37;">*</span><b/>',
                                            inputId: 'txtPOPHICN',
                                            allowBlank: false,
                                            enforceMaxLength: true,
                                            maxLength: 11,
                                            vtype: 'alphanum'
                                        }
                                    ]
                                },
                                {
                                    xtype: 'container',
                                    itemId: 'Name',
                                    margin: '7 0 7 0',
                                    layout: {
                                        type: 'hbox',
                                        align: 'stretch'
                                    },
                                    items: [
                                        {
                                            xtype: 'textfield',
                                            itemId: 'txtPOPFname',
                                            width: 300,
                                            fieldLabel: '<b>First Name&nbsp;<span style="color:#D94E37;">*</span><b/>',
                                            msgTarget: 'side',
                                            inputId: 'txtPOPFname',
                                            allowBlank: false,
                                            regex: /^[a-zA-Z ]*$/,
                                            regexText: 'Please enter valid First name'
                                        },
                                        {
                                            xtype: 'textfield',
                                            flex: 0,
                                            itemId: 'txtPOPMname',
                                            width: 300,
                                            fieldLabel: '<b>&nbsp;&nbsp;&nbsp;Middle Name</b>',
                                            msgTarget: 'side',
                                            inputId: 'txtPOPMname',
                                            regex: /^[a-zA-Z ]*$/,
                                            regexText: 'Please enter valid Middle name'
                                        }
                                    ]
                                },
                                {
                                    xtype: 'container',
                                    itemId: 'Name1',
                                    margin: '7 0 7 0',
                                    items: [
                                        {
                                            xtype: 'textfield',
                                            itemId: 'txtPOPLname',
                                            width: 300,
                                            fieldLabel: '<b>Last Name&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            msgTarget: 'side',
                                            inputId: 'txtPOPLname',
                                            allowBlank: false,
                                            regex: /^[a-zA-Z ]*$/,
                                            regexText: 'Please enter valid Last name'
                                        }
                                    ]
                                },
                                {
                                    xtype: 'container',
                                    itemId: 'DOBSex',
                                    margin: '7 0 7 0',
                                    layout: {
                                        type: 'hbox',
                                        align: 'stretch'
                                    },
                                    items: [
                                        {
                                            xtype: 'datefield',
                                            id: 'txtPOPDOBID',
                                            itemId: 'txtPOPDOB',
                                            width: 300,
                                            fieldLabel: '<b>DOB&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            inputId: 'txtPOPDOB',
                                            allowBlank: false,
                                            editable: false,
                                            format: 'm-d-Y'
                                        },
                                        {
                                            xtype: 'combobox',
                                            itemId: 'txtPOPSex',
                                            width: 300,
                                            fieldLabel: '<b>&nbsp;&nbsp;&nbsp;Sex&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            msgTarget: 'side',
                                            inputId: 'ddlPOPSex',
                                            allowBlank: false,
                                            emptyText: 'Unknown',
                                            validateBlank: true,
                                            editable: false,
                                            displayField: 'des',
                                            forceSelection: true,
                                            queryMode: 'local',
                                            store: 'MyArrayStore',
                                            valueField: 'id'
                                        }
                                    ]
                                },
                                {
                                    xtype: 'container',
                                    itemId: 'Address',
                                    margin: '7 0 7 0',
                                    layout: {
                                        type: 'vbox',
                                        align: 'stretch'
                                    },
                                    items: [
                                        {
                                            xtype: 'textfield',
                                            itemId: 'txtPOPAddress1',
                                            maxWidth: 600,
                                            fieldLabel: '<b>Address1&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            inputId: 'txtPOPAddress1',
                                            allowBlank: false
                                        },
                                        {
                                            xtype: 'textfield',
                                            itemId: 'txtPOPAddress2',
                                            maxWidth: 600,
                                            fieldLabel: '<b>Address2</b>',
                                            inputId: 'txtPOPAddress2'
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
                                            itemId: 'txtPOPCity',
                                            width: 300,
                                            fieldLabel: '<b>City&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            msgTarget: 'side',
                                            inputId: 'txtPOPCity',
                                            allowBlank: false,
                                            regex: /^[a-zA-Z\s]*$/,
                                            regexText: 'Please enter valid city.'
                                        },
                                        {
                                            xtype: 'combobox',
                                            flex: 1,
                                            itemId: 'ddlPOPState2',
                                            maxWidth: 300,
                                            fieldLabel: '<b>&nbsp;&nbsp;&nbsp;State&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            value: [
                                                'AL'
                                            ],
                                            inputId: 'ddlPOPNewPatientState',
                                            forceSelection: true,
                                            store: [
                                                'AL',
                                                'MT',
                                                'AK',
                                                'NE',
                                                'AZ',
                                                'NV',
                                                'AR',
                                                'NH',
                                                'CA',
                                                'NJ',
                                                'CO',
                                                'NM',
                                                'CT',
                                                'NY',
                                                'DE',
                                                'NC',
                                                'FL',
                                                'ND',
                                                'GA',
                                                'OH',
                                                'HI',
                                                'OK',
                                                'ID',
                                                'OR',
                                                'IL',
                                                'PA',
                                                'IN',
                                                'RI',
                                                'IA',
                                                'SC',
                                                'KS',
                                                'SD',
                                                'KY',
                                                'TN',
                                                'LA',
                                                'TX',
                                                'ME',
                                                'UT',
                                                'MD',
                                                'VT',
                                                'MA',
                                                'VA',
                                                'MI',
                                                'WA',
                                                'MN',
                                                'WV',
                                                'MS',
                                                'WI',
                                                'MO',
                                                'WY'
                                            ]
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
                                            itemId: 'txtPOPZip',
                                            width: 300,
                                            fieldLabel: '<b>Zip&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            msgTarget: 'side',
                                            inputId: 'txtPOPZip',
                                            allowBlank: false,
                                            enforceMaxLength: true,
                                            maxLength: 10,
                                            regex: /(^\d{5}$)|(^\d{5}-\d{4}$)/,
                                            regexText: 'Invalid Zip Code'
                                        },
                                        {
                                            xtype: 'textfield',
                                            itemId: 'txtPOPPhoneNo',
                                            width: 300,
                                            fieldLabel: '<b>&nbsp;&nbsp;&nbsp;Phone No.&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            msgTarget: 'side',
                                            inputId: 'txtPOPPhoneno',
                                            allowBlank: false,
                                            enforceMaxLength: true,
                                            maxLength: 12,
                                            regex: /^(\([0-9]{3}\) |[0-9]{3}-)[0-9]{3}-[0-9]{4}$/,
                                            regexText: 'Please enter phone No. in xxx-xxx-xxxx format.'
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
                                            itemId: 'btnPOPPatientCancel',
                                            margin: '0 10 0 0',
                                            padding: '',
                                            width: 92,
                                            text: 'Reset',
                                            listeners: {
                                                click: {
                                                    fn: me.onBtnPOPPatientCancelClick,
                                                    scope: me
                                                }
                                            }
                                        },
                                        {
                                            xtype: 'button',
                                            formBind: true,
                                            itemId: 'btnPOPPatientSave',
                                            margin: '0 0 0 0',
                                            width: 92,
                                            text: 'Save',
                                            listeners: {
                                                click: {
                                                    fn: me.onBtnPOPPatientSaveClick,
                                                    scope: me
                                                }
                                            }
                                        }
                                    ]
                                }
                            ]
                        }
                    ],
                    listeners: {
                        afterrender: {
                            fn: me.onPatientPopForm1AfterRender,
                            scope: me
                        }
                    }
                }
            ]
        });

        me.callParent(arguments);
    },

    onBtnPOPPatientCancelClick: function(button, e, eOpts) {
           Ext.getCmp('patientPopForm1').getForm().reset();

    },

    onBtnPOPPatientSaveClick: function(button, e, eOpts) {
        var form = button.up('form');
        var domain = localStorage.getItem('email');
                   //var header = button.up('headerPanel');
                       values = form.getValues();
         //var popupHICN= ;

                // Success
                var successCallback = function(resp, ops) {

                    var HICNresponse = Ext.JSON.decode(resp.responseText);
                    if(HICNresponse.status === 'ok'){

                      Ext.Msg.alert("Data Inserted", 'Patient HICN Inserted successfully');


                        Ext.getCmp('POPHICN').destroy();
                        localStorage.removeItem("new_HICN"); //remove old items
                        localStorage.setItem("new_HICN", HICNresponse.HICN);
                        localStorage.setItem("new_HICN_name", HICNresponse.Name);
                        var patientHICN =  Ext.getCmp('PatientHICNPOP');
                        var patientName =  Ext.getCmp('txtPatientName');
                        patientHICN.setValue(localStorage.getItem('new_HICN'));
                        patientName.setValue(localStorage.getItem('new_HICN_name'));
           // Code to reset the form values
                    form.getForm().getFields().each(function(f){
                    f.originalValue=undefined;
                    });
                    form.getForm().reset();

                   }
                   else if(resp.responseText === 'false'){

                      Ext.Msg.alert("Duplicate Entry", 'Patient HICN Already Exists');
                   }
                    else{
                      // Show login failure error
                    Ext.Msg.alert("Insert Failure", 'Data cannot be added');
                    }

                };

                // Failure
                var failureCallback = function(resp, ops) {

                    // Show login failure error
                    //Ext.Msg.alert("Login Failure", 'Incorrect Username or Password');

                };


                // TODO: Login using server-side authentication service
                Ext.Ajax.request({url: "services/Maintainence.php?action=POPinsertPatientHICN&src="+domain,
                        method: 'POST',
                        params: values,
                        success: successCallback,
                        failure: failureCallback
                 });
    },

    onPatientPopForm1AfterRender: function(component, eOpts) {
        Ext.getCmp('txtPOPDOBID').setMaxValue(Ext.util.Format.date(new Date(), 'm/d/Y'));
    }

});