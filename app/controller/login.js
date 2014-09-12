/*
 * File: app/controller/login.js
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

Ext.define('SignaTouch.controller.login', {
    extend: 'Ext.app.Controller',

    onLogOut: function(button, e, eOpts) {
        // success
        var successCallback = function(resp, ops) {
            if(resp.responseText === 'true'){
                var Username =  Ext.getCmp('IDtxtUsername');
                var Password =  Ext.getCmp('IDtxtPassword');
                Ext.getCmp('loginForm1').getForm().reset();

                localStorage.removeItem("user_name"); //remove
                localStorage.removeItem("SectionAHDRID"); //remove
                localStorage.removeItem("new_HICN"); //remove
                localStorage.removeItem("new_HICN_name"); //remove
                localStorage.removeItem("preauthURL"); //remove
                localStorage.removeItem("domain"); //remove
                localStorage.removeItem("email"); //remove
                localStorage.removeItem("DetailID");// remove
                //localStorage.removeItem("RouteType"); // remove
                localStorage.removeItem("physician_cos"); //remove

                localStorage.removeItem("FacilityAddr1"); //remove

                localStorage.removeItem("FacilityAddr2"); //remove

                localStorage.removeItem("FacilityCity"); //remove

                localStorage.removeItem("FacilityNPI"); //remove

                localStorage.removeItem("FacilityName"); //remove

                localStorage.removeItem("FacilityPhone"); //remove

                localStorage.removeItem("FacilityST"); //remove

                localStorage.removeItem("FacilityZip"); //remove
                // refresh page
                window.location.reload();

                //Login Panel
                Ext.getCmp('panelLoginID').show();
                Ext.getCmp('loginForm1').show();

                // hide

                Ext.getCmp('Menu').hide();
                Ext.getCmp('Footer').hide();
                Ext.getCmp('Header').hide();

                // section A
                Ext.getCmp('SectionAID').hide();
                Ext.getCmp('SectionA1NextID').hide();

                // section B
                Ext.getCmp('SectionB1NextID').hide();
                Ext.getCmp('sectionB1ID').hide();

                //Patient Record
                Ext.getCmp('PatientRecord').hide();
                Ext.getCmp('PatientPanelID').hide();
                Ext.getCmp('PatientViewID').hide();

                //Physician Record
                Ext.getCmp('PhysicianPanelID').hide();
                Ext.getCmp('PhysicianViewID').hide();
                Ext.getCmp('PhysicianRecord').hide();

                //Supplier Record
                Ext.getCmp('SupplierRecord').hide();
                Ext.getCmp('SupplierPanelID').hide();
                Ext.getCmp('SupplierViewID').hide();

                Ext.getCmp('ViewAll').hide();

                Ext.getCmp('AddCOSID').hide();

                //Dashboard
                Ext.getCmp('Dashboard').hide();

                Ext.getCmp('Messaging').hide();

                // hide menus
                Ext.getCmp('SectionBMenu').hide();
                Ext.getCmp('CMS484SectionA').hide();
                Ext.getCmp('Maintanance').hide();
                Ext.getCmp('MaintananceClientID').hide();
                Ext.getCmp('ManageAccountID').hide();
                Ext.getCmp('ChangePasswordPanelID').hide();
                Ext.getCmp('AddUserPanelID').hide();
                Ext.getCmp('AddAlias').hide();
                Ext.getCmp('DomainRecordID').hide();


                // refresh store
                var myStore = Ext.getStore('SectionA1GridBind');
                myStore.clearFilter();
                myStore.load();

                var myStoreb = Ext.getStore('SectionBGridBind');
                myStoreb.clearFilter();
                myStoreb.load();
            }
        };
        // Failure
        var failureCallback = function(resp, ops) {
            console.log('URL not called');
        };

        // TODO: Login using server-side authentication service
        Ext.Ajax.request({url: "services/Function.php?action=logout",
                          method: 'POST',
                          params:  [Username,Password],
                          success: successCallback,
                          failure: failureCallback
                         });
    },

    init: function(application) {
        this.control({
            "#BtLogoff": {
                click: this.onLogOut
            }
        });
    }

});
