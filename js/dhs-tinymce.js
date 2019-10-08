(function() {

    tinymce.create('tinymce.plugins.closereading', {
        init : function(ed, url) {
            ed.addButton('closereading', {
                title : 'Add a Close Reading Section',
                image : url+'/../images/icon-splitscreen-pixel.png',
                onclick : function() {
                     ed.selection.setContent('[closereading inline=0 id=]' + ed.selection.getContent() + '[/closereading]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('closereading', tinymce.plugins.closereading);

	tinymce.create('tinymce.plugins.spacer', {
        init : function(ed, url) {
            ed.addButton('spacer', {
                title : 'Add a Parallax Background Spacer',
                image : url+'/../images/icon-spacer.png',
                onclick : function() {
                     ed.selection.setContent('[spacer height=]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('spacer', tinymce.plugins.spacer);

	/*
	tinymce.create('tinymce.plugins.twocolumns', {
        init : function(ed, url) {
            ed.addButton('twocolumns', {
                title : 'Add Bootstrap shortcodes for two column layout',
                image : url+'/../images/icon-twocolumns.png',
                onclick : function() {
                     ed.selection.setContent('[row]<br>[column md="6"]<br><br><br><br>[/column]<br><br>[column md="6"]<br><br><br><br>[/column]<br>[/row]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('twocolumns', tinymce.plugins.twocolumns);

	tinymce.create('tinymce.plugins.imageframe', {
        init : function(ed, url) {
            ed.addButton('imageframe', {
                title : 'Add an Image Frame',
                image : url+'/icon-imageframe-pixel.png',
                onclick : function() {
                     ed.selection.setContent('[imageframe url= width= height=]' + ed.selection.getContent() + '[/imageframe]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('imageframe', tinymce.plugins.imageframe);
	*/

	tinymce.create('tinymce.plugins.collapsible', {
        init : function(ed, url) {
            ed.addButton('collapsible', {
                title : 'Add an Collapsible Section',
                image : url+'/accordion-512.png',
                onclick : function() {
                     ed.selection.setContent('[collapsible label=""]' + ed.selection.getContent() + '[/collapsible]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('collapsible', tinymce.plugins.collapsible);
	
	tinymce.create('tinymce.plugins.linkbutton', {
        init : function(ed, url) {
            ed.addButton('linkbutton', {
                title : 'Add a Link Button',
                image : url+'/icon-linkbutton.png',
                onclick : function() {
                     ed.selection.setContent('[linkbutton url=""]' + ed.selection.getContent() + '[/linkbutton]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('linkbutton', tinymce.plugins.linkbutton);

	tinymce.create('tinymce.plugins.footnotebutton', {
        init : function(ed, url) {
            ed.addButton('footnotebutton', {
                title : 'Add a Footnote',
                image : url+'/icon-footnote.png',
                onclick : function() {
                     ed.selection.setContent('[note]' + ed.selection.getContent() + '[/note]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('footnotebutton', tinymce.plugins.footnotebutton);

})();