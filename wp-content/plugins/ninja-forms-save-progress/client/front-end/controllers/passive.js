/**
 * Save Progress Passive Controller
 */
var nfSaveProgressPassiveController = Marionette.Object.extend({

    initialize: function( options ) {

        this.storage = window.localStorage;

        this.listenTo( nfRadio.channel( 'form' ), 'render:view', this.onFormRendered );
    },

    onFormRendered: function( formView ) {
        var formModel = formView.model;

        if( ! formModel.get( 'save_progress_passive_mode' ) ) return;

        var formInstanceID = formModel.get( 'id' );
        var formID = formInstanceID.toString().split('_')[0];

        var formData = this.storage.getItem( 'nfForm-' + formID );

        Backbone.Radio.channel( 'forms' ).request( 'save:updateFieldsCollection',
            formModel.get( 'id' ),
            JSON.parse( formData )
        );

        this.listenTo( nfRadio.channel( 'fields' ), 'change:modelValue', this.onChangeModelValue );
        this.listenTo( nfRadio.channel( 'form-' + formInstanceID ), 'submit:response', function(){
            this.storage.removeItem( 'nfForm-' + formID );
        } );
    },

    onChangeModelValue: function( fieldModel ) {

        var formInstanceID  = fieldModel.get( 'formID' );
        var formID = formInstanceID.toString().split('_')[0];

        var name = 'nfForm-' + formID;


        var formModel = Backbone.Radio.channel( 'app' ).request( 'get:form', formInstanceID );

        if( 'undefined' == typeof formModel ) return;
        if( ! formModel.get( 'save_progress_passive_mode' ) ) return;

        // var formData = this.cookie.get( name ) || {};
        // formData[ fieldModel.get( 'id' ) ] = fieldModel.get( 'value' );

        var fieldData = Backbone.Radio.channel( 'forms' ).request( 'save:fieldAttributes', formInstanceID );

        this.storage.setItem( name, JSON.stringify( fieldData ) );
    },

});
