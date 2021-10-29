const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType("ic-wp-blocks/title", {
	title: __("Ic Title", "ultimate-blocks"),
	keywords: [
		__("Heading", "ultimate-blocks"),
		__("Advanced Heading", "ultimate-blocks"),
		__("Ultimate Blocks", "ultimate-blocks"),
	],
	attributes: {
		fname: {
			type: "string",
			default: "",
		},
	},
	edit: () => {
		return [];
	},
	save: () => null,
});
