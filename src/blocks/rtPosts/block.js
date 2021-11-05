const {__} = wp.i18n;
const {registerBlockType} = wp.blocks;
import attributes from "./attributes"
import edit from "./edit"

registerBlockType("rt-radius-blocks/posts", {
    title: __("Radius Post", "radius-blocks"),
    keywords: [
        __("Posts", "radius-blocks")
    ],
    attributes,
    edit,
    save: function () {
        return null
    }
});