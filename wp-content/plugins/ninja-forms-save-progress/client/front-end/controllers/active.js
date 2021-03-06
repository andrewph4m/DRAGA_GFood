/**
 * Save User Progress Active Controller
 */
var nfSaveProgressActiveController = Marionette.Object.extend({

    endpoint: nfSaveProgress.restApiEndpoint || '',

    initialize: function( options ) {
        this.listenTo( Backbone.Radio.channel( 'form' ), 'loaded', this.onFormLoaded );
        this.listenTo( Backbone.Radio.channel( 'form' ), 'render:view', this.onFormRenderView );
    },

    onFormLoaded: function( formModel ) {
        var save_actions = formModel.get( 'save_progress_actions' );
        if( 'undefined' == typeof save_actions ) return;

        _.each( save_actions, function( action, actionID ){
            if( 'undefined' == typeof action.active ) return;
            Backbone.Radio.channel( 'actions-' + actionID ).reply( 'get:status', function(){
                return ( 1 == action.active );
            } )
        } );
    },

    onFormRenderView: function( formLayoutView ) {

        if( ! nfSaveProgress.currentUserID ) return;

        var formModel = formLayoutView.model;
        var formInstanceID = formModel.get( 'id' );
        var formID = formInstanceID.toString().split('_')[0];

        var saveField = formModel.get( 'fields' ).findWhere( { type: 'save' } );

        if( 'undefined' == typeof saveField ) {
            jQuery( '#nf-form-' + formInstanceID + '-cont .nf-saves-cont' ).remove();
            return;
        }

        if( formModel.get( 'save_progress_allow_multiple' ) ){
            return this.renderSaveTable( formModel );
        }

        return this.loadLastSave( formModel );
    },

    loadLastSave: function( formModel ) {

        // render loading view
        var loading = new SavesLoadingView();
        loading.render();

        var requestData = {
            _wpnonce: wpApiSettings.nonce,
        };

        var formInstanceID = formModel.get( 'id' );
        var formID = formInstanceID.toString().split('_')[0];

        jQuery.ajax({
            url: this.endpoint + 'saves/' + formID,
            type: 'GET',
            data: Backbone.Radio.channel( 'save-progress' ).request( 'getSavesRequestData', requestData ) || requestData,
            cache: false,
            success: function( data, textStatus, jqXHR ){
                jQuery( loading.$el ).slideUp( 400, function(){
                    loading.remove();
                });

                if( 0 == data.saves.length ) {
                    jQuery( '#nf-form-' + formInstanceID + '-cont .nf-saves-cont' ).remove();
                    return;
                }

                var save = data.saves.pop();

                formModel.set( 'save_id', save.save_id );

                var fields = JSON.parse( save.fields );

                Backbone.Radio.channel( 'forms' ).request( 'save:updateFieldsCollection',
                    formInstanceID,
                    fields
                );

                jQuery( '#nf-form-' + formInstanceID + '-cont .nf-saves-cont' ).remove();
            },
            error: function(){

            }
        });
    },

    renderSaveTable: function( formModel ) {

        // render loading view
        var loading = new SavesLoadingView();
        loading.render();

        var collection = new SavesCollection( [], {
            formModel: formModel
        });
        collection.fetch({
            success: function(){
                loading.remove();
                var collectionView = new SavesCollectionView( {
                    collection: collection,
                } );
            }
        });
    },

});
