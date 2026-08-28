/**
 * TinyMCE listbox for applying a single style class to <ul> elements.
 *
 * Options come from app/Config/list-styles.php via tiny_mce_before_init,
 * so this stays in step with the core/list control. Applies the class
 * as `list--{slug}`.
 *
 * Unlike style_formats/styleselect, which toggle each class independently,
 * this control clears the other classes before applying the selected one.
 */
(function (window) {
    'use strict';

    var PREFIX = 'list--';
    // Styled lists opt out of the typography plugin's descendant rules.
    var NOT_PROSE = 'not-prose';

    window.tinymce.PluginManager.add('asylum_list_styles', function (editor) {
        var styles = editor.settings.asylum_list_styles || [];

        if (!styles.length) {
            return;
        }

        // Leading empty value clears whichever class is currently set.
        var values = [{ text: 'Default', value: '' }].concat(
            styles.map(function (style) {
                return { text: style.label, value: PREFIX + style.slug };
            })
        );

        function selectedList() {
            return editor.dom.getParent(editor.selection.getNode(), 'ul');
        }

        editor.addButton('asylum_list_styles', {
            type: 'listbox',
            text: 'List style',
            tooltip: 'Apply a style to the selected list',
            fixedWidth: true,
            values: values,

            onselect: function () {
                var list = selectedList();
                var value = this.value();

                if (!list) {
                    return;
                }

                editor.undoManager.transact(function () {
                    values.forEach(function (style) {
                        if (style.value) {
                            editor.dom.removeClass(list, style.value);
                        }
                    });

                    editor.dom.removeClass(list, NOT_PROSE);

                    if (value) {
                        editor.dom.addClass(list, value);
                        editor.dom.addClass(list, NOT_PROSE);
                    }
                });

                editor.nodeChanged();
            },

            // Disable outside lists, and reflect the class already on the list.
            onPostRender: function () {
                var control = this;

                editor.on('NodeChange', function () {
                    var list = selectedList();
                    var active = '';

                    if (list) {
                        values.forEach(function (style) {
                            if (style.value && editor.dom.hasClass(list, style.value)) {
                                active = style.value;
                            }
                        });
                    }

                    control.disabled(!list);
                    control.value(active);
                });
            },
        });
    });
})(window);
