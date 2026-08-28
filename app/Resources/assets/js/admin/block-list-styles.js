/**
 * List style select for the core/list block.
 *
 * Options come from app/Config/list-styles.php via wp_add_inline_script,
 * so this stays in step with the ACF WYSIWYG control. Applies the class
 * as `list--{slug}`.
 *
 * register_block_style() is not used here: it always emits `is-style-{slug}`
 * and offers no way to set the class name.
 */
(function (wp, config) {
    'use strict';

    var styles = config || [];

    if (!wp || !styles.length) {
        return;
    }

    var el = wp.element.createElement;
    var BLOCK = 'core/list';
    var ATTRIBUTE = 'listStyle';
    var PREFIX = 'list--';
    // Styled lists opt out of the typography plugin's descendant rules.
    var NOT_PROSE = 'not-prose';

    // Leading empty value clears whichever class is currently set.
    var options = [{ label: 'Default', value: '' }].concat(
        styles.map(function (style) {
            return { label: style.label, value: style.slug };
        })
    );

    function className(value) {
        return value ? PREFIX + value + ' ' + NOT_PROSE : '';
    }

    /**
     * Store the choice as a block attribute.
     */
    wp.hooks.addFilter(
        'blocks.registerBlockType',
        'asylum/list-styles/attribute',
        function (settings, name) {
            if (name !== BLOCK) {
                return settings;
            }

            settings.attributes = Object.assign({}, settings.attributes, {
                listStyle: {
                    type: 'string',
                    default: '',
                },
            });

            return settings;
        }
    );

    /**
     * Add the select to the block inspector's Styles tab.
     */
    wp.hooks.addFilter(
        'editor.BlockEdit',
        'asylum/list-styles/control',
        wp.compose.createHigherOrderComponent(function (BlockEdit) {
            return function (props) {
                if (props.name !== BLOCK) {
                    return el(BlockEdit, props);
                }

                return el(
                    wp.element.Fragment,
                    null,
                    el(BlockEdit, props),
                    el(
                        wp.blockEditor.InspectorControls,
                        { group: 'styles' },
                        el(
                            wp.components.PanelBody,
                            { title: 'List style' },
                            el(wp.components.SelectControl, {
                                label: 'Style',
                                value: props.attributes[ATTRIBUTE] || '',
                                options: options,
                                onChange: function (value) {
                                    var attributes = {};
                                    attributes[ATTRIBUTE] = value;
                                    props.setAttributes(attributes);
                                },
                                __nextHasNoMarginBottom: true,
                            })
                        )
                    )
                );
            };
        }, 'asylumListStyles')
    );

    /**
     * Reflect the class in the editor canvas.
     */
    wp.hooks.addFilter(
        'editor.BlockListBlock',
        'asylum/list-styles/preview',
        wp.compose.createHigherOrderComponent(function (BlockListBlock) {
            return function (props) {
                if (props.name !== BLOCK) {
                    return el(BlockListBlock, props);
                }

                return el(
                    BlockListBlock,
                    Object.assign({}, props, {
                        className: [props.className, className(props.attributes[ATTRIBUTE])]
                            .filter(Boolean)
                            .join(' '),
                    })
                );
            };
        }, 'asylumListStylesPreview')
    );

    /**
     * Write the class into the saved markup.
     */
    wp.hooks.addFilter(
        'blocks.getSaveContent.extraProps',
        'asylum/list-styles/class',
        function (props, blockType, attributes) {
            if (blockType.name !== BLOCK || !attributes[ATTRIBUTE]) {
                return props;
            }

            props.className = [props.className, className(attributes[ATTRIBUTE])]
                .filter(Boolean)
                .join(' ');

            return props;
        }
    );
})(window.wp, window.asylumListStyles);
