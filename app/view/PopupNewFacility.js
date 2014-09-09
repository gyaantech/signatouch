/*
 * File: app/view/PopupNewFacility.js
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

Ext.define('SignaTouch.view.PopupNewFacility', {
    extend: 'Ext.window.Window',
    alias: 'widget.NewFacility',

    requires: [
        'Ext.form.Panel',
        'Ext.form.FieldSet',
        'Ext.form.field.ComboBox',
        'Ext.button.Button'
    ],

    height: 317,
    hidden: false,
    itemId: 'FacilityItem',
    width: 656,
    title: 'Facility',
    hideShadowOnDeactivate: true,
    modal: true,

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'form',
                    id: 'PopForm2',
                    layout: 'auto',
                    bodyPadding: 10,
                    bodyStyle: 'background-color:#a5cfff;',
                    title: '',
                    titleAlign: 'center',
                    items: [
                        {
                            xtype: 'fieldset',
                            height: 258,
                            style: 'border-style:solid;\r\nborder-color:#000000;',
                            width: 629,
                            title: '<font size="4">Facility</font>',
                            items: [
                                {
                                    xtype: 'container',
                                    itemId: 'NPI',
                                    margin: '7 0 7 0',
                                    items: [
                                        {
                                            xtype: 'textfield',
                                            id: 'txtFacilityNPIIPOP',
                                            itemId: '',
                                            width: 300,
                                            fieldLabel: '<b>Facility NPI&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            inputId: 'txtPOPFacilityNPI',
                                            allowBlank: false,
                                            enforceMaxLength: true,
                                            maxLength: 10,
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
                                            id: 'txtPOPFacilitynameID',
                                            width: 300,
                                            fieldLabel: '<b>Facility Name&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            msgTarget: 'side',
                                            fieldStyle: 'text-transform:capitalize',
                                            inputId: 'txtPOPFacilityname',
                                            allowBlank: false,
                                            regex: /^[a-zA-Z ]*$/,
                                            regexText: 'Please enter valid name.'
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
                                            id: 'txtPOPFacilityAddress1ID',
                                            itemId: '',
                                            width: 600,
                                            fieldLabel: '<b>Address1&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            inputId: 'txtPOPFacilityAddress1',
                                            allowBlank: false
                                        },
                                        {
                                            xtype: 'textfield',
                                            id: 'txtPOPFacilityAddress2ID',
                                            width: 600,
                                            fieldLabel: '<b>Address2</b>',
                                            inputId: 'txtPOPFacilityAddress2'
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
                                            id: 'txtPOPFacilityCityID',
                                            itemId: '',
                                            width: 300,
                                            fieldLabel: '<b>City&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            msgTarget: 'side',
                                            fieldStyle: 'text-transform:capitalize',
                                            inputId: 'txtPOPFacilityCity',
                                            allowBlank: false,
                                            regex: /^[a-zA-Z\s]*$/,
                                            regexText: 'Please enter valid city'
                                        },
                                        {
                                            xtype: 'combobox',
                                            flex: 1,
                                            id: 'ddlPOPFacilityStateID',
                                            maxWidth: 300,
                                            fieldLabel: '<b>&nbsp;&nbsp;&nbsp;State&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            inputId: 'ddlPOPFacilityState',
                                            allowBlank: false,
                                            emptyText: '-Select-',
                                            regexText: '',
                                            displayField: 'des',
                                            forceSelection: true,
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
                                            id: 'txtPOPFacilityzipID',
                                            itemId: '',
                                            width: 300,
                                            fieldLabel: '<b>Zip&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            msgTarget: 'side',
                                            inputId: 'txtPOPFacilityzip',
                                            allowBlank: false,
                                            enforceMaxLength: true,
                                            maxLength: 10,
                                            regex: /(^\d{5}$)|(^\d{5}-\d{4}$)/,
                                            regexText: 'Invalid Zip Code'
                                        },
                                        {
                                            xtype: 'textfield',
                                            id: 'txtPOPFacilityPhoneNoID',
                                            width: 300,
                                            fieldLabel: '<b>&nbsp;&nbsp;&nbsp;Phone No.&nbsp;<span style="color:#D94E37;">*</span></b>',
                                            msgTarget: 'side',
                                            inputId: 'txtPOPFacilityPhoneNo',
                                            allowBlank: false,
                                            enableKeyEvents: true,
                                            enforceMaxLength: true,
                                            maxLength: 12,
                                            regex: /^(\([0-9]{3}\) |[0-9]{3}-)[0-9]{3}-[0-9]{4}$/,
                                            regexText: 'Please enter phone No. in xxx-xxx-xxxx format.',
                                            listeners: {
                                                keypress: {
                                                    fn: me.onTxtPOPFacilityPhoneNoIDKeypress,
                                                    scope: me
                                                }
                                            }
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
                                            formBind: true,
                                            cls: 'SaveBt',
                                            itemId: 'btnPOPFacilitySave',
                                            margin: '0 10 0 0',
                                            width: 92,
                                            text: 'Save',
                                            listeners: {
                                                click: {
                                                    fn: me.onBtnPOPFacilitySaveClick,
                                                    scope: me
                                                }
                                            }
                                        },
                                        {
                                            xtype: 'button',
                                            cls: 'BackBt',
                                            itemId: 'btnPOPFacilityCancel',
                                            padding: '',
                                            width: 92,
                                            text: 'Reset',
                                            listeners: {
                                                click: {
                                                    fn: me.onBtnPOPFacilityCancelClick,
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
                    fn: me.onFacilityItemShow,
                    scope: me
                }
            }
        });

        me.callParent(arguments);
    },

    onTxtPOPFacilityPhoneNoIDKeypress: function(textfield, e, eOpts) {
        var phone = Ext.getCmp('txtPOPFacilityPhoneNoID').getValue();
        if(phone.length === 3 || phone.length === 7){
            var newPhone = phone.concat('-');
            Ext.getCmp('txtPOPFacilityPhoneNoID').setValue(newPhone);
        }


    },

    onBtnPOPFacilitySaveClick: function(button, e, eOpts) {
        var form = button.up('form');
        //var header = button.up('headerPanel');
        values = form.getValues();

        var LocalHDRid = localStorage.getItem('SectionAHDRID');

        // Success

        var successCallback = function(resp, ops) {
            var responseOjbect = JSON.parse(Ext.JSON.decode(resp.responseText));

            if(responseOjbect.status === true){

                Ext.Msg.alert("Facility Added", 'Facility Added Successfully');
                button.up('window').close();

                localStorage.removeItem("FacilityNPI"); //remove
                localStorage.setItem("FacilityNPI",values.txtPOPFacilityNPI);

                localStorage.removeItem("FacilityName"); //remove
                localStorage.setItem("FacilityName",values.txtPOPFacilityname);

                localStorage.removeItem("FacilityPhone"); //remove
                localStorage.setItem("FacilityPhone",values.txtPOPFacilityPhoneNo);

                localStorage.removeItem("FacilityST"); //remove
                localStorage.setItem("FacilityST",values.ddlPOPFacilityState);

                localStorage.removeItem("FacilityZip"); //remove
                localStorage.setItem("FacilityZip",values.txtPOPFacilityzip);

                localStorage.removeItem("FacilityAddr1"); //remove
                localStorage.setItem("FacilityAddr1",values.txtPOPFacilityAddress1);

                localStorage.removeItem("FacilityAddr2"); //remove
                localStorage.setItem("FacilityAddr2",values.txtPOPFacilityAddress2);

                localStorage.removeItem("FacilityCity"); //remove
                localStorage.setItem("FacilityCity",values.txtPOPFacilityCity);

                var successCallbackFacility = function(resp, ops) {

                    Ext.getCmp('FacilityNameText').setValue(Ext.JSON.decode(resp.responseText));
                };
                var failureCallbackFacility = function(resp, ops) {};

                // fetch facility name from facility NPI and display in textfield
                Ext.Ajax.request({url: "services/SectionA.php?action=fetchFacilityName&facility_NPI="+responseOjbect.facility_npi,
                                  method: 'POST',
                                  params: values,
                                  success: successCallbackFacility,
                                  failure: failureCallbackFacility
                                 });
                // Code to reset the form values
                form.getForm().getFields().each(function(f){
                    f.originalValue=undefined;
                });
                form.getForm().reset();
            }
            else if(responseOjbect === false){

                Ext.Msg.alert("Facility Already Exists", 'Facility Already Exists');

            }
                else{

                    Ext.Msg.alert("Insert Failure", 'Data cannot be added');
                }

        };

        // Failure
        var failureCallback = function(resp, ops) {

            // Show login failure error
            //Ext.Msg.alert("Login Failure", 'Incorrect Username or Password');

        };



        // TODO: Login using server-side authentication service
        Ext.Ajax.request({url: "services/Maintainence.php?action=insertFacility&HdrID="+LocalHDRid,
                          method: 'POST',
                          params: values,
                          success: successCallback,
                          failure: failureCallback
                         });
    },

    onBtnPOPFacilityCancelClick: function(button, e, eOpts) {
        Ext.getCmp('PopForm2').getForm().reset();
    },

    onFacilityItemShow: function(component, eOpts) {
        Ext.getCmp('PopForm2').getForm().setValues({
            txtPOPFacilityNPI : localStorage.getItem("FacilityNPI"),
            txtPOPFacilityname : localStorage.getItem("FacilityName"),
            txtPOPFacilityAddress1 : localStorage.getItem("FacilityAddr1"),
            txtPOPFacilityAddress2 : localStorage.getItem("FacilityAddr2"),
            txtPOPFacilityCity : localStorage.getItem("FacilityCity"),
            ddlPOPFacilityState : localStorage.getItem("FacilityST"),
            txtPOPFacilityzip : localStorage.getItem("FacilityZip"),
            txtPOPFacilityPhoneNo : localStorage.getItem("FacilityPhone")
        });



    }

});