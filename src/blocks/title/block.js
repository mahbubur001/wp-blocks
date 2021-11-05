const {__} = wp.i18n;
const {registerBlockType} = wp.blocks;
import attributes from "./attributes"
import edit from "./edit"
import save from "./save"
import "./style.scss"

registerBlockType("rt-radius-blocks/title", {
    title: __("Radius Title", "radius-blocks"),
    keywords: [
        __("Heading", "radius-blocks")
    ],
    attributes,
    edit,
    save
});
