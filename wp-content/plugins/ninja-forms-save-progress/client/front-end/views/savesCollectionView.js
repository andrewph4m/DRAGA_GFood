var SavesCollectionView = Marionette.CompositeView.extend({
    tagName: 'table',
    childView: SaveItemView,
    emptyView: SaveEmptyView,
    childViewContainer: 'tbody',
    template: '#tmpl-nf-save-table',

    initialize: function( options ){

        var formInstanceID = this.collection.formModel.get( 'id' );
        var formID = formInstanceID.toString().split('_')[0];

        this.collection.each(function(model){
            model.set('form_id', formInstanceID);
        });

        // Set element selector
        this.el = '#nf-form-' + formInstanceID + '-cont';

        // Update element cache
        this.$el = jQuery(this.el).find('.nf-saves-cont table');

        this.render();

        this.listenTo( Backbone.Radio.channel( 'form-' + formInstanceID ), 'submit:response', function(){
            var collectionView = this;
            this.collection.fetch({
                success: function(){
                    collectionView.render();
                }
            });
        }, this );
    },

    onRender: function(){
        if( 0 == this.collection.length ){
            this.$el.hide();
            this.$el.parent().hide();
        } else {
            this.$el.show();
            this.$el.parent().show();
        }
    },

    templateHelpers: function(){
        var view = this;
        return {
            headers: function(){
                var formModel = view.collection.formModel;
                var columns = formModel.get( 'save_progress_table_columns' );
                var $return = '';
                _.each( columns, function( column ){
                    var fieldModel = formModel.get( 'fields' ).find( function( field ){
                        return column.field ==  field.get( 'key' );
                    });
                    if( 'undefined' != typeof( fieldModel ) ) {
                        $return += '<th>' + fieldModel.get( 'label' ) + '</th>';
                    } else {
                        $return += '<th></th>';
                    }
                });
                return $return;
            }
        }
    }
});
